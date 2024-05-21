<div class="form-group">
    <label>{{ __('Title') }}</label>
    <input type="text" class="form-control" name="title" value="{{ Arr::get($config, 'title') }}">
</div>

<div class="form-group">
    <label>{{ __('Description') }}</label>
    <textarea name="description" id="description" class="form-control">{{ Arr::get($config, 'description') }}</textarea>
</div>

<div class="form-group">
    <label class="control-label" for="image">{{ __('Image') }}</label>
    {!! Form::mediaImage('image', Arr::get($config, 'image')) !!}
</div>

@foreach(['primary', 'secondary'] as $type)
    <div class="form-group">
        <label class="control-label" for="button_{{ $type }}_url">{{ __('Button :type URL', ['type' => $type]) }}</label>
        <input type="text" name="button_{{ $type }}_url" value="{{ Arr::get($config, 'button_' . $type . '_url') }}" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="button_{{ $type }}_label">{{ __('Button :type label', ['type' => $type]) }}</label>
        <input type="text" name="button_{{ $type }}_label" value="{{ Arr::get($config, 'button_' . $type . '_label') }}" class="form-control">
    </div>

    <div class="form-group">
        <label class="control-label" for="button_{{ $type }}_icon">{{ __('Button :type icon', ['type' => $type]) }}</label>
        {!! Form::mediaImage('button_' . $type . '_icon', Arr::get($config, 'button_' . $type . '_icon')) !!}
    </div>
@endforeach
