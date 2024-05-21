@php
    $styleImages = [
        'service' => __('Service'),
        'product' => __('Product'),
    ];
@endphp

<div class="form-group">
    <label class="control-label" for="title">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" rows="3" class="form-control">{{ Arr::get($attributes, 'description') }}</textarea>
</div>

<div class="form-group">
    <label class="control-label" for="image">{{ __('Image') }}</label>
    {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Style image') }}</label>
    {!! Form::customSelect('style_image', $styleImages, Arr::get($attributes, 'style_image')) !!}
</div>

<div class="form-group">
    <label class="control-label" for="button_primary_url">{{ __('Button primary URL') }}</label>
    <input type="text" name="button_primary_url" value="{{ Arr::get($attributes, 'button_primary_url') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="button_primary_label">{{ __('Button primary label') }}</label>
    <input type="text" name="button_primary_label" value="{{ Arr::get($attributes, 'button_primary_label') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="button_primary_icon">{{ __('Button primary icon') }}</label>
    {!! Form::mediaImage('button_primary_icon', Arr::get($attributes, 'button_primary_icon')) !!}
</div>

<div class="form-group">
    <label class="control-label" for="button_secondary_url">{{ __('Button secondary URL') }}</label>
    <input type="text" name="button_secondary_url" value="{{ Arr::get($attributes, 'button_secondary_url') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="button_secondary_label">{{ __('Button secondary label') }}</label>
    <input type="text" name="button_secondary_label" value="{{ Arr::get($attributes, 'button_secondary_label') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="button_secondary_icon">{{ __('Button secondary icon') }}</label>
    {!! Form::mediaImage('button_secondary_icon', Arr::get($attributes, 'button_secondary_icon')) !!}
</div>
