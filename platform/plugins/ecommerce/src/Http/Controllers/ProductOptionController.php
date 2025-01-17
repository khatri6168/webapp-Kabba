<?php

namespace Botble\Ecommerce\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Ecommerce\Models\GlobalOption;
use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Ecommerce\Forms\GlobalOptionForm;
use Botble\Base\Events\BeforeEditContentEvent;
use Botble\Ecommerce\Tables\GlobalOptionTable;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Http\Requests\GlobalOptionRequest;
use Botble\Ecommerce\Repositories\Interfaces\GlobalOptionInterface;
use DB;

class ProductOptionController extends BaseController
{
    public function __construct(protected GlobalOptionInterface $globalOptionRepository)
    {
    }

    public function index(GlobalOptionTable $table)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::product-option.name'));

        return $table->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::product-option.create'));

        return $formBuilder->create(GlobalOptionForm::class)->renderForm();
    }

    public function store(GlobalOptionRequest $request, BaseHttpResponse $response)
    {
        $option = $this->globalOptionRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(GLOBAL_OPTION_MODULE_SCREEN_NAME, $request, $option));

        return $response
            ->setPreviousUrl(route('global-option.index'))
            ->setNextUrl(route('global-option.edit', $option->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int|string $id, FormBuilder $formBuilder, Request $request)
    {
        $option = $this->globalOptionRepository->findOrFail($id, ['values']);

        event(new BeforeEditContentEvent($request, $option));

        PageTitle::setTitle(trans('plugins/ecommerce::product-option.edit', ['name' => $option->name]));

        return $formBuilder->create(GlobalOptionForm::class, ['model' => $option])->renderForm();
    }

    public function destroy(int|string $id, Request $request, BaseHttpResponse $response)
    {
        try {
            $option = $this->globalOptionRepository->findOrFail($id);

            $this->globalOptionRepository->delete($option);

            event(new DeletedContentEvent(GLOBAL_OPTION_MODULE_SCREEN_NAME, $request, $option));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
        }
    }

    public function update(int|string $id, GlobalOptionRequest $request, BaseHttpResponse $response)
    {
        if ($request->submit == 'save_as_new') {
            $request->name = $request->name." copy";
            $newArray = $request->input();
            $newArray['name'] = $newArray['name']." copy";
            // $nextId = GlobalOption::max('id') + 1;
            $prevID = explode('edit/',url()->current());
            $getRecords = DB::table('ec_global_option_value')->where('option_id','=', $prevID[1])->get();
            //return dd($getRecords);
            

            $option = $this->globalOptionRepository->createOrUpdate($newArray);
            $latestOptionId = $option['id'];
            //return dd($option['id']);
            event(new CreatedContentEvent(GLOBAL_OPTION_MODULE_SCREEN_NAME, $request, $option));
            if($getRecords){
                foreach($getRecords as $record){
                    DB::table('ec_global_option_value')->insert(
                        array(
                            'option_id'     =>   $prevID[1], 
                            'option_value'   =>   $record->option_value,
                            'affect_price'   =>   $record->affect_price,
                            'order'   =>   $record->order,
                            'affect_type'   =>   $record->affect_type,
                            'value_type'   =>   $record->value_type,
                            'comment'=>$record->comment,
                            'created_at'=> $record->created_at,
                            'updated_at'=>$record->updated_at,
                        )
                    );
                }
            }
            
            return $response
                ->setNextUrl(route('global-option.edit', $option->id))
                ->setPreviousUrl(route('global-option.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));
        } else {
            $option = $this->globalOptionRepository->findOrFail($id);
    
            $this->globalOptionRepository->createOrUpdate($request->input(), ['id' => $id]);
            event(new UpdatedContentEvent(GLOBAL_OPTION_MODULE_SCREEN_NAME, $request, $option));
            return $response
                ->setPreviousUrl(route('global-option.index'))
                ->setMessage(trans('core/base::notices.update_success_message'));
        }

    }

    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $option = $this->globalOptionRepository->findOrFail($id);
            $this->globalOptionRepository->delete($option);
            event(new DeletedContentEvent(GLOBAL_OPTION_MODULE_SCREEN_NAME, $request, $option));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }

    public function ajaxInfo(Request $request, BaseHttpResponse $response): BaseHttpResponse
    {
        $optionsValues = $this->globalOptionRepository->findOrFail($request->input('id'), ['values']);

        return $response->setData($optionsValues);
    }
}
