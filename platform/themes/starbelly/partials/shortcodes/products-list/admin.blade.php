@php
    $productTypes = [
        'all' => __('All'),
        'feature' => __('Featured products'),
        'trending' => __('Trending products'),
    ];

    $itemsPerRows = [
        3 => __('Three items'),
        4 => __('Four items'),
    ];
@endphp

<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Products type') }}</label>
    {!! Form::customSelect('type', $productTypes, Arr::get($attributes, 'type')) !!}
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Items per row') }}</label>
    {!! Form::customSelect('items_per_row', $itemsPerRows, Arr::get($attributes, 'items_per_row')) !!}
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Items per page') }}</label>
    <input type="text" name="per_page" value="{{ Arr::get($attributes, 'per_page') }}" class="form-control" placeholder="{{ __('Items per page') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Limit') }}</label>
    <input type="text" name="limit" value="{{ Arr::get($attributes, 'limit', 6) }}" class="form-control" placeholder="{{ __('Number of products to display') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Button label') }}</label>
    <input type="text" name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" placeholder="{{ __('Button label') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Button URL') }}</label>
    <input type="text" name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" placeholder="{{ __('Button action') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Button icon') }}</label>
    {!! Form::mediaImage('button_icon', Arr::get($attributes, 'button_icon')) !!}
</div>
