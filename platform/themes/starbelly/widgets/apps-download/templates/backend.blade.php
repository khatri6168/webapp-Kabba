<section style="max-height: 400px; overflow: auto">
    <div class="form-group">
        <label class="control-label">{{ __('Title') }}</label>
        <input type="text" name="title" value="{{ Arr::get($config, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle') }}</label>
        <input type="text" name="subtitle" value="{{ Arr::get($config, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image') }}</label>
        {!! Form::mediaImage('image', Arr::get($config, 'image')) !!}
    </div>

    @for ($i = 1; $i <= 3; $i++)
        <div class="form-group">
            <label class="control-label">{{ __('Platform name :number', ['number' => $i]) }}</label>
            <input type="text" name="platform_name_{{ $i }}" value="{{ Arr::get($config, 'platform_name_' . $i) }}" class="form-control" placeholder="{{ __('Platform name :number', ['number' => $i]) }}">
        </div>

        <div class="form-group">
            <label class="control-label">{{ __('Platform button image :number', ['number' => $i]) }}</label>
            {!! Form::mediaImage('platform_button_image_' . $i, Arr::get($config, 'platform_button_image_' . $i)) !!}
        </div>

        <div class="form-group">
            <label class="control-label">{{ __('Platform url :number', ['number' => $i]) }}</label>
            <input type="text" name="platform_url_{{ $i }}" value="{{ Arr::get($config, 'platform_url_' . $i) }}" class="form-control" placeholder="{{ __('Platform :number', ['number' => $i]) }}">
        </div>
    @endfor
</section>