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

class NewsletterTable extends TableAbstract
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
        if(isset($_GET['sms']) && $_GET['sms'] == 1){
            $data = $this->table
            ->eloquent($this->query())
            // ->editColumn('checkbox', function (EmailTemplate $item) {
            //     return $this->getCheckbox($item->getKey());
            // })
            ->editColumn('name', function (EmailTemplate $item) {
                return BaseHelper::clean(trim($item->name)) ?: '&mdash;';
            })
            ->editColumn('description', function (EmailTemplate $item) {
                return BaseHelper::clean($item->description);
            })
            ->addColumn('operations', function (EmailTemplate $item) {
                return $this->getOperations(null, 'emailtemplate.destroy', $item, '<a href="/admin/settings/email/templates/edit/plugins/newsletter/' . $item->slug . '?is_template=1&is_sms=1" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-warning sendMailToNewsLatterMail" data-id="' . $item->id . '" data-bs-toggle="tooltip" data-bs-original-title="SMS"><i class="fa-solid fa-envelope"></i></a>
                
                ');
            });

        }else{
            $data = $this->table
            ->eloquent($this->query())
            // ->editColumn('checkbox', function (EmailTemplate $item) {
            //     return $this->getCheckbox($item->getKey());
            // })
            ->editColumn('name', function (EmailTemplate $item) {
                return BaseHelper::clean(trim($item->name)) ?: '&mdash;';
            })
            ->editColumn('subject', function (EmailTemplate $item) {
                return BaseHelper::clean($item->subject);
            })
            ->editColumn('description', function (EmailTemplate $item) {
                return BaseHelper::clean($item->description);
            })
            ->addColumn('operations', function (EmailTemplate $item) {
                return $this->getOperations(null, 'emailtemplate.destroy', $item, '<a href="/admin/settings/email/templates/edit/plugins/newsletter/' . $item->slug . '?is_template=1" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-warning sendMailToNewsLatterMail" data-id="' . $item->id . '" data-bs-toggle="tooltip" data-bs-original-title="Email"><i class="fa-solid fa-envelope"></i></a>
                <a href="#" class="btn btn-icon btn-sm btn-warning copymail" data-id="' . $item->id . '" data-bs-toggle="tooltip" data-bs-original-title="Copy Mail"><i class="fa-solid fa-copy"></i></a>
                ');
            });

        }

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        if(isset($_GET['sms']) && $_GET['sms'] == 1){
            $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'name',
                'subject',
                'description',
                'slug',
            ])->where('template_type','=','sms_template');
        }else{
            $query = $this
            ->getModel()
            ->query()
            ->select([
                'id',
                'name',
                'subject',
                'description',
                'slug',
            ])->where('template_type','=','email_template')->orWhere('template_type','=',null);
        }


        return $this->applyScopes($query);
    }
    public function buttons(): array
    {
        return $this->addCustomeCreateButton();
    }
    public function columns(): array
    {
        if(isset($_GET['smsbrodcast']) && $_GET['smsbrodcast'] == 1){
            return [
                'id' => [
                    'title' => trans('core/base::tables.id'),
                    'width' => '20px',
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
        }else{
            return [
                'id' => [
                    'title' => trans('core/base::tables.id'),
                    'width' => '20px',
                ],
                'name' => [
                    'title' => 'name',
                    'class' => 'text-start',
                    'width' => '30px',
                ],
                'subject' => [
                    'title' => 'subject',
                    'class' => 'text-start',
                    'width' => '30px',
                ],
                'description' => [
                    'title' => 'description',
                    'width' => '50px',
                ]
            ];
        }

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
