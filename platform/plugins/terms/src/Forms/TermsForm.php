<?php

namespace Botble\Terms\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Terms\Http\Requests\TermsRequest;
use Botble\Terms\Models\Terms;
use Botble\Terms\Repositories\Interfaces\TermsCategoryInterface;

class TermsForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Terms())
            ->setValidatorClass(TermsRequest::class)
            ->withCustomFields()
            ->add('title', 'text', [
                'label' => trans('plugins/terms::terms.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                ],
            ]);
        $this->add('content', 'editor', [
            'label' => trans('plugins/terms::terms.content'),
            'label_attr' => ['class' => 'control-label required'],
            'attr' => [
                'rows' => 4,
                'with-short-code' => true,
                'without-buttons' => false,
                // 'product_terms' => true,
                'customer_initials' => true,
            ],
        ]);
            
            /*$this->add('is_global', 'customSelect', [
                'label' => trans('plugins/terms::terms.type'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'class' => 'select-search-full',
                ],
                'choices' => [1=>'Global',2=>'Product'],
            ])*/
            $this->add('status', 'customSelect', [
                'label' => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices' => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
