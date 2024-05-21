<?php

namespace Botble\Contact\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Contact\Exports\ContactExport;
use Botble\Contact\Models\Contact;
use Botble\Base\Facades\Html;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Validation\Rule;
use Botble\Table\DataTables;

class ContactTable extends TableAbstract
{
    protected string $exportClass = ContactExport::class;

    public function __construct(DataTables $table, UrlGenerator $urlGenerator, Contact $contact)
    {
        parent::__construct($table, $urlGenerator);

        $this->model = $contact;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (! Auth::user()->hasAnyPermission(['contacts.edit', 'contacts.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function (Contact $item) {
                if (! Auth::user()->hasPermission('contacts.edit')) {
                    return BaseHelper::clean(($item->name) ? $item->name : $item->first_name.' '.$item->last_name);
                }

                return Html::link(route('contacts.edit', $item->getKey()), BaseHelper::clean(($item->name) ? $item->name : $item->first_name.' '.$item->last_name));
            })
            ->editColumn('checkbox', function (Contact $item) {
                return $this->getCheckbox($item->getKey());
            })
            ->editColumn('created_at', function (Contact $item) {
                return BaseHelper::formatDate($item->created_at,'m/d/Y');
            })
            ->editColumn('phone', function (Contact $item) {
                return $this->phoneNumber($item->phone);
            })
            ->editColumn('contactTag', function (Contact $item) {
                return BaseHelper::clean(str_replace(",", ", ",$item->contactTag));
            })

            ->addColumn('operations', function (Contact $item) {
                if (!empty($item->customer_id)) {
                    //return $this->getOperations('contacts.edit', 'contacts.destroy', $item, '<a href="/admin/customers/edit/'.$item->customer_id. '" class="btn btn-icon btn-sm btn-info" data-bs-toggle="tooltip" target="_blank" data-bs-original-title="View Customer"><i class="fa fa-user"></i></a>' );
                }
                return $this->getOperations('contacts.edit', 'contacts.destroy', $item, );
                // return $this->getOperations('contacts.edit', 'contacts.destroy', $item, '<a href="/admin/contacts/reply/'.$item->id. '" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-original-title="Reply"><i class="fa fa-reply"></i></a><a href="/admin/customers/edit/'.$item->customer_id. '" class="btn btn-icon btn-sm btn-success" data-bs-toggle="tooltip" data-bs-original-title="View Customer"><i class="fa fa-user"></i></a>' );
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
                'customer_id',
                'name',
                'first_name',
                'last_name',
                'phone',
                'email',
                'contactTag',
                'created_at',
                //'status',
            ]);

        return $this->applyScopes($query);
    }
    public function phoneNumber($data) {
        // add logic to correctly format number here
        // a more robust ways would be to use a regular expression
        $data = preg_replace('/[^a-zA-Z0-9-_\.]/','', trim($data));
        $code =  substr($data, 0, 2);
        //return $code;
        if(str_contains($code,'+1')){
           // return 'here';
            $data = substr($data,'+1'); 
            //return $data;
            return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
        }
        //return strlen($data);
        if(!str_contains($code,'+1') && strlen($data) == 11){
            //return strlen($data);
            $data =  substr($data, 1);
            return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
        }
        if(!str_contains($code,'+1') && strlen($data) == 10){
            // return $code;
             return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
         }
        if(!str_contains($code,'+1') && strlen($data) > 11){
             
           $data =  substr($data, 2);
           return "(".substr($data, 0, 3).") ".substr($data, 3, 3)."-".substr($data,6);
         }
        
    }
    public function buttons(): array
    {
        $buttons = [];
        $buttons =  $this->addCreateButton(route('contacts.create'), 'contacts.create');
        $buttons['import'] = [
            'link' => route('contacts.import'),
            'text' => '<i class="fas fa-cloud-upload-alt"></i> Import Contacts',
            'class' => 'btn-warning',
        ];

        return $buttons;
    }

    public function columns(): array
    {
        return [
            'id' => [
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name' => [
                'title' => trans('core/base::tables.name'),
                'class' => 'text-start',
            ],
            'email' => [
                'title' => trans('plugins/contact::contact.tables.email'),
                'class' => 'text-start',
            ],
            'phone' => [
                'title' => trans('plugins/contact::contact.tables.phone'),
            ],
            'contactTag' => [
                'title' => 'Tag',
            ],
            'created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],

        ];
    }

    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('contacts.deletes'), 'contacts.destroy', parent::bulkActions());
    }

    public function getBulkChanges(): array
    {
        return [
            'name' => [
                'title' => trans('core/base::tables.name'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'email' => [
                'title' => trans('core/base::tables.email'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'phone' => [
                'title' => trans('plugins/contact::contact.sender_phone'),
                'type' => 'text',
                'validate' => 'required|max:120',
            ],
            'status' => [
                'title' => trans('core/base::tables.status'),
                'type' => 'customSelect',
                'choices' => ContactStatusEnum::labels(),
                'validate' => 'required|' . Rule::in(ContactStatusEnum::values()),
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
            'export',
            'reload',

        ];
    }
}
