<?php

namespace Botble\Ecommerce\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Enums\ShippingMethodEnum;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Repositories\Interfaces\OrderHistoryInterface;
use Botble\Ecommerce\Repositories\Interfaces\OrderInterface;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Botble\Ecommerce\Facades\OrderHelper;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Botble\Table\DataTables;
use Illuminate\Support\Facades\Log;

class OrderTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, OrderInterface $orderRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $orderRepository;

        if (! Auth::user()->hasPermission('orders.edit')) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            // ->editColumn('status', function ($item) {
            //     return BaseHelper::clean($item->status->toHtml());
            // })
            ->editColumn('payment_status', function ($item) {
                if (! is_plugin_active('payment')) {
                    return '&mdash;';
                }

                return $item->payment->status->label() ? BaseHelper::clean(
                    $item->payment->status->toHtml()
                ) : '&mdash;';
            })
            ->editColumn('payment_method', function ($item) {
                if (! is_plugin_active('payment')) {
                    return '&mdash;';
                }

                return BaseHelper::clean($item->payment->payment_channel->label() == 'Cash on delivery (COD)' ? 'COD': 'Credit / Debit Card');
            })
            ->editColumn('amount', function ($item) {
                return format_price($item->amount);
            })
            // ->editColumn('shipping_amount', function ($item) {
            //     return format_price($item->shipping_amount);
            // })
            ->editColumn('user_id', function ($item) {
                return BaseHelper::clean($item->user->name ?: $item->address->name);
            })
