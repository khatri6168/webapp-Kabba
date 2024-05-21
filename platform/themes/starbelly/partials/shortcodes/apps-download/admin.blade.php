<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Image') }}</label>
    {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
</div>

@foreach(range(1, 3) as $i)
    <div class="form-group">
        <label class="control-label">{{ __('Platform name :number', ['number' => $i]) }}</label>
        <input type="text" name="platform_name_{{ $i }}" value="{{ Arr::get($attributes, 'platform_name_' . $i) }}" class="form-control" placeholder="{{ __('Platform name :number', ['number' => $i]) }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Platform button image :number', ['number' => $i]) }}</label>
        {!! Form::mediaImage('platform_button_image_' . $i, Arr::get($attributes, 'platform_button_image_' . $i)) !!}
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Platform url :number', ['number' => $i]) }}</label>
        <input type="text" name="platform_url_{{ $i }}" value="{{ Arr::get($attributes, 'platform_url_' . $i) }}" class="form-control" placeholder="{{ __('Platform :number', ['number' => $i]) }}">
    </div>
@endforeach
