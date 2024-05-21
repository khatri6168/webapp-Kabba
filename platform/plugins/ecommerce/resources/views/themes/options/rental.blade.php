<div class="form-group mb-3 variant-radio product-option product-option-{{ Str::slug($option->name) }} product-option-{{ $option->id }}"
    style="margin-bottom:10px">
    <div class="product-option-item-wrapper">
        <div class="product-option-item-label">
            <label class="{{ $option->required ? 'required' : '' }}">
                {{-- {{ $option->name }} --}}
                <strong>{{ __('Options') }}</strong>
            </label>
        </div>
        @php
            if (isset($_GET['options'])) {
                $segment = $_GET['options'];
                if (isset($segment) && !empty($segment)) {
                    $option_segment_array = explode(',', $segment);
                }
            }
        @endphp
        <div class="product-option-item-values">
            <input type="hidden" name="options[{{ $option->id }}][option_type]" value="checkbox" />
            @php
                // Get Cart Data using session
                // $cart = request()->session()->get('cart', []);
                // $cartArray = $cart['cart']->toArray();

                // Get Data usign instance
                $optionArr = [];
                $cartFlag = false;
                foreach (\Botble\Ecommerce\Facades\Cart::instance('cart')->content() as $item) {
                    if ($item->id == $product->id) {
                        if (isset($item->options->options['optionCartValue'])) {
                            $optionArr = $item->options->options['optionCartValue'][$option->id];
                        }
                        $cartFlag = true;
                    }
                }
            @endphp
            @foreach ($option->values as $value)
                @php
                    $optionArrValues = array_column($optionArr,'option_value');
                    if ($cartFlag) {
                        if (in_array($value->option_value,$optionArrValues)) {
                            $value->value_type = 1;
                        }else{
                            $value->value_type = 0;
                        }
                    }
                    $price = 0;
                    if (!empty($value->affect_price) && doubleval($value->affect_price) > 0) {
                        $price = $value->affect_type == 0 ? $value->affect_price : (floatval($value->affect_price) * $product->front_sale_price_with_taxes) / 100;
                    }
                @endphp
                @if ($option->option_type == 'Botble\Ecommerce\Option\OptionType\Rental')
                    <div class="form-checkbox">
                        <input data-extra-price="{{ $price }}" type="checkbox"
                            name="options[{{ $option->id }}][values][]" value="{{ $value->option_value }}"
                            @if ($value->value_type == 1 && $value->comment != '') class="rental_option_swal" @endif
                            data-comment="{{ $value->comment }}"
                            id="option-{{ $option->id }}-value-{{ Str::slug($value->option_value) }}"
                            @if (($option->required && $loop->first) || $value->value_type == 1) checked @endif
                            @if (isset($option_segment_array) &&
                                    !empty($option_segment_array) &&
                                    in_array($value->option_value, $option_segment_array)) checked @endif>
                        <label for="option-{{ $option->id }}-value-{{ Str::slug($value->option_value) }}">
                            &nbsp;{{ $value->option_value }}
                            @if ($price > 0)
                                <strong class="extra-price">+ {{ format_price($price) }}</strong>
                            @endif
                        </label>
                    </div>
                @else
                    <div class="form-checkbox">
                        <input data-extra-price="{{ $price }}" type="checkbox"
                            name="options[{{ $option->id }}][values][]" value="{{ $value->option_value }}"
                            id="option-{{ $option->id }}-value-{{ Str::slug($value->option_value) }}"
                            @if ($option->required && $loop->first) checked @endif
                            @if (isset($option_segment_array) &&
                                    !empty($option_segment_array) &&
                                    in_array($value->option_value, $option_segment_array)) checked @endif>
                        <label for="option-{{ $option->id }}-value-{{ Str::slug($value->option_value) }}">
                            &nbsp;{{ $value->option_value }}
                            @if ($price > 0)
                                <strong class="extra-price">+ {{ format_price($price) }}</strong>
                            @endif
                        </label>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
