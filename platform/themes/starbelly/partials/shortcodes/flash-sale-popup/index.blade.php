@if ($product)
    <div class="sb-popup-frame" id="flash-sale-modal" data-id="flash-sale-id-{{ $flashSale->id }}">
        <div class="sb-popup-body">
            <input type="hidden" value="{{ $shortcode->timeout * 1000 ?? 10000  }}">
            <div class="sb-close-popup">+</div>
            <div class="sb-promo-content">
                <div class="sb-text-frame">
                    <h3 class="sb-mb-15">{!! BaseHelper::clean($product->name) !!}</h3>
                    <h3 class="sb-mb-10">
                        <b class="sb-h2 text-primary"><span class="bg-white">{{ format_price($product->front_sale_price_with_taxes) }}</span></b>&nbsp;
                        <small>
                            <del class="price-old @if ($product->front_sale_price === $product->price) d-none @endif">{{ format_price($product->price_with_taxes) }}</del>
                        </small>
                    </h3>
                    @if ($description = $shortcode->description)
                        <p class="sb-text sb-text-sm sb-mb-15">{!! BaseHelper::clean($description) !!}</p>
                    @endif
                    <p class="sb-text sb-text-sm sb-mb-15"></p>
                    <a href="{{ $product->url }}" class="sb-btn sb-ppc">
                      <span class="sb-icon">
                        <img src="{{ Theme::asset()->url('images/icons/arrow.svg') }}" alt="{{ __('Icon') }}">
                      </span>
                      <span>{{ __('Get it now') }}</span>
                    </a>
                </div>
                <div class="sb-image-frame">
                    <div class="sb-illustration-5">
                        <img src="{{ RvMedia::getImageUrl($product->image) }}" alt="{{ $product->name }}" class="sb-cup">
                        <div class="sb-cirkle-1"></div>
                        <div class="sb-cirkle-2"></div>
                        <div class="sb-cirkle-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
