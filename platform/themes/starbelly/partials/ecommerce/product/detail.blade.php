<div class="sb-product-description sb-mb-90">
    <div class="sb-price-frame sb-mb-30">
        <div>
            <h3 class="mb-1">{!! BaseHelper::clean($product->name) !!}</h3>
            {!! Theme::partial('ecommerce.product.availability', compact('product', 'productVariation')) !!}
        </div>
        <div class="sb-price box-price">
            <span class="price">{{ format_price($product->front_sale_price_with_taxes) }}</span>
            @if ($product->front_sale_price !== $product->price)
                <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
            @endif
        </div>
    </div>
    @if (EcommerceHelper::isReviewEnabled())
        <div class="sb-text sb-stars sb-mb-25">
            <div class="rating-star">
                <span class="rating-star-item" style="width: {{ $product->reviews_avg * 20 }}%"></span>
            </div>
            <span class="ms-2">({{ __(':count', ['count' => $product->reviews_count]) }})</span>
        </div>
    @endif
    <p class="sb-text sb-mb-30">{!! BaseHelper::clean($product->description) !!}</p>

    {!! apply_filters('ecommerce_after_product_description', null, $product) !!}



    <form action="{{ route('public.cart.add-to-cart') }}" method="post" class="cart-form">

        <input type="hidden" name="id" class="hidden-product-id"
            value="{{ $product->is_variation || !$product->defaultVariation->product_id ? $product->id : $product->defaultVariation->product_id }}" />

            @if (isset($_GET['rawId']) && !empty($_GET['rawId']))
                <input type="hidden" name="rawId" class="hidden-raw-id" value="{{ $_GET['rawId'] }}" />
            @else
                <input type="hidden" name="rawId" class="hidden-raw-id" value="" />
            @endif

        @if ($product->variations()->count() > 0)
            <div class="pr_switch_wrap">
                {!! render_product_swatches($product, [
                    'selected' => $selectedAttrs,
                    'view' => Theme::getThemeNamespace('views.ecommerce.attributes.swatches-renderer'),
                ]) !!}
            </div>
            <div class="items-available-wrap">
                <div class="number-items-available sb-text" style="display: none;"></div>
            </div>
        @endif
        @php
            $date = "";
            foreach (\Botble\Ecommerce\Facades\Cart::instance('cart')->content() as $item) {
                if ($item->id == $product->id) {
                    $value = $item->qty;
                    $date = $item->options->deldate;
                }
            }
        @endphp
        {!! render_product_options($product) !!}

        @if ($product->delivery_pickup > 0 || $product->store_pickup > 0)
            <div class="product-option-item-label">
                @if ($product->delivery_pickup > 0 || $product->store_pickup > 0)
                    <strong><label class="">{{__('delivery_or_pickup')}}</label></strong>
                @endif
                @if ($product->delivery_pickup > 0)
                    <div class="form-checkbox">
                        <input type="radio" value="0" name="delivery" id="delivery" onchange="changeStorePickUp(this)">
                        <label for="delivery">Delivery
                            @if ($product->delivery_range != 0)
                            {{ '- Up to ' . $product->delivery_range . ' Miles'}}
                            @endif
                            @if ($product->delivery_price != 0)
                            <strong> + {{get_application_currency()->symbol}} {{ $product->delivery_price}}</strong>
                            @endif
                        </label>
                    </div>
                @endif
                @if ($product->delivery_pickup > 0)
                    <div class="form-checkbox">
                        <input type="checkbox" name="pickup" value="0" id="pickup" onchange="changePickUp()">
                        <label for="pickup">Pick Up
                            @if ($product->delivery_range != 0)
                            {{ '- Up to ' . $product->delivery_range . ' Miles'}}
                            @endif
                            @if ($product->delivery_price != 0)
                            <strong> + {{get_application_currency()->symbol}} {{ $product->delivery_price}}</strong>
                            @endif
                        </label>
                    </div>
                @endif
                @if ($product->store_pickup > 0)
                    <div class="form-checkbox">
                        <input type="radio" name="store_pickup" id="store_pickup" onchange="changeStorePickUp(this)"
                        value="{{($product->delivery_pickup < 0) ? '1': '0'}}" {{($product->delivery_pickup < 0) ? 'checked': ''}}">
                        <label for="store_pickup">{{__('pickup_in_store')}}</label>
                    </div>
                @endif
                <div class="form-checkbox store_location" style="display: {{ ($product->store_pickup > 0 && !$product->delivery_pickup > 0) ? 'block' : 'none'}}">
                    <select name="store_id" id="store_id" class="select2 form-control" style="width: 350px" onchange="changeStore()">
                        <option value="" disabled selected>{{__('select_store')}}</option>
                        @foreach ($storeLocators as $item)
                            <option value="{{$item->id}}" >
                                <span>{{ isset($item->address) ? $item->address : '' }}</span>
                                <span>{{ isset($item->city_name) ? ', ' . $item->city_name : '' }}</span>
                                <span>{{ isset($item->state_name) ? ', ' . $item->state_name : '' }}</span>
                                <span>{{ isset($item->zip_code) ? ', ' . $item->zip_code : ''}}</span>
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        @endif

        <div class="sb-buttons-frame mt-3">
            <div class="sb-input-number-frame">
                <div class="sb-input-number-btn sb-sub">-</div>
                    <input type="number" name="{{ $name ?? 'qty' }}" value="{{ isset($value) ? $value : (isset($_GET['qty']) ? $_GET['qty'] : 1) }}" min="1"
                    max="{{ $product->with_storehouse_management ? $product->quantity : 1000 }}">
                <div class="sb-input-number-btn sb-add">+</div>
            </div>
            @if (EcommerceHelper::isCartEnabled())
                <button type="submit" class="sb-btn sb-atc">
                    <span class="sb-icon">
                        <img src="{{ Theme::asset()->url('images/icons/cart.svg') }}" alt="{{ __('Add to cart') }}">
                        <i class="fas fa-spinner fa-spin" style="display: none"></i>
                    </span>
                    <span class="sb-add-to-cart-text">{{ __('Add to cart') }}</span>
                    <span class="sb-added-text">{{ __('Added') }}</span>
                </button>
            @endif

            @if (EcommerceHelper::isWishlistEnabled())
                <!-- <a class="sb-btn custom-btn product-wishlist-button" aria-label="{{ __('Add To Wishlist') }}"
                    data-url="{{ route('public.ajax.add-to-wishlist', $product->id) }}" href="#">
                    <i class="fas fa-heart"></i>
                </a> -->
            @endif
            <div class="col-md-4 col-sm-4 col-xs-12">

                <input type="text"  id="datepicker" @if($date) value="{{$date}}" @else value="Select Date" @endif name="deldate" style="border:none;margin-left:60px;">
                </div>
            @if (EcommerceHelper::isCompareEnabled())
                <a class="sb-btn custom-btn product-compare-button" aria-label="{{ __('Compare') }}"
                    data-url="{{ route('public.compare.add', $product->id) }}" href="#">
                    <i class="fa fa-random"></i>
                </a>
            @endif
        </div>
    </form>
    <!-- <small class="errordate" style="color:#231e41;width:435px;float:right;">Select Date</small> -->

    <div class="sb-text mt-4">
        @if (is_plugin_active('marketplace') && $product->store_id)
            <div>
                <span>{{ __('Vendor') }}:</span>
                <a href="{{ $product->store->url }}">{{ $product->store->name }}</a>
            </div>
        @endif

        @if ($product->sku)
            <div>
                <span>{{ __('SKU') }}: </span>
                <span class="text-dark">{{ $product->sku }}</span>
            </div>
        @endif
        @if ($product->categories->count())
            <div>
                <span>{{ __('Categories') }}: </span>
                @foreach ($product->categories as $category)
                    <a href="{{ $category->url }}" class="text-dark">{!! BaseHelper::clean($category->name) !!}</a>
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </div>
        @endif
        @if ($product->tags->count())
            <div>
                <span>{{ __('Tags') }}: </span>
                @foreach ($product->tags as $tag)
                    <a href="{{ $tag->url }}" class="text-dark">{!! BaseHelper::clean($tag->name) !!}</a>
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>

