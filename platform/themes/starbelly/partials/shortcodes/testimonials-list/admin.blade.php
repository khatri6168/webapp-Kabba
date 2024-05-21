<div class="form-group">
    <label class="control-label" for="per_page">{{ __('Number of reviews per page') }}</label>
    <input type="text" name="per_page" value="{{ Arr::get($attributes, 'per_page', 8) }}" class="form-control" placeholder="{{ __('Number of reviews per page') }}">
</div>
