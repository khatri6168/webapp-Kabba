<div class="form-group">
    <label for="image" class="control-label">{{ __('Image') }}</label>
    {!! Form::mediaImage('image', Arr::get($attributes, 'image')) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="experience_year" class="control-label">{{ __('Experience year') }}</label>
            <input type="text" id="experience_year" name="experience_year" class="form-control" value="{{ Arr::get($attributes, 'experience_year') }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="experience_text" class="control-label">{{ __('Experience text') }}</label>
            <input type="text" id="experience_text" name="experience_text" class="form-control" value="{{ Arr::get($attributes, 'experience_text') }}">
        </div>
    </div>
</div>

<div class="form-group">
    <label for="title" class="control-label">{{ __('Title') }}</label>
    <input type="text" id="title" name="title" class="form-control" value="{{ Arr::get($attributes, 'title') }}" placeholder="{{ __('Title') }}">
</div>

<div class="form-group">
    <label for="text" class="control-label">{{ __('Text') }}</label>
    <textarea name="text" id="text" class="form-control" rows="5">{{ Arr::get($attributes, 'text') }}</textarea>
</div>

<div class="form-group">
    <label for="text_image" class="control-label">{{ __('Image below the text') }}</label>
    {!! Form::mediaImage('text_image', Arr::get($attributes, 'text_image')) !!}
</div>
