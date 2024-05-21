<div
    class="form-group mb-3 variant-radio product-option product-option-{{ Str::slug($option->name) }} product-option-{{ $option->id }}"
    style="margin-bottom:10px">
    <div class="product-option-item-wrapper">
        <div class="product-option-item-label">
            <label class="{{ ($option->required) ? 'required' : '' }}">
                {{-- {{ $option->name }} --}}
                {{ __('Options') }}
            </label>
        </div>
        
        <div class="product-option-item-values">
            <input type="hidden" name="options[{{ $option->id }}][option_type]" value="checkbox"/>
            @foreach($option->values as $value)
                @php
                    $price = 0;
                    if (!empty($value->affect_price) && doubleval($value->affect_price) > 0) {
                        $price = $value->affect_type == 0 ? $value->affect_price : (floatval($value->affect_price) * $product->front_sale_price_with_taxes) / 100;
                    }
                @endphp
                @if ($option->option_type == "Botble\Ecommerce\Option\OptionType\Rental")
                    <div class="form-checkbox">
                        <input data-extra-price="{{ $price }}" type="checkbox" name="options[{{ $option->id }}][values][]"
                            value="{{ $value->option_value }}" 
                            @if ($value->value_type == 1 && $value->comment != '')
                            class="rental_option_swal"
                            @endif
                            data-comment="{{ $value->comment }}"
                            id="option-{{ $option->id}}-value-{{ Str::slug($value->option_value) }}"  @if (($option->required && $loop->first) || $value->value_type == 1) checked @endif>
                        <label for="option-{{ $option->id }}-value-{{ Str::slug($value->option_value) }}">
                            &nbsp;{{ $value->option_value }}
                            @if ($price > 0)
                                <strong class="extra-price">+ {{ format_price($price) }}</strong>
                            @endif
                        </label>
                    </div>
                @else
                    <div class="form-checkbox">
                        <input data-extra-price="{{ $price }}" type="checkbox" name="options[{{ $option->id }}][values][]"
                            value="{{ $value->option_value }}"
                            id="option-{{ $option->id}}-value-{{ Str::slug($value->option_value) }}"  @if ($option->required && $loop->first) checked @endif>
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
