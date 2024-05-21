@php
    $categoryIds = explode(',', Arr::get($attributes, 'category_ids'));
    $style = [
        1 => __('Style 1'),
        2 => __('Style 2')
    ]
@endphp

<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Choose categories') }}</label>
    <select class="select-full" name="category_ids" multiple>
        @foreach($categories as $category)
            <option @selected(in_array($category->id, $categoryIds)) value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label class="control-label">{{ __('Button label') }}</label>
    <input type="text" name="button_label" value="{{ Arr::get($attributes, 'button_label') }}" class="form-control" placeholder="{{ __('Button label') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Button url') }}</label>
    <input type="text" name="button_url" value="{{ Arr::get($attributes, 'button_url') }}" class="form-control" placeholder="{{ __('Button url') }}">
</div>

<div class="form-group mb-3">
    <label class="control-label">{{ __('Style') }}</label>
    {!! Form::customSelect('style', $style, Arr::get($attributes, 'style')) !!}
</div>
