@php
    Theme::asset()->usePath()->add('fancybox', 'plugins/fancybox.min.css');
    $galleries = app(\Botble\Gallery\Repositories\Interfaces\GalleryInterface::class)->advancedGet([
        'paginate' => [
            'per_page' => 8,
            'current_paged' => (int)request()->input('page', 1),
        ],
    ]);

    if (theme_option('gallery_page_style') == 2) {
        Theme::set('breadcrumbStyle', 'expanded');
        Theme::set('breadcrumbTitle', theme_option('gallery_breadcrumb_title'));
        Theme::set('breadcrumbSubtitle', theme_option('gallery_breadcrumb_subtitle'));
    }

    $style = theme_option('gallery_page_style');
@endphp

<section class="sb-blog-list sb-p-90-90">
    <div class="sb-bg-1">
        <div></div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div @class(['sb-mb-60', 'text-center' => $style == 2])>
                            @if ($title = theme_option('gallery_page_title'))
                                <h2 class="sb-cate-title sb-mb-30">{!! BaseHelper::clean($title) !!}</h2>
                            @endif
                            @if ($description = theme_option('gallery_page_description'))
                                <p class="sb-text">{!! BaseHelper::clean($description) !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="sb-masonry-grid">
                    <div class="sb-grid-sizer"></div>
                    {!! Theme::partial('gallery.galleries-list', compact('galleries', 'style')) !!}
                </div>
            </div>
        </div>
        <div>
            {{ $galleries->links(Theme::getThemeNamespace('partials.pagination')) }}
        </div>
    </div>

    <section class="sb-call-to-action">
        {!! dynamic_sidebar('galleries_sidebar') !!}
    </section>
</section>
