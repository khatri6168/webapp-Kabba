{!! Theme::partial('header') !!}

<div class="sb-app">
    <div class="sb-click-effect"></div>

    <div id="sb-dynamic-content" class="sb-transition-fade">
        {!! Theme::content() !!}
    </div>
</div>

{!! Theme::partial('footer') !!}
