<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

@for($i = 1; $i <= 3; $i++)
    <div class="form-group">
        <label class="control-label">{{ __('Title step :number', ['number' => $i]) }}</label>
        <input type="text" name="title_{{ $i }}" value="{{ Arr::get($attributes, 'title_' . $i) }}" class="form-control" placeholder="{{ __('Title step :number', ['number' => $i]) }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Subtitle step :number', ['number' => $i]) }}</label>
        <input type="text" name="subtitle_{{ $i }}" value="{{ Arr::get($attributes, 'subtitle_' . $i) }}" class="form-control" placeholder="{{ __('Subtitle step :number', ['number' => $i]) }}">
    </div>
@endfor

<div class="form-group">
    <label class="control-label">{{ __('Image') }}</label>
    {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Years experience') }}</label>
    <input type="number" name="year_experience" value="{{ Arr::get($attributes, 'year_experience') }}" class="form-control" placeholder="{{ __('Years experience') }}">
</div>
