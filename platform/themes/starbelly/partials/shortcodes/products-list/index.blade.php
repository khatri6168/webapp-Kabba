@switch($shortcode->style)
    @case('static')
        <section class="sb-menu-section sb-p-90-60">
            <div class="sb-bg-1">
                <div></div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach($products as $product)
                        <div @class(['mb-4', 'col-lg-4' => $shortcode->items_per_row == 3, 'col-lg-3' => $shortcode->items_per_row == 4])>
                            {!! Theme::partial('ecommerce.products.item', ['product' => $product, 'style' => $shortcode->style, 'footerStyle' => $shortcode->footer_style]) !!}
                        </div>
                    @endforeach
                </div>
                @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div>
                        {{ $products->links(Theme::getThemeNamespace('partials.pagination')) }}
                    </div>
                @endif
            </div>
        </section>
        @break
    @default
        <section class="sb-short-menu sb-p-90-90">
            <div class="container">
                <div class="sb-group-title sb-mb-30">
                    <div class="sb-left sb-mb-30">
                        @if ($title = $shortcode->title)
                            <h2 class="sb-mb-30">{!! BaseHelper::clean($title) !!}</h2>
                        @endif

                        @if($subtitle = $shortcode->subtitle)
                            <p class="sb-text">{!! BaseHelper::clean($subtitle) !!}</p>
                        @endif
                    </div>
                    <div class="sb-right sb-mb-30">
                        <div class="sb-slider-nav">
                            <div class="sb-prev-btn sb-short-menu-prev"><i class="fas fa-arrow-left"></i></div>
                            <div class="sb-next-btn sb-short-menu-next"><i class="fas fa-arrow-right"></i></div>
                        </div>
                        <a href="{{ $shortcode->button_url ?? '#' }}" class="sb-btn">
                            <span class="sb-icon">
                                <img src="{{ RvMedia::getImageUrl($shortcode->button_icon) }}" alt="{{ $shortcode->button_label }}">
                            </span>
                            <span>{!! BaseHelper::clean($shortcode->button_label ?? __('Go shipping now')) !!}</span>
                        </a>
                    </div>
                </div>
                <div class="swiper-container sb-short-menu-slider-{{ $shortcode->items_per_row ?: 4 }}i">
                    <div class="swiper-wrapper">
                        @foreach($products as $product)
                            <div class="swiper-slide">
                                {!! Theme::partial('ecommerce.products.item', ['product' => $product, 'style' => $shortcode->style, 'footerStyle' => $shortcode->footer_style]) !!}
                            </div>
                        @endforeach
                    </div>
                    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                </div>
            </div>
        </section>
@endswitch
