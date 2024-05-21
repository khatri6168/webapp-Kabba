<span class="quantity">
    <span class="box-price price-amount amount">
        <span class="price">{{ format_price($product->front_sale_price_with_taxes) }}</span>
        <small>
            <del class="price-old @if ($product->front_sale_price === $product->price) d-none @endif">{{ format_price($product->price_with_taxes) }}</del>
        </small>
    </span>
</span>
