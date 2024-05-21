<section style="max-height: 400px; overflow: auto">
    <div class="form-group">
        <label>{{ __('Title') }}</label>
        <input type="text" class="form-control" name="title" value="{{ $config['title'] }}">
    </div>

    <div class="form-group">
        <label>{{ __('Phone') }}</label>
        <input type="text" class="form-control" name="phone" value="{{ $config['phone'] }}">
    </div>

    <div class="form-group">
        <label>{{ __('Email') }}</label>
        <input type="email" class="form-control" name="email" value="{{ $config['email'] }}">
    </div>

    <div class="form-group">
        <label>{{ __('Address') }}</label>
        <textarea rows="2" class="form-control" name="address">{{ $config['address'] }}</textarea>
    </div>

    <div class="form-group">
        <label>{{ __('Working hours start') }}</label>
        <input type="time" step="3600" class="form-control" name="working_hours_start" value="{{ $config['working_hours_start'] }}">
    </div>

    <div class="form-group">
        <label>{{ __('Working hours end') }}</label>
        <input type="time" step="3600" class="form-control" name="working_hours_end" value="{{ $config['working_hours_end'] }}">
    </div>
</section>
