<?php

namespace Botble\Terms\Http\Controllers;

use Botble\Base\Facades\PageTitle;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Terms\Http\Requests\GlobalTermsRequest;
use Botble\Terms\Models\Terms;
use Botble\Terms\Repositories\Interfaces\TermsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use Botble\Terms\Tables\GlobalTermsTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Terms\Forms\GlobalTermsForm;
use Botble\Base\Forms\FormBuilder;

class GlobalTermsController extends BaseController
{
    use HasDeleteManyItemsTrait;

    public function __construct(protected TermsInterface $termsRepository)
    {
    }

    public function index(GlobalTermsTable $table)
    {
        PageTitle::setTitle(trans('plugins/terms::globalterms.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/terms::globalterms.create'));

        return $formBuilder->create(GlobalTermsForm::class)->renderForm();
    }

    public function store(GlobalTermsRequest $request, BaseHttpResponse $response)
    {
        $terms = $this->termsRepository->createOrUpdate($request->input());
        $terms->slug = 'global_term_'.$terms->id;
        $terms->is_global = 1;
        $terms->save();
        event(new CreatedContentEvent(TERMS_MODULE_SCREEN_NAME, $request, $terms));

        return $response
            ->setPreviousUrl(route('globalterms.index'))
            ->setNextUrl(route('globalterms.edit', $terms->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Terms $terms, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $terms->title]));

        return $formBuilder->create(GlobalTermsForm::class, ['model' => $terms])->renderForm();
    }

    public function update(Terms $terms, GlobalTermsRequest $request, BaseHttpResponse $response)
    {
        $terms->fill($request->input());
        
        $this->termsRepository->createOrUpdate($terms);

        event(new UpdatedContentEvent(TERMS_MODULE_SCREEN_NAME, $request, $terms));

        return $response
            ->setPreviousUrl(route('globalterms.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Terms $terms, Request $request, BaseHttpResponse $response)
    {
        try {
            $this->termsRepository->delete($terms);

            event(new DeletedContentEvent(TERMS_MODULE_SCREEN_NAME, $request, $terms));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->termsRepository, TERMS_MODULE_SCREEN_NAME);
    }
}
