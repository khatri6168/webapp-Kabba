@foreach(range(1, 6) as $i)
    <div style="border: 1px solid #a8a8a8; padding: 15px; margin-bottom: 15px; border-radius: 5px">
        <div class="form-group">
            <label class="control-label">{{ __('Title :number', ['number' => $i]) }}</label>
            <input type="text" name="title_{{ $i }}" value="{{ Arr::get($attributes, 'title_' . $i) }}" class="form-control">
        </div>

        <div class="form-group">
            <label class="control-label">{{ __('Description :number', ['number' => $i]) }}</label>
            <textarea name="description_{{ $i }}" id="description_{{ $i }}" class="form-control">{{ Arr::get($attributes, 'description_' . $i) }}</textarea>
        </div>
    </div>
@endforeach
