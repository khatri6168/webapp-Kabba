<div class="shipment-info-panel hide-print">
    <div class="shipment-info-header">
        <div class="row">
            <div class="col-md-4 col-xs-4 col-4" style="display: flex; justify-content: center; flex-direction: column">
                <a target="_blank" href="{{ route('deliveries.edit', $delivery->id) }}">
                    <h5>{{ get_shipment_code($delivery->id) }}</h5>
                </a>
            </div>
            <div class="col-md-4 col-xs-4 col-4">
                @if ($delivery->customer_delivery == CUSTOMER_DELIVERY)
                    @if ($delivery->delivery_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::PENDING)
                        <img width='50' src='/vendor/core/plugins/ecommerce/images/store_pending.svg' alt='icon'>
                    @else
                        <img width='50' src='/vendor/core/plugins/ecommerce/images/store_success.svg' alt='icon'>
                    @endif
                @else
                    @if ($delivery->delivery_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::PENDING)
                        <img width='50' src='/vendor/core/plugins/ecommerce/images/delivery_pending.svg' alt='icon'>
                    @else
                        <img width='50' src='/vendor/core/plugins/ecommerce/images/delivery_success.svg' alt='icon'>
                    @endif
                @endif
            </div>
            <div class="col-md-4 col-xs-4 col-4">
                @if ($delivery->customer_pickup == CUSTOMER_PICKUP) {
                    @if ($delivery->pickup_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::PENDING)
                        <img width='50' src='/vendor/core/plugins/ecommerce/images/store_pending.svg' alt='icon'>
                    @else
                        <img width='50' src='/vendor/core/plugins/ecommerce/images/store_success.svg' alt='icon'>
                    @endif
                @else
                    @if ($delivery->pickup_status == \Botble\Ecommerce\Enums\DeliveryStatusEnum::PENDING)
                        <img width='50' src='/vendor/core/plugins/ecommerce/images/delivery_pending.svg' alt='icon'>
                    @else
                        <img width='50' src='/vendor/core/plugins/ecommerce/images/delivery_success.svg' alt='icon'>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
