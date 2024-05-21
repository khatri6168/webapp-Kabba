<?php

namespace Botble\Contact\Http\Controllers;

use App\Imports\BulkImports;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Contact\Forms\ContactForm;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Botble\Contact\Models\ContactNote;
use Botble\Contact\Http\Requests\ContactReplyRequest;
use Botble\Contact\Http\Requests\EditContactRequest;
use Botble\Contact\Http\Requests\CreateContactRequest;
use Botble\Contact\Models\Contact;
use Botble\Contact\Repositories\Interfaces\ContactReplyInterface;
use Botble\Contact\Tables\ContactTable;
use Botble\Contact\Tables\ContactTags;
use Botble\Contact\Tables\CompanyList;
use Botble\Contact\Repositories\Interfaces\ContactInterface;
use Botble\Base\Facades\EmailHandler;
use Exception;
use Illuminate\Http\Request;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Contact\Exports\ContactExport;
use Botble\Contact\Models\Company;
use Botble\Ecommerce\Exports\TemplateProductExport;
use Twilio\Rest\Client;
use Botble\Ecommerce\Forms\CustomerForm;
use Illuminate\Support\Facades\Redirect;
use DB;
use File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Response;

class ContactController extends BaseController
{
    use HasDeleteManyItemsTrait;

    public function __construct(protected ContactInterface $contactRepository)
    {
    }
    public function bulkImport()
    {
        PageTitle::setTitle('Contacts Bulk import');
        Assets::addScriptsDirectly(['vendor/core/plugins/contact/js/bulk-import.js']);

        // $template = new TemplateProductExport('xlsx');
        // $headings = $template->headings();
        // $data = $template->collection();
        // $rules = $template->rules();

        $headings = Schema::getColumnListing('contacts');
        $data = Contact::leftJoin('companies', function ($join) {
            $join->on('contacts.company', '=', 'companies.id');
        })->take(3)
            ->get([
                'contacts.*',
                'companies.*',
            ])->toArray();

        if (($key = array_search('company', $headings)) !== false) {
            unset($headings[$key]);
        }
        if (($key = array_search('created_at', $headings)) !== false) {
            unset($headings[$key]);
        }
        if (($key = array_search('updated_at', $headings)) !== false) {
            unset($headings[$key]);
        }
        if (($key = array_search('id', $headings)) !== false) {
            unset($headings[$key]);
        }

        array_push($headings, 'company_name', 'company_email', 'company_country', 'company_url', 'company_address');

        $rules = [
            //'name' => 'required|string|max:220',
            'email' => 'required|string|max:220',
            //'currency' => 'required|string|max:220',
            'company_name' => 'required|string|max:220',
            'company_email' => 'required|string|max:220',
            'company_country' => 'nullable|string|max:220',
            'company_url' => 'nullable|string|max:220',
            'phone_1' => 'nullable|numeric|min:0|max:100000000000',
            'phone_2' => 'nullable|numeric|min:0|max:100000000000',
            'skype' => 'nullable|string|max:220',
            'tax_id' => 'nullable|numeric|min:0|max:100000000000',
            'address' => 'nullable|string|max:220',
            'city' => 'nullable|string|max:220',
            'state' => 'nullable|string|max:220',
            'zipcode' => 'nullable|numeric|min:0|max:1000000',
            'country' => 'nullable|string|max:220',
            'delivery_name' => 'nullable|string|max:220',
            'delivery_address' => 'nullable|string|max:220',
            'delivery_city' => 'nullable|string|max:220',
            'delivery_state' => 'nullable|string|max:220',
            'deleivery_zipcode' => 'nullable|numeric|min:0|max:1000000',
            'delivery_country' => 'nullable|string|max:220',
        ];

        return view('plugins/contact::bulk-import.index', compact('headings', 'data', 'rules'));
    }
    public function index(ContactTable $dataTable)
    {

        PageTitle::setTitle(trans('plugins/contact::contact.menu'));
        return $dataTable->renderTable();
    }
    public function addNotes(Request $request)
    {
        try {

            $data = $request->all();
            $contactNote = new ContactNote;
            $contactNote->notes = $data['notes'];
            $contactNote->contact_id = $data['contact_id'];

            $save = $contactNote->save();

            if ($save) {
                $response = [
                    'status' => true,
                    'message' => 'Notes Data Saved',
                    'data' => $contactNote
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Something went Wrong !!',
                    'data' => $data
                ];
            }

            return $response;
        } catch (Exception $e) {

            $response = [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];

            return $response;
        }
    }
    public function updateNotes(Request $request)
    {
        try {

            $data = $request->all();
            $contactNote = ContactNote::find($data["notes_id"]);
            if(!$contactNote)
            {
                $response = [
                    'status' => false,
                    'message' => 'Something went Wrong !!',
                    'data' => $data
                ];
                return $response;
            }

            $contactNote->notes = $data['notes'];


            $save = $contactNote->save();

            if ($save) {
                $response = [
                    'status' => true,
                    'message' => 'Notes Data Saved',
                    'data' => $contactNote
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Something went Wrong !!',
                    'data' => $data
                ];
            }

            return $response;
        } catch (Exception $e) {

            $response = [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];

            return $response;
        }
    }
    public function deleteNotes(Request $request)
    {
        try {

            $data = $request->all();
            $contactNote = ContactNote::find($data["id"]);
            if(!$contactNote)
            {
                $response = [
                    'status' => false,
                    'message' => 'Something went Wrong !!',
                    'data' => $data
                ];
                return $response;
            }
            $delete = $contactNote->delete();

            if ($delete) {
                $response = [
                    'status' => true,
                    'message' => 'Notes Data Deleted',
                    'data' => $contactNote
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Something went Wrong !!',
                    'data' => $data
                ];
            }

            return $response;
        } catch (Exception $e) {

            $response = [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];

            return $response;
        }
    }
    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/contact::contact.create'));

