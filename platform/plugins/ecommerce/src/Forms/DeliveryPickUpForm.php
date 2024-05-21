<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Facades\Assets;
use Botble\Ecommerce\Enums\DeliveryStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\DeliveryPickUpRequest;
use Botble\Ecommerce\Models\DeliveryPickup;
use DB;

class DeliveryPickUpForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this->addAssets();
        $countryValue = DB::select('select id,name from country where code="US"');
        $stateValue = DB::select('select id,name,is_default from states where country_id=1');

        $str = array();
        $stateStr = array();
        $defaultSelectedState = "";
        foreach ($countryValue as $key => $value) {
            $str[$value->name] = $value->name;
        }

        $stateStr['0']='-- Select state --';
        foreach ($stateValue as $key => $value) {
            $stateStr[$value->name] = $value->name;
            if ($value->is_default == 1) {
                $defaultSelectedState = $value->name;
            }
        }

        $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $con = explode("/", $url);
        $deliveryId = end($con);

        $this
            ->setupModel(new DeliveryPickup())
            ->setValidatorClass(DeliveryPickUpRequest::class)
            ->withCustomFields()
            ->setWrapperClass('row')
            ->add('name', 'text', [
                'label' => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.name'),
                    'data-counter' => 120,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('phone', 'text', [
                'label' => trans('plugins/ecommerce::deliveries.form.phone'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('plugins/ecommerce::deliveries.form.phone'),
                    'data-counter' => 400,
                    'class' => ['form-control', 'phone'],
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('email', 'text', [
                'label' => trans('plugins/ecommerce::deliveries.form.email'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => 'Ex: john@gmail.com',
                    'data-counter' => 120,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('address', 'text', [
                'label' => trans('plugins/ecommerce::deliveries.form.address'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::deliveries.form.address'),
                    'data-counter' => 120,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('city', 'text', [
                'label' => trans('plugins/ecommerce::deliveries.city'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::deliveries.city'),
                    'data-counter' => 120,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('state', 'customSelect', [
                'label' => trans('plugins/ecommerce::deliveries.state'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'data-counter' => 120,
                ],
                'choices' => $stateStr,
                'wrapper' => [
                    'class' => 'form-group col-md-3 select2',
                ],
            ])
            ->add('country', 'customSelect', [
                'label' => trans('plugins/ecommerce::deliveries.country'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
//                    'placeholder' => trans('plugins/ecommerce::deliveries.country'),
                    'data-counter' => 120,
                ],
                'choices'    => $str,
                'wrapper'    => [
                    'class' => 'form-group col-md-3 select2',
                ],
                'selected' => 'United States'
            ])
            ->add('zip_code', 'text', [
                'label' => trans('plugins/ecommerce::deliveries.zip_code'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::deliveries.zip_code'),
                    'data-counter' => 120,
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('delivery_date', 'datePicker', [
                'label' => trans('plugins/ecommerce::deliveries.delivery_date'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::deliveries.delivery_date'),
                    'data-date-format' => 'M d, Y',
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('delivery_time', 'time', [
                'label' => trans('plugins/ecommerce::deliveries.delivery_time'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::deliveries.delivery_time'),
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('pickup_date', 'datePicker', [
                'label' => trans('plugins/ecommerce::deliveries.pickup_date'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::deliveries.pickup_date'),
                    'data-date-format' => 'M d, Y',
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('pickup_time', 'time', [
                'label' => trans('plugins/ecommerce::deliveries.pickup_time'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::deliveries.pickup_time'),
                ],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
            ])
            ->add('delivery_status', 'customSelect', [
                'label' => trans('plugins/ecommerce::deliveries.delivery_status'),
                'label_attr' => ['class' => 'control-label'],
                'choices' => DeliveryStatusEnum::labels(),
                'attr' => [
                    'disabled' => $this->getModel()->pickup_status == DeliveryStatusEnum::COMPLETED ? true: false,
                ]
            ])
            ->add('pickup_status', 'customSelect', [
                'label' => trans('plugins/ecommerce::deliveries.pickup_status'),
                'label_attr' => ['class' => 'control-label'],
                'choices' => DeliveryStatusEnum::labels(),
                'attr' => [
                    'disabled' => $this->getModel()->delivery_status == DeliveryStatusEnum::PENDING ? true: false,
                ]
            ])
            ->setBreakFieldPoint('delivery_status');

        $notestring = '';
        $notesListhtml='<table class="table table-striped table-hover vertical-middle"><thead></thead><tbody>';
        if (is_numeric($deliveryId)) {
            $notesLists = DB::select('select * from ec_delivery_notes where delivery_id='.$deliveryId.' order by id desc');
            $numItems = count($notesLists);
            $i = 0;
            $deleteNotes =  url('admin/ecommerce/deliveries/edit/'.$deliveryId.'/notes/delete');
            if (count($notesLists)>0) {
                foreach($notesLists as $note) {
                    if (++$i === $numItems) {
                        $notestring .= $note->notes;
                    } else {
                        $notestring .= $note->notes.',';
                    }
                    $time = strtotime($note->updated_at.' - 5 hours');
                    $myDateTime = date("m-d-Y H:i:s", $time);


                    $action='<div class="table-actions">
                                <a href="javascript:void(0)" onClick="updateNote('.$note->id.')" id="note-'.$note->id.'" data-id="'.$note->id.'" data-notes="'.$note->notes.'" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip" style="padding:1px 8px 4px 8px;" data-bs-original-title="Edit"><i class="fa fa-edit" style="font-size:10px;"></i></a>
                                <a href="#" class="notesDeleteBtn btn btn-danger btn-icon btn-sm" onClick="deleteNote('.$note->id.')" id="delete-note-'.$note->id.'" data-id="'.$note->id.'" class="btn btn-icon btn-sm btn-danger deleteDialog" style="padding:1px 8px 4px 8px;" data-bs-toggle="modal" data-bs-target=".modal-confirm-delete" data-bs-toggle="tooltip" data-section="'.$deleteNotes.'" role="button" data-bs-original-title="Delete">
                                    <i class="fa fa-trash" style="font-size:10px;"></i>
                                </a>
                            </div>';
                    $notesListhtml .= "<tr id='row-note-".$note->id."'><td><span class='row-note-".$note->id."'>".$note->notes."</span><br /><em style='font-size:10px;'>".$myDateTime."</em></td><td style='width:31%;'>".$action."</td></tr>";
                }
            } else {
                $notesListhtml .= "<tr><td class='text-center' colspan='2'>No Data</td></tr>";
            }
        }
        $notesListhtml.="</tbody></table>";

        $this->add('notes', 'blade', [
            'label' =>"". trans('plugins/contact::contact.tables.notes'),
            'label_attr' => [
                'class' => 'control-label control-label-2',

            ],
            'html' => '<div id="notest_list">'.$notesListhtml.'</div>
                <div class="modal fade modal-confirm-delete" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header bg-danger">
                                <h4 class="modal-title"><i class="til_img"></i><strong>Confirm delete</strong></h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>

                            <div class="modal-body with-padding" data-select2-dropdown-parent>
                                <div>Do you really want to delete this record?</div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="float-start btn btn-warning" data-bs-dismiss="modal">Cancel</button>
                                <button class="float-end btn btn-danger" data-bs-dismiss="modal" id="notes-action-button" type="button" >Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="NotesModal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg ">
                        <div class="modal-content">
                            <div class="modal-header bg-info"><h4 class="modal-title"><strong>Add Notes</strong></h4>
                                <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close notesModalClose"></button>
                            </div>
                            <div class="modal-body with-padding">
                                <div class="row p-2">
                                    <form action="#" id="notesCreateForm">
                                        <input type="hidden" id="delivery_id_notes" value="'.$this->getModel()->id.'" />
                                        <input type="hidden" id="notes_id" />

                                        <div class="mb-3 col-md-12">
                                            <label for="notes_name" class="form-label required">Enter Notes</label>
                                            <textarea class="form-control" style="width:100% !important;height:150px" id="notes_name" aria-describedby="emailHelp" name="notes_name"></textarea>
                                            <input type="hidden" class="old_val">
                                            <small id="notes_nameHelp" class="form-text text-muted"></small>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-bs-dismiss="modal" class="float-start notesModalClose btn btn-warning">Cancel</button>
                                            <button type="button" data-bs-dismiss="modal" class="btn btn-primary notesCreateBtn">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>',
            ]);

        $this->add('temp_notes', 'hidden', [
            'label' => 'temp notes',
            'label_attr' => ['class' => 'control-label'],
            'value'=>$notestring,
            'wrapper'    => [
                'class' => 'form-group col-md-3',
            ],
            'attr' => [
                'placeholder' => trans('City'),
                'data-counter' => 120,
                'id'=>'temp_notes',

            ],
        ]);
    }

    public function addAssets(): void
    {
        Assets::addScriptsDirectly('vendor/core/plugins/ecommerce/js/delivery.js');
    }
}
