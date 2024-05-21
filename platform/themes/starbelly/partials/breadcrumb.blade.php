@php
    $crumbs = Theme::breadcrumb()->getCrumbs();
    $style = Theme::get('breadcrumbStyle') ?: theme_option('blog_default_breadcrumb_style');
    $breadcrumbImage = Theme::get('breadcrumbImage');
    $pageTitle = Theme::get('pageTitle') ?: Arr::get(Arr::last($crumbs), 'label');
    $pageDescription = Theme::get('pageDescription');
@endphp

@switch($style)
    @case('expanded')
        <section class="position-relative sb-banner sb-banner-sm @if (! $breadcrumbImage) sb-banner-color @endif"
                 @if ($breadcrumbImage) style="background: url('{{ RvMedia::getImageUrl($breadcrumbImage) }}') center no-repeat; background-size: cover;" @endif
        >
            <div class="position-absolute @if ($breadcrumbImage) breadcrumb-backdrop @endif"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sb-main-title-frame">
                            <div class="sb-main-title text-center">
                                @if($pageTitle = Arr::get(Arr::last($crumbs), 'label'))
                                    <span class="sb-subtitle sb-mb-30">{{ $pageTitle }}</span>
                                    <h1 class="sb-mb-30">{!! BaseHelper::clean(Theme::get('breadcrumbTitle') ?? $pageTitle) !!}</h1>
                                @endif

                                @if ($pageDescription)
                                    <p class="sb-text sb-text-lg sb-mb-30">{!! BaseHelper::clean(Str::limit($pageDescription, 120)) !!}</p>
                                @endif
                                <ul class="sb-breadcrumbs">
                                    @foreach ($crumbs as $i => $crumb)
                                    <li>
                                        <a href="{{ Arr::get($crumb, 'url') }}">{!! BaseHelper::clean(Arr::get($crumb, 'label')) !!}</a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @break
    @default
        <section class="position-relative sb-banner sb-banner-xs @if (! $breadcrumbImage) sb-banner-color @endif"
                 @if ($breadcrumbImage) style="background: url('{{ RvMedia::getImageUrl($breadcrumbImage) }}') center no-repeat; background-size: cover;" @endif
        >
            <div class="position-absolute @if ($breadcrumbImage) breadcrumb-backdrop @endif"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        @if ($pageDescription)
                            <div class="breadcrumb-description position-absolute">
                                <p>{!! BaseHelper::clean(Str::limit($pageDescription, 120)) !!}</p>
                            </div>
                        @endif
                        <div class="sb-main-title-frame position-relative">
                            <div class="sb-main-title">
                                @if($pageTitle)
                                    <h1 class="sb-h2">{!! BaseHelper::clean($pageTitle) !!}</h1>
                                @endif
                                <ul class="sb-breadcrumbs">
                                    @foreach ($crumbs as $i => $crumb)
                                        <li>
                                            <a href="{{ Arr::get($crumb, 'url') }}">{!! BaseHelper::clean(Arr::get($crumb, 'label')) !!}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @break
@endswitch
