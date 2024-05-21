@if ($displayBasePrice)
    <small style="display:block">{{ trans('plugins/ecommerce::product-option.price') }}: <strong style="float: right">{{ format_price($product->original_product->front_sale_price_with_taxes) }}</strong></small>
@endif

@foreach ($productOptions['optionCartValue'] as $key => $optionValue)
    @php
        $price = 0;
        $totalOptionValue = count($optionValue);
    @endphp
    @foreach ($optionValue as $value)
            @php
                if ($value['affect_type'] == 1) {
                    $price += ($product->original_product->front_sale_price_with_taxes * $value['affect_price']) / 100;
                } else {
                    $price += $value['affect_price'];
                }
            @endphp
    @endforeach
    <small style="width:37%;float:right;">
        @if ($price > 0)
                <strong style="float: right; margin-top:0px;">+ {{ format_price($price) }}</strong>
            @endif
    </small>
    @continue(!$totalOptionValue)
    <small style="display: block; width:100%; float:left; padding-bottom:10px; margin-top: -23px;">
        {{ (isset($productOptions['optionInfo']) && $productOptions['optionInfo'][$key] == "Rental Day" ? "Options" : "Options")  }}:

        @foreach ($optionValue as $value)
        <br>
            @php
                if ($value['affect_type'] == 1) {
                    $price += ($product->original_product->front_sale_price_with_taxes * $value['affect_price']) / 100;
                } else {
                    $price += $value['affect_price'];
                }
            @endphp

            <small>- {{ $value['option_value'] }}</small>
            @if ($key + 1 < $totalOptionValue) , @endif
        @endforeach



    </small>


@endforeach
