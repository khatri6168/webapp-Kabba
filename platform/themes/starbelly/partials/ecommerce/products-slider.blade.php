@php
    Theme::asset()->container('footer')->usePath()->add('swiper', 'plugins/swiper.min.js');
    Theme::asset()->usePath()->add('swiper-css', 'plugins/swiper.min.css');
@endphp

<section class="sb-short-menu sb-p-0-90 products-slider">
    <div class="container">
        <div class="sb-group-title sb-mb-30">
            <div>
                <p class="text-title pb-0">{{ __('Customers who bought this item also bought') }}</p>
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
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>
</section>
