@php
    SeoHelper::setTitle(__('404 - Not found'));
    Theme::fireEventGlobalAssets();
@endphp

{!! Theme::partial('header') !!}

<section class="sb-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="sb-main-title-frame">
                    <div class="sb-main-title">
                        <span class="sb-404">{{ __('404') }}</span>
                        <h1 class="sb-mb-30">{{ __('Oops! Where ') }}<br>{{ __('are we') }}?</h1>
                        <p class="sb-text sb-text-lg sb-mb-30">{{ __('Page not Found! The page you are looking for was moved, removed, renamed or might never existed.') }}</p>
                        <a href="{{ route('public.index') }}" class="sb-btn sb-btn-2">
                    <span class="sb-icon">
                      <img src="{{ Theme::asset()->url('images/icons/arrow-2.svg') }}" alt="{{ __('Icon') }}">
                    </span>
                            <span>{{ __('Back to homepage') }}</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="sb-illustration-1-404">
                    @if ($backgroundImage = theme_option('background_image_page_404'))
                        <img src="{{ RvMedia::getImageUrl($backgroundImage) }}" alt="{{ theme_option('site_name') }}" class="sb-man">
                    @endif
                    <div class="sb-cirkle-1"></div>
                    <div class="sb-cirkle-2"></div>
                    <div class="sb-cirkle-3"></div>
                    <div class="sb-cirkle-4"></div>
                    <div class="sb-cirkle-5"></div>
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/3.svg') }}" alt="{{ __('icon') }}" class="sb-pik-1">
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/1.svg') }}" alt="{{ __('icon') }}" class="sb-pik-2">
                    <img src="{{ Theme::asset()->url('images/icons/illustrations/2.svg') }}" alt="{{ __('icon') }}" class="sb-pik-3">
                </div>
            </div>
        </div>
    </div>
</section>
{!! Theme::partial('footer') !!}


