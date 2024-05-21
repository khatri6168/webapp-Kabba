@if (is_plugin_active('blog'))
    <div class="sb-ib-title-frame sb-mb-30">
        <h4>{!! BaseHelper::clean(Arr::get($config, 'name')) !!}</h4>
        <i class="fas fa-arrow-down"></i>
    </div>
    <form action="{{ route('public.search') }}" method="get">
        <div class="sb-group-input sb-group-with-btn">
            <input type="text" required name="q" value="{{ BaseHelper::stringify(request()->query('q')) }}">
            <span class="sb-bar"></span>
            <label>{{ __('What do you search?') }}</label>
            <button type="submit">
                <img src="{{ Theme::asset()->url('images/icons/search.svg') }}" alt="{{ __('Search') }}">
            </button>
        </div>
    </form>
@endif
