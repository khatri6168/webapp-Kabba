<div class="form-group">
    <label for="widget" class="form-label">{{ __('Widget') }}</label>
    {!! Form::customSelect('widget', ['blog-footer' => __('Blog Footer')], Arr::get($attributes, 'widget')) !!}
</div>