//            ->editColumn('customer_email', function ($item) {
//                return BaseHelper::clean($item->user->email ?: $item->address->email);
//            })
            ->editColumn('product_name', function ($item) {
                // get product name from ec_order_product table
                $product = DB::table('ec_order_product')->where(['order_id' => $item->id])->orderBy('price')->first();
                return BaseHelper::clean($product->product_name);
            })
            ->editColumn('customer_phone', function ($item) {
                //sprintf("%s-%s-%s", substr($item->address->phone, 2, 3), substr($item->address->phone, 5, 3),substr($item->address->phone, 8));
                return $this->phoneNumber($item->user->phone ? $item->address->phone: $item->address->phone);
                //return BaseHelper::clean($item->address->phone);
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at,'m/d/Y');
            });

        // if (EcommerceHelper::isTaxEnabled()) {
        //     $data = $data->editColumn('tax_amount', function ($item) {
        //         return format_price($item->tax_amount);
        //     });
        // }

        $data = $data
            ->addColumn('terms_status', function ($item) {
                if ($item->terms_signed != 1) {
                    return "<a href='https://rentnking.com/checkout/".$item->token."/sign-terms/?admin=true' target='__BLANK'>".BaseHelper::clean(OrderStatusEnum::PENDING()->toHtml()).'</a>';
                } else {
                    return "<a href='https://rentnking.com/checkout/".$item->token."/sign-terms/?admin=true' target='__BLANK'>".BaseHelper::clean(OrderStatusEnum::ACCEPTED()->toHtml()).'</a>';
                }
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('orders.edit','orders.destroy', $item);
            })
            ->filter(function ($query) {
                if ($keyword = $this->request->input('search.value')) {
                    return $query
                        ->whereHas('address', function ($subQuery) use ($keyword) {
                            return $subQuery
                                ->where('name', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('phone', 'LIKE', '%' . $keyword . '%');
                        })
                        ->orWhereHas('user', function ($subQuery) use ($keyword) {
                            return $subQuery
                                ->where('name', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                                ->orWhere('phone', 'LIKE', '%' . $keyword . '%');
                        })
                        ->orWhere('code', 'LIKE', '%' . $keyword . '%');
                }

                return $query;
            });

        return $this->toJson($data);
    }

    public function phoneNumber($data) {
        // add logic to correctly format number here
        // a more robust ways would be to use a regular expression
        $data = preg_replace('/[^a-zA-Z0-9-_\.]/','', trim($data));

        $code =  substr($data, 0, 2);

        //return $code;
        if(str_contains($code,'+1')){
            //return 'here';
            $data = substr($data,'+1');
            //return $data;
            return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."".substr($data,6);
        }
        //return strlen($data);
        if(!str_contains($code,'+1') && strlen($data) == 11){
           // return $code;
            return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."".substr($data,6);
        }
        if(!str_contains($code,'+1') && strlen($data) == 10){
            // return $code;
             return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."".substr($data,6);
         }
        if(!str_contains($code,'+1') && strlen($data) > 11){
            // return $code;
           $data =  substr($data, 1);
             return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."".substr($data,6);
         }
    }
    public function query(): Relation|Builder|QueryBuilder
    {
        $with = ['user'];

        if (is_plugin_active('payment')) {
            $with[] = 'payment';
        }

        $query = $this->repository->getModel()
            ->with($with)
//            ->leftJoin('ec_order_product', 'ec_order_product.order_id', '=', 'ec_orders.id')
            ->select([
                'ec_orders.id as id',
                'ec_orders.status as status',
                'user_id',
                'ec_orders.created_at as created_at',
                'amount',
                'token',
                //'tax_amount',
                //'shipping_amount',
                'payment_id',
                'terms_signed'
//                'ec_order_product.product_name as product_name'
            ])
//            ->distinct()
            ->where('is_finished', 1);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        $columns = [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
                'class' => 'text-start',
            ],
            'user_id' => [
                'title' => trans('plugins/ecommerce::order.customer_label'),
                'class' => 'text-start',
            ],
//            'customer_email' => [
//                'title' => trans('plugins/ecommerce::customer.email'),
//                'class' => 'text-start',
//                'sortable' => false,
//            ],
            'product_name' => [
                'title' => trans('plugins/ecommerce::order.product_name'),
                'class' => 'text-start',
                'sortable' => false,
            ],
            'customer_phone' => [
                'title' => trans('plugins/ecommerce::customer.phone'),
                'class' => 'text-start',
                'sortable' => false,
            ],
            'amount' => [
                'title' => trans('plugins/ecommerce::order.amount'),
                'class' => 'text-center',
            ],
        ];

        // if (EcommerceHelper::isTaxEnabled()) {
        //     $columns['tax_amount'] = [
        //         'title' => trans('plugins/ecommerce::order.tax_amount'),
        //         'class' => 'text-center',
        //     ];
        // }

        $columns += [
            // 'shipping_amount' => [
            //     'title' => trans('plugins/ecommerce::order.shipping_amount'),
            //     'class' => 'text-center',
            // ],
            'payment_method' => [
                'name' => 'payment_id',
                'title' => trans('plugins/ecommerce::order.payment_method'),
                'class' => 'text-start',
                //'width'=>'30px'
            ],
            'payment_status' => [
                'name' => 'payment_id',
                'title' => trans('plugins/ecommerce::order.payment_status_label'),
                'class' => 'text-center',
                'width'=>'10px'
            ],

            'terms_status' => [
                'title' => 'Terms Status',
                'class' => 'text-center',
                //'width'=>'10px'
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                //'width' => '10px',
                'class' => 'text-start',
            ],
        ];

        return $columns;
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('orders.create'), 'orders.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('orders.deletes'), 'orders.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'select',
                'choices' => OrderStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', OrderStatusEnum::values()),
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }

    public function getFilters(): array
    {
        $filters = parent::getFilters();

        $filters = array_merge($filters, [
            'customer_name' => [
                'title' => trans('plugins/ecommerce::ecommerce.customer_name'),
                'type' => 'text',
            ],
            'customer_email' => [
                'title' => trans('plugins/ecommerce::ecommerce.customer_email'),
                'type' => 'text',
            ],
            'customer_phone' => [
                'title' => trans('plugins/ecommerce::ecommerce.customer_phone'),
                'type' => 'text',
            ],
            'amount' => [
                'title' => trans('plugins/ecommerce::order.amount'),
                'type' => 'number',
            ],
            'shipping_method' => [
                'title' => trans('plugins/ecommerce::ecommerce.shipping_method'),
                'type' => 'select',
                'choices' => array_filter(ShippingMethodEnum::labels()),
            ],
        ]);

        if (is_plugin_active('payment')) {
            $filters = array_merge($filters, [
                'payment_method' => [
                    'title' => trans('plugins/ecommerce::order.payment_method'),
                    'type' => 'select',
                    'choices' => PaymentMethodEnum::labels(),
                ],
                'payment_status' => [
                    'title' => trans('plugins/ecommerce::order.payment_status_label'),
                    'type' => 'select',
                    'choices' => PaymentStatusEnum::labels(),
                ],
            ]);
        }

        if (is_plugin_active('marketplace')) {
            $filters['store_id'] = [
                'title' => trans('plugins/marketplace::store.forms.store'),
                'type' => 'select-search',
                'choices' => [-1 => theme_option('site_title')] + DB::table('mp_stores')->pluck('name', 'id')->all(),
            ];
        }

        return $filters;
    }

    public function renderTable($data = [], $mergeData = []): View|Factory|Response
    {
        if ($this->query()->count() === 0 &&
            ! $this->request()->wantsJson() &&
            $this->request()->input('filter_table_id') !== $this->getOption('id') && ! $this->request()->ajax()
        ) {
            return view('plugins/ecommerce::orders.intro');
        }

        return parent::renderTable($data, $mergeData);
    }

    public function getDefaultButtons(): array
    {
        return [
            'export',
            'reload',
        ];
    }

    public function saveBulkChangeItem(Model|Order $item, string $inputKey, ?string $inputValue): Model|bool
    {
        if ($inputKey === 'status' && $inputValue == OrderStatusEnum::CANCELED) {
            /**
             * @var Order $item
             */
            if (! $item->canBeCanceledByAdmin()) {
                return $item;
            }

            OrderHelper::cancelOrder($item);

            app(OrderHistoryInterface::class)->createOrUpdate([
                'action' => 'cancel_order',
                'description' => trans('plugins/ecommerce::order.order_was_canceled_by'),
                'order_id' => $item->id,
                'user_id' => Auth::id(),
            ]);

            return $item;
        }

        return parent::saveBulkChangeItem($item, $inputKey, $inputValue);
    }

    public function applyFilterCondition(Builder|QueryBuilder|Relation $query, string $key, string $operator, ?string $value): Builder|QueryBuilder|Relation
    {
        switch ($key) {
            case 'customer_name':
                if (! $value) {
                    break;
                }

                return $this->filterByCustomer($query, 'name', $operator, $value);
            case 'customer_email':
                if (! $value) {
                    break;
                }

                return $this->filterByCustomer($query, 'email', $operator, $value);
            case 'customer_phone':
                if (! $value) {
                    break;
                }

                return $this->filterByCustomer($query, 'phone', $operator, $value);
            case 'status':
                if (! OrderStatusEnum::isValid($value)) {
                    return $query;
                }

                break;
            case 'shipping_method':
                if (! $value) {
                    break;
                }

                if (! ShippingMethodEnum::isValid($value)) {
                    return $query;
                }

                break;
            case 'payment_method':
                if (! is_plugin_active('payment') || ! PaymentMethodEnum::isValid($value)) {
                    return $query;
                }

                return $query->whereHas('payment', function ($subQuery) use ($value) {
                    $subQuery->where('payment_channel', $value);
                });

            case 'payment_status':
                if (! is_plugin_active('payment') || ! PaymentStatusEnum::isValid($value)) {
                    return $query;
                }

                return $query->whereHas('payment', function ($subQuery) use ($value) {
                    $subQuery->where('status', $value);
                });

            case 'store_id':
                if (! is_plugin_active('marketplace')) {
                    return $query;
                }
                if ($value == -1) {
                    return $query->where(function ($subQuery) {
                        $subQuery->whereNull('store_id')
                            ->orWhere('store_id', 0);
                    });
                }
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    protected function filterByCustomer(Builder|QueryBuilder|Relation $query, string $column, string $operator, ?string $value): Builder|QueryBuilder|Relation
    {
        if ($operator === 'like') {
            $value = '%' . $value . '%';
        } elseif ($operator !== '=') {
            $operator = '=';
        }

        return $query
            ->where(function ($query) use ($column, $operator, $value) {
                $query
                    ->whereHas('user', function ($subQuery) use ($column, $operator, $value) {
                        $subQuery->where($column, $operator, $value);
                    })
                    ->orWhereHas('address', function ($subQuery) use ($column, $operator, $value) {
                        $subQuery->where($column, $operator, $value);
                    });
            });
    }
}
