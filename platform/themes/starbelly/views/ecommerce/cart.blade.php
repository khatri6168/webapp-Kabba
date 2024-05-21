<section class="sb-p-90-90">
    <div class="container cart-page-content">
        <form class="form--shopping-cart cart-form" method="post" action="{{ route('public.cart.update') }}">
            @csrf
            @if (count($products) > 0)
                <div class="sb-cart-table">
                    <div class="sb-cart-table-header">
                        <div class="row">
                            <div class="col-lg-5">{{ __('Product') }}</div>
                            <div class="col-lg-3">{{ __('Quantity') }}</div>
                            <div class="col-lg-2">{{ __('Price') }}</div>
                            <div class="col-lg-1">{{ __('Total') }}</div>
                            <div class="col-lg-1"></div>
                        </div>
                    </div>
                    @foreach(Cart::instance('cart')->content() as $key => $cartItem)
                        @php
                            $product = $products->find($cartItem->id);
                        @endphp

                        <div class="sb-cart-item">
                            <div class="row align-items-center">
                                <div class="col-lg-5">
                                    <input type="hidden" name="items[{{ $key }}][rowId]" value="{{ $cartItem->rowId }}">
                                    <a class="sb-product" href="{{ $product->original_product->url  }}">
                                        <div class="sb-cover-frame">
                                            <img src="{{ RvMedia::getImageUrl($product->original_product->image) }}" alt="{{ $product->original_product->name }}">
                                        </div>
                                        <div class="sb-prod-description">
                                            <h4 class="sb-mb-10">{!! BaseHelper::clean($product->original_product->name) !!}</h4>
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
                                <div class="col-6 col-lg-3 product-quantity" data-title="{{ __('Quantity') }}">
                                    <div class="product-button">
                                        {!! Theme::partial('ecommerce.product-quantity', compact('product') + [
                                            'name' => 'items[' . $key . '][values][qty]',
                                            'value' => $cartItem->qty,
                                            ]);
                                        !!}
                                    </div>
                                </div>
                                <div class="col-6 col-lg-2 d-flex align-items-center">
                                    <span class="sb-price-2 ">{{ format_price($product->front_sale_price_with_taxes) }}</span>
                                    <del class="ms-2 sb-price-1 @if ($product->front_sale_price === $product->price) d-none @endif"><small>{{ format_price($product->price_with_taxes) }}</small></del>
                                </div>
                                <div class="col-12 col-lg-1 box-price">
                                    <div class="sb-price-2 price-current" data-current="{{ $cartItem->price * $cartItem->qty }}"><span>{{ __('Total:') }} </span>{{ format_price($cartItem->price * $cartItem->qty) }}</div>
                                </div>
                                <div class="col-1">
                                    <a href="#"
                                       data-url="{{ route('public.cart.remove', $cartItem->rowId) }}"
                                       aria-label="{{ __('Remove this item') }}"
                                       class="sb-remove remove-cart-item">+</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="row justify-content-end">
                        <div class="col-lg-6 wrapper-apply-coupon-code">
                            <h3 class="sb-mb-30">{{ __('Using A Promo Code?') }}</h3>
                            <div class="row form-coupon-wrapper">
                                <div class="col-8">
                                    <div class="sb-group-input">
                                        <input type="text" class="coupon-code" name="coupon_code" placeholder="{{ __('Enter coupon code') }}" value="{{ old('coupon_code') }}">
                                    </div>
                                </div>
                                <div class="col-4 px-0">
                                    <button class="sb-btn sb-m-0 pl-4 text-center btn-apply-coupon-code" data-url="{{ route('public.coupon.apply') }}">
                                        <span>{{ __('Apply') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="sb-cart-total">
                                <div class="sb-sum">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="sb-total-title">{{ __('Subtotal:') }}</div>
                                        </div>
                                        <div class="col-4">
                                            <div class="sb-price-1 text-right">{{ format_price(Cart::instance('cart')->rawSubTotal()) }}</div>
                                        </div>
                                    </div>
                                </div>
                                @if (EcommerceHelper::isTaxEnabled())
                                    <div class="sb-sum">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="sb-total-title">{{ __('Tax') }}</div>
                                            </div>
                                            <div class="col-4">
                                                <div class="sb-price-1 text-right">{{ format_price(Cart::instance('cart')->rawTax()) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($couponDiscountAmount > 0 && session('applied_coupon_code'))
                                    <div class="sb-sum">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="sb-total-title">{{ __('Coupon code: :code', ['code' => session('applied_coupon_code')]) }}</div>(<small>
                                                    <a class="btn-remove-coupon-code text-danger" data-url="{{ route('public.coupon.remove') }}"
                                                       href="#" data-processing-text="{{ __('Removing...') }}">{{ __('Remove') }}</a>
                                                </small>)
                                            </div>
                                            <div class="col-4">
                                                <div class="sb-price-1 text-right">{{ format_price($couponDiscountAmount) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="sb-realy-sum">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="sb-total-title">{{ __('Total:') }} </div>
                                            <span class="note">{{ __('(Shipping fees not included)') }}</span>
                                        </div>
                                        <div class="col-4">
                                            <div class="sb-price-2 text-right">{{ ($promotionDiscountAmount + $couponDiscountAmount) > Cart::instance('cart')->rawTotal() ? format_price(0) : format_price(Cart::instance('cart')->rawTotal() - $promotionDiscountAmount - $couponDiscountAmount) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="sb-cart-btns-frame text-right">
                                <a href="{{ route('public.products') }}" class="sb-btn sb-btn-2 sb-btn-gray">
                                    <span class="sb-icon">
                                      <img src="{{ Theme::asset()->url('images/icons/arrow-2.svg') }}" alt="{{ __('Cart') }}">
                                    </span>
                                    <span>{{ __('Continue shopping') }}</span>
                                </a>
                                @if (session('tracked_start_checkout'))
                                    <a href="{{ route('public.checkout.information', session('tracked_start_checkout')) }}" class="sb-btn btn-checkout sb-m-0">
                                        <span class="sb-icon">
                                          <img src="{{ Theme::asset()->url('images/icons/arrow-2.svg') }}" alt="{{ __('Cart') }}">
                                        </span>
                                        <span>{{ __('Checkout') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-center">{{ __('Your cart is empty!') }}</p>
            @endif
        </form>
    </div>
</section>

@if (count($crossSellProducts) > 0)
    {!! Theme::partial('ecommerce.products-slider', ['products' => $crossSellProducts]) !!}
@endif
