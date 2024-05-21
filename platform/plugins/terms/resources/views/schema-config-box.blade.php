<div class="terms-schema-items @if (!$hasValue) hidden @endif">
    {!! Form::repeater('terms_schema_config', $value, [
        [
            'type'       => 'textarea',
            'label'      => trans('plugins/terms::terms.question'),
            'label_attr' => ['class' => 'control-label required'],
            'attributes' => [
                'name'    => 'question',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 1000,
                    'rows'         => 1,
                ],
            ],
        ],
        [
            'type'       => 'textarea',
            'label'      => trans('plugins/terms::terms.answer'),
            'label_attr' => ['class' => 'control-label required'],
            'attributes' => [
                'name'    => 'answer',
                'value'   => null,
                'options' => [
                    'class'        => 'form-control',
                    'data-counter' => 1000,
                    'rows'         => 1,
                ],
            ],
        ],
    ]) !!}
</div>
