<?php

namespace Botble\Terms\Http\Controllers;

use Botble\Base\Facades\PageTitle;
use Botble\Base\Traits\HasDeleteManyItemsTrait;
use Botble\Terms\Http\Requests\TermsRequest;
use Botble\Terms\Models\Terms;
use Botble\Terms\Repositories\Interfaces\TermsInterface;
use Botble\Base\Http\Controllers\BaseController;
use Exception;
use Illuminate\Http\Request;
use Botble\Terms\Tables\TermsTable;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Terms\Forms\TermsForm;
use Botble\Base\Forms\FormBuilder;

class TermsController extends BaseController
{
    use HasDeleteManyItemsTrait;

    public function __construct(protected TermsInterface $termsRepository)
    {
    }

    public function index(TermsTable $table)
    {
        PageTitle::setTitle(trans('plugins/terms::terms.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/terms::terms.create'));

        return $formBuilder->create(TermsForm::class)->renderForm();
    }

    public function store(TermsRequest $request, BaseHttpResponse $response)
    {
        $terms = $this->termsRepository->createOrUpdate($request->input());
        $terms->slug = 'product_term_'.$terms->id;
        $terms->is_global = 2;
        $terms->save();
        event(new CreatedContentEvent(TERMS_MODULE_SCREEN_NAME, $request, $terms));

        return $response
            ->setPreviousUrl(route('terms.index'))
            ->setNextUrl(route('terms.edit', $terms->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(Terms $terms, FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $terms->title]));

        return $formBuilder->create(TermsForm::class, ['model' => $terms])->renderForm();
    }

    public function update(Terms $terms, TermsRequest $request, BaseHttpResponse $response)
    {
        $terms->fill($request->input());
        
        $this->termsRepository->createOrUpdate($terms);

        event(new UpdatedContentEvent(TERMS_MODULE_SCREEN_NAME, $request, $terms));

        return $response
            ->setPreviousUrl(route('terms.index'))
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
