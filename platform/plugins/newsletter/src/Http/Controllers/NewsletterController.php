<?php

namespace Botble\Newsletter\Http\Controllers;

use Botble\Base\Events\DeletedContentEvent;
use Twilio\Rest\Client;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Newsletter\Models\EmailTemplate;
use Botble\Base\Facades\EmailHandler;
use Botble\Contact\Models\Contact;
use Botble\Ecommerce\Models\Customer;
use Botble\Newsletter\Models\Newsletter;
use Botble\Newsletter\Models\NewsLetterEmailLog;
use Botble\Newsletter\Repositories\Interfaces\NewsletterInterface;
use Botble\Newsletter\Tables\NewsletterTable;
use Botble\Newsletter\Tables\SmsBrodcastTable;
use Botble\Newsletter\Tables\SmsLogTable;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends BaseController
{
    use HasDeleteManyItemsTrait;

    public function __construct(protected NewsletterInterface $newsletterRepository)
    {
    }

    public function index(NewsletterTable $dataTable)
    {
        if(isset($_GET['sms']) && $_GET['sms'] == 1){
            PageTitle::setTitle('sms Brodcasts');
        }else{
            PageTitle::setTitle('email Broadcasts');
        }

        return $dataTable->renderTable();
    }

    public function SMSindex(SmsBrodcastTable $dataTable)
    {
        
            PageTitle::setTitle('sms Brodcasts');
        

        return $dataTable->renderTable();
    }

    public function SMSLogindex(SmsLogTable $dataTable)
    {
        
            PageTitle::setTitle('SMS Log');
        

        return $dataTable->renderTable();
    }

    public function EditSMS(Request $request)
    {
        
            $id =  $request->id;
           $smsTemplate =  DB::table('email_templates')->where('id', $id)->first(); 
           return json_encode($smsTemplate);      
        

    }

    public function UpdateSMSStatus(Request $request, BaseHttpResponse $response){
        $id = $request->id;
        NewsLetterEmailLog::where('id',$id)->update(['status'=>'In-progress']);
        return $response->setMessage('SMS Sent Successfully.');


    }

    public function UpdateSMSRecords(Request $request, BaseHttpResponse $response)
    {
        //dd($request);
        
            $id =  $request->sms_id;
           DB::table('email_templates')
            ->where('id', $id)
            ->update(['name' => $request->sms_title, 'description' => $request->sms_description]);
          return $response->setMessage('SMS Content Updated Successfully.');
          // return Redirect::to('https://rentnking.com/admin/smsbrodcast');      
        

    }

    public function destroy(Newsletter $newsletter, Request $request, BaseHttpResponse $response)
    {
        try {
            $this->newsletterRepository->delete($newsletter);

            event(new DeletedContentEvent(NEWSLETTER_MODULE_SCREEN_NAME, $request, $newsletter));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }
    public function emailTemplateCreate(Request $request)
    {
        try {

            $rules = [
                'name' => 'required|unique:email_templates,name|string|min:2|max:255',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $validator_error = $validator->errors();

                $response = [
                    'status' => false,
                    'message' => 'Error : Validation Error',
                    'data' => $validator_error
                ];
                return $response;
            } else {

                $email_template = new EmailTemplate;
                $email_template->name = $request->name;
                $email_template->template_type = $request->template_type;
                $email_template->slug = \Str::slug($request->name, '-');
                $email_template->subject = $request->subject;
                $email_template->description = $request->description;
                $save = $email_template->save();
                if ($save) {


                    $newFilename = $email_template->slug . ".tpl";
                    if($request->template_type == 'sms_template'){
                        $content = '<p>Your name: {{ name }}</p>
<p>Your email: {{ email }}</p>';
                    }else{
                        $content = '{{ header }}
<p>Your name: {{ name }}</p>
<p>Your email: {{ email }}</p>
<hr>
{{ footer }}';
                    }




                    Storage::disk('local')->put('/email-templates/newsletter/' . $newFilename, $content);


                    $response = [
                        'status' => true,
                        'message' => 'Email Template Data added Successfully!!',
                        'data' => [],
                        'slug' => $email_template->slug
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'message' => 'Something went Wrong',
                        'data' => []
                    ];
                }

                return $response;
            }
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Error : ' . $e->getMessage(),
                'data' => []
            ];

            return $response;
        }
    }
    public function newsletterBulkEmailSend(Request $request)
    {
        try {

            $receiver_roles = $request->receivers_roles;
            $tagged_contacts = $request->tagged_contacts;
            $contacts = 0;
            $customers = 0;
            $email_template_id = $request->email_template_id;
            if($receiver_roles){
                foreach ($receiver_roles as $receiver_role) {
                
                    if ($receiver_role == 'all') {
                        $contacts = 1;
                    }
                }
            }
            
            if(!empty($tagged_contacts)){
                foreach($tagged_contacts as $tcontact){
                    $newsletter_email_log = new NewsLetterEmailLog;
                    $newsletter_email_log->contact = $contacts;
                    $newsletter_email_log->tagged_contact = $tcontact;
                    $newsletter_email_log->customer = $customers;
                    $newsletter_email_log->template_id = $email_template_id;
                    $newsletter_email_log->type = 'email_template';
                    $newsletter_email_log->status = 'pending';
                    $newsletter_email_log->save();
                }
            }else{
                $newsletter_email_log = new NewsLetterEmailLog;
                $newsletter_email_log->contact = 1;
                $newsletter_email_log->tagged_contact = '';
                $newsletter_email_log->customer = $customers;
                $newsletter_email_log->template_id = $email_template_id;
                $newsletter_email_log->type = 'email_template';
                $newsletter_email_log->status = 'pending';
                $newsletter_email_log->save();
            }
            

            $response = [
                'status' => true,
                'message' => 'Email Data Stored......',
                'data' => []
            ];

            return $response;


        } catch (Exception $e) {

            $response = [
                'status' => false,
                'message' => 'Error : ' . $e->getMessage(),
                'data' => []
            ];

            return $response;
        }
    }

    public function BulkSMSSend(Request $request)
    {
        try {

            //dd($request);
            $tagged_contacts = json_decode($request->taglist);
            //dd($tagged_contacts);
            $contacts = 0;
            $customers = 0;
            $email_template_id = $request->smstemplateid;
            $numberOfUsers = $request->number_of_users;
            $smstemp = DB::table('email_templates')->select('name')->where('id','=',$email_template_id)->get();
            $smsoption = $request->smsoption;

            

            if(!empty($tagged_contacts)){
                
                foreach($tagged_contacts as $tcontact){
                    $newsletter_email_log = new NewsLetterEmailLog;
                    $newsletter_email_log->contact = $contacts;
                    $newsletter_email_log->tagged_contact = $tcontact;
                    $newsletter_email_log->customer = $customers;
                    $newsletter_email_log->template_id = $email_template_id;
                    $newsletter_email_log->temp_name = $smstemp[0]->name;
                    $newsletter_email_log->type = 'sms_template';
                    $newsletter_email_log->number_of_users = $numberOfUsers;
                    $newsletter_email_log->status = 'pendings';
                    $newsletter_email_log->save();
                    
                }
            }else{
                $newsletter_email_log = new NewsLetterEmailLog;
                $newsletter_email_log->contact = 1;
                $newsletter_email_log->tagged_contact = '';
                $newsletter_email_log->customer = $customers;
                $newsletter_email_log->template_id = $email_template_id;
                $newsletter_email_log->type = 'sms_template';
                $newsletter_email_log->temp_name = $smstemp[0]->name;
                $newsletter_email_log->number_of_users = $numberOfUsers;
                $newsletter_email_log->status = 'pendings';
                $newsletter_email_log->save();
            }

            $response = [
                'status' => true,
                'message' => 'Email Data Stored......',
                'data' => []
            ];

            return $response;


        } catch (Exception $e) {

            $response = [
                'status' => false,
                'message' => 'Error : ' . $e->getMessage(),
                'data' => []
            ];

            return $response;
        }
    }
    public function emailTemplateDeletes(Request $request, BaseHttpResponse $response)
    {
        $data = $request->all();
        $id = 0;
        foreach ($data as $key => $value) {
            if ($value == null) {
                $id = $key;
            }
        }
        $email_template = EmailTemplate::find($id);
        if ($email_template) {
            $slug = $email_template->slug;
            $path = storage_path() . '/app/email-templates/newsletter/' . $slug . ".tpl";
            if (file_exists($path)) {
                unlink($path);
            }
            $email_template->delete();
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        }


        return $request->all();
    }

    public function SmsLogDelete(Request $request, BaseHttpResponse $response)
    {
        $data = $request->all();
        $id = 0;
        foreach ($data as $key => $value) {
            if ($value == null) {
                $id = $key;
            }
        }
        $email_template = NewsLetterEmailLog::find($id);
        
            $email_template->delete();
            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        


        return $request->all();
    }
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems(
            $request,
            $response,
            $this->newsletterRepository,
            NEWSLETTER_MODULE_SCREEN_NAME
        );
    }

    public function CopySMS(Request $request){
        $id = $request->id;
        $email_template = EmailTemplate::find($id);
        $template = new EmailTemplate();
        $template->name = $email_template->name.' -copy';
        $template->description = $email_template->description.' -copy';
        $template->template_type = 'sms_template';
       

        $template->save();
        $response = [
            'status' => true,
            'message' => 'SMS Template Copied',
            'data' => []
        ];
        return $response; 

    }

    public function CreateSMSTemplate(Request $request,BaseHttpResponse $response)
    {
        
           $smsTitle =  $request->sms_title;
           $smsDescription = $request->smstdescription;
           $template = new EmailTemplate();
           $template->name = $smsTitle;
           $template->description = $smsDescription;
           $template->template_type = 'sms_template';
           $template->save();
           return $response->setMessage('SMS Content Created Successfully.');
           //return $response; 

        

    }

    public function SMSBrodcastTemplate(Request $request)
    {
        PageTitle::setTitle('sms Brodcasts');
        $smstemplate = DB::table('email_templates')->select('id','name','description')->where('template_type','sms_template')->orderBy('name')->get();
        $contacttags = DB::table('contacttags')->select('id','name')->orderBy('name','asc')->get();
        //dd($contacttags);

        return view('plugins/newsletter::smsbrodcast.index',compact('smstemplate','contacttags'));
           

        

    }

    public function GetSMSContent(Request $request)
    {
        $smsid = $request->id;
        $smstemplate = DB::table('email_templates')->select('id','name','description')->where('id',$smsid)->get();
        return json_encode($smstemplate);
    }

    public function SearchContacts(Request $request){
        if(!empty($request->tags)){
            $alltags = $request->tags;
            $contacts = [];
            
            foreach($alltags as $tag){
                $contact = DB::table('contacts')->select('id','name','first_name','last_name','email','phone','contactTag')->whereRaw('FIND_IN_SET("'.$tag.'", contactTag)')->get();
                $contacts['count'][] = count($contact);
               $contacts['totalrecords'][] = $contact;
                //$contacts['count'] += $totalrecords;
            }
        }
        //dd(count($contacts['count']));
        if($request->all == 1){
            $contacts = DB::table('contacts')->select('id','name','first_name','last_name','email','phone','contactTag')->get();
        }
        return $contacts;
    }
    public function CopyMail(Request $request){
        $id = $request->id;
        $email_template = EmailTemplate::find($id);
        $template = new EmailTemplate();
        $template->name = $email_template->name.' -copy';
        $template->description = $email_template->description.' -copy';
        $template->subject = $email_template->subject.' -copy';
        $template->template_type = 'email_template';
       

        $template->save();
        $response = [
            'status' => true,
            'message' => 'SMS Template Copied',
            'data' => []
        ];
        return $response; 

    }
}
