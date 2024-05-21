<?php

namespace Botble\Ecommerce\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Repositories\Interfaces\EmployeeInterface;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Ecommerce\Enums\EmployeeStatusEnum;
use Botble\Base\Facades\Html;
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

class EmployeeTable extends TableAbstract
{
    protected $hasActions = true;

    protected $hasFilter = true;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, EmployeeInterface $storeRepository)
    {
        parent::__construct($table, $urlGenerator);

        $this->repository = $storeRepository;

        if (! Auth::user()->hasAnyPermission(['employees.edit', 'employees.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (! Auth::user()->hasPermission('employees.edit')) {
                    return BaseHelper::clean($item->name);
                }

                return Html::link(route('employees.edit', $item->id), BaseHelper::clean($item->name));
            })
            ->editColumn('checkbox', function ($item) {
                return $this->getCheckbox($item->id);
            })
            ->editColumn('first_name', function ($item) {
                return $item->first_name;
            })
            ->editColumn('last_name', function ($item) {
                return $item->last_name;
            })
            ->editColumn('phone', function ($item) {
                return $this->phoneNumber($item->phone);
            })
            ->editColumn('email', function ($item) {
                return BaseHelper::clean($item->email);
            })
            ->editColumn('address', function ($item) {
                return $item->address;
            })
            ->editColumn('created_at', function ($item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function ($item) {
                return BaseHelper::clean($item->status->toHtml());
            })
            ->addColumn('operations', function ($item) {
                return $this->getOperations('employees.edit', 'employees.destroy', $item);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this->repository->getModel()->select([
            'id',
            'first_name',
            'last_name',
            'phone',
            'email',
            'address',
            'status',
            'created_at',
        ])
        ->orderby('id');;

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
                'class' => 'text-start',
            ],
            'name' => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-start',
            ],
            'phone' => [
                'title' => trans('plugins/ecommerce::employees.phone'),
                'class' => 'text-start',
            ],
            'email' => [
                'title' => trans('core/base::tables.email'),
                'class' => 'text-start',
            ],
            'address' => [
                'title' => trans('core/base::tables.address'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
                'class' => 'text-start',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
                'class' => 'text-center',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('employees.create'), 'employees.create');
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
                'choices' => EmployeeStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', EmployeeStatusEnum::values()),
            ],
        ];
    }

    public function renderTable($data = [], $mergeData = []): View|Factory|Response
    {
        if ($this->query()->count() === 0 &&
            ! $this->request()->wantsJson() &&
            $this->request()->input('filter_table_id') !== $this->getOption('id') && ! $this->request()->ajax()
        ) {
            return view('plugins/ecommerce::employees.intro');
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
