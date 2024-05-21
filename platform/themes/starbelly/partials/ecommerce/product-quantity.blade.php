<div class="sb-input-number-frame quantity">
    <div class="sb-input-number-btn decrease">{{ __('-') }}</div>
    <input class="qty-val qty"
           value="{{ $value ?? 1 }}" type="number" step="1"
           min="1" max="{{ $product->with_storehouse_management ? $product->quantity : 1000 }}"
           name="{{ $name ?? 'qty' }}" title="Qty" tabindex="0">
    <div class="sb-input-number-btn increase">{{ __('+') }}</div>
</div>
