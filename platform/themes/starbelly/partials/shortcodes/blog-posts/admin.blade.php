<div class="form-group">
    <label for="title" class="form-label">{{ __('Style') }}</label>
    {!! Form::customSelect('style', [1 => __('Style 1'), 2 => __('Style 2')], Arr::get($attributes, 'style')) !!}
</div>

<div class="form-group">
    <label for="title" class="form-label">{{ __('Title') }}</label>
    <input type="text" id="title" name="title" class="form-control" value="{{ Arr::get($attributes, 'title') }}">
</div>

<div class="form-group">
    <label for="title" class="form-label">{{ __('Description') }}</label>
    <textarea name="description" id="description" class="form-control">{{ Arr::get($attributes, 'description') }}</textarea>
</div>

<div class="form-group">
    <label for="limit" class="form-label">{{ __('Limit') }}</label>
    <input type="number" id="limit" name="limit" class="form-control" value="{{ Arr::get($attributes, 'limit') }}">
</div>
