@foreach(['left', 'right'] as $col)
    <div class="form-group">
        <label class="control-label" for="title_{{ $col }}">{{ __('Title col :position', ['position' => $col]) }}</label>
        <input type="text" name="title_{{ $col }}" value="{{ Arr::get($attributes, 'title_' . $col) }}" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="subtitle_{{ $col }}">{{ __('Subtitle col :position', ['position' => $col]) }}</label>
        <input type="text" name="subtitle_{{ $col }}" value="{{ Arr::get($attributes, 'subtitle_' . $col) }}" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="description_{{ $col }}">{{ __('Description col :position', ['position' => $col]) }}</label>
        <input type="text" name="description_{{ $col }}" value="{{ Arr::get($attributes, 'description_' . $col) }}" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Image :position', ['position' => $col]) }}</label>
        {!! Form::mediaImage('image_' . $col, Arr::get($attributes, 'image_' . $col)) !!}
    </div>

    <div class="form-group">
        <label class="control-label" for="button_label_{{ $col }}">{{ __('Button label col :position', ['position' => $col]) }}</label>
        <input type="text" name="button_label_{{ $col }}" value="{{ Arr::get($attributes, 'button_label_' . $col) }}" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="button_url_{{ $col }}">{{ __('Button URL col :position', ['position' => $col]) }}</label>
        <input type="text" name="button_url_{{ $col }}" value="{{ Arr::get($attributes, 'button_url_' . $col) }}" class="form-control">
    </div>
@endforeach
