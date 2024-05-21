@php($style = (int)$shortcode->style)

@if($style === 3)
    <section class="sb-blog-list sb-p-90-90">
        <div class="sb-bg-1">
            <div></div>
        </div>
        <div class="container" data-sticky-container>
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="sb-mb-60">
                                <h2 class="sb-cate-title sb-mb-30">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                                <p class="sb-text">{!! BaseHelper::clean($shortcode->description) !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="sb-masonry-grid">
                        <div class="sb-grid-sizer"></div>
                        {!! Theme::partial('blog.posts-list', compact('style', 'posts')) !!}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sb-sidebar-frame sb-pad-type-1 sb-sticky" data-margin-top="120">
                        <div class="sb-sidebar">
                            {!! dynamic_sidebar('blog-sidebar') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div>
                {{ $posts->links(Theme::getThemeNamespace('partials.pagination')) }}
            </div>
        </div>
    </section>
@else
    <section class="sb-blog-list sb-p-90-90">
        <div class="sb-bg-1">
            <div></div>
        </div>
        <div class="container">
            <div @class(['sb-mb-60', 'text-center' => $style === 2])>
                <h2 @class(['sb-cate-title sb-mb-15' => $style === 1, 'sb-mb-30' => $style === 2])>{!! BaseHelper::clean($shortcode->title) !!}</h2>
                <p class="sb-text">{!! BaseHelper::clean($shortcode->description) !!}</p>
            </div>
            <div class="sb-masonry-grid">
                <div class="sb-grid-sizer"></div>
                {!! Theme::partial('blog.posts-list', compact('style', 'posts')) !!}
            </div>
            <div>
                {{ $posts->links(Theme::getThemeNamespace('partials.pagination')) }}
            </div>
        </div>
    </section>
@endif
