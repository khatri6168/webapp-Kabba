<?php

namespace Botble\Contact\Http\Controllers;

use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Contact\Enums\ContactStatusEnum;
use Botble\Contact\Forms\ContactForm;
use Botble\Contact\Http\Requests\ContactReplyRequest;
use Botble\Contact\Http\Requests\EditContactRequest;
use Botble\Contact\Http\Requests\CreateContactRequest;
use Botble\Contact\Models\Contact;
use Botble\Contact\Repositories\Interfaces\ContactReplyInterface;
use Botble\Contact\Tables\ContactTable;
use Botble\Contact\Repositories\Interfaces\ContactInterface;
use Botble\Base\Facades\EmailHandler;
use Exception;
use Illuminate\Http\Request;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Contact\Models\Company;
use Botble\Ecommerce\Forms\CustomerForm;


class ContactController extends BaseController
{
    use HasDeleteManyItemsTrait;

    public function __construct(protected ContactInterface $contactRepository)
    {
    }

    public function index(ContactTable $dataTable)
    {

        PageTitle::setTitle(trans('plugins/contact::contact.menu'));
        return $dataTable->renderTable();
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
            $company = new Company;
            $company->company_name = $data['company_name'];
            $company->company_email = $data['company_email'];
            $company->company_country = $data['company_country'];
            $company->company_url = $data['company_url'];
            $company->company_address = $data['company_address'];
            $save = $company->save();

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
        $contact = $this->contactRepository->getModel();
        $contact->fill($request->input());
        $contact = $this->contactRepository->createOrUpdate($contact);

        return $response
            ->setPreviousUrl(route('contacts.index'))
            ->setNextUrl(route('contacts.edit', $contact->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
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
        $contact->fill($request->input());

        $this->contactRepository->createOrUpdate($contact);

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

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->contactRepository, CONTACT_MODULE_SCREEN_NAME);
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
}
