<?php

namespace Botble\Ecommerce\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Enums\OrderStatusEnum;
use Botble\Ecommerce\Repositories\Interfaces\DeliveryPickUpInterface;

use Botble\Ecommerce\Enums\DeliveryStatusEnum;
use Botble\Base\Facades\Html;
use Botble\Payment\Enums\PaymentStatusEnum;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Botble\Table\DataTables;
use Illuminate\Support\Facades\DB;

class DeliveryPickUpTable extends TableAbstract
{
    protected $hasActions = true;

//    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, DeliveryPickUpInterface $storeRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $storeRepository;

        if (! Auth::user()->hasAnyPermission(['deliveries.edit', 'deliveries.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->addColumn('product', function ($item) {
                return Html::link(route('products.edit', $item->product_id), $item->product->name, ['target' => '_blank'], null, false);
            })
            ->editColumn('name', function ($item) {
                if (! Auth::user()->hasPermission('deliveries.edit')) {
                    return BaseHelper::clean($item->name);
                }

                return Html::link(route('deliveries.edit', $item->id), BaseHelper::clean($item->name));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('name', function ($item) {
                return $item->name;
            })
            ->editColumn('phone', function ($item) {
                $phone = preg_replace('/[^\d]/','', $item->phone);
                return Html::link("tel:$phone", BaseHelper::clean($this->phoneNumber($item->phone)));
            })
            ->addColumn('location', function ($item) {
                $locationText = $item->address.', '.$item->city. ', ' .$item->state. ', ' .$item->zip_code;
                $location = $item->address.', '.$item->city. ', ' .$item->state. ', ' .$item->country. ', ' .$item->zip_code;
                return "<a target='_blank' href='https://maps.google.com/?q=$location'>
                        <a target='_blank' href='https://maps.apple.com/maps?q=$location'>
                        $locationText</a></a>";
            })
            ->editColumn('country', function ($item) {
                return BaseHelper::clean($item->country);
            })
            ->editColumn('state', function ($item) {
                return BaseHelper::clean($item->state);
            })
            ->editColumn('city', function ($item) {
                return BaseHelper::clean($item->city);
            })
            ->editColumn('address', function ($item) {
                return $item->address;
            })
            ->addColumn('order', function ($item) {
//                if ($item->order->payment->status == PaymentStatusEnum::COMPLETED) {
//                    return '<a href="/admin/orders/edit/'. $item->order_id .'" target="_blank"><span class="label-success status-label">Paid</span></a>';
//                } else {
                    return Html::link(route('orders.edit', $item->order_id), $item->order->payment->status->toHtml(), ['target' => '_blank'], null, false);
//                }
            })
            ->editColumn('zip_code', function ($item) {
                return $item->zip_code;
            })
            ->editColumn('delivery_date', function ($item) {
                $formattedTime = date( "h:s A", strtotime( $item->delivery_time ));
                return date('M d', strtotime($item->delivery_date)) . ' - ' . $formattedTime;
            })
            ->editColumn('delivery_status', function ($item) {
                if ($item->customer_delivery == CUSTOMER_DELIVERY) {
                    if ($item->delivery_status == DeliveryStatusEnum::PENDING) {
                        return BaseHelper::clean("<img width='50' src='/vendor/core/plugins/ecommerce/images/store_pending.svg' alt='icon'>");
                    } else {
                        return BaseHelper::clean("<img width='50' src='/vendor/core/plugins/ecommerce/images/store_success.svg' alt='icon'>");
                    }
                } else {
                    if ($item->delivery_status == DeliveryStatusEnum::PENDING) {
                        return BaseHelper::clean("<img width='50' src='/vendor/core/plugins/ecommerce/images/delivery_pending.svg' alt='icon'>");
                    } else {
                        return BaseHelper::clean("<img width='50' src='/vendor/core/plugins/ecommerce/images/delivery_success.svg' alt='icon'>");
                    }
                }
            })
            ->editColumn('pickup_date', function ($item) {
                $formattedTime = date( "h:s A", strtotime( $item->pickup_time ));
                return date('M d', strtotime($item->pickup_date)) . ' - ' . $formattedTime;
            })
            ->editColumn('pickup_status', function ($item) {
                if ($item->customer_pickup == CUSTOMER_PICKUP) {
                    if ($item->pickup_status == DeliveryStatusEnum::PENDING) {
                        return BaseHelper::clean("<img width='50' src='/vendor/core/plugins/ecommerce/images/store_pending.svg' alt='icon'>");
                    } else {
                        return BaseHelper::clean("<img width='50' src='/vendor/core/plugins/ecommerce/images/store_success.svg' alt='icon'>");
                    }
                } else {
                    if ($item->pickup_status == DeliveryStatusEnum::PENDING) {
                        return BaseHelper::clean("<img width='50' src='/vendor/core/plugins/ecommerce/images/delivery_pending.svg' alt='icon'>");
                    } else {
                        return BaseHelper::clean("<img width='50' src='/vendor/core/plugins/ecommerce/images/delivery_success.svg' alt='icon'>");
                    }
                }
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('deliveries.edit', 'deliveries.destroy', $item);
            });

        /*$data = $data->filter(function ($query) {
            if ($keyword = $this->request->input('search.value')) {
                $deliveryDate = date("Y-m-d", strtotime($keyword));
                $query->where('delivery_date', '=', $deliveryDate);
                $query->orWhere('pickup_date', '=', $deliveryDate);
                return $query;
            }

            return $query;
        });*/

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->repository->getModel()
            ->leftJoin('ec_orders', 'ec_delivery_pickup.order_id', '=', 'ec_orders.id')
            ->leftJoin('payments', 'payments.order_id', '=', 'ec_orders.id')
            ->select([
                'ec_delivery_pickup.id',
                'name',
                'phone',
                'email',
                'country',
                'state',
                'city',
                'ec_delivery_pickup.order_id',
                'ec_delivery_pickup.product_id',
                'comment',
                'zip_code',
                'delivery_date',
                'delivery_time',
                'address',
                'delivery_status',
                'pickup_date',
                'pickup_time',
                'pickup_status',
                'ec_delivery_pickup.created_at',
                'ec_delivery_pickup.updated_at',
                'customer_delivery',
                'customer_pickup',
                DB::raw('DATEDIFF(delivery_date, now()) as delivery_order'),
                DB::raw('DATEDIFF(pickup_date, now()) as pickup_order')
            ]);
//            ->where(DB::raw('(delivery_status = '. DeliveryStatusEnum::COMPLETED . ' AND ' . 'pickup_status =' . DeliveryStatusEnum::COMPLETED. ')'), '=', 'false')
//            ->distinct()
//            ->where('delivery_status', '<>', DeliveryStatusEnum::COMPLETED)
//            ->orWhere('pickup_status', '<>', DeliveryStatusEnum::COMPLETED)
//            ->orderby('recent', 'asc');
//            ->orderby('delivery_date', 'desc')
//            ->orderby('delivery_time', 'desc')
//            ->orderby('pickup_date', 'desc')
//            ->orderby('pickup_time', 'desc');

        $query->where(function($query) {
            if ($this->request()->input('pending') == '2') {
                if ($this->request()->input('delivery') == 'true') {
                    $query->orWhere('delivery_status', '=', '1');
                }

                if ($this->request()->input('pickup') == 'true') {
                    $query->orWhere('pickup_status', '=', '1');
                    if ($this->request()->input('completed') == '1') {
                        if ($this->request()->input('delivery') == 'false') {
                            $query->where('delivery_status', '!=', '1');
                        }
                    }
                }
            }

            if ($this->request()->input('completed') == '2') {
                if ($this->request()->input('delivery') == 'true') {
                    $query->orWhere('delivery_status', '=', '2');
                    if ($this->request()->input('pending') == '1') {
                        if ($this->request()->input('pickup') == 'false') {
                            $query->where('pickup_status', '!=', '2');
                        }
                    }
                }

                if ($this->request()->input('pickup') == 'true') {
                    $query->orWhere('pickup_status', '=', '2');
                }
            }
        });

        // set sort
        if ($this->request()->input('pickup') == 'true' && $this->request()->input('delivery') == 'false') {
            $query->orderby('pickup_order', 'asc');
        } else {
            $query->orderby('delivery_order', 'asc');
        }

        // first request
        if ($this->request()->input('delivery') == null) {
            $query->where('delivery_status', '=', '1');
            $query->orderby('delivery_order', 'asc');
        }

        if ($this->request()->input('store_delivery') == 'false') {
            if ($this->request()->input('delivery') == 'true') {
                $query->where('customer_delivery', '!=', '2');
            } else {
                $query->where('customer_pickup', '!=', '2');
            }
        }

        if ($this->request()->input('customer_delivery') == 'false') {
            if ($this->request()->input('delivery') == 'true') {
                $query->where('customer_delivery', '!=', '1');
            } else {
                $query->where('customer_pickup', '!=', '1');
            }
        }

        $query->where('payments.status', '!=',  PaymentStatusEnum::FAILED);
        $query->where('ec_orders.status', '!=',  OrderStatusEnum::CANCELED);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'product' => [
                'title' => trans('plugins/ecommerce::deliveries.product_name'),
                'class' => 'text-start',
            ],
            'name' => [
                'title' => trans('plugins/ecommerce::deliveries.form.name'),
                'class' => 'text-start',
            ],
            'phone' => [
                'title' => trans('plugins/ecommerce::deliveries.phone'),
                'class' => 'text-center',
                'width' => '90px',
            ],
            'location' => [
                'title' => trans('plugins/ecommerce::deliveries.delivery_address'),
                'class' => 'text-start',
            ],
            'delivery_date' => [
                'title' => trans('plugins/ecommerce::deliveries.delivery_date'),
                'class' => 'text-center',
                'width' => '140px',
            ],
            'delivery_status' => [
                'title' => trans('plugins/ecommerce::deliveries.delivery_status'),
                'width' => '40px',
                'class' => 'text-center',
            ],
            'pickup_date' => [
                'title' => trans('plugins/ecommerce::deliveries.pickup_date'),
                'class' => 'text-center',
                'width' => '110px',
            ],
            'pickup_status' => [
                'title' => trans('plugins/ecommerce::deliveries.pickup_status'),
                'width' => '50px',
                'class' => 'text-center',
            ],
            'order' => [
                'title' => trans('plugins/ecommerce::deliveries.payment_status'),
                'class' => 'text-center',
                'width' => '40px',
            ],
            'operations' => [
                'title' => trans('plugins/ecommerce::deliveries.operation'),
                'width' => '60px',
                'class' => 'text-center',
            ],
        ];
    }

    public function buttons(): array
    {
//        return $this->addCreateButton(route('deliveries.calendar'), 'deliveries.index');
        return [];
    }

    public function getDefaultButtons(): array
    {
        return [
            'reload',
        ];
    }

    public function bulkActions(): array
    {
        return parent::bulkActions();
    }

    public function getBulkChanges(): array
    {
        return [
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'select',
                'choices' => DeliveryStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', DeliveryStatusEnum::values()),
            ],
        ];
    }

