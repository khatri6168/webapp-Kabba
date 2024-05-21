<?php

namespace Botble\Newsletter\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Newsletter\Enums\NewsletterStatusEnum;
use Botble\Newsletter\Models\EmailTemplate;
use Botble\Newsletter\Models\Newsletter;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Botble\Table\DataTables;

class SmsBrodcastTable extends TableAbstract
{
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        EmailTemplate $email_template
    ) {
        parent::__construct($table, $urlGenerator);

        // $email_template = new EmailTemplate;
        $this->model = $email_template;
        $this->hasCheckbox = false;

        // $this->hasActions = true;
        // $this->hasFilter = true;

        // if (! Auth::user()->hasPermission('newsletter.destroy')) {
        //     $this->hasOperations = false;
        //     $this->hasActions = false;
        // }
    }

    public function ajax(): JsonResponse
    {
        
            $data = $this->table
            ->eloquent($this->query())
            // ->editColumn('checkbox', function (EmailTemplate $item) {
            //     return $this->getCheckbox($item->getKey());
            // })
            ->editColumn('created_at', function (EmailTemplate $item) {
                return BaseHelper::formatDate($item->created_at,'m/d/Y');
            })
            ->editColumn('description', function (EmailTemplate $item) {
                return BaseHelper::clean($item->description);
            })
            ->addColumn('operations', function (EmailTemplate $item) {
                return $this->getOperations(null, 'emailtemplate.destroy', $item, '<a href="#" class="btn btn-icon btn-sm btn-primary editsms"  data-id="' . $item->id . '" data-bs-toggle="tooltip" data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-warning copysms" data-id="' . $item->id . '" data-bs-toggle="tooltip" data-bs-original-title="Copy SMS"><i class="fa-solid fa-copy"></i></a>
                ');
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
                'created_at',
                'name',
                'subject',
                'description',
                'slug',
            ])->where('template_type','=','sms_template');
        
                return $query;

        return $this->applyScopes($query);
    }
    public function buttons(): array
    {
      
        $buttons = [];
        $buttons =  $this->addCustomeCreateButton();
        $buttons['sendsms'] = [
            'link' => route('smsbrodcast.process'),
            'text' => '<i class="fas fa-plus"></i> Send SMS',
            'class' => 'btn-warning',
        ];
        // $buttons['createconent'] = [
        //     'link' => route('smsbrodcast'),
        //     'text' => '<i class="fas fa-plus"></i> Create Content',
        //     'class' => 'btn-warning',
        // ];

        return $buttons;
    
        
    }
    public function columns(): array
    {
       
            return [
                'created_at' => [
                    'title' => 'Create date',
                    'width' => '30px',
                ],
                'name' => [
                    'title' => 'name',
                    'class' => 'text-start',
                    'width' => '30px',
                ],
                'description' => [
                    'title' => 'description',
                    'width' => '50px',
                ]
            ];
        

    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('newsletter.deletes'), 'newsletter.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'name' => [
                'title' => 'name',
                'type' => 'text',
                'validate' => 'required|max:120|email',
            ],
            'name' => [
                'title' => 'name',
                'type' => 'text',
                'validate' => 'required|max:120|email',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type' => 'datePicker',
            ],
        ];
    }

    public function getDefaultButtons(): array
    {
        return [
            'reload',
        ];
    }
}
