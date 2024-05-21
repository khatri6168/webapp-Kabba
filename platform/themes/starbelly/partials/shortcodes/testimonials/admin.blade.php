<div class="form-group">
    <label class="control-label" for="title">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" rows="3" class="form-control">{{ Arr::get($attributes, 'description') }}</textarea>
</div>

<div class="form-group">
    <label class="control-label" for="limit">{{ __('Limit') }}</label>
    <input type="text" name="limit" value="{{ Arr::get($attributes, 'limit', 5) }}" class="form-control" placeholder="{{ __('Number of reviews to display') }}">
</div>

<div class="form-group">
    <label class="control-label" for="button_url">{{ __('Button URL') }}</label>
    <input type="text" name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="button_label">{{ __('Button label') }}</label>
    <input type="text" name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="button_icon">{{ __('Button icon') }}</label>
    {!! Form::mediaImage('button_icon', Arr::get($attributes, 'button_icon')) !!}
</div>