        return $formBuilder->create(ContactForm::class)->renderForm();
    }
    public function addCompany(Request $request)
    {
        try {

            $data = $request->all();
            $company_id = $data['company_id'];

            $company = new Company;
            $company->company_name = $data['company_name'];
            $company->company_email = $data['company_email'];
            $company->company_country = $data['company_country'];
            $company->company_url = $data['company_url'];
            $company->company_address = $data['company_address'];
            if($company_id){
                $save =  DB::table('companies')
            ->where('id', $company_id)
            ->update(['company_name' => $data['company_name'],'company_email' => $data['company_email'], 'company_country' => $data['company_country'], 'company_url' => $data['company_url'], 'company_address' => $data['company_address']]);
            }else{
                $save = $company->save();
            }


            if ($save) {
                $response = [
                    'status' => true,
                    'message' => 'Country Data Saved',
                    'data' => $company
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Something went Wrong !!',
                    'data' => $data
                ];
            }

            return $response;
        } catch (Exception $e) {

            $response = [
                'status' => false,
                'message' => $e->getMessage(),
                'data' => []
            ];

            return $response;
        }
    }

    public function store(CreateContactRequest $request, BaseHttpResponse $response)
    {

        $condetail = $request->input();
        //dd($condetail);
        if(!empty($condetail['first_name']) || !empty($condetail['last_name']) || !empty($condetail['phone']) || !empty($condetail['email'])){
            $contact = $this->contactRepository->getModel();
            if(array_key_exists('contactTag',$condetail)){
                foreach($condetail['contactTag'] as $contag){
                    $gettag = DB::select('select * from contacttags where name="'.$contag.'" ');
                    if(empty($gettag)){
                        $data = array("name"=>$contag);
                        DB::table('contacttags')->insert($data);
                    }
                }
                $condetail['contactTag'] = implode(',' , $condetail['contactTag']);

            }

            if($condetail['phone']){
                //dd($condetail['phone']);


                $phone= preg_replace('/[^A-Za-z0-9\-]/', '', $condetail['phone']);
                $string = '+'.str_replace('-', '', $phone);
                $condetail['phone'] = $string;

            }

            if(isset($condetail['same_as_delivery']) && ($condetail['same_as_delivery'] == 'on')){
                $condetail['first_name_d'] = $condetail['first_name'];
                $condetail['last_name_d'] = $condetail['last_name'];
                $condetail['mobile_d'] = $condetail['phone'];
                $condetail['mobile2_d'] = $condetail['phone2'];
                $condetail['delivery_address'] = $condetail['address'];
                $condetail['delivery_city'] = $condetail['city'];
                $condetail['delivery_state'] = $condetail['state'];
                $condetail['delivery_zipcode'] = $condetail['zipcode'];
            }
            if(isset($condetail['same_as_delivery']) && ($condetail['same_as_delivery'] == 'on')){
                $condetail['same_as_delivery'] = 1;
            }else{
                $condetail['same_as_delivery'] = 0;
            }
            if(isset($condetail['same_as_company']) &&  ($condetail['same_as_company']== 'on')){
                $condetail['same_as_company'] = 1;
            }else{
                $condetail['same_as_company'] = 0;
            }
           //dd($condetail);

            $contact->fill($condetail);
            $contact = $this->contactRepository->createOrUpdate($contact);
            if($contact->id && isset($condetail['temp_notes'])){
                $notes = explode(',',$condetail['temp_notes']);
                if($notes){
                    foreach($notes as $note){
                        $contactNote = new ContactNote;
                        $contactNote->notes = $note;
                        $contactNote->contact_id = $contact->id;
                        $contactNote->save();

                    }
                }

            }
            //dd($contact->id);

            return $response
                ->setPreviousUrl(route('contacts.index'))
                ->setNextUrl(route('contacts.edit', $contact->id))
                ->setMessage(trans('core/base::notices.create_success_message'));
        }else{
            return $response->setError()
            ->setMessage('Please enter atleast one field');
        }

    }

    public function edit(Contact $contact, FormBuilder $formBuilder)
    {
        // dd($contact);
        PageTitle::setTitle(trans('plugins/contact::contact.edit'));

        return $formBuilder->create(ContactForm::class, ['model' => $contact])->renderForm();
    }
    public function reply($id, FormBuilder $formBuilder)
    {
        $contact = Contact::find($id);
        PageTitle::setTitle(trans('plugins/contact::contact.edit'));

        return $formBuilder->create(ContactForm::class, ['model' => $contact])->renderForm();
    }

    public function update(Contact $contact, EditContactRequest $request, BaseHttpResponse $response)
    {
        $condetail = $request->input();
        if(array_key_exists('contactTag',$condetail)){
            foreach($condetail['contactTag'] as $contag){
                $gettag = DB::select('select * from contacttags where name="'.$contag.'" ');
                if(empty($gettag)){
                    $data = array("name"=>$contag);
                    DB::table('contacttags')->insert($data);
                }
            }
            $condetail['contactTag'] = implode(',' , $condetail['contactTag']);
        }
        if($condetail['phone']){
            //dd($condetail['phone']);


            $phone= preg_replace('/[^A-Za-z0-9\-]/', '', $condetail['phone']);
            $string = '+'.str_replace('-', '', $phone);
            $condetail['phone'] = $string;

        }
        if(isset($condetail['same_as_delivery']) && ($condetail['same_as_delivery'] == 'on')){
            $condetail['first_name_d'] = $condetail['first_name'];
            $condetail['last_name_d'] = $condetail['last_name'];
            $condetail['mobile_d'] = $condetail['phone'];
            $condetail['mobile2_d'] = $condetail['phone2'];
            $condetail['delivery_address'] = $condetail['address'];
            $condetail['delivery_city'] = $condetail['city'];
            $condetail['delivery_state'] = $condetail['state'];
            $condetail['delivery_zipcode'] = $condetail['zipcode'];
        }
        if(isset($condetail['same_as_delivery']) && ($condetail['same_as_delivery'] == 'on')){
            $condetail['same_as_delivery'] = 1;
        }else{
            $condetail['same_as_delivery'] = 0;
        }
        if(isset($condetail['same_as_company']) &&  ($condetail['same_as_company']== 'on')){
            $condetail['same_as_company'] = 1;
        }else{
            $condetail['same_as_company'] = 0;
        }
        //dd($condetail);
        $contact->fill($condetail);

        $updatedContact = $this->contactRepository->createOrUpdate($contact);
        if($updatedContact->id && isset($condetail['temp_notes'])){
            //echo $updatedContact->id;die;
            DB::table('contact_notes')->where('contact_id', $updatedContact->id)->delete();


            $notes = explode(',',$condetail['temp_notes']);
            if($notes){
                foreach($notes as $note){
                    $contactNote = new ContactNote;
                    $contactNote->notes = $note;
                    $contactNote->contact_id = $contact->id;
                    $contactNote->save();

                }
            }
        }

        event(new UpdatedContentEvent(CONTACT_MODULE_SCREEN_NAME, $request, $contact));

        return $response
            ->setPreviousUrl(route('contacts.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Contact $contact, Request $request, BaseHttpResponse $response)
    {
        try {
            $this->contactRepository->delete($contact);
            event(new DeletedContentEvent(CONTACT_MODULE_SCREEN_NAME, $request, $contact));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function destroyTag(Request $request, BaseHttpResponse $response)
    {
        $data = $request->all();
        $id = 0;
        foreach ($data as $key => $value) {
            if ($value == null) {
                $id = $key;
            }
        }

        DB::table('contacttags')->where('id', $id)->delete();
        return $response->setMessage(trans('core/base::notices.delete_success_message'));

    }

    public function destroyCompany(Request $request, BaseHttpResponse $response)
    {
        $data = $request->all();
        $id = 0;
        foreach ($data as $key => $value) {
            if ($value == null) {
                $id = $key;
            }
        }

        DB::table('companies')->where('id', $id)->delete();
        return $response->setMessage(trans('core/base::notices.delete_success_message'));

    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->contactRepository, CONTACT_MODULE_SCREEN_NAME);
    }

    public function postBulkImport(Request $request, BaseHttpResponse $response)
    {
        //dd('test');
        //ini_set("auto_detect_line_endings", true);

        try {







            BaseHelper::maximumExecutionTimeAndMemoryLimit();


            // if ($request->hasFile('file')) {

            //     $validator = Validator::make($request->all(), [
            //         'file' => 'file|mimes:xls,xlsx,csv,xml',
            //     ]);
            //     if ($validator->fails()) {
            //         return $response
            //         ->setError()
            //         ->setMessage('Please Provide Correct File');
            //     }
            // }
            // else{

            //     return $response
            //     ->setError()
            //     ->setMessage('Please Provide Correct File');

            // }


            $path = public_path() . "/csv";
            if (!Storage::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
            $file = $request->file('file');
            $path = public_path() . "/csv";
            $fileName = $file->getClientOriginalName();
            $file->move($path, $fileName);

            ini_set('memory_limit', '5000M');
            $filename = public_path() . "/csv/" . $fileName;

            $contacts = array();
            //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            //dd($extension);
            if($extension == 'csv'){
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            }
            if($extension == 'xlsx'){

                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($filename);
            $spreadsheet = $spreadsheet->getActiveSheet();
            //$spreadsheet = $spreadsheet->getHighestDataRow();
            $data_array =  $spreadsheet->toArray();
           // $alldata =  array_splice($data_array,0,0);
            //dd($data_array[1]);
            // $datacontact = array_pop(array_reverse($data_array));

            // $header = null;
            // if (($handle = fopen($filename, 'r')) !== false) {
            //     while (($row = fgetcsv($handle, null, ',')) !== false) {
            //         if (!$header) {
            //             $header = $row;
            //         } else {
            //             $contacts[] = $row;
            //         }
            //     }
            //     fclose($handle);
            // }

            if($data_array){
                $i=1;
                foreach($data_array as $data){
                    if($i > 1){
                        if(!empty($data) && $data[$i] != null){
                            //dd($data[26]);
                            $contacts[] = $data;
                            if($data[26]){
                                $tags = explode(',',$data[26]);

                                foreach($tags as $tag){
                                    $gettag = DB::select('select * from contacttags where name="'.$tag.'" ');
                                    //print_r($gettag);
                                    if(empty($gettag)){
                                        $data = array("name"=>$tag);
                                        DB::table('contacttags')->insert($data);
                                    }
                                }
                            }

                        }

                    }
                  $i++;
                }
            }
           // dd($contacts);
            $contacts = collect($contacts)->map(function ($item) {
                //$line = iconv('macintosh', 'UTF-8', $item[0]);
                //dd($item);
                return [
                    'name' => $item[0],
                    'tax_id' => $item[8],
                    'email' => $item[1],
                    'phone' => $item[2],
                    'phone_2' => $item[9],
                    'address' => $item[10],
                    'zipcode' => $item[11],
                    'city' => $item[12],
                    'state' => $item[13],
                    'country' => $item[14],
                    'delivery_name' => $item[15],
                    'delivery_address' => $item[16],
                    'delivery_zipcode' => $item[17],
                    'delivery_city' => $item[18],
                    'delivery_state' => $item[19],
                    'delivery_country' => $item[20],
                    'subject' => $item[21],
                    'content' => $item[22],
                    'status' => $item[23],
                    'currency' => $item[24],
                    'skype' => $item[25],
                    'company_name' => $item[3],
                    'company_email' => $item[4],
                    'company_url' => $item[5],
                    'company_country' => $item[6],
                    'company_address' => $item[7],
                    'contactTag' => $item[26],
                    'note'=>$item[27],
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ];
            })->chunk(1000)->toArray();

            foreach ($contacts as $contact) {
                foreach ($contact as $key => $value) {


                    $company = Company::where('company_email', "=", strtolower($value['company_email']))->orWhere('company_name', '=', strtolower($value['company_name']))->first();

                    if ($company) {
                        $company = $company->id;
                    } else {
                        $company = new Company;
                        $company->company_name = $value['company_name'];
                        $company->company_email = $value['company_email'];
                        $company->company_address = $value['company_address'];
                        $company->company_url = $value['company_url'];
                        $company->company_country = $value['company_country'];
                        $company->created_at = \Carbon\Carbon::now()->toDateTimeString();
                        $company->updated_at = \Carbon\Carbon::now()->toDateTimeString();
                        $save = $company->save();
                        if ($save) {
                            $company = $company->id;
                        }
                    }
                    //dd($value);
                    $contact = new Contact;
                    $contact->name = $value['name'];
                    $contact->tax_id = $value['tax_id'];
                    $contact->email = $value['email'];
                    $contact->phone = $value['phone'];
                    $contact->phone_2 = $value['phone_2'];
                    $contact->address = $value['address'];
                    $contact->zipcode = $value['zipcode'];
                    $contact->city = $value['city'];
                    $contact->state = $value['state'];
                    $contact->country = $value['country'];
                    $contact->delivery_name = $value['delivery_name'];
                    $contact->delivery_address = $value['delivery_address'];
                    $contact->delivery_zipcode = $value['delivery_zipcode'];
                    $contact->delivery_city = $value['delivery_city'];
                    $contact->delivery_country = $value['delivery_country'];
                    $contact->subject = $value['subject'];
                    $contact->content = $value['content'];
                    $contact->status = $value['status'];
                    $contact->contactTag = $value['contactTag'];
                    $contact->currency = $value['currency'];
                    $contact->skype = $value['skype'];
                    $contact->note = $value['note'];
                    $contact->company = $company;
                    $contact->save();
                }
            }
            return $response->setMessage('Data Stored Successfully..');
        } catch (Exception $e) {
            return $response
                ->setError()
                ->setMessage($e->getMessage());
        }
    }

    public function postReply(
        int|string $id,
        ContactReplyRequest $request,
        BaseHttpResponse $response,
        ContactReplyInterface $contactReplyRepository
    ) {
        $contact = $this->contactRepository->findOrFail($id);

        EmailHandler::send($request->input('message'), 'Re: ' . $contact->subject, $contact->email);
        // if($email){
        //     return true;
        // }else{
        //     return false;
        // }



        $contactReplyRepository->create([
            'message' => $request->input('message'),
            'contact_id' => $contact->id,
        ]);

        $contact->status = ContactStatusEnum::READ();
        $this->contactRepository->createOrUpdate($contact);

        return $response
            ->setMessage(trans('plugins/contact::contact.message_sent_success'));
        // return 'test';
    }
    public function downloadTemplate(Request $request)
    {
        $extension = $request->input('extension');
        $extension = $extension == 'csv' ? $extension : Excel::XLSX;
        $writeType = $extension == 'csv' ? Excel::CSV : Excel::XLSX;
        $contentType = $extension == 'csv' ? ['Content-Type' => 'text/csv'] : ['Content-Type' => 'text/xlsx'];
        // $file_path = $extension == 'csv' ? public_path('csv/template/contacts.csv') : public_path('csv/template/contacts.xlsx') ;
        $fileName = 'template_contacts_import.' . $extension;

         //return Response::download($file_path, 'filename.pdf', $contentType);
         //return (new CsvProductExport())->download('export_products.csv', Excel::CSV, ['Content-Type' => 'text/csv']);
        return (new ContactExport())->download($fileName, $writeType, $contentType);
    }



    public function companyList(CompanyList $dataTable)
    {
        PageTitle::setTitle('Company');
        return $dataTable->renderTable();
    }

    public function Tags(ContactTags $dataTable)
    {
        PageTitle::setTitle('Contact Tags');
        return $dataTable->renderTable();
    }
    public function EditTag(Request $request)
    {

            $id =  $request->id;
           $smsTemplate =  DB::table('contacttags')->where('id', $id)->first();
           return json_encode($smsTemplate);


    }

    public function EditCompany(Request $request)
    {

            $id =  $request->id;
           $smsTemplate =  DB::table('companies')->where('id', $id)->first();
           return json_encode($smsTemplate);


    }

    public function UpdateTag(Request $request)
    {
        //dd($request);

            $id =  $request->sms_id;
           DB::table('contacttags')
            ->where('id', $id)
            ->update(['name' => $request->sms_title]);
           return Redirect::to('http://rentnking.com/admin/contacts/contacttags');


    }
    public function CheckDuplicateTag(Request $request)
    {
        $tag = $request->name;
        $contacttags = DB::select('select * from contacttags where name="'.$tag.'" ');
        return count($contacttags);

    }

    public function CreateTags(Request $request)
    {
        //dd($request);
        $data = array("name"=>$request['tagtitle']);
        DB::table('contacttags')->insert($data);
        //dd($request);
        return Redirect::to('https://rentnking.com/admin/contacts/contacttags');
    }

    public function CreateTags2(Request $request)
    {
        //dd($request->name);
        $data = array("name"=>$request->name);
        DB::table('contacttags')->insert($data);
        return "Tag Insert";
        //dd($request);

    }

    public function CreateContactTags(Request $request){
        $errors = [];

        if(!$request->has('name')){
            array_push($errors,'Tag name not provided');
        }
        if(!empty($errors)){

            return response()->json([
                'errors' => $errors,
                'message' => 'Validation error...',
                'success' => false
            ],422);
        }
        $data = $request->all();
        DB::table('contacttags')->insert($data);
        return response()->json([
            'errors' => [],
            'data' => $data,
            'message' => 'Tag Created successfully..',
            'success' => true
        ], 200);

    }

    public function ContactTags(){
        $contacttags = DB::select('select * from contacttags ');
        $alltags = json_encode($contacttags);
        return $alltags;

    }

    public function AdminLogin(Request $request){


        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        //return $user;
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);

    }

}
