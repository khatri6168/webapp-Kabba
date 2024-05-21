<?php

namespace Botble\Ecommerce\Forms;

use Botble\Ecommerce\Enums\EmployeeStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Http\Requests\EmployeeRequest;
use Botble\Ecommerce\Models\Employee;

class EmployeeForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Employee())
            ->setValidatorClass(EmployeeRequest::class)
            ->withCustomFields()
            ->add('first_name', 'text', [
                'label' => trans('core/base::forms.first_name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.first_name'),
                    'data-counter' => 120,
                ],
            ])
            ->add('last_name', 'text', [
                'label' => trans('core/base::forms.last_name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'placeholder' => trans('core/base::forms.last_name'),
                    'data-counter' => 120,
                ],
            ])
            ->add('phone', 'text', [
                'label' => trans('plugins/ecommerce::employees.form.phone'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('plugins/ecommerce::employees.form.phone'),
                    'data-counter' => 400,
                    'class' => ['form-control', 'phone'],
                ],
            ])
            ->add('email', 'text', [
                'label' => trans('plugins/ecommerce::employees.form.email'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => 'Ex: john@gmail.com',
                    'data-counter' => 120,
                ],
            ])
            ->add('address', 'text', [
                'label' => trans('plugins/ecommerce::employees.form.address'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'placeholder' => trans('plugins/ecommerce::employees.form.address'),
                    'data-counter' => 120,
                ],
            ])
            ->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices' => EmployeeStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