<script>
    function changeStorePickUp(e) {
        if (e.type == 'radio') {
            if (e.id == 'delivery') {
                $('.store_location').hide();
                $('#delivery').val(1);
                $('#delivery').prop('checked', true);
                $('#store_pickup').val(0);
                $('#store_pickup').prop('checked', false);
                $('#pickup').val(1);
                $('#pickup').prop('checked', true);
            } else {
                $('.store_location').show();
                $('#store').val("");
                $('#delivery').val(0);
                $('#delivery').prop('checked', false);
                $('#store_pickup').val(1);
                $('#store_pickup').prop('checked', true);
            }
        } else {
            if ($(e).prop('checked') == true) {
                $(e).val(1);
            } else {
                $(e).val(0);
            }
            if (e.id == 'store_pickup') {
                if ($(e).prop('checked') == true) {
                    $('.store_location').show();
                } else {
                    $('.store_location').hide();
                }
            }
        }

        let selection = $("#delivery").prop('checked') || $("#store_pickup").prop('checked');
        if (selection == false) {
            $("#delivery").parent().css('color', 'red')
            $("#store_pickup").parent().css('color','red');
        } else {
            $("#delivery").parent().css('color', '#212529')
            $("#store_pickup").parent().css('color','#212529');
        }
    }

    function changePickUp() {
        if ($('#pickup').prop('checked') == true) {
            $('#pickup').val(1);
        } else {
            $('#pickup').val(0)
        }
    }

    function changeStore() {
        if ($('#store_id').val()) {
            $('#store_id').css('border-color', '#212529')
        }
    }

</script>


