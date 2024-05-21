<?php

namespace Botble\Contact\Tables;

use Botble\Base\Facades\BaseHelper;
use Botble\Contact\Models\Contact;
use Botble\Contact\Models\Contacttag;
use Botble\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Botble\Table\DataTables;

class ContactTags extends TableAbstract
{
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        Contacttag $contact_tag
    ) {
        parent::__construct($table, $urlGenerator);

         $contact_tag = new Contacttag;
        $this->model = $contact_tag;
        $this->hasCheckbox = false;

        $this->hasActions = true;
        $this->hasFilter = true;

        if (! Auth::user()->hasPermission('contacttags.destroy')) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    public function ajax(): JsonResponse
    {
       // dd('here');
       
        $data = $this->table
        ->eloquent($this->query())
        // ->editColumn('name', function (Contact $item) {
        //     if (! Auth::user()->hasPermission('contacts.edit')) {
        //         return BaseHelper::clean($item->name);
        //     }

        //     return Html::link(route('contacts.edit', $item->getKey()), BaseHelper::clean($item->name));
        // })
        ->editColumn('name', function (Contacttag $item) {
            return BaseHelper::clean(trim($item->name)) ?: '&mdash;';
        })
        ->editColumn('checkbox', function (Contacttag $item) {
            return $this->getCheckbox($item->getKey());
        })
        
        ->addColumn('operations', function (Contacttag $item) {
            return $this->getOperations(null, 'contacttags.destroy', $item, '<a href="#" class="btn btn-icon btn-sm btn-primary edittag"  data-id="' . $item->id . '" data-bs-toggle="tooltip" data-bs-original-title="Edit"><i class="fa fa-edit"></i></a>
            
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
                'name',
                
            ]);
        


        return $this->applyScopes($query);
    }
    public function buttons(): array
    {
        return $this->addCustomeCreateButton();
    }
    public function columns(): array
    {
        
            return [
                
                'name' => [
                    'title' => 'name',
                    'class' => 'text-start',
                    'width' => 'auto',
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
