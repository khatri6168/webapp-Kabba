@php
    $styles = [
        1 => __('Style 1'),
        2 => __('Style 2'),
    ];
@endphp

<div class="form-group">
    <label class="control-label" for="per_page">{{ __('Number of galleries per page') }}</label>
    <input type="text" name="per_page" value="{{ Arr::get($attributes, 'per_page', 5) }}" class="form-control" placeholder="{{ __('Number of galleries per page') }}">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Style') }}</label>
    {!! Form::customSelect('style', $styles, Arr::get($attributes, 'style')) !!}
</div>
