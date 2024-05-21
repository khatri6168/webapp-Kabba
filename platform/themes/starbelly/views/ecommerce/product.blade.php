@php
    Theme::asset()->usePath()->add('swiper-css', 'plugins/swiper.min.css');
    Theme::asset()->usePath()->add('jquery-rating-bar-css', 'css/css-stars.css');
    Theme::asset()->container('footer')->usePath()->add('jquery-rating-bar-js', 'plugins/jquery.barrating.min.js');
    Theme::asset()->container('footer')->usePath()->add('swiper-js', 'plugins/swiper.min.js');
@endphp

<section class="sb-p-90-0">
    <div class="container product-details">
        <div class="row">
            <div class="col-lg-6">
                <div class="sb-gallery-item sb-gallery-square">
                    <img src="{{ RvMedia::getImageUrl($product->image, 'product_detail') }}" alt="{{ $product->name }}" id="sb-primary-image">
                    @foreach ($product->categories as $category)
                        <div class="sb-badge">
                            {!! BaseHelper::clean($category->name) !!}
                        </div>
                    @endforeach
                        <a data-fancybox="menu"  href="{{ RvMedia::getImageUrl($product->image, 'product_detail') }}" id="sb-primary-image-zoom" class="sb-btn sb-btn-2 sb-btn-icon sb-btn-gray sb-zoom">
                        <span class="sb-icon">
                            <img src="{{ Theme::asset()->url('images/icons/zoom.svg') }}" alt="{{ __('View') }}">
                        </span>
                    </a>
                </div>
                @foreach ($productImages as $image)
                    <img src="{{ RvMedia::getImageUrl($image, 'product_detail') }}" alt="{{ $product->name }}" style="height: 50px;object-fit:scale-down;" class="sb-footer-image">
                    {{-- <a data-fancybox="menu" data-no-swup href="{{ RvMedia::getImageUrl($image, 'product_detail') }}" class="sb-btn sb-btn-2 sb-btn-icon sb-btn-gray sb-zoom">
                        <span class="sb-icon">
                            <img src="{{ Theme::asset()->url('images/icons/zoom.svg') }}" alt="{{ __('View') }}">
                        </span>
                    </a> --}}
                @endforeach
                @php
                   // Retrieve the cart data from the session
                   //$cart = Cart::instance('cart')->content();

                    // dd($cartItem);
                @endphp
            </div>
            <div class="col-lg-6">
                {!! Theme::partial('ecommerce.product.detail', compact('product', 'selectedAttrs', 'productVariation', 'storeLocators')) !!}
            </div>
        </div>
        <div class="sb-filter">
            <a href="#." data-filter=".sb-details-tab" class="sb-filter-link sb-active">{{ __('Details') }}</a>
            @if (is_plugin_active('faq') && count($product->faq_items) > 0)
                <a href="#." data-filter=".sb-faqs-tab" class="sb-filter-link">{{ __('Questions & Answers') }}</a>
            @endif
            @if (EcommerceHelper::isReviewEnabled())
                <a href="#." data-filter=".sb-reviews-tab" class="sb-filter-link">{{ __('Reviews (:count)', ['count' => $product->reviews_count]) }}</a>
            @endif
        </div>
        <div class="sb-masonry-grid sb-tabs">
            <div class="sb-grid-sizer"></div>
            <div class="sb-grid-item sb-details-tab" style="position: absolute">
                <div class="sb-tab">
                    <div class="sb-text">{!! BaseHelper::clean($product->content) !!}</div>

                    @if (theme_option('facebook_comment_enabled_in_product', 'yes') == 'yes')
                        {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, Theme::partial('comments')) !!}
                    @endif
                </div>
            </div>
            @if (is_plugin_active('faq') && count($product->faq_items) > 0)
                <div class="sb-grid-item sb-faqs-tab" style="position: absolute">
                    <div class="sb-tab">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="sb-faq">
                                    @foreach($product->faq_items as $faq)
                                        <li>
                                            <div class="sb-question">
                                                <h4>{!! BaseHelper::clean($faq[0]['value']) !!}</h4>
                                                <span class="sb-plus-minus-toggle sb-collapsed"></span>
                                            </div>
                                            <div class="sb-answer sb-text">
                                                {!! BaseHelper::clean($faq[1]['value']) !!}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (EcommerceHelper::isReviewEnabled())
                <div class="sb-grid-item sb-reviews-tab" style="position: absolute">
                    <div class="sb-tab">
                        <div class="row">
                            <div class="col-md-8">
                                {!! Theme::partial('ecommerce.product.review-form', compact('product')) !!}
                                {!! Theme::partial('ecommerce.product.reviews-list', compact('product')) !!}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@if (($products = get_related_products($product)) && $products->count())
    <section class="sb-short-menu sb-p-0-90" style="display: none;">
        <div class="sb-bg-2">
            <div></div>
        </div>
        <div class="container">
            <div class="sb-group-title sb-mb-30">
                <div class="sb-left sb-mb-30">
                    <h2 class="sb-cate-title sb-mb-30">{{ __('It is usually bought together with this product') }}</h2>
                    <p class="sb-text">{{ __('You may also like') }}</p>
                </div>
                <div class="sb-right sb-mb-30">
                    <div class="sb-slider-nav">
                        <div class="sb-prev-btn sb-short-menu-prev"><i class="fas fa-arrow-left"></i></div>
                        <div class="sb-next-btn sb-short-menu-next"><i class="fas fa-arrow-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="swiper-container sb-short-menu-slider-4i">
                <div class="swiper-wrapper">
                    @foreach($products as $product)
                        <div class="swiper-slide">
                            {!! Theme::partial('ecommerce.products.item', compact('product')) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif

{!! dynamic_sidebar('product-footer') !!}
