@for ($i = 1; $i <= 3; $i++)
    <div class="form-group">
        <label class="control-label">{{ __('Title :number', ['number' => $i]) }}</label>
        <input type="text" name="title_{{ $i }}" value="{{ Arr::get($attributes, 'phone' . $i) }}" class="form-control" placeholder="{{ __('Title :number', ['number' => $i]) }}">
    </div>

    <div class="form-group">
        <label class="control-label">{{ __('Description :number', ['number' => $i]) }}</label>
        <textarea name="description_{{ $i }}" class="form-control" rows="3" placeholder="{{ __('Description :number', ['number' => $i]) }}">{{ Arr::get($attributes, 'description_' . $i) }}</textarea>
    </div>
@endfor
