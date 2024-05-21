<?php

namespace Botble\Terms\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Terms\Models\Terms;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Base\Facades\Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Botble\Table\DataTables;

class GlobalTermsTable extends TableAbstract
{
    public function __construct(DataTables $table, UrlGenerator $urlGenerator, Terms $terms)
    {
        parent::__construct($table, $urlGenerator);

        $this->model = $terms;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (! Auth::user()->hasAnyPermission(['globalterms.edit', 'globalterms.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query()->where('is_global',1))
            ->editColumn('title', function (Terms $item) {
                if (! Auth::user()->hasPermission('terms.edit')) {
                    return $item->title;
                }

                return Html::link(route('globalterms.edit', $item->getKey()), $item->title);
            })
            ->editColumn('checkbox', function (Terms $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('is_global', function (Terms $item) {
                return 'Global';
                
            })
            ->editColumn('created_at', function (Terms $item) {
                return BaseHelper::formatDate($item->created_at);
            })
            ->editColumn('status', function (Terms $item) {
                return $item->status->toHtml();
            })
            ->addColumn('operations', function (Terms $item) {
                return $this->getOperations('globalterms.edit', 'globalterms.destroy', $item);
            });

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'title',
                'is_global',
                'created_at',
                'status',
            ]);

        return $this->applyScopes($query);
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'title' => [
                'title' => trans('plugins/terms::terms.title'),
                'class' => 'text-start',
            ],
            'is_global' => [
                'title' => trans('plugins/terms::terms.type'),
                'class' => 'text-start',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    public function buttons(): array
    {
        return $this->addCreateButton(route('globalterms.create'), 'terms.create');
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('globalterms.deletes'), 'terms.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            /*'content' => [
                'title' => trans('plugins/terms::terms.content'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],*/
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }
}