    public function getFilters(): array
    {
        $filters = [
            'name' => [
                'title' => trans('plugins/ecommerce::deliveries.form.name'),
                'type' => 'text',
            ],
            'phone' => [
                'title' => trans('plugins/ecommerce::deliveries.phone'),
                'type' => 'text',
            ],
            'address' => [
                'title' => trans('plugins/ecommerce::deliveries.address'),
                'type' => 'text',
            ],
            'delivery_status' => [
                'title' => trans('plugins/ecommerce::deliveries.delivery_status'),
                'type' => 'select',
                'choices' => array_filter(DeliveryStatusEnum::labels()),
            ],
            'pickup_status' => [
                'title' => trans('plugins/ecommerce::deliveries.pickup_status'),
                'type' => 'select',
                'choices' => array_filter(DeliveryStatusEnum::labels()),
            ],
        ];

/*        if (is_plugin_active('payment')) {
            $filters = array_merge($filters, [
                'payment_method' => [
                    'title' => trans('plugins/ecommerce::order.payment_method'),
                    'type' => 'select',
                    'choices' => PaymentMethodEnum::labels(),
                ],
                'order.status' => [
                    'title' => trans('plugins/ecommerce::order.order_status_label'),
                    'type' => 'select',
                    'choices' => OrderStatusEnum::labels(),
                ],
            ]);
        }*/

        return $filters;
    }


    public function renderTable($data = [], $mergeData = []): View|Factory|Response
    {
        if ($this->query()->count() === 0 &&
            ! $this->request()->wantsJson() &&
            $this->request()->input('filter_table_id') !== $this->getOption('id') && ! $this->request()->ajax()
        ) {
            return view('plugins/ecommerce::deliveries.intro');
        }

        return parent::renderTable($data, $mergeData);
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
}
