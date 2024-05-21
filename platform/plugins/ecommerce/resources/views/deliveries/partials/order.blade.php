<ul class="nav nav-tabs" id="orderTab" role="tablist" style="margin-bottom: 0px;">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="order-tab" data-bs-toggle="tab" data-bs-target="#order-tab-pane" type="button" role="tab" aria-controls="order-tab-pane" aria-selected="true">{{ trans('plugins/ecommerce::order.order_info') }}</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="machine-tab" data-bs-toggle="tab" data-bs-target="#machine-tab-pane" type="button" role="tab" aria-controls="machine-tab-pane" aria-selected="false">{{ trans('plugins/ecommerce::order.machine_hours') }}</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="images-tab" data-bs-toggle="tab" data-bs-target="#images-tab-pane" type="button" role="tab" aria-controls="images-tab-pane" aria-selected="false">{{ trans('plugins/ecommerce::order.images') }}</button>
    </li>
</ul>
<div class="tab-content" id="tabContent">
    <div class="tab-pane fade show active" id="order-tab-pane" role="tabpanel" aria-labelledby="order-tab" tabindex="0">
        <div class="wrapper-content">
            <div class="pd-all-20">
                <div class="flexbox-grid-default">
                    <div class="flexbox-auto-right mr5">
                        <label class="title-product-main text-no-bold">{{ trans('plugins/ecommerce::order.order_information') }} {{ $order->code }}</label>
                        <label class="flexbox-auto-left float-end">
                            <a target="_blank" href="/admin/orders/login-customer/{{$order->user->id}}" class="btn btn-sm">
                                <i class="fa fa-sign-in"></i>  Login
                            </a>
                        </label>
                    </div>
                </div>
                <div class="mt20">
                    @if ($order->completed_at)
                        <svg class="svg-next-icon svg-next-icon-size-16 next-icon--right-spacing-quartered text-info" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24">
                            <g><path d="M20.2 1H3.9C2.3 1 1 2.3 1 3.9v16.9C1 22 2.1 23 3.4 23h17.3c1.3 0 2.3-1 2.3-2.3V3.9C23 2.3 21.8 1 20.2 1zM20 4v11h-2.2c-1.3 0-2.8 1.5-2.8 2.8v1c0 .3.2.2-.1.2H8.2c-.3 0-.2.1-.2-.2v-1C8 16.5 6.7 15 5.3 15H4V4h16zM10.8 14.7c.2.2.6.2.8 0l7.1-6.9c.3-.3.3-.6 0-.8l-.8-.8c-.2-.2-.6-.2-.8 0l-5.9 5.7-2.4-2.3c-.2-.2-.6-.2-.8 0l-.8.8c-.2.2-.2.6 0 .8l3.6 3.5z"></path></g>
                        </svg>
                        <strong class="ml5 text-info">{{ trans('plugins/ecommerce::order.completed') }}</strong>
                    @else
                        <svg class="svg-next-icon svg-next-icon-size-16 text-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" enable-background="new 0 0 16 16">
                            <g><path d="M13.9130435,0 L2.08695652,0 C0.936347826,0 0,0.936347826 0,2.08695652 L0,14.2608696 C0,15.2194783 0.780521739,16 1.73913043,16 L14.2608696,16 C15.2194783,16 16,15.2194783 16,14.2608696 L16,2.08695652 C16,0.936347826 15.0636522,0 13.9130435,0 L13.9130435,0 Z M13.9130435,2.08695652 L13.9130435,10.4347826 L12.173913,10.4347826 C11.2153043,10.4347826 10.4347826,11.2153043 10.4347826,12.173913 L10.4347826,12.8695652 C10.4347826,13.0615652 10.2789565,13.2173913 10.0869565,13.2173913 L5.2173913,13.2173913 C5.0253913,13.2173913 4.86956522,13.0615652 4.86956522,12.8695652 L4.86956522,12.173913 C4.86956522,11.2153043 4.08904348,10.4347826 3.13043478,10.4347826 L2.08695652,10.4347826 L2.08695652,2.08695652 L13.9130435,2.08695652 L13.9130435,2.08695652 Z"></path></g>
                        </svg>
                        <strong class="ml5 text-warning">{{ trans('plugins/ecommerce::order.uncompleted') }}</strong>
                    @endif
                </div>
            </div>
            <div class="pd-all-20 p-none-t border-top-title-main">
                <div class="table-wrap">
                    @foreach ($order->products as $orderProduct)
                        @php
                            //echo '<pre>';
                               // print_r($orderProduct->options);
                               // echo '</pre>';
                                $product = $orderProduct->product->original_product;
                        @endphp
                        <div class="row">
                            <div class="offset-md-1 col-md-6 col-sm-12 mt-3">
                                <div style="display:flex; justify-content: space-between;">
                                    <div class="width-60-px min-width-60-px vertical-align-t">
                                        <div class="wrap-img">
                                            <img class="thumb-image thumb-image-cartorderlist" src="{{ RvMedia::getImageUrl($orderProduct->product_image, 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $orderProduct->product_name }}">
                                        </div>
                                    </div>
                                    <div class="pl5 p-r5 min-width-200-px" style="width: 100%">
                                        <a class="text-underline hover-underline pre-line" target="_blank" href="{{ $product && $product->id && Auth::user()->hasPermission('products.edit') ? route('products.edit', $product->id) : '#' }}" title="{{ $orderProduct->product_name }}">
                                            {{ $orderProduct->product_name }}
                                        </a>
                                        &nbsp;
                                        @if(isset($orderProduct->options['deldate']))
                                            <p>Schedule Date: {{$orderProduct->options['deldate']}}</p>
                                        @endif
                                        @if ($sku = Arr::get($orderProduct->options, 'sku'))
                                            ({{ trans('plugins/ecommerce::order.sku') }}:
                                            <strong>{{ $sku }}</strong>)
                                        @endif

                                        @if ($attributes = Arr::get($orderProduct->options, 'attributes'))
                                            <p class="mb-0">
                                                <small>{{ $attributes }}</small>
                                            </p>
                                        @endif

                                        @if (! empty($orderProduct->product_options) && is_array($orderProduct->product_options))
                                            {!! render_product_options_html($orderProduct->product_options, $orderProduct->price) !!}
                                        @endif

                                        @include('plugins/ecommerce::themes.includes.cart-item-options-extras', ['options' => $orderProduct->options])

                                        {!! apply_filters(ECOMMERCE_ORDER_DETAIL_EXTRA_HTML, null) !!}
                                        @if ($order->shipment->id)
                                            <ul class="unstyled">
                                                <li class="simple-note">
                                                    <a>
                                                        <span>{{ $orderProduct->qty }}</span>
                                                        <span class="text-lowercase"> {{ trans('plugins/ecommerce::order.completed') }}</span>
                                                    </a>
                                                    <ul class="dom-switch-target line-item-properties small">
                                                        <li class="ws-nm">
                                                            <span class="bull">↳</span>
                                                            <span class="black">{{ trans('plugins/ecommerce::order.shipping') }} </span>
                                                            <a class="text-underline bold-light" target="_blank" title="{{ $order->shipping_method_name }}" href="{{ route('ecommerce.shipments.edit', $order->shipment->id) }}">{{ $order->shipping_method_name }}</a>
                                                        </li>

                                                        @if (is_plugin_active('marketplace') && $order->store->name)
                                                            <li class="ws-nm">
                                                                <span class="bull">↳</span>
                                                                <span class="black">{{ trans('plugins/marketplace::store.store') }}</span>
                                                                <a href="{{ $order->store->url }}" class="bold-light" target="_blank">{{ $order->store->name }}</a>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12" style="display: flex; flex-direction: column; justify-content: center;">
                                <div style="display: flex; flex-direction: row; justify-content: right;">
                                    <div style="display: flex; flex-direction: row; justify-content: center; width: 100%" >
                                        <div class="pl5 p-r5 text-end">
                                            <div class="inline_block">
                                                <span>{{ format_price($orderProduct->price) }}</span>
                                            </div>
                                        </div>
                                        <div class="pl5 p-r5 text-center">x</div>
                                        <div class="pl5 p-r5">
                                            <span>{{ $orderProduct->qty }}</span>
                                        </div>
                                    </div>
                                    <div class="pl5 text-end">{{ format_price($orderProduct->price * $orderProduct->qty) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="pd-all-20 p-none-t">
                <div class="row">
                    <div class="offset-md-6 col-md-5">
                        <div class="table-wrap">
                            <table class="table-normal table-none-border table-color-gray-text">
                                <tbody>
                                <tr>
                                    <td class="text-end color-subtext">{{ trans('plugins/ecommerce::order.sub_amount') }}</td>
                                    <td class="text-end pl10">
                                        <span>{{ format_price($order->sub_total) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end color-subtext mt10">
                                        <p class="mb0">{{ trans('plugins/ecommerce::order.discount') }}</p>
                                        @if ($order->coupon_code)
                                            <p class="mb0">{!! trans('plugins/ecommerce::order.coupon_code', ['code' => Html::tag('strong', $order->coupon_code)->toHtml()])  !!}</p>
                                        @elseif ($order->discount_description)
                                            <p class="mb0">{{ $order->discount_description }}</p>
                                        @endif
                                    </td>
                                    <td class="text-end p-none-b pl10">
                                        <p class="mb0">{{ format_price($order->discount_amount) }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end color-subtext mt10">
                                        <p class="mb0">{{ trans('plugins/ecommerce::order.shipping_fee') }}</p>
                                        <p class="mb0 font-size-12px">{{ $order->shipping_method_name }}</p>
                                        <p class="mb0 font-size-12px">{{ $order->products_weight }} {{ ecommerce_weight_unit(true) }}</p>
                                    </td>
                                    <td class="text-end p-none-t pl10">
                                        <p class="mb0">{{ format_price($order->shipping_amount) }}</p>
                                    </td>
                                </tr>
                                @if (EcommerceHelper::isTaxEnabled())
                                    <tr>
                                        <td class="text-end color-subtext mt10">
                                            <p class="mb0">{{ trans('plugins/ecommerce::order.tax') }}</p>
                                        </td>
                                        <td class="text-end p-none-t pl10">
                                            <p class="mb0">{{ format_price($order->tax_amount) }}</p>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-end mt10">
                                        <p class="mb0 color-subtext">{{ trans('plugins/ecommerce::order.total_amount') }}</p>
                                        @if (is_plugin_active('payment') && $order->payment->id)
                                            <p class="mb0  font-size-12px"><a href="{{ route('payment.show', $order->payment->id) }}" target="_blank">{{ $order->payment->payment_channel->label() }}</a>
                                            </p>
                                        @endif
                                    </td>
                                    <td class="text-end text-no-bold p-none-t pl10">
                                        @if (is_plugin_active('payment') && $order->payment->id)
                                            <a href="{{ route('payment.show', $order->payment->id) }}" target="_blank">
                                                <span>{{ format_price($order->amount) }}</span>
                                            </a>
                                        @else
                                            <span>{{ format_price($order->amount) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border-bottom"></td>
                                    <td class="border-bottom"></td>
                                </tr>
                                <tr>
                                    <td class="text-end color-subtext">{{ trans('plugins/ecommerce::order.paid_amount') }}</td>
                                    <td class="text-end color-subtext pl10">
                                        @if (is_plugin_active('payment') && $order->payment->id)
                                            <a href="{{ route('payment.show', $order->payment->id) }}" target="_blank">
                                                <span>{{ format_price($order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::COMPLETED ? $order->payment->amount : 0) }}</span>
                                            </a>
                                        @else
                                            <span>{{ format_price(is_plugin_active('payment') && $order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::COMPLETED ? $order->payment->amount : 0) }}</span>
                                        @endif
                                    </td>
                                </tr>

                                @if(isset($order->products[0]->store_id))
                                    <tr>
                                        <td class="text-end color-subtext">{{ trans('plugins/ecommerce::order.store_selcted') }} {{$order->products[0]->store->name}}</td>
                                    </tr>
                                @endif
                                @if (is_plugin_active('payment') && $order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::REFUNDED)
                                    <tr class="hidden">
                                        <td class="text-end color-subtext">{{ trans('plugins/ecommerce::order.refunded_amount') }}</td>
                                        <td class="text-end pl10">
                                            <span>{{ format_price($order->payment->amount) }}</span>
                                        </td>
                                    </tr>
                                @endif
                                <tr class="hidden">
                                    <td class="text-end color-subtext">{{ trans('plugins/ecommerce::order.amount_received') }}</td>
                                    <td class="text-end pl10">
                                        <span>{{ format_price(is_plugin_active('payment') && $order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::COMPLETED ? $order->amount : 0) }}</span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <br>
                        @if ($order->isInvoiceAvailable())
                            <div class="text-end">
                                <a href="{{ route('orders.generate-invoice', $order->id) }}?type=print" class="btn btn-primary me-2" target="_blank">
                                    <i class="fa fa-print"></i> {{ trans('plugins/ecommerce::order.print_invoice') }}
                                </a>
                                <a href="{{ route('orders.generate-invoice', $order->id) }}" class="btn btn-info">
                                    <i class="fa fa-download"></i> {{ trans('plugins/ecommerce::order.download_invoice') }}
                                </a>
                            </div>
                        @endif

                        @if(!empty($order))
                            <div class="py-3">
                                <form action="{{ route('orders.edit', $order->id) }}">
                                    <label class="text-title-field">{{ trans('plugins/ecommerce::deliveries.order_note') }}</label>
                                    <textarea class="ui-text-area textarea-auto-height" name="description" rows="3" placeholder="{{ trans('plugins/ecommerce::order.add_note') }}">{{ $order->description }}</textarea>
                                    <div class="mt10">
                                        <button type="button" class="btn btn-primary btn-update-order">{{ trans('plugins/ecommerce::order.save') }}</button>
                                    </div>
                                </form>
                            </div>
                        @endif

                        @if(!empty($delivery))
                            <div class="py-3">
                                <form action="{{ route('deliveries.update-comment', $delivery->id) }}">
                                    <label class="text-title-field">{{ trans('plugins/ecommerce::deliveries.delivery_note') }}</label>
                                    <textarea class="ui-text-area textarea-auto-height" name="comment" rows="3" placeholder="{{ trans('plugins/ecommerce::order.add_note') }}">{{ $delivery->comment }}</textarea>
                                    <div class="mt10">
                                        <button type="button" class="btn btn-primary btn-update-order">{{ trans('plugins/ecommerce::order.save') }}</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if ($order->status != \Botble\Ecommerce\Enums\OrderStatusEnum::CANCELED || $order->is_confirmed)
                <div class="pd-all-20 border-top-title-main">
                    <div class="row">
                        <div class="offset-md-1 col-md-10" style="display: flex">
                            <div class="flexbox-auto-left">
                                <svg class="svg-next-icon svg-next-icon-size-20 @if ($order->is_confirmed) svg-next-icon-green @else svg-next-icon-gray @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M7 18c-.265 0-.52-.105-.707-.293l-6-6c-.39-.39-.39-1.023 0-1.414s1.023-.39 1.414 0l5.236 5.236L18.24 2.35c.36-.42.992-.468 1.41-.11.42.36.47.99.11 1.41l-12 14c-.182.212-.444.338-.722.35H7z"></path>
                                </svg>
                            </div>
                            <div class="flexbox-auto-right ml15 mr15 text-upper">
                                @if ($order->is_confirmed)
                                    <span>{{ trans('plugins/ecommerce::order.order_was_confirmed') }}</span>
                                @else
                                    <span>{{ trans('plugins/ecommerce::order.confirm_order') }}</span>
                                @endif
                            </div>
                            @if (!$order->is_confirmed)
                                <div class="flexbox-auto-left">
                                    <script>
                                        $(document).ready(function(){
                                            $(".image-data").change(function(){
                                                let imgval = $(".image-data").val();
                                                console.log('imgval',imgval);
                                            })
                                        })
                                    </script>
                                    <form action="{{ route('orders.confirm') }}">
                                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                                        <input type="hidden" name="license_image" class="license_image" value="" />
                                        <button class="btn btn-primary btn-confirm-order">{{ trans('plugins/ecommerce::order.confirm') }}</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            <div class="pd-all-20 border-top-title-main">
                <div class="row">
                    <div class="offset-md-1 col-md-10" style="display: flex">
                        <div class="flexbox-auto-left">
                            <svg class="svg-next-icon svg-next-icon-size-20 @if (isset($order->terms_signed) && $order->terms_signed == 1) svg-next-icon-green @else svg-next-icon-gray @endif" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M7 18c-.265 0-.52-.105-.707-.293l-6-6c-.39-.39-.39-1.023 0-1.414s1.023-.39 1.414 0l5.236 5.236L18.24 2.35c.36-.42.992-.468 1.41-.11.42.36.47.99.11 1.41l-12 14c-.182.212-.444.338-.722.35H7z"></path>
                            </svg>
                        </div>
                        <div class="flexbox-auto-right ml15 mr15 text-upper">
                            Terms
                        </div>
                        <div class="flexbox-auto-left">
                            @if ($order->terms_signed != 1)
                                <a href="/checkout/{{$order->token}}/sign-terms/?admin=true" target="_blank" class="btn btn-warning"><span class="">Pending</span></a>
                            @else
                                <a href="/checkout/{{$order->token}}/sign-terms/?admin=true" target="_blank" class="btn btn-info"><span class="">Accepted</span></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="pd-all-20 border-top-title-main">
                <div class="row">
                    <div class="offset-md-1 col-md-10" style="display: flex">
                        @if ($order->status == \Botble\Ecommerce\Enums\OrderStatusEnum::CANCELED)
                            <div class="flexbox-auto-left">
                                <svg class="svg-next-icon svg-next-icon-size-24 svg-next-icon-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24">
                                    <path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.6 0 12 0zm0 4c1.4 0 2.7.4 3.9 1L12 8.8 8.8 12 5 15.9c-.6-1.1-1-2.5-1-3.9 0-4.4 3.6-8 8-8zm0 16c-1.4 0-2.7-.4-3.9-1l3.9-3.9 3.2-3.2L19 8.1c.6 1.1 1 2.5 1 3.9 0 4.4-3.6 8-8 8z"></path>
                                </svg>
                            </div>
                            <div class="flexbox-auto-content ml15 mr15 text-upper">
                                <span>{{ trans('plugins/ecommerce::order.order_was_canceled') }}</span>
                            </div>
                        @elseif (is_plugin_active('payment') && $order->payment->id)
                            <div class="flexbox-auto-left">
                                @if (!$order->payment->status || $order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::PENDING)
                                    <svg class="svg-next-icon svg-next-icon-size-24 svg-next-icon-gray" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24">
                                        <g><path d="M23.6 10H.4c-.2 0-.4.5-.4.7v7.7c0 .7.6 1.6 1.3 1.6h21.4c.7 0 1.3-.9 1.3-1.6v-7.7c0-.2-.2-.7-.4-.7zM20 16.6c0 .2-.2.4-.4.4h-4.1c-.2 0-.4-.2-.4-.4v-2.1c0-.2.2-.4.4-.4h4.1c.2 0 .4.2.4.4v2.1zM22.7 4H1.3C.6 4 0 4.9 0 5.6v1.7c0 .2.2.7.4.7h23.1c.3 0 .5-.5.5-.7V5.6c0-.7-.6-1.6-1.3-1.6z"></path></g>
                                    </svg>
                                @elseif ($order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::COMPLETED || $order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::PENDING)
                                    <svg class="svg-next-icon svg-next-icon-size-20 svg-next-icon-green" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path d="M7 18c-.265 0-.52-.105-.707-.293l-6-6c-.39-.39-.39-1.023 0-1.414s1.023-.39 1.414 0l5.236 5.236L18.24 2.35c.36-.42.992-.468 1.41-.11.42.36.47.99.11 1.41l-12 14c-.182.212-.444.338-.722.35H7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="flexbox-auto-content ml15 mr15 text-upper">
                                @if (!$order->payment->status || $order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::PENDING)
                                    <span>{{ trans('plugins/ecommerce::order.pending_payment') }}</span>
                                @elseif ($order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::COMPLETED)
                                    <span>{{ trans('plugins/ecommerce::order.payment_was_accepted', ['money' => format_price($order->payment->amount - $order->payment->refunded_amount)]) }}</span>
                                @elseif ($order->payment->amount - $order->payment->refunded_amount == 0)
                                    <span>{{ trans('plugins/ecommerce::order.payment_was_refunded') }}</span>
                                @endif
                            </div>
                            @if (!$order->payment->status || in_array($order->payment->status, [\Botble\Payment\Enums\PaymentStatusEnum::PENDING]))
                                <div class="">
                                    <button class="btn btn-primary btn-trigger-confirm-payment" data-target="{{ route('orders.confirm-payment', $order->id) }}">{{ trans('plugins/ecommerce::order.confirm_payment') }}</button>
                                    <a href="{{ route('orders.reorder', ['order_id' => $order->id]) }}" class="btn btn-info">{{ trans('plugins/ecommerce::order.reorder') }}</a>&nbsp;
                                    @if ($order->canBeCanceledByAdmin())
                                        <a href="#" class="btn btn-secondary btn-trigger-cancel-order" data-target="{{ route('orders.cancel', $order->id) }}">{{ trans('plugins/ecommerce::order.cancel') }}</a>
                                    @endif

                                </div>
                            @endif
                            @if ($order->payment->status == \Botble\Payment\Enums\PaymentStatusEnum::COMPLETED && (($order->payment->amount - $order->payment->refunded_amount > 0) || ($order->products->sum('qty') - $order->products->sum('restock_quantity') > 0)))
                                <div class="">
                                    <button class="btn btn-secondary ml10 btn-trigger-refund">{{ trans('plugins/ecommerce::order.refund') }}</button>
                                    <a href="{{ route('orders.reorder', ['order_id' => $order->id]) }}" class="btn btn-info">{{ trans('plugins/ecommerce::order.reorder') }}</a>&nbsp;
                                    @if ($order->canBeCanceledByAdmin())
                                        <a href="#" class="btn btn-secondary btn-trigger-cancel-order" data-target="{{ route('orders.cancel', $order->id) }}">{{ trans('plugins/ecommerce::order.cancel') }}</a>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="machine-tab-pane" role="tabpanel" aria-labelledby="machine-tab" tabindex="0">
        <div class="wrapper-content">
            <div class="pd-all-20">
                <div class="flexbox-grid-default">
                    <div class="flexbox-auto-right mr5">
                        <label class="title-product-main text-no-bold">{{ trans('plugins/ecommerce::order.order_information') }} {{ $order->code }}</label>
                    </div>
                </div>
                <div class="mt20">
                    @if ($order->completed_at)
                        <svg class="svg-next-icon svg-next-icon-size-16 next-icon--right-spacing-quartered text-info" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24">
                            <g><path d="M20.2 1H3.9C2.3 1 1 2.3 1 3.9v16.9C1 22 2.1 23 3.4 23h17.3c1.3 0 2.3-1 2.3-2.3V3.9C23 2.3 21.8 1 20.2 1zM20 4v11h-2.2c-1.3 0-2.8 1.5-2.8 2.8v1c0 .3.2.2-.1.2H8.2c-.3 0-.2.1-.2-.2v-1C8 16.5 6.7 15 5.3 15H4V4h16zM10.8 14.7c.2.2.6.2.8 0l7.1-6.9c.3-.3.3-.6 0-.8l-.8-.8c-.2-.2-.6-.2-.8 0l-5.9 5.7-2.4-2.3c-.2-.2-.6-.2-.8 0l-.8.8c-.2.2-.2.6 0 .8l3.6 3.5z"></path></g>
                        </svg>
                        <strong class="ml5 text-info">{{ trans('plugins/ecommerce::order.completed') }}</strong>
                    @else
                        <svg class="svg-next-icon svg-next-icon-size-16 text-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" enable-background="new 0 0 16 16">
                            <g><path d="M13.9130435,0 L2.08695652,0 C0.936347826,0 0,0.936347826 0,2.08695652 L0,14.2608696 C0,15.2194783 0.780521739,16 1.73913043,16 L14.2608696,16 C15.2194783,16 16,15.2194783 16,14.2608696 L16,2.08695652 C16,0.936347826 15.0636522,0 13.9130435,0 L13.9130435,0 Z M13.9130435,2.08695652 L13.9130435,10.4347826 L12.173913,10.4347826 C11.2153043,10.4347826 10.4347826,11.2153043 10.4347826,12.173913 L10.4347826,12.8695652 C10.4347826,13.0615652 10.2789565,13.2173913 10.0869565,13.2173913 L5.2173913,13.2173913 C5.0253913,13.2173913 4.86956522,13.0615652 4.86956522,12.8695652 L4.86956522,12.173913 C4.86956522,11.2153043 4.08904348,10.4347826 3.13043478,10.4347826 L2.08695652,10.4347826 L2.08695652,2.08695652 L13.9130435,2.08695652 L13.9130435,2.08695652 Z"></path></g>
                        </svg>
                        <strong class="ml5 text-warning">{{ trans('plugins/ecommerce::order.uncompleted') }}</strong>
                    @endif
                </div>
            </div>
            <form action="{{ route('orders.edit', $order->id) }}">
                <div class="pd-all-20 p-none-t border-top-title-main">
                    <div class="table-wrap">
                        <input type="hidden" name="operation" value="machine_hours">

                        @foreach ($order->products as $key => $orderProduct)
                            @php
                                //echo '<pre>';
                                   // print_r($orderProduct->options);
                                   // echo '</pre>';
                                    $product = $orderProduct->product->original_product;
                            @endphp
                            <div class="row mt-3">
                                <div class="offset-md-1 col-md-6 col-sm-12">
                                    <div style="display: flex; flex-direction: row; justify-content: space-between">
                                        <div class="width-60-px min-width-60-px vertical-align-t">
                                            <div class="wrap-img">
                                                <img class="thumb-image thumb-image-cartorderlist" src="{{ RvMedia::getImageUrl($orderProduct->product_image, 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $orderProduct->product_name }}">
                                            </div>
                                        </div>
                                        <div class="pl5 p-r5 min-width-200-px" style="width: 100%">
                                            <a class="text-underline hover-underline pre-line" target="_blank" href="{{ $product && $product->id && Auth::user()->hasPermission('products.edit') ? route('products.edit', $product->id) : '#' }}" title="{{ $orderProduct->product_name }}">
                                                {{ $orderProduct->product_name }}
                                            </a>
                                            &nbsp;
                                            @if(isset($orderProduct->options['deldate']))
                                                <p>Schedule Date: {{$orderProduct->options['deldate']}}</p>
                                            @endif
                                            @if ($sku = Arr::get($orderProduct->options, 'sku'))
                                                ({{ trans('plugins/ecommerce::order.sku') }}:
                                                <strong>{{ $sku }}</strong>)
                                            @endif

                                            @if ($attributes = Arr::get($orderProduct->options, 'attributes'))
                                                <p class="mb-0">
                                                    <small>{{ $attributes }}</small>
                                                </p>
                                            @endif

                                            @if (! empty($orderProduct->product_options) && is_array($orderProduct->product_options))
                                                {!! render_product_options_html($orderProduct->product_options, $orderProduct->price) !!}
                                            @endif

                                            @include('plugins/ecommerce::themes.includes.cart-item-options-extras', ['options' => $orderProduct->options])

                                            {!! apply_filters(ECOMMERCE_ORDER_DETAIL_EXTRA_HTML, null) !!}
                                            @if ($order->shipment->id)
                                                <ul class="unstyled">
                                                    <li class="simple-note">
                                                        <a>
                                                            <span>{{ $orderProduct->qty }}</span>
                                                            <span class="text-lowercase"> {{ trans('plugins/ecommerce::order.completed') }}</span>
                                                        </a>
                                                        <ul class="dom-switch-target line-item-properties small">
                                                            <li class="ws-nm">
                                                                <span class="bull">↳</span>
                                                                <span class="black">{{ trans('plugins/ecommerce::order.shipping') }} </span>
                                                                <a class="text-underline bold-light" target="_blank" title="{{ $order->shipping_method_name }}" href="{{ route('ecommerce.shipments.edit', $order->shipment->id) }}">{{ $order->shipping_method_name }}</a>
                                                            </li>

                                                            @if (is_plugin_active('marketplace') && $order->store->name)
                                                                <li class="ws-nm">
                                                                    <span class="bull">↳</span>
                                                                    <span class="black">{{ trans('plugins/marketplace::store.store') }}</span>
                                                                    <a href="{{ $order->store->url }}" class="bold-light" target="_blank">{{ $order->store->name }}</a>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </li>
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-12">
                                    <td class="pl5 p-r5 text-end">
                                        @foreach ($order->machineHours as $orderMachineHour)
                                            @php
                                                if ($orderMachineHour->product_id == $orderProduct->product_id) {
                                                    $machineHour = $orderMachineHour;
                                                }
                                            @endphp
                                        @endforeach
                                        @if(!isset($machineHour))
                                            @php
                                                $machineHour = new \Botble\Ecommerce\Models\OrderMachineHour();
                                            @endphp
                                        @endif
                                        <input name="machineHour[{{$key}}][product_id]" value="{{$orderProduct->product_id}}" type="hidden">
                                        <input name="machineHour[{{$key}}][order_id]" value="{{$order->id}}" type="hidden">
                                        <input name="machineHour[{{$key}}][id]" value="{{$machineHour->id}}" type="hidden">
                                        <div style="display: flex; justify-content: right">
                                            <label for="start_hours">
                                                {{ trans('plugins/ecommerce::order.start_hours') }}
                                            </label>
                                            <input name="machineHour[{{$key}}][start]" value="{{$machineHour->start}}" type="text" class="numberic start">
                                        </div>
                                        <div style="display: flex; justify-content: right">
                                            <label for="allocated">
                                                {{ trans('plugins/ecommerce::order.hours_allocated') }}
                                            </label>
                                            <input name="machineHour[{{$key}}][allocated]" value="{{$machineHour->allocated}}" type="text" class="numberic allocated">
                                        </div>
                                        <div style="display: flex; justify-content: right">
                                            <label for="end_hours">
                                                {{ trans('plugins/ecommerce::order.end_hours') }}
                                            </label>
                                            <input name="machineHour[{{$key}}][end]" value="{{$machineHour->end}}" type="text" class="numberic end">
                                        </div>
                                        <div style="display: flex; justify-content: right">
                                            <label for="total">
                                                {{ trans('plugins/ecommerce::order.total_hours') }}
                                            </label>
                                            <input name="machineHour[{{$key}}][total]" value="{{$machineHour->total}}" type="text" class="numberic total">
                                        </div>
                                        <div style="display: flex; justify-content: right">
                                            <label for="prorated">
                                                {{ trans('plugins/ecommerce::order.over_hour') }}
                                            </label>
                                            <input name="machineHour[{{$key}}][over]" value="{{$machineHour->over}}" type="text" class="numberic over">
                                        </div>
                                        <div style="display: flex; justify-content: right">
                                            <label for="prorated_hourly_fee">
                                                {{ trans('plugins/ecommerce::order.prorated_hourly_fee') }}
                                            </label>
                                            <span class="currency">$<input name="machineHour[{{$key}}][over_rate]" value="{{$machineHour->over_rate}}" type="text" class="more-numberic over-rate"></span>
                                        </div>
                                        <div style="display: flex; justify-content: right">
                                            <label for="total_cost-cost">
                                                {{ trans('plugins/ecommerce::order.total_charge') }}
                                            </label>
                                            <span class="currency">$<input name="machineHour[{{$key}}][total_cost]" value="{{$machineHour->total_cost}}" type="text" class="more-numberic total-charge"></span>
                                        </div>
                                    </td>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="pd-all-20 p-none-t">
                    <div class="flexbox-grid-default block-rps-768">
                        <div class="flexbox-auto-right p-r5">
                        </div>
                        <div class="flexbox-auto-right pl5">
                            <div class="py-3">
                                <div class="mt10">
                                    <button type="button" class="btn btn-primary btn-update-order">{{ trans('plugins/ecommerce::order.save') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="tab-pane fade" id="images-tab-pane" role="tabpanel" aria-labelledby="images-tab" tabindex="0">
        <div class="wrapper-content">
            <div class="pd-all-20">
                <div class="flexbox-grid-default">
                    <div class="flexbox-auto-right mr5">
                        <label class="title-product-main text-no-bold">{{ trans('plugins/ecommerce::order.order_information') }} {{ $order->code }}</label>
                    </div>
                </div>
                <div class="mt20">
                    @if ($order->completed_at)
                        <svg class="svg-next-icon svg-next-icon-size-16 next-icon--right-spacing-quartered text-info" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" enable-background="new 0 0 24 24">
                            <g><path d="M20.2 1H3.9C2.3 1 1 2.3 1 3.9v16.9C1 22 2.1 23 3.4 23h17.3c1.3 0 2.3-1 2.3-2.3V3.9C23 2.3 21.8 1 20.2 1zM20 4v11h-2.2c-1.3 0-2.8 1.5-2.8 2.8v1c0 .3.2.2-.1.2H8.2c-.3 0-.2.1-.2-.2v-1C8 16.5 6.7 15 5.3 15H4V4h16zM10.8 14.7c.2.2.6.2.8 0l7.1-6.9c.3-.3.3-.6 0-.8l-.8-.8c-.2-.2-.6-.2-.8 0l-5.9 5.7-2.4-2.3c-.2-.2-.6-.2-.8 0l-.8.8c-.2.2-.2.6 0 .8l3.6 3.5z"></path></g>
                        </svg>
                        <strong class="ml5 text-info">{{ trans('plugins/ecommerce::order.completed') }}</strong>
                    @else
                        <svg class="svg-next-icon svg-next-icon-size-16 text-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" enable-background="new 0 0 16 16">
                            <g><path d="M13.9130435,0 L2.08695652,0 C0.936347826,0 0,0.936347826 0,2.08695652 L0,14.2608696 C0,15.2194783 0.780521739,16 1.73913043,16 L14.2608696,16 C15.2194783,16 16,15.2194783 16,14.2608696 L16,2.08695652 C16,0.936347826 15.0636522,0 13.9130435,0 L13.9130435,0 Z M13.9130435,2.08695652 L13.9130435,10.4347826 L12.173913,10.4347826 C11.2153043,10.4347826 10.4347826,11.2153043 10.4347826,12.173913 L10.4347826,12.8695652 C10.4347826,13.0615652 10.2789565,13.2173913 10.0869565,13.2173913 L5.2173913,13.2173913 C5.0253913,13.2173913 4.86956522,13.0615652 4.86956522,12.8695652 L4.86956522,12.173913 C4.86956522,11.2153043 4.08904348,10.4347826 3.13043478,10.4347826 L2.08695652,10.4347826 L2.08695652,2.08695652 L13.9130435,2.08695652 L13.9130435,2.08695652 Z"></path></g>
                        </svg>
                        <strong class="ml5 text-warning">{{ trans('plugins/ecommerce::order.uncompleted') }}</strong>
                    @endif
                </div>
            </div>
            <form action="{{ route('orders.edit', $order->id) }}">
                <div class="pd-all-20 p-none-t border-top-title-main">
                    <div class="table-wrap">
                        <input type="hidden" name="operation" value="machine_hours">
                        @foreach ($order->products as $key => $orderProduct)
                            @php
                                //echo '<pre>';
                                   // print_r($orderProduct->options);
                                   // echo '</pre>';
                                    $product = $orderProduct->product->original_product;
                            @endphp

                            <div class="row mt-3">
                                <div class="col-md-6 col-sm-12">
                                    <div class="">
                                        <img class="" src="{{ RvMedia::getImageUrl($orderProduct->product_image, 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $orderProduct->product_name }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div style="margin-bottom:20px;">
                            @if($order->images)
                                <input type="hidden" name="all_img" class="all_img" value="{{$order->images}}" />
                                @php
                                    $images = json_decode($order->images);
                                    $i = 1;
                                @endphp
                                <div class="images_wrap row">
                                    @foreach($images as $img)
                                        <div class="actionImage{{$i}} actionImage col-md-4">
                                            <img class="img{{$i}}" src="{{url('/')}}/storage/{{$img}}" style="width:300px;max-width: calc(100% + 16px); padding-right:20px; cursor:pointer;" />
                                            <a href="{{url('/')}}/storage/{{$img}}" target="__blank"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                            <span class="deleteimg" data-id="{{$i}}" onclick="deleteImage({{$i}})" ><i class="fa fa-trash" aria-hidden="true"></i></span>
                                        </div>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </div>
                                <div style="clear:both"></div>
                            @endif
                        </div>
                        <x-core-setting::form-group>
                            <label class="text-title-field" for="admin-login-screen-backgrounds">Click to upload images</label>
                            {!! Form::mediaImages('login_screen_backgrounds[]', is_array(setting('login_screen_backgrounds', '')) ? setting('login_screen_backgrounds', '') : json_decode(setting('login_screen_backgrounds', ''), true)) !!}

                        </x-core-setting::form-group>
                        <div class="mt10" style="text-align: right;">
                            <button type="button" class="btn btn-primary btn-update-image">Save</button>
                            <div class="success_image" style="display:none;color:green;">License uploaded successfully.</div>
                            <div class="loader" style="display:none;"><img src="{{ url('/') }}/loader.gif" style="width:50px;" /></div>
                        </div>
                        <style>
                            .actionImage {
                                text-align:center;
                                float:left;
                                /* position:absolute;
                                margin-top:-100px;
                                text-align:center; */
                            }
                            .actionImage a{
                                padding-right:20px;
                            }
                            /* .actionLisense:nth-of-type(2) {
                                margin-left:185px;
                            } */
                        </style>
                        <script>
                            function deleteImage(id){

                                var selectedimg = $('.img'+id).attr('src');
                                var value = selectedimg.split("/");
                                if(typeof value[5] == 'undefined'){
                                    var deletedimg = value[4]
                                }else{
                                    var deletedimg = value[4]+'/'+value[5];
                                }

                                //console.log('deletedimg',deletedimg);
                                //return false;
                                var allimages = JSON.parse($('.all_img').val());
                                var remainingarray = allimages.filter(function(item) {
                                    return item !== deletedimg
                                })
                                $('.all_img').val(JSON.stringify(remainingarray))
                                let orderid = $("input[name=order_id]").val();
                                let data = {}
                                data['orderid'] = orderid;
                                data['img'] = $('.all_img').val();
                                $('.actionImage'+id).hide();
                                //console.log(data);
                                //return false;

                                let url = "{{ route('orders.updateImage') }}"
                                $.ajax({
                                    type: "post",
                                    url: url,
                                    data: data,
                                    beforeSend: function(){
                                        // Show image container
                                        //$('div.loader').show();
                                    },
                                    success: function (response) {
                                        console.log(response);

                                    },
                                    complete:function(data){
                                        $(".sucess_license").show();
                                    }
                                })

                            }
                            $(document).ready(function() {
                                var imgArray = new Array();
                                $('.btn-update-image').click(function(){
                                    if ($('.all_img').val()) {
                                        var all_img = JSON.parse($('.all_img').val());
                                        $('.image-data').each(function(){
                                            imgArray.push($(this).val());

                                        });
                                        var allimg = imgArray.concat(all_img);
                                    } else {
                                        $('.image-data').each(function(){
                                            imgArray.push($(this).val());

                                        });
                                        var allimg = imgArray
                                    }

                                    let orderid = $("input[name=order_id]").val();

                                    let data = {}
                                    data['orderid'] = orderid;
                                    data['img'] = JSON.stringify(allimg);

                                    let url = "{{ route('orders.updateImage') }}"
                                    $.ajax({
                                        type: "post",
                                        url: url,
                                        data: data,
                                        beforeSend: function(){
                                            // Show image container
                                            $('div.loader', $('.btn-update-image').parent()).show();
                                        },
                                        success: function (response) {
                                            console.log(response);
                                        },
                                        complete:function(data){
                                            // Hide image container
                                            $('div.loader', $('.btn-update-image').parent()).hide();
                                            setTimeout(() => {
                                                window.location.reload(true);
                                            }, 2000);
                                        }
                                    })
                                })

                                $(document).on('click', '.btn-trigger-update-billing-address', event => {
                                    event.preventDefault()
                                    $('#update-billing-address-modal').modal('show')

                                    $(document).on('click', '#confirm-update-billing-address-button', event => {
                                        event.preventDefault()
                                        let _self = $(event.currentTarget)

                                        _self.addClass('button-loading')

                                        $.ajax({
                                            type: 'POST',
                                            cache: false,
                                            url: _self.closest('.modal-content').find('form').prop('action'),
                                            data: _self.closest('.modal-content').find('form').serialize(),
                                            success: res => {
                                                if (!res.error) {
                                                    Botble.showSuccess(res.message)
                                                    $('#update-billing-address-modal').modal('hide')
                                                    window.location.reload(true);

                                                    let $formBody = $('.shipment-create-wrap')
                                                    Botble.blockUI({
                                                        target: $formBody,
                                                        iconOnly: true,
                                                        overlayColor: 'none',
                                                    })

                                                    $('#select-billing-provider').load($('.btn-trigger-shipment').data('target') + '?view=true #select-shipping-provider > *', () => {
                                                        Botble.unblockUI($formBody)
                                                        Botble.initResources()
                                                    })
                                                } else {
                                                    Botble.showError(res.message)
                                                }
                                                _self.removeClass('button-loading')
                                            },
                                            error: res => {
                                                Botble.handleError(res)
                                                _self.removeClass('button-loading')
                                            },
                                        })
                                    })
                                })
                            })
                        </script>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="mt20 mb20">
    <div>
        <div class="comment-log ws-nm">
            <div class="comment-log-title">
                <label class="bold-light m-xs-b hide-print">{{ trans('plugins/ecommerce::order.history') }}</label>
            </div>
            <div class="comment-log-timeline">
                <div class="column-left-history ps-relative" id="order-history-wrapper">
                    @foreach ($order->histories()->orderBy('id', 'DESC')->get() as $history)
                        <div class="item-card">
                            <div class="item-card-body clearfix">
                                <div
                                    class="item comment-log-item comment-log-item-date ui-feed__timeline">
                                    <div class="ui-feed__item ui-feed__item--message">
                                                                <span
                                                                    class="ui-feed__marker @if ($history->user_id) ui-feed__marker--user-action @endif"></span>
                                        <div class="ui-feed__message">
                                            <div class="timeline__message-container">
                                                <div class="timeline__inner-message">
                                                    @if (in_array($history->action, ['confirm_payment', 'refund']))
                                                        <a href="#" class="text-no-bold show-timeline-dropdown hover-underline" data-target="#history-line-{{ $history->id }}">
                                                            <span>{{ OrderHelper::processHistoryVariables($history) }}</span>
                                                        </a>
                                                    @else
                                                        <span>{{ OrderHelper::processHistoryVariables($history) }}</span>
                                                    @endif
                                                </div>
                                                <time class="timeline__time">
                                                    <span>{{ $history->created_at }}</span>
                                                </time>
                                            </div>
                                        </div>
                                    </div>
                                    @if ($history->action == 'refund' && Arr::get($history->extras, 'amount', 0) > 0)
                                        <div class="timeline-dropdown"
                                             id="history-line-{{ $history->id }}">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.order_number') }}</th>
                                                    <td>
                                                        <a href="{{ route('orders.edit', $order->id) }}" title="{{ $order->code }}">{{ $order->code }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.description') }}</th>
                                                    <td>{{ $history->description . ' ' . trans('plugins/ecommerce::order.from') . ' ' . $order->payment->payment_channel->label() }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.amount') }}</th>
                                                    <td>{{ format_price(Arr::get($history->extras, 'amount', 0)) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.status') }}</th>
                                                    <td>{{ trans('plugins/ecommerce::order.successfully') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.transaction_type') }}</th>
                                                    <td>{{ trans('plugins/ecommerce::order.refund') }}</td>
                                                </tr>
                                                @if ($history->user->name)
                                                    <tr>
                                                        <th>{{ trans('plugins/ecommerce::order.staff') }}</th>
                                                        <td>{{ $history->user->name ?: trans('plugins/ecommerce::order.n_a') }}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.refund_date') }}</th>
                                                    <td>{{ $history->created_at }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    @if (is_plugin_active('payment') && $history->action == 'confirm_payment' && $order->payment)
                                        <div class="timeline-dropdown"
                                             id="history-line-{{ $history->id }}">
                                            <table>
                                                <tbody>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.order_number') }}</th>
                                                    <td>
                                                        <a href="{{ route('orders.edit', $order->id) }}" title="{{ $order->code }}">{{ $order->code }}</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.description') }}</th>
                                                    <td>{!! trans('plugins/ecommerce::order.mark_payment_as_confirmed', ['method' => $order->payment->payment_channel->label()]) !!}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.transaction_amount') }}</th>
                                                    <td>{{ format_price($order->payment->amount) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.payment_gateway') }}</th>
                                                    <td>{{ $order->payment->payment_channel->label() }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.status') }}</th>
                                                    <td>{{ trans('plugins/ecommerce::order.successfully') }}</td>
                                                </tr>
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.transaction_type') }}</th>
                                                    <td>{{ trans('plugins/ecommerce::order.confirm') }}</td>
                                                </tr>
                                                @if ($history->user->name)
                                                    <tr>
                                                        <th>{{ trans('plugins/ecommerce::order.staff') }}</th>
                                                        <td>{{ $history->user->name ?: trans('plugins/ecommerce::order.n_a') }}</td>
                                                    </tr>
                                                @endif
                                                <tr>
                                                    <th>{{ trans('plugins/ecommerce::order.payment_date') }}</th>
                                                    <td>{{ $history->created_at }}</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                    @if ($history->action == 'send_order_confirmation_email')
                                        <div class="ui-feed__item ui-feed__item--action">
                                            <span class="ui-feed__spacer"></span>
                                            <div class="timeline__action-group">
                                                <a href="#" class="btn hide-print timeline__action-button hover-underline btn-trigger-resend-order-confirmation-modal" data-action="{{ route('orders.send-order-confirmation-email', $history->order_id) }}">{{ trans('plugins/ecommerce::order.resend') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@push('header')
    <style>
        .numberic {
            width: 60px;
            margin-left: 20px;
            margin-right: 40px;
            border-top: none;
            border-right: none;
            border-left: none;
            outline: none;
            border-width: 1px;
        }
        .currency {
            margin-left: 20px;
        }
        .more-numberic {
            width: 60px;
            margin-right: 40px;
            border-top: none;
            border-right: none;
            border-left: none;
            outline: none;
            border-width: 1px;
        }
    </style>
@endpush
@push('footer')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.numberic').inputmask({
                alias: 'numeric',
                allowMinus: false,
                digits: 1,
                max: 999.9
            });
            $('.more-numberic').inputmask({
                alias: 'numeric',
                allowMinus: false,
                digits: 2,
                max: 9999.9
            });

            $('.start').on('change', function(ev) {
                if ($('.end', $(this).parent().parent())[0].value - this.value < 0) {
                    $('.total', $(this).parent().parent())[0].value = 0;
                } else {
                    $('.total', $(this).parent().parent())[0].value = $('.end', $(this).parent().parent())[0].value - this.value;
                }

                $('.total', $(this).parent().parent()).trigger('change');
            });

            $('.end').on('change', function(ev) {
                if (this.value - $('.start', $(this).parent().parent())[0].value < 0) {
                    $('.total', $(this).parent().parent())[0].value = 0;
                } else {
                    $('.total', $(this).parent().parent())[0].value = this.value - $('.start', $(this).parent().parent())[0].value;
                }
                $('.total', $(this).parent().parent()).trigger('change');
            });

            $('.allocated').on('change', function(ev) {
                if ($('.total', $(this).parent().parent())[0].value - this.value < 0) {
                    $('.over', $(this).parent().parent())[0].value = 0;
                } else {
                    $('.over', $(this).parent().parent())[0].value = $('.total', $(this).parent().parent())[0].value - this.value;
                }
                $('.over', $(this).parent().parent()).trigger('change');
            });

            $('.total').on('change', function(ev) {
                if (this.value - $('.allocated', $(this).parent().parent())[0].value < 0) {
                    $('.over', $(this).parent().parent())[0].value = 0;
                } else {
                    $('.over', $(this).parent().parent())[0].value = this.value - $('.allocated', $(this).parent().parent())[0].value;
                }
                $('.over', $(this).parent().parent()).trigger('change');
            });

            $('.over').on('change', function(ev) {
                $('.total-charge', $(this).parent().parent().parent())[0].value = this.value * $('.over-rate', $(this).parent().parent().parent())[0].value;
            });

            $('.over-rate').on('change', function(ev) {
                $('.total-charge', $(this).parent().parent())[0].value = this.value * $('.over', $(this).parent().parent())[0].value;
            });
        });
    </script>
@endpush
