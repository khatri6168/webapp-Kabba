<div class="sb-menu-item">
    <div class="position-relative">
        <a href="{{ $product->url }}" class="sb-cover-frame">
            <img src="{{ RvMedia::getImageUrl($product->image, 'small', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}">
            @if ($product->isOutOfStock())
                <span class="sb-badge out-stock">{{ __('Out Of Stock') }}</span>
            @else
                @if ($product->productLabels->count())
                    @foreach ($product->productLabels as $label)
                        <span class="sb-badge" @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                    @endforeach
                @else
                    @if ($product->front_sale_price !== $product->price)
                        <div class="featured sb-badge" dir="ltr">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</div>
                    @endif
                @endif
            @endif
        </a>
        <a href="{{ $product->url }}" class="sb-item-backdrop"></a>
        <div class="sb-item-options">
            <div class="sb-item-action-wrapper">
                @if (EcommerceHelper::isWishlistEnabled())
                    <a class="sb-item-action product-wishlist-button" title="{{ __('Add To Wishlist') }}" data-url="{{ route('public.ajax.add-to-wishlist', $product->id) }}">
                        <i class="fas fa-heart"></i>
                    </a>
                @endif

                @if(EcommerceHelper::isCompareEnabled())
                    <a class="sb-item-action product-compare-button" title="{{ __('Compare') }}" data-url="{{ route('public.compare.add', $product->id) }}">
                        <i class="fa fa-random"></i>
                    </a>
                @endif

            </div>
        </div>
    </div>

    <a class="sb-card-tp" href="{{ $product->url }}">
        <h4 class="sb-card-title">
            {{ $product->name }}
        </h4>
    </a>
    <div class="sb-item-meta">
        <div class="sb-price">
            <span class="price">{{ format_price($product->front_sale_price_with_taxes) }}</span>
            @if($product->front_sale_price !== $product->price)
                <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
            @endif
        </div>
        @if(EcommerceHelper::isReviewEnabled())
            <div class="rating-star">
                <span class="rating-star-item" style="width: {{ $product->reviews_avg * 20 }}%"></span>
            </div>
        @endif
    </div>
    @if (EcommerceHelper::isCartEnabled())
        <div class="sb-card-buttons-frame" style="justify-content: center;">
            {{-- <a href="{{ $product->url }}" class="sb-btn sb-btn-2 sb-btn-gray sb-btn-icon sb-m-0">
                <span class="sb-icon">
                    <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ __('Detail') }}">
                </span>
            </a> --}}
            {{-- <form action="{{ route('public.cart.add-to-cart') }}" method="POST" class="cart-form">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}" class="hidden-product-id">
                <input type="hidden" name="qty" value="1">
                <button type="submit" class="sb-btn sb-atc btn-cart" @disabled($product->isOutOfStock())>
                <span class="sb-icon">
                    <img src="{{ Theme::asset()->url('images/icons/cart.svg') }}" alt="{{ __('Add to cart') }}">
                    <i class="fs-5 fas fa-spinner fa-spin" style="display: none"></i>
                </span>
                    <span class="sb-add-to-cart-text">{{ __('Add to cart') }}</span>
                    <span class="sb-added-text">{{ __('Added') }}</span>
                </button>
            </form> --}}
            <a href="{{ $product->url }}" class="sb-btn sb-atc btn-cart" style="justify-content: center;">
                {{-- {{ __('Add to cart') }}</span>
                <span class="sb-added-text">{{ __('Added') }}</span> --}}
                <span style="padding: 0px !important; font-size:12px;">{{ __('Reserve Now / Learn More') }}</span>
            </a>
        </div>
    @endif
</div>
