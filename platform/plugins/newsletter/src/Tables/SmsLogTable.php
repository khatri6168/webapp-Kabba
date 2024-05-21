<?php

namespace Botble\Newsletter\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Newsletter\Enums\NewsletterStatusEnum;
use Botble\Newsletter\Models\EmailTemplate;
use Botble\Newsletter\Models\Newsletter;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Botble\Newsletter\Models\NewsLetterEmailLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Botble\Table\DataTables;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation as EloquentRelation;


class SmsLogTable extends TableAbstract
{
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        NewsLetterEmailLog $newsletter_emaillog
    ) {
        parent::__construct($table, $urlGenerator);

        // $email_template = new EmailTemplate;
        $this->model = $newsletter_emaillog;
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
            ->editColumn('id', function (NewsLetterEmailLog $item) {
                // dd($item);
                 return BaseHelper::clean(trim($item->id)) ?: '&mdash;';
             })
            ->editColumn('name', function (NewsLetterEmailLog $item) {
               // dd($item);
                return BaseHelper::clean(trim($item->temp_name)) ?: '&mdash;';
            })
            ->editColumn('number_of_users', function (NewsLetterEmailLog $item) {
                // dd($item);
                 return BaseHelper::clean(trim($item->number_of_users)) ?: '&mdash;';
             })
            ->editColumn('status', function (NewsLetterEmailLog $item) {
                return BaseHelper::clean(trim($item->status == 'pendings') ? 'Pending' : $item->status);
            })
            ->editColumn('created_at', function (NewsLetterEmailLog $item) {
                return BaseHelper::formatDate($item->created_at,'m/d/Y');
            })
            ->addColumn('operations', function (NewsLetterEmailLog $item) {
                return $this->getOperations(null, 'smslogs.distroy', $item, ($item->status != 'In-progress' && $item->status != 'Sent')?'<a href="#" class="sendMailToNewsLatterMail" data-id="' . $item->id . '" data-bs-toggle="tooltip" data-bs-original-title="SMS"><button class="btn btn-secondary action-item btn-warning">Send Sms</button><div class="loader" style="display:none;" ><img src="https://rentnking.com/loader.gif" style="width:60px;" /></div></a>': '');
            });

        //dd($data);

        return $this->toJson($data);
    }

    public function query(): Relation|Builder|QueryBuilder
    {
        
            $query = $this
            ->getModel()
            ->query()
            ->select('id','temp_name','number_of_users','status','created_at')->where('type','=','sms_template')->orderBy('status','asc');
        
                //dd($query);

        return $this->applyScopes($query);
    }
    public function applyFilterCondition(EloquentBuilder|QueryBuilder|EloquentRelation $query, string $key, string $operator, ?string $value): EloquentRelation|EloquentBuilder|QueryBuilder
    {
        // $query = $query
        //                 ->join(
        //                     'email_templates',
        //                     'email_templates.id',
        //                     '=',
        //                     'newsletter_email_logs.template_id'
        //                 );
        //return $query;
    }
    public function buttons(): array
    {
      
        $buttons = [];
        //$buttons =  $this->addCreateButton(route('smsbrodcast.process'), 'Send SMS');
        $buttons['sendsms'] = [
            'link' => route('smsbrodcast.process'),
            'text' => '<i class="fas fa-plus"></i> Send SMS',
            'class' => 'btn-primary',
        ];
        $buttons['createconent'] = [
            'link' => route('smsbrodcast'),
            'text' => '<i class="fas fa-plus"></i> Create Content',
            'class' => 'btn-warning',
        ];

        return $buttons;
    
        
    }
    public function columns(): array
    {
       
            return [
                'id' => [
                    'title' => 'ID',
                    'width' => '20px',
                ],
                'name' => [
                    'title' => 'Name',
                    'width' => '60px',
                ],
                'number_of_users' => [
                    'title' => 'Total users',
                    'class' => 'text-start',
                    'width' => '30px',
                ],
                
                'created_at' => [
                    'title' => 'created_at',
                    'width' => '50px',
                ],
                'status' => [
                    'title' => 'status',
                    'class' => 'text-start',
                    'width' => '50px',
                ],
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
