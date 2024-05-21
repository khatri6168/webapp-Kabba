{!! Theme::partial('header') !!}

<div class="sb-app">
    <div id="sb-dynamic-content" class="sb-transition-fade content">
        @if(Theme::get('withBreadcrumb', true))
            {!! Theme::partial('breadcrumb') !!}
        @endif

        {!! Theme::content() !!}
    </div>
</div>

{!! Theme::partial('footer') !!}
