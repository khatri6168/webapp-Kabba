@if ($displayBasePrice && $basePrice != null)
    <div class="small d-flex justify-content-between">
        <span>{{ trans('plugins/ecommerce::product-option.total_price') }}</span>
        <span><strong>{{ format_price($basePrice) }}</strong></span>
    </div>
@endif

@foreach ($productOptions['optionCartValue'] as $key => $optionValue)
    @php
        $price = 0;
        $totalOptionValue = count($optionValue);
    @endphp
    @continue(! $totalOptionValue)
    <div class="small d-flex justify-content-between">
        <span>
            {{ (isset($productOptions['optionInfo']) && $productOptions['optionInfo'][$key] == "Rental Day" ? "Options Total" : "Options Total")  }}:
            @foreach ($optionValue as $value)
                <br>
                @php
                    if (Arr::get($value, 'option_type') != 'field') {
                        if ($value['affect_type'] == 1) {
                            $price += ($basePrice * $value['affect_price']) / 100;
                        } else {
                            $price += $value['affect_price'];
                        }
                    }
                @endphp
                <small>- {{ $value['option_value'] }}</small>
                @if ($key + 1 < $totalOptionValue) , @endif
            @endforeach
        </span>
        @if ($price > 0)
            <small style="width:60px; text-align:right;"><strong>+ {{ format_price($price) }}</strong></small>
        @endif
    </div>
@endforeach
