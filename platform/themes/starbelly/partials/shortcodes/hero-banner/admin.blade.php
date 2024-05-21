<div class="form-group">
    <label class="control-label" for="style">{{ __('Style') }}</label>
    {!! Form::customSelect('style', [1 => __('Style 1'), 2 => __('Style 2')], Arr::get($attributes, 'style')) !!}
</div>

<div class="form-group">
    <label class="control-label">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Subtitle') }}</label>
    <input type="text" name="subtitle" value="{{ Arr::get($attributes, 'subtitle') }}" class="form-control" placeholder="{{ __('Subtitle') }}">
</div>

<div class="form-group">
    <label class="control-label">{{ __('Text secondary') }}</label>
    <input type="text" name="text_secondary" value="{{ Arr::get($attributes, 'text_secondary') }}" class="form-control" placeholder="{{ __('text secondary') }}">
</div>

@foreach(range(1, 3) as $i)
    <div class="form-group">
        <label class="control-label" for="image-{{ $i }}">{{ __('Image :number', ['number' => $i]) }}</label>
        {!! Form::mediaImage('image_' . $i, Arr::get($attributes, 'image_' . $i)) !!}
    </div>
@endforeach

@foreach(range(1, 2) as $i)
    <div class="form-group">
        <label class="control-label" for="message-{{ $i }}">{{ __('Text message :number (only style 2)', ['number' => $i]) }}</label>
        <input type="text" id="message-{{ $i }}" name="message_{{ $i }}" value="{{ Arr::get($attributes, 'message_' . $i) }}" class="form-control" placeholder="{{ __('Text message :number', ['number' => $i]) }}">
    </div>
@endforeach

@for ($i = 1; $i <= 2; $i++)
    <div class="form-group">
        <label class="control-label">{{ __('Button action label :number', ['number' => $i]) }}</label>
        <input type="text" name="button_label_{{ $i }}" value="{{ Arr::get($attributes, 'button_label_' . $i) }}" class="form-control" placeholder="{{ __('Button action label :number', ['number' => $i]) }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Button action url :number', ['number' => $i]) }}</label>
        <input type="text" name="button_url_{{ $i }}" value="{{ Arr::get($attributes, 'button_url_' . $i) }}" class="form-control" placeholder="{{ __('Button action label :number', ['number' => $i]) }}">
    </div>
@endfor
