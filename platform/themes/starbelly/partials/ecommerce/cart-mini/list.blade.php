<div class="sb-minicart-content mb-0" >
    <div class="sb-ib-title-frame sb-mb-30">
        <h4>{{ __('Your cart.') }}</h4><i class="fas fa-arrow-down"></i>
    </div>
    @if (Cart::instance('cart')->count() > 0 && Cart::instance('cart')->products()->count() > 0)
        @php
            $products = Cart::instance('cart')->products();
        @endphp
        <div class="sb-cartmini-list-items h-100" style="overflow-x:hidden;">
            @if (count($products))
                @forelse (Cart::instance('cart')->content() as $key => $cartItem)
                    @php
                        $product = $products->find($cartItem->id);
                    @endphp
                    {!! Theme::partial('ecommerce.cart-mini.item', compact('product', 'cartItem')) !!}
                @empty
                    <div class="cart_no_items py-3 px-3">
                        <span class="cart-empty-message">{{ __('No products in the cart.') }}</span>
                    </div>
                @endforelse
                @endif
                <div class="col-md-12">
                    <div class="sb-minicart-totals">
                        @if (EcommerceHelper::isTaxEnabled())
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>{{ __('Sub Total') }}:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span>
                                        <bdi>{{ format_price(Cart::instance('cart')->rawSubTotal()) }}</bdi>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-6">
                                    <strong>{{ __('Tax') }}:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span>
                                        <bdi>{{ format_price(Cart::instance('cart')->rawTax()) }}</bdi>
                                    </span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                @else
                                    <div class="row mb-2">
                                        <div class="col-6">
                                            <strong>{{ __('Sub Total') }}:</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <span>
                                                <bdi>{{ format_price(Cart::instance('cart')->rawSubTotal()) }}</bdi>
                                            </span>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-6">
                                    <strong>{{ __('Total') }}:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <span>
                                        <bdi>{{ format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax()) }}</bdi>
                                    </span>
                                </div>
                            </div>
                    </div>
                    <div class="sb-minicart-footer-action">
                        {{-- <a href="{{ route('public.cart') }}" class="sb-btn sb-btn-gray sb-btn-text">
                            <span>{{ __('View cart') }}</span>
                        </a> --}}
                        <a href="{{ route('public.checkout.information', OrderHelper::getOrderSessionToken()) }}" class="btn btn-warning w-100">
                            <span>{{ __('Checkout') }}</span>
                        </a>
                    </div>
                </div>
        </div>
    @else
        <div class="cart_no_items py-3 px-3">
            <span class="cart-empty-message">{{ __('No products in the cart.') }}</span>
        </div>
    @endif
</div>
