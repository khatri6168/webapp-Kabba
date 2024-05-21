<div class="form-group">
    <label class="control-label" for="title">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="title">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="image">{{ __('Primary image') }}</label>
    {!! Form::mediaImage('primary_image', Arr::get($attributes, 'primary_image')) !!}
</div>

<div class="form-group">
    <label class="control-label" for="image">{{ __('Secondary image') }}</label>
    {!! Form::mediaImage('secondary_image', Arr::get($attributes, 'secondary_image')) !!}
</div>
