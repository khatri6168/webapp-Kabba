@if ($product->isOutOfStock())
    <span class="sb-text">({{ __('Out of stock') }})</span>
@else
    @if (!$productVariation)
        <span class="sb-text">({{ __('Not available') }})</span>
    @else
        @if ($productVariation->isOutOfStock())
            <span class="sb-text">({{ __('Out of stock') }})</span>
        @elseif  (!$productVariation->with_storehouse_management || $productVariation->quantity < 1)
            <span class="sb-text">({!! BaseHelper::clean($productVariation->stock_status_html) !!})</span>
        @elseif ($productVariation->quantity)
            @if (EcommerceHelper::showNumberOfProductsInProductSingle())
                <span class="sb-text">
                    @if ($productVariation->quantity != 1)
                        ({{ __(':number products available', ['number' => $productVariation->quantity]) }})
                    @else
                        ({{ __(':number product available', ['number' => $productVariation->quantity]) }})
                    @endif
                </span>
            @else
                <span class="sb-text">({{ __('In stock') }})</span>
            @endif
        @endif
    @endif
@endif
