<div class="sb-product-description sb-mb-90">
    <div class="sb-price-frame sb-mb-30">
        <div>
            <h3 class="mb-1">{!! BaseHelper::clean($product->name) !!}</h3>
            {!! Theme::partial('ecommerce.product.availability', compact('product', 'productVariation')) !!}
        </div>
        <div class="sb-price box-price">
            <span class="price">{{ format_price($product->front_sale_price_with_taxes) }}</span>
            @if($product->front_sale_price !== $product->price)
                <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
            @endif
        </div>
    </div>
    @if (EcommerceHelper::isReviewEnabled())
        <div class="sb-text sb-stars sb-mb-25">
            <div class="rating-star">
                <span class="rating-star-item" style="width: {{ $product->reviews_avg * 20 }}%"></span>
            </div>
            <span class="ms-2">({{ __(':count', ['count' => $product->reviews_count]) }})</span>
        </div>
    @endif
    <p class="sb-text sb-mb-30">{!! BaseHelper::clean($product->description) !!}</p>

    {!! apply_filters('ecommerce_after_product_description', null, $product) !!}

    <form action="{{ route('public.cart.add-to-cart') }}" method="post" class="cart-form">
        <input type="hidden" name="id" class="hidden-product-id" value="{{ ($product->is_variation || !$product->defaultVariation->product_id) ? $product->id : $product->defaultVariation->product_id }}"/>
        @if ($product->variations()->count() > 0)
            <div class="pr_switch_wrap">
                {!! render_product_swatches($product, [
                    'selected' => $selectedAttrs,
                    'view' => Theme::getThemeNamespace('views.ecommerce.attributes.swatches-renderer')
                ]) !!}
            </div>
            <div class="items-available-wrap">
                <div class="number-items-available sb-text" style="display: none;"></div>
            </div>
        @endif

        {!! render_product_options($product) !!}

        <div class="sb-buttons-frame">
            <div class="sb-input-number-frame">
                <div class="sb-input-number-btn sb-sub">-</div>
                <input type="number" name="{{ $name ?? 'qty' }}" value="{{ $value ?? 1 }}" min="1" max="{{ $product->with_storehouse_management ? $product->quantity : 1000 }}">
                <div class="sb-input-number-btn sb-add">+</div>
            </div>
            @if (EcommerceHelper::isCartEnabled())
                <button type="submit" class="sb-btn sb-atc">
                    <span class="sb-icon">
                        <img src="{{ Theme::asset()->url('images/icons/cart.svg') }}" alt="{{ __('Add to cart') }}">
                        <i class="fas fa-spinner fa-spin" style="display: none"></i>
                    </span>
                    <span class="sb-add-to-cart-text">{{ __('Add to cart') }}</span>
                    <span class="sb-added-text">{{ __('Added') }}</span>
                </button>

            @endif

            @if (EcommerceHelper::isWishlistEnabled())
                <a class="sb-btn custom-btn product-wishlist-button" aria-label="{{ __('Add To Wishlist') }}" data-url="{{ route('public.ajax.add-to-wishlist', $product->id) }}" href="#">
                    <i class="fas fa-heart"></i>
                </a>
            @endif

            @if (EcommerceHelper::isCompareEnabled())
                <a class="sb-btn custom-btn product-compare-button" aria-label="{{ __('Compare') }}" data-url="{{ route('public.compare.add', $product->id) }}" href="#">
                    <i class="fa fa-random"></i>
                </a>
            @endif
        </div>
    </form>

    <div class="sb-text mt-4">
        @if (is_plugin_active('marketplace') && $product->store_id)
            <div>
                <span>{{ __('Vendor') }}:</span>
                <a href="{{ $product->store->url }}">{{ $product->store->name }}</a>
            </div>
        @endif

        @if ($product->sku)
            <div>
                <span>{{ __('SKU') }}: </span>
                <span class="text-dark">{{ $product->sku }}</span>
            </div>
        @endif
        @if ($product->categories->count())
            <div>
                <span>{{ __('Categories') }}: </span>
                @foreach($product->categories as $category)
                    <a href="{{ $category->url }}" class="text-dark">{!! BaseHelper::clean($category->name) !!}</a>@if (!$loop->last), @endif
                @endforeach
            </div>
        @endif
        @if ($product->tags->count())
            <div>
                <span>{{ __('Tags') }}: </span>
                @foreach($product->tags as $tag)
                    <a href="{{ $tag->url }}" class="text-dark">{!! BaseHelper::clean($tag->name) !!}</a>@if (!$loop->last), @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
