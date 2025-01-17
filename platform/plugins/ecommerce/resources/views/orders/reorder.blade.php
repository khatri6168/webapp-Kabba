@extends(BaseHelper::getAdminMasterLayoutTemplate())
@section('content')
    <div class="max-width-1200" id="main-order">
        <create-order
            :products="{{ json_encode($products) }}"
            :product_ids="{{ json_encode($productIds) }}"
            @if ($customer)
                :customer="{{ $customer }}"
            @endif
            :customer_id="{{ $order->user_id }}"
            :customer_addresses="{{ json_encode($customerAddresses) }}"
            :customer_address="{{ $customerAddress->toJson() }}"
            :sub_amount="{{ $order->amount }}"
            :total_amount="{{ is_plugin_active('payment') && $order->payment->amount ? $order->payment->amount : $order->amount }}"
            :discount_amount="{{ $order->discount_amount }}"
            @if ($order->coupon_code) :coupon_code="'{{ $order->coupon_code }}'" @endif
            @if ($order->discount_description) :discount_description="'{{ $order->discount_description }}'" @endif
            :shipping_amount="{{ $order->shipping_amount }}"
            @if ($order->shipping_method)
                :shipping_method="'{{ $order->shipping_method }}'"
            @endif
            @if ($order->shipping_option)
                :shipping_option="'{{ $order->shipping_option }}'"
            @endif
            @if ($order->shipping_method)
                :shipping_method_name="'{{ OrderHelper::getShippingMethod($order->shipping_method, $order->shipping_option) }}'"
            @endif
            :is_selected_shipping="true"
            :customer_order_numbers="{{ $customerOrderNumbers }}"
            :currency="'{{ get_application_currency()->symbol }}'"
            :zip_code_enabled="{{ (int)EcommerceHelper::isZipCodeEnabled() }}"
            :use_location_data="{{ (int)EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation() }}"
            :sub_amount_label="'{{ format_price(0) }}'"
            :tax_amount_label="'{{ format_price(0) }}'"
            :promotion_amount_label="'{{ format_price(0) }}'"
            :discount_amount_label="'{{ format_price(0) }}'"
            :shipping_amount_label="'{{ format_price(0) }}'"
            :total_amount_label="'{{ format_price(0) }}'"
            :is_custom_reorder="{{ $order->authorize_customer_id != null ? 'true' : 'false' }}"
            :old_order_id="{{ $order->id }}"
        ></create-order>
    </div>
@stop

@push('header')
    <script>
        'use strict';

        window.trans = window.trans || {};

        window.trans.order = JSON.parse('{!! addslashes(json_encode(trans('plugins/ecommerce::order'))) !!}');
    </script>
@endpush
