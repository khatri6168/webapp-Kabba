<?php

namespace Botble\Contact\Forms;

use Botble\Base\Facades\Assets;
use Botble\Base\Forms\FormAbstract;
use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Contact\Enums\ContactTags;
use Botble\Contact\Http\Requests\EditContactRequest;
use Botble\Contact\Models\Contact;
use Botble\Contact\Models\Company;
use Botble\Payment\Models\Payment;
use Carbon;
use DB;

class ContactForm extends FormAbstract
{
    protected $template = 'plugins/contact::forms.form';
    function phoneNumber($data) {
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
    public function buildForm(): void
    {
        Assets::addScriptsDirectly('vendor/core/plugins/contact/js/contacts.js')->addStylesDirectly('vendor/core/plugins/contact/css/contact.css');
        $contacttag = [];
        $contacttags = DB::select('select name from contacttags order by name asc ');
        $url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $con = explode("/", $url);
        //dd(end($con));
        $contactid = end($con);

        //dd('select * from contacts where id='.$contactid);
        $contactdetail = '';
        if(is_numeric($contactid)){
            $contactdetail = DB::select('select * from contacts where id='.$contactid);
            $contacttag = explode(',',$contactdetail[0]->contactTag);
            $phone = $this->phoneNumber($contactdetail[0]->phone);

        }


        //dd($contacttags);
        if($contacttags){
            $html = '';
            foreach($contacttags as $tag){
                //dd($tag['name']);
               // $html .= '<option value = "'.$tag->name.'">'.$tag->name.'</option>';
                if(!empty($contacttag)){
                    if(in_array($tag->name,$contacttag)){
                        $html .= '<option value = "'.$tag->name.'" selected>'.$tag->name.'</option>';
                    }else{
                        $html .= '<option value = "'.$tag->name.'">'.$tag->name.'</option>';
                    }

                }else{
                    $html .= '<option value = "'.$tag->name.'">'.$tag->name.'</option>';
                }

            }
        }
        $notestring = '';

        $notesListhtml='<table class="table table-striped table-hover vertical-middle">
        <thead>

        </thead><tbody>';
        if(is_numeric($contactid)){
            $notesLists = DB::select('select * from contact_notes where contact_id='.$contactid.' order by id desc');
            $numItems = count($notesLists);
            $i = 0;
            $deleteNotes =  url('admin/contacts/edit/'.$contactid.'/notes/delete');
            if(count($notesLists)>0)
            {

                foreach($notesLists as $note){


                    if(++$i === $numItems) {
                        $notestring .= $note->notes;
                      }else{
                        $notestring .= $note->notes.',';
                      }
                      $time = strtotime($note->updated_at.' - 5 hours');
                      $myDateTime = date("m-d-Y H:i:s", $time);


                $action='<div class="table-actions">
                <a href="javascript:void(0)" onClick="updateNote('.$note->id.')" id="note-'.$note->id.'" data-id="'.$note->id.'" data-notes="'.$note->notes.'" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="tooltip" style="padding:1px 8px 4px 8px;" data-bs-original-title="Edit"><i class="fa fa-edit" style="font-size:10px;"></i></a>
                <a href="#" onClick="deleteNote('.$note->id.')" id="delete-note-'.$note->id.'" data-id="'.$note->id.'" class="btn btn-icon btn-sm btn-danger deleteDialog" style="padding:1px 8px 4px 8px;" data-bs-toggle="modal" data-bs-target=".modal-confirm-delete" data-bs-toggle="tooltip" data-section="'.$deleteNotes.'" role="button" data-bs-original-title="Delete">
                    <i class="fa fa-trash" style="font-size:10px;"></i>
                </a>
                </div>';
                $notesListhtml .= "<tr id='row-note-".$note->id."'><td><span class='row-note-".$note->id."'>".$note->notes."</span><br /><em style='font-size:10px;'>".$myDateTime."</em></td><td style='width:31%;'>".$action."</td></tr>";
                }
            }
            else
            {
                $notesListhtml .= "<tr><td class='text-center' colspan='2'>No Data</td>";
            }
            //echo $notestring;
        }
        $notesListhtml.="</tbody></table>";
        //dd($contacttag);
        $countryValue = DB::select('select id,name from country where code="US"');
        $stateValue = DB::select('select id,name,is_default from states where country_id=1');

        $str = array();
        $staestr = array();
        $defaultSelectedState = "";
        foreach ($countryValue as $key => $value) {
            $str[$value->name] = $value->name;
        }

        $staestr['0']='-- Select state --';
        foreach ($stateValue as $key => $value) {
            $staestr[$value->name] = $value->name;
            if ($value->is_default == 1) {
                $defaultSelectedState = $value->name;
            }
        }

       // dd($staestr);
       //$companies = array();

        $companies = Company::pluck('company_name','id')->toArray();
        //$companies[100] = 'select company';

        array_unshift($companies,'select company');
        //dd($companies);




        $str = array();
        foreach ($countryValue as $key => $value) {
            $str[$value->name] = $value->name;
        }

        $countryOptions = "";
        foreach ($str as $countryName) {
            if($countryName == "United States"){
                $countryOptions .= "<option value='" . $countryName . "' selected>" . $countryName . "</option>";
            }
        }
        // dd($countryOptions);

        if(\Request::segment(3) != 'reply'){

        $this->setupModel(new Contact())
            ->setValidatorClass(EditContactRequest::class)
            ->withCustomFields()
            ->add('rowOpen1', 'html', [
                'html' => '
                <style>
                .form-side-meta-boxes > .meta-boxes:first-of-type { display:none; }
                .form-actions-wrapper .widget-title{
                    display:none;
                }
                .sameascheckbox{
                    font-size:14px;
                }
                .add-button-custome{
                    background-color:#4d97c1 !important;
                }
                .charcounter{
                    display:none !important;
                }
                </style>
                <script>


                function validateEmail(email) {
                    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                    var errhtml = "<span class=\"mobile_error\" style=\"color:red;\">Email not valid.</span>"
                    var succhtml = "<span class=\"mobile_sucess\" style=\"color:green;\">Email valid.</span>"
                    if (!emailReg.test(email)) {
                        if ($(".mobile_error")[0]){

                        }else{
                            $("#email").after(errhtml);
                        }

                    } else {
                        $(".mobile_error").remove();
                    }
                }

                updateNote=function(id) {
                    var myModal = new bootstrap.Modal(document.getElementById("NotesModal"), {
                      keyboard: false
                    });

                    var notes=$("#note-"+id).attr("data-notes");
                    var id=$("#note-"+id).data("id");
                    $("#notes_name").val(notes)
                    $(".old_val").val(notes);
                    $("#notes_id").val(id)
                    myModal.show();
                  }
                $ (document).ready(function() {
                    $(".control-label-2").append("<span class=\"add-button-custome d-inline ms-2\" data-bs-toggle=\"modal\" data-bs-target=\"#NotesModal\" style=\"background-color: red;width: auto;padding: 2px;cursor:pointer;height: fit-content;border-radius: 4px;\"><i class=\"fa fa-plus text-white\" aria-hidden=\"true\"></i></span>")

                    $("#email").first().keyup(function () {
                        var $email = this.value;
                        validateEmail($email);
                    });
                })
                </script>
                <div class="row">
                <div id="exampleModal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>Add Company</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
                <div class="row p-2">
                    <form action="#" id="companyCreateForm">
                        <div class="mb-3 col-md-3">
                            <label for="company_name" class="form-label required">Company Name</label>
                            <input type="text" class="form-control" id="company_name" aria-describedby="emailHelp" name="company_name"/>
                            <small id="emailHelp" class="form-text text-muted"></small>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="company_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="company_email" aria-describedby="emailHelp" name="company_email"/>
                        </div>
                        <div class="mb-3 col-md-3">
                        <label for="company_country" class="form-label">Country</label>
                        <select id="company_country" class="form-select form-control" aria-label="Default select example" name="company_country">
                                '.$countryOptions. '
                                </select>
                        </div>
                        <div class="mb-3 col-md-3">
                            <label for="company_url" class="form-label">URL</label>
                            <input type="email" class="form-control" id="company_url" aria-describedby="emailHelp" name="company_url">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="company_address">Address</label>
                            <textarea class="form-control" placeholder="Address" id="company_address" style="height: 100px" name="company_address"></textarea>
                        </div>


                 </div>
                     <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning">Cancel</button>
                     <button type="button"  class="btn btn-primary companyCreateBtn">save</button>
                     </form></div></div></div></div></div>',
            ])
            // ->add('name', 'text', [
            //     'label' => trans('core/base::forms.name'),
            //     'label_attr' => ['class' => 'control-label required'],
            //     'wrapper'    => [
            //         'class' => 'form-group col-md-3',
            //     ],
            //     'attr' => [
            //         'placeholder' => trans('core/base::forms.name_placeholder'),
            //         'data-counter' => 120,
            //         'class' => 'form-control'
            //     ],
            // ])

            ->add('first_name', 'text', [
                'label'      => 'First Name',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'First Name',
                    'data-counter' => 120,
                    'class' => 'form-control'
                ],
            ])
            ->add('last_name', 'text', [
                'label'      => 'Last Name',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'Last Name',
                    'data-counter' => 120,
                    'class' => 'form-control'
                ],
            ])
            // ->add('phone', 'text', [
            //     'label' => 'Mobile',
            //     'label_attr' => ['class' => 'control-label'],
            //     'wrapper'    => [
            //         'class' => 'form-group col-md-4',
            //     ],
            //     'attr' => [
            //         'placeholder' =>'Mobile',
            //         'data-counter' => 20,
            //         'class' => 'form-control'
            //     ],
            // ])
            ->add('phone', 'text', [
                'label' => 'Mobile',
                'label_attr' => ['class' => 'control-label mobile required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                //'html' => '<span class="mobile_error" style="color:red; text-align:right;"></span>',
                'attr' => [
                    'placeholder' => 'xxx-xxx-xxxx',
                    'data-counter' => 24,
                    'class' => 'form-control'
                ],
            ])

            ->add('phone2', 'text', [
                'label' => 'Phone 2',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'xxx-xxx-xxxx',
                    'data-counter' => 24,
                    'class' => 'form-control'
                ],
            ])
            ->add('email', 'email', [
                'label' => trans('core/base::forms.email'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('core/base::forms.email_placeholder'),
                    'data-counter' => 60,
                ],
            ])
            ->add('skype', 'text', [
                'label' => trans('Skype'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'Skype',
                ],
            ])->add('blank', 'html', [
                'wrapper'    => [
                    'class' => 'form-group col-md-6',
                ],
            ])


            ->add('address', 'text', [
                'label' => trans('Address'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('Address'),
                    'data-counter' => 120,
                ],
            ])
            ->add('city', 'text', [
                'label' => trans('City'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('City'),
                    'data-counter' => 20,
                ],
            ])
            ->add('state', 'select', [
                'label' => __('State'),
                'label_attr' => ['class' => 'control-label '], // Add class "required" if that is mandatory field
                'choices'    => $staestr,
                'wrapper'    => [
                    'class' => 'form-group col-md-3 select2',
                ],
                'selected' => ($contactdetail) ? $contactdetail[0]->state : $defaultSelectedState
            ])
            ->add('zipcode', 'text', [
                'label' => trans('Zipcode'),
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('Zipcode'),
                    'data-counter' => 20,
                ],
            ])
            ->add('rightcon', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('rightcon1', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('rightcon2', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('country', 'select', [
                'label' => __('Country'),
                'label_attr' => ['class' => 'control-label '], // Add class "required" if that is mandatory field
                'choices'    => $str,
                'wrapper'    => [
                    'class' => 'form-group col-md-3 select2',

                ],
                'selected' => 'United States'
            ])
            ->add('rowClose1', 'html', [
                'html' => '</div>',
            ])
            ->add('rowOpen2', 'html', [
                'html' => '<br /><div class="row"><h5 class="com_section">Company Address</h5>',
            ])
            // ->add('currency', 'select', [
            //     'label' => __('Currency'),
            //     'label_attr' => ['class' => 'control-label required'], // Add class "required" if that is mandatory field
            //     'choices'    => [
            //         'USD' => 'USD',
            //         'INR' => 'INR'
            //     ],
            //     'wrapper'    => [
            //         'class' => 'form-group col-md-3 select2',
            //     ],
            //     'selected' => 'USD'
            // ])


            // ->add('email', 'text', [
            //     'label' => trans('core/base::forms.email'),
            //     'label_attr' => ['class' => 'control-label required'],
            //     'attr' => [
            //         'placeholder' => trans('core/base::forms.email_placeholder'),
            //         'data-counter' => 60,
            //     ],
            // ])
            // ->add('content', 'text', [
            //     'label' => trans('core/base::forms.content'),
            //     'label_attr' => ['class' => 'control-label required'],
            //     'attr' => [
            //         'placeholder' => trans('core/base::forms.content_placeholder'),
            //         'data-counter' => 120,
            //     ],
            // ])
            // ->add('company', 'text', [
            //     'label' => trans('Company'),
            //     'label_attr' => ['class' => 'control-label required'],
            //     'attr' => [
            //         'placeholder' => trans('Company'),
            //         'data-counter' => 120,
            //     ],
            // ])
            // ->add('rowOpen2', 'html', [
            //     'html' => '<i class="fa fa-plus text-danger" aria-hidden="true"></i>',
            // ])
            // ->add('span4', 'html', [
            //     'html' => '<span class="sameascheckbox"><input type = "checkbox" name="same_as_checkbox" class="same_as_checkbox" />Same as above</span>',
            // ])


            ->add('company', 'text', [ // Change "select" to "customSelect" for better UI
                'label' => __('Company Name'),
                'label_attr' => [
                    'class' => 'control-label control-label-1',


                ], // Add class "required" if that is mandatory field
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'Company Name',

                ],
                //'selected' => ($contactdetail) ? $contactdetail[0]->company : 'Select company'


            ])





            ->add('phone_2', 'text', [
                'label' => trans('Phone'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'xxx-xxx-xxxx',
                    'data-counter' => 24,
                ],
            ])
            ->add('span3', 'html', [
                'html' => '<span class="mobile3_error" style="color:red;display:contents;"></span>',
            ])

            ->add('tax_id', 'text', [
                'label' => trans('Tax Id'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('Tax Id'),
                    'data-counter' => 20,
                ],
            ])
            ->add('url', 'text', [
                'label' => 'URL',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' =>'URL',
                    'data-counter' => 20,
                ],
            ])
            ->add('companyaddress', 'text', [
                'label' => trans('Address'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('Address'),
                    'data-counter' => 120,
                ],
            ])
            ->add('companycity', 'text', [
                'label' => trans('City'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('City'),
                    'data-counter' => 20,
                ],
            ])
            ->add('companystate', 'select', [
                'label' => __('State'),
                'label_attr' => ['class' => 'control-label '], // Add class "required" if that is mandatory field
                'choices'    => $staestr,
                'wrapper'    => [
                    'class' => 'form-group col-md-3 select2',
                ],
                'selected' => ($contactdetail) ? $contactdetail[0]->companystate : $defaultSelectedState
            ])
            ->add('companyzipcode', 'text', [
                'label' => trans('Zipcode'),
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('Zipcode'),
                    'data-counter' => 20,
                ],
            ])
            ->add('rightcon3', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('rightcon4', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('rightcon5', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('companycountry', 'select', [
                'label' => __('Country'),
                'label_attr' => ['class' => 'control-label '], // Add class "required" if that is mandatory field
                'choices'    => $str,
                'wrapper'    => [
                    'class' => 'form-group col-md-3 select2',
                ],
                'selected' => 'United States'
            ])

            ->add('rowClose2', 'html', [
                'html' => '</div>',
            ])

            ->add('rowOpen3', 'html', [
                'html' => '<br /><div class="row"><h5 class="del_section">Delivery / Shipping Address</h5>'
            ])
            ->add('delrowopen', 'html', [
                'html' => '<div class="row del_row" style="display:none;">'
            ])
            ->add('delivery_first_name', 'text', [
                'label' => 'First Name',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'First Name',
                    'data-counter' => 120,
                ],
            ])
            ->add('delivery_last_name', 'text', [
                'label' => 'Last Name',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'Last Name',
                    'data-counter' => 120,
                ],
            ])
            ->add('delivery_mobile', 'text', [
                'label' => 'Mobile',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'xxx-xxx-xxxx',
                    'data-counter' => 14,
                ],
            ])
            ->add('delivery_mobile2', 'text', [
                'label' => 'Phone 2',
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => 'xxx-xxx-xxxx',
                    'data-counter' => 24,
                ],
            ])
            ->add('delivery_address', 'text', [
                'label' => trans('Address'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('Address'),
                    'data-counter' => 120,
                ],
            ])
            ->add('delivery_city', 'text', [
                'label' => trans('City'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('City'),
                    'data-counter' => 120,
                ],
            ])
            ->add('temp_notes', 'hidden', [
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
            ])

            ->add('same_as_del', 'hidden', [
                'label' => 'temp notes',
                'label_attr' => ['class' => 'control-label'],
                'value'=>isset($contactdetail[0]->same_as_delivery) ? $contactdetail[0]->same_as_delivery : '',
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('City'),
                    'data-counter' => 120,
                    'id'=>'same_as_del',

                ],
            ])
            ->add('same_as_com', 'hidden', [
                'label' => 'temp notes',
                'label_attr' => ['class' => 'control-label'],
                'value'=>isset($contactdetail[0]->same_as_company) ? $contactdetail[0]->same_as_company : '',
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('City'),
                    'data-counter' => 120,
                    'id'=>'same_as_com',

                ],
            ])
            ->add('delivery_state', 'select', [
                'label' => __('State'),
                'label_attr' => ['class' => 'control-label '], // Add class "required" if that is mandatory field
                'choices'    => $staestr,
                'wrapper'    => [
                    'class' => 'form-group col-md-3 select2',
                ],
                'selected' => ($contactdetail)? $contactdetail[0]->delivery_state : $defaultSelectedState
            ])



            ->add('delivery_zipcode', 'text', [
                'label' => trans('Zipcode'),
                'label_attr' => ['class' => 'control-label'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                ],
                'attr' => [
                    'placeholder' => trans('Zipcode'),
                    'data-counter' => 20,
                ],
            ])
            ->add('rightcon6', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('rightcon7', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('rightcon8', 'html', [
                'html' => '<div class="col-md-3"></div>',
            ])
            ->add('delivery_country', 'select', [
                'label' => trans('Country'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => $str,
                'wrapper'    => [
                    'class' => 'form-group col-md-3 select-2',
                ],
                'selected' => 'United States',
            ])
            ->add('delrowclose', 'html', [
                'html' => '</div>'
            ])
            ->add('rowClose3', 'html', [
                'html' => '</div>',
            ])

            ->add('rowOpen4', 'html', [
                'html' => '<div class="row">' ,
            ])

            ->setBreakFieldPoint('country')

            ->add('rowClose4', 'html', [
                'html' => '</div>',
            ])









            // ->add('rowOpen6', 'html', [

            // ])

            // ->add('rowClose6', 'html', [
            //     'html' => '</div>',
            // ])
            // ->add('rowOpen7', 'html', [
            //     'html' => '<div class="row">',
            // ])



            // ->add('rowClose7', 'html', [
            //     'html' => '</div>',
            // ])

            // ->add('rowOpen8', 'html', [
            //     'html' => '<div class="row">',
            // ])


            // ->add('rowClose8', 'html', [
            //     'html' => '</div>',
            // ])

            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'wrapper'    => [
                    'class' => 'form-group col-md-3',
                    'style'=>'display:none;'
                ],
                //'attr'=>'style="display:none;"',
                'choices' => ContactStatusEnum::labels(),
            ])

            ->add('Tags', 'html', [

                'html'=>'

    <link
      href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet"
    />


    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>
    <script>
    $(document).ready(function(){
        var phonelen = $("#phone").val()
        if(phonelen.length == 11){
           if(phonelen.charAt(0) == 1){
            $("#phone").val(phonelen.slice(1));
           }
        }
        $("#phone, #phone2, #phone_2, #mobile_d, #mobile2_d").inputmask("(999) 999-9999");

        $("#phone, #phone2, #phone_2, #mobile_d, #mobile2_d").on("keyup", function() {
            var inputValue = $(this).val();
            if (inputValue.length === 10) {
                $(this).val(inputValue);
            }
        });

        $(document).on("click", ".add-tag", function(e) {
            e.preventDefault();
            $("#comment-modal").modal("show");
        });


    });
    </script>

    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
      integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <div id="comment-modal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>Contact Tags</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close"></button></div> <div class="modal-body with-padding">
                <form name="updatesms" id="createtagform" method="POST" action="https://rentnking.com/admin/contacts/createtags" >
                <label for="comment-text">Title</label>
                <input type="text" name="tagtitle"  class="form-control tagtitle" />


                </div> <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start btn btn-warning cancelbtnc">Cancel</button> <button id="save-comment-button" class="float-end btn btn-info createtags " type="button">submit</button></form></div></div></div></div>
                <span class="successt" style="color:green"></span>

                <select class="form-control contactTags" name="contactTag[]" multiple="multiple">
                   '.$html.'
                </select>

                <script>
                $(".contactTags").select2({
                    tags: true
                  });
                </script>
                '
            ])
            ->setBreakFieldPoint('status');
        }

        //if ($this->getModel()->id && \Request::segment(3) != 'reply')
        //{

            $this->add('notes', 'html', [
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
                <div id="NotesModal" tabindex="-1" aria-labelledby="comment-modal" data-backdrop="static" data-keyboard="false" class="modal fade" style="display: none;" aria-hidden="true"><div class="modal-dialog modal-lg "><div class="modal-content"><div class="modal-header bg-info"><h4 class="modal-title"><strong>Add Notes</strong></h4> <button type="button" data-bs-dismiss="modal" aria-hidden="true" class="btn-close notesModalClose"></button></div> <div class="modal-body with-padding">
                <div class="row p-2">
                    <form action="#" id="notesCreateForm">
                        <input type="hidden" id="company_id_notes" value="'.$this->getModel()->id.'" />
                        <input type="hidden" id="notes_id" />

                        <div class="mb-3 col-md-12">
                            <label for="notes_name" class="form-label required">Enter Notes</label>
                            <textarea class="form-control" style="width:100% !important;height:150px" id="notes_name" aria-describedby="emailHelp" name="notes_name"></textarea>
                            <input type="hidden" class="old_val">
                            <small id="notes_nameHelp" class="form-text text-muted"></small>
                        </div>

                 </div>
                     <div class="modal-footer"><button type="button" data-bs-dismiss="modal" class="float-start notesModalClose btn btn-warning">Cancel</button>
                     <button type="button" data-bs-dismiss="modal" class="btn btn-primary notesCreateBtn">Save</button>
                     </form></div></div>',

            ]);

       // }

            $customerid = 0;
            if(isset($contactdetail[0]->email)){
                $customer = DB::select('select * from ec_customers where email = "'.$contactdetail[0]->email.'"');
                if(isset($customer[0])){
                    $customerid = $customer[0]->id;
                }

            }


       //dd($users);
        $this->addMetaBoxes([
            'payments' => [
                'title' => 'Orders',
                'content' => view('plugins/ecommerce::customers.payments.payments', [
                    'payments' =>Payment::where('customer_id', $customerid)->get(),
                ])->render(),
                'wrap' => true,
            ],
        ]);

        if ($this->getModel()->id && \Request::segment(3) == 'reply') {
            $this->addMetaBoxes([
                'payments' => [
                    'title' => 'Orders',
                    'content' => view('plugins/ecommerce::customers.payments.payments', [
                        'payments' => $this->model->payments()->get(),
                    ])->render(),
                    'wrap' => true,
                ],
            ]);


        }
    }
}
