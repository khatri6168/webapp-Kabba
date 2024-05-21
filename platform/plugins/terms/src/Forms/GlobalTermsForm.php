<?php

namespace Botble\Terms\Forms;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Forms\FormAbstract;
use Botble\Terms\Http\Requests\GlobalTermsRequest;
use Botble\Terms\Models\Terms;
use Botble\Terms\Repositories\Interfaces\TermsCategoryInterface;

class GlobalTermsForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new Terms())
            ->setValidatorClass(GlobalTermsRequest::class)
            ->withCustomFields()
            ->add('title', 'text', [
                'label' => trans('plugins/terms::globalterms.title'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                ],
            ]);
            $this->add('content', 'editor', [
                'label' => trans('plugins/terms::globalterms.content'),
                'label_attr' => ['class' => 'control-label required'],
                'attr' => [
                    'rows' => 4,
                    'with-short-code' => true,
                    'without-buttons' => false,
                    'product_terms' => true,
                    // 'customer_initials' => true,
                ],
            ]);
        if($this->getModel() && $this->getModel()->id > 0){
            $this->add('signature_block', 'editor', [
                'label' => trans('Signature Block'),
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'rows' => 4,
                    'with-short-code' => false, // if true, it will add a button to select shortcode
                    'without-buttons' => true, // if true, all buttons will be hidden
                ],
            ]);
        } else {
            $this->add('signature_block', 'editor', [
                'label' => trans('Signature Block'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'with-short-code' => false, // if true, it will add a button to select shortcode
                    'without-buttons' => true, // if true, all buttons will be hidden
                ],
                'value' => '<p>IN WITNESS WHEREOF, the parties have executed this Agreement as of the date first written above.</p><p>OWNER:<br>Development 360, Inc<br>By: Gary Jezorski <br>Signature: ____________<br>Title: President</p><p>RENTER:<br>By: [customer_name]<br>Signature: [customer_signature]</p>',
            ]);
        }
            
            /*$this->add('is_global', 'customSelect', [
                'label' => trans('plugins/terms::globalterms.type'),
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
