@php $stripeStatus = setting('payment_authorizenet_status'); @endphp
<table class="table payment-method-item">
    <tbody><tr class="border-pay-row">
        <td class="border-pay-col"><i class="fa fa-theme-payments"></i></td>
        <td style="width: 20%;">
            {{-- <img class="filter-black" src="{{ plugin_path('authorizenet/screenshot.png') }}" alt="authorizenet"> --}}
            <img class="filter-black" src="{{ 'data:image/png;base64,' . base64_encode(File::get(plugin_path('authorizenet/screenshot.png'))) }}" alt="authorizenet">
        </td>
        <td class="border-right">
            <ul>
                <li>
                    <a href="https://authorize.net" target="_blank">Authorizenet</a>
                    <p>{{ trans('Customer can buy product and pay directly using Visa, Credit card via Authorizenet') }}</p>
                </li>
            </ul>
        </td>
    </tr>
    <tr class="bg-white">
        <td colspan="3">
            <div class="float-start" style="margin-top: 5px;">
                <div class="payment-name-label-group @if ($stripeStatus == 0) hidden @endif">
                    <span class="payment-note v-a-t">{{ trans('plugins/payment::payment.use') }}:</span>
                    <label class="ws-nm inline-display method-name-label">{{ setting('payment_authorizenet_name') }}</label>
                </div>
            </div>
            <div class="float-end">
                <a class="btn btn-secondary toggle-payment-item edit-payment-item-btn-trigger @if ($stripeStatus == 0) hidden @endif">{{ trans('plugins/payment::payment.edit') }}</a>
                <a class="btn btn-secondary toggle-payment-item save-payment-item-btn-trigger @if ($stripeStatus == 1) hidden @endif">{{ trans('plugins/payment::payment.settings') }}</a>
            </div>
        </td>
    </tr>
    <tr class="payment-content-item hidden">
        <td class="border-left" colspan="3">
            {!! Form::open() !!}
            {!! Form::hidden('type', AUTHORIZENET_PAYMENT_METHOD_NAME, ['class' => 'payment_type']) !!}
            <div class="row">
                <div class="col-sm-6">
                    <ul>
                        <li>
                            <label>{{ trans('plugins/payment::payment.configuration_instruction', ['name' => 'Authorizenet']) }}</label>
                        </li>
                        <li class="payment-note">
                            <p>{{ trans('plugins/payment::payment.configuration_requirement', ['name' => 'Authorizenet']) }}:</p>
                            <ul class="m-md-l" style="list-style-type:decimal">
                                <li style="list-style-type:decimal">
                                    <a href="https://dashboard.authorize.net/register" target="_blank">
                                        {{ trans('plugins/payment::payment.service_registration', ['name' => 'Authorizenet']) }}
                                    </a>
                                </li>
                                <li style="list-style-type:decimal">
                                    <p>{{ trans('plugins/payment::payment.stripe_after_service_registration_msg', ['name' => 'Authorizenet']) }}</p>
                                </li>
                                <li style="list-style-type:decimal">
                                    <p>{{ trans('plugins/payment::payment.stripe_enter_client_id_and_secret') }}</p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-6">
                    <div class="well bg-white">
                        <x-core-setting::text-input
                            name="payment_authorizenet_name"
                            :label="trans('plugins/payment::payment.method_name')"
                            :value="setting('payment_authorizenet_name', trans('plugins/payment::payment.pay_online_via', ['name' => 'Authorizenet']))"
                            data-counter="400"
                        />

                        <x-core-setting::form-group>
                            <label class="text-title-field" for="payment_authorizenet_description">{{ trans('core/base::forms.description') }}</label>
                            <textarea class="next-input" name="payment_authorizenet_description" id="payment_authorizenet_description">{{ get_payment_setting('description', 'stripe', __('Payment with :paymentType', ['paymentType' => 'Authorizenet'])) }}</textarea>
                        </x-core-setting::form-group>

                        <p class="payment-note">
                            {{ trans('plugins/payment::payment.please_provide_information') }} <a target="_blank" href="//www.authorize.net">Authorizenet</a>:
                        </p>

                        <x-core-setting::text-input
                            name="payment_authorizenet_merchant_login_id"
                            :label="trans('Authorizenet Merchant Login Id')"
                            :value="BaseHelper::hasDemoModeEnabled() ? '*******************************' : setting('payment_authorizenet_merchant_login_id')"
                            placeholder="authorize.*************"
                        />

                        <x-core-setting::text-input
                            name="payment_authorizenet_merchant_transaction_key"
                            :label="trans('Authorizenet Merchant Transaction Key')"
                            :value="BaseHelper::hasDemoModeEnabled() ? '*******************************' : setting('payment_authorizenet_merchant_transaction_key')"
                            placeholder="authorize.*************"
                            data-counter="400"
                        />

                        {{-- <x-core-setting::select
                            :name="'payment_' . AUTHORIZENET_PAYMENT_METHOD_NAME . '_payment_type'"
                            :label="__('Payment Type')"
                            :options="[
                                'stripe_api_charge' => 'Authorizenet API Charge',
                                'stripe_checkout' => 'Authorizenet Checkout',
                            ]"
                            :value="get_payment_setting('payment_type', AUTHORIZENET_PAYMENT_METHOD_NAME, 'stripe_api_charge')"
                        /> --}}

                        {!! apply_filters(PAYMENT_METHOD_SETTINGS_CONTENT, null, 'authorizenet') !!}
                    </div>
                </div>
            </div>
            <div class="col-12 bg-white text-end">
                <button class="btn btn-warning disable-payment-item @if ($stripeStatus == 0) hidden @endif" type="button">{{ trans('plugins/payment::payment.deactivate') }}</button>
                <button class="btn btn-info save-payment-item btn-text-trigger-save @if ($stripeStatus == 1) hidden @endif" type="button">{{ trans('plugins/payment::payment.activate') }}</button>
                <button class="btn btn-info save-payment-item btn-text-trigger-update @if ($stripeStatus == 0) hidden @endif" type="button">{{ trans('plugins/payment::payment.update') }}</button>
            </div>
            {!! Form::close() !!}
        </td>
    </tr>
    </tbody>
</table>
