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
        PageTitle::setTitle(trans('plugins/newsletter::newsletter.name'));
        return $dataTable->renderTable();
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
                $email_template->slug = \Str::slug($request->name, '-');
                $email_template->subject = $request->subject;
                $email_template->description = $request->description;
                $save = $email_template->save();
                if ($save) {


                    $newFilename = $email_template->slug . ".tpl";
                    $content = '{{ header }}
<p>Your name: {{ name }}</p>
<p>Your email: {{ email }}</p>
<hr>
{{ footer }}';

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
            $contacts = 0;
            $customers = 0;
            $email_template_id = $request->email_template_id;            

            foreach ($receiver_roles as $receiver_role) {
                if ($receiver_role == 'customers') {
                    $customers = 1;
                }
                if ($receiver_role == 'contacts') {
                    $contacts = 1;
                }
            }

            $newsletter_email_log = new NewsLetterEmailLog;
            $newsletter_email_log->contact = $contacts;
            $newsletter_email_log->customer = $customers;
            $newsletter_email_log->template_id = $email_template_id;
            $newsletter_email_log->status = 'pending';
            $newsletter_email_log->save();            

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
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems(
            $request,
            $response,
            $this->newsletterRepository,
            NEWSLETTER_MODULE_SCREEN_NAME
        );
    }
}
