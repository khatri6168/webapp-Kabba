<div class="sb-menu-item sb-menu-item-sm sb-mb-15 sb-cart-item">
    <div class="sb-cover-frame">
        <a href="{{ $product->original_product->url }}">
            <img src="{{ RvMedia::getImageUrl(Arr::get($cartItem->options, 'image', $product->original_product->image)) }}" alt="{{ $product->original_product->name }}">
        </a>
    </div>
    <div class="sb-card-tp" style="padding:10px !important; ">
        <a href="{{ $product->original_product->url }}">
            <h4 class="sb-card-title">{{ $product->original_product->name }}</h4>
        </a>
        <span class="price">{{ format_price($cartItem->price) }}
            @if ($product->front_sale_price != $product->price)
                <small class="text-secondary text-sm">
                    <del>{{ format_price($product->price) }}</del>
                </small>
            @endif
            (x{{ $cartItem->qty }})
        </span>
        <br>
        <p class="mb-0">
            <small>
                <small>{{ $cartItem->options['attributes'] ?? '' }}</small>
            </small>
        </p>
        @if (!empty($cartItem->options['options']))
            {!! render_product_options_info($cartItem->options['options'], $product, true) !!}
        @endif
        <br />
        <small style="display:block; width:100%; float:left; height:30px;">Schedule Date: {{$cartItem->options['deldate']}}</small>
       
        <div class="actionsection" style="width:100%; display:block; float:inline-end;">
            <span aria-hidden="true">&times;</span><small><a href="{{ route('public.cart.remove', $cartItem->rowId) }}" class="">Remove</a></small> |
            <small><a href="{{ $product->original_product->url }}" class="text-info">Update </a></small>
        </div>

        @if (!empty($cartItem->options['extras']) && is_array($cartItem->options['extras']))
            @foreach($cartItem->options['extras'] as $option)
                @if (!empty($option['key']) && !empty($option['value']))
                    <p class="mb-0"><small>{{ $option['key'] }}: <strong> {{ $option['value'] }}</strong></small></p>
                @endif
            @endforeach
        @endif
        {{-- <span class="delete-item-cart remove-cart-item" data-url="{{ route('public.cart.remove', $cartItem->rowId) }}">&times;</span> --}}
    </div>
</div>
