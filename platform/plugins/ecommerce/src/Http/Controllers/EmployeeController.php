<?php

namespace Botble\Ecommerce\Http\Controllers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\Base\Events\UpdatedContentEvent;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Forms\FormBuilder;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Forms\EmployeeForm;
use Botble\Ecommerce\Http\Requests\EmployeeRequest;
use Botble\Ecommerce\Repositories\Interfaces\EmployeeInterface;
use Botble\Ecommerce\Tables\EmployeeTable;
use Exception;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
{
    public function __construct(protected EmployeeInterface $employeeRepository)
    {
    }

    public function index(EmployeeTable $dataTable)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::employees.menu'));

        return $dataTable->renderTable();
    }

    public function create(FormBuilder $formBuilder)
    {
        PageTitle::setTitle(trans('plugins/ecommerce::employees.create'));

        return $formBuilder->create(EmployeeForm::class)->renderForm();
    }

    public function store(EmployeeRequest $request, BaseHttpResponse $response)
    {
        $employee = $this->employeeRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(EMPLOYEE_MODULE_SCREEN_NAME, $request, $employee));

        return $response
            ->setPreviousUrl(route('employees.index'))
            ->setNextUrl(route('employees.edit', $employee->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    public function edit(int|string $id, FormBuilder $formBuilder)
    {
        $employee = $this->employeeRepository->findOrFail($id);

        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $employee->name]));

        return $formBuilder->create(EmployeeForm::class, ['model' => $employee])->renderForm();
    }

    public function update(int|string $id, EmployeeRequest $request, BaseHttpResponse $response)
    {
        $employee = $this->employeeRepository->findOrFail($id);
        $employee->fill($request->input());

        $this->employeeRepository->createOrUpdate($employee);

        event(new UpdatedContentEvent(BRAND_MODULE_SCREEN_NAME, $request, $employee));

        return $response
            ->setPreviousUrl(route('employees.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(int|string $id, Request $request, BaseHttpResponse $response)
    {
        try {
            $employee = $this->employeeRepository->findOrFail($id);
            $this->employeeRepository->delete($employee);

            event(new DeletedContentEvent(EMPLOYEE_MODULE_SCREEN_NAME, $request, $employee));

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage($exception->getMessage());
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
            $brand = $this->employeeRepository->findOrFail($id);
            $this->employeeRepository->delete($brand);
            event(new DeletedContentEvent(EMPLOYEE_MODULE_SCREEN_NAME, $request, $employee));
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
