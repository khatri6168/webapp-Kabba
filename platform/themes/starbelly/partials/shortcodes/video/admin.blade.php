<div class="form-group">
    <label class="control-label" for="badge_text">{{ __('Badge text') }}</label>
    <input type="text" name="badge_text" value="{{ Arr::get($attributes, 'badge_text') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="title">{{ __('Title') }}</label>
    <input type="text" name="title" value="{{ Arr::get($attributes, 'title') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" rows="3" class="form-control">{{ Arr::get($attributes, 'description') }}</textarea>
</div>

<div class="form-group">
    <label for="video_thumbnail" class="control-label">{{ __('Video thumbnail') }}</label>
    {!! Form::mediaImage('video_thumbnail', Arr::get($attributes, 'video_thumbnail')) !!}
</div>

<div class="form-group">
    <label class="control-label" for="video_url">{{ __('Video URL') }}</label>
    <input type="text" name="video_url" value="{{ Arr::get($attributes, 'video_url') }}" class="form-control">
</div>

<div class="form-group">
    <label class="control-label" for="play_button_label">{{ __('Play button label') }}</label>
    <input type="text" name="play_button_label" value="{{ Arr::get($attributes, 'play_button_label') }}" class="form-control">
</div>
