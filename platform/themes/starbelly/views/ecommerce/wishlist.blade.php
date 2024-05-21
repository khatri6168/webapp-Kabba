<section class="sb-p-90-90">
    <div class="container wishlist-page-content">
        @if($products->total())
            <div class="sb-cart-table">
                <div class="sb-cart-table-header">
                    <div class="row">
                        <div class="col-lg-4">{{ __('Product') }}</div>
                        <div class="col-lg-2">{{ 'Unit Price' }}</div>
                        <div class="col-lg-2">{{ 'Stock status' }}</div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-1"></div>
                    </div>
                </div>
                @foreach($products as $product)

                    <div class="sb-cart-item">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <a class="sb-product" href="{{ $product->url }}">
                                    <div class="sb-cover-frame">
                                        <img src="{{ RvMedia::getImageUrl($product->image, 'thumb') }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="sb-prod-description">
                                        <h4 class="sb-mb-10">{!! BaseHelper::clean($product->name) !!}</h4>
                                        @if (EcommerceHelper::isReviewEnabled())
                                            <div class="sb-menu-item">
                                                <div class="sb-item-meta">
                                                    <div class="rating-star">
                                                        <span class="rating-star-item" style="width: {{ $product->reviews_avg * 20 }}%"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <p class="mb-0">
                                            <small>
                                                <small>{{ $cartItem->options['attributes'] ?? '' }}</small>
                                            </small>
                                        </p>
                                        @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))
                                            @foreach($cartItem->options['extras'] as $option)
                                                @if (!empty($option['key']) && !empty($option['value']))
                                                    <p class="sb-text sb-text-sm">
                                                        <small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small>
                                                    </p>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </a>
                            </div>
                            <div class="col-4 col-lg-2">
                                <div>
                                    <span class="sb-price-2 ">{{ format_price($product->front_sale_price_with_taxes) }}</span>
                                    @if ($product->front_sale_price != $product->price)
                                        <small class="sb-price-1"><del>{{ format_price($product->price_with_taxes) }}</del></small>
                                    @endif</div>
                            </div>
                            <div class="col-4 col-lg-2">
                                @if ($product->isOutOfStock()) {{ __('Out Of Stock') }} @else {{ __('In Stock') }} @endif
                            </div>
                            <div class="col-12 col-lg-2" >
                                @if (EcommerceHelper::isCartEnabled())
                                    <form class="cart-form" action="{{ route('public.cart.add-to-cart') }}" method="POST">
                                        @csrf
                                        <input type="hidden"
                                               name="id" class="hidden-product-id"
                                               value="{{ ($product->is_variation || !$product->defaultVariation->product_id) ? $product->id : $product->defaultVariation->product_id }}"/>
                                        <input type="hidden" name="qty" value="1">
                                        <button type="submit" class="sb-btn sb-atc btn-cart" @if ($product->isOutOfStock()) disabled @endif>
                                            <span class="sb-icon">
                                                <img src="{{ Theme::asset()->url('images/icons/cart.svg') }}" alt="{{ __('Cart') }}">
                                            </span>
                                            <span class="sb-add-to-cart-text">{{ __('Add to cart') }}</span>
                                            <span class="sb-added-text">{{ __('Added') }}</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="col-12 col-lg-1">
                                <a href="#" class="sb-remove remove-wishlist-item" data-url="{{ route('public.wishlist.remove', $product->id) }}"
                                   aria-label="{{ __('Remove this item') }}">+</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center wishlist-empty">{{ __('No products in wishlist!!') }}</p>
        @endif
    </div>
</section>

@if ($products->total())
    {!! $products->links() !!}
@endif
