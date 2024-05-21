@if (setting('payment_authorizenet_status') == 1)
    <li class="list-group-item">
        <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_authorizenet"
               value="authorizenet" @if ($selecting == AUTHORIZENET_PAYMENT_METHOD_NAME) checked @endif>
        <label for="payment_authorizenet" class="text-start">
            {{-- {{ setting('payment_authorizenet_name', trans('plugins/payment::payment.payment_via_card')) }} --}}
            {{ trans('plugins/payment::payment.pay_using_card') }}
        </label>
        <div class="payment_authorizenet_wrap payment_collapse_wrap collapse @if ($selecting == AUTHORIZENET_PAYMENT_METHOD_NAME) show @endif" style="padding: 15px 0;">
            {{-- <p>{!! BaseHelper::clean(get_payment_setting('description', AUTHORIZENET_PAYMENT_METHOD_NAME)) !!}</p> --}}
            <div class="card-checkout" style="max-width: 350px">
                <div class="form-group mt-3 mb-3">
                    <div class="stripe-card-wrapper"></div>
                </div>
                <div class="form-group mb-3 @if ($errors->has('number') || $errors->has('name')) has-error @endif">
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <input placeholder="{{ trans('plugins/payment::payment.first_name') }}"
                                    class="form-control" id="stripe-name" type="text" data-stripe="first-name" autocomplete="off">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <input placeholder="{{ trans('plugins/payment::payment.last_name') }}"
                                    class="form-control" id="stripe-name" type="text" data-stripe="last-name" autocomplete="off">
                        </div>
                        <div class="col-sm-12">
                            <input name="card_number" placeholder="{{ trans('plugins/payment::payment.card_number') }}"
                                    class="form-control" type="text" id="stripe-number" data-stripe="number" autocomplete="off">
                        </div>
                        {{-- <div class="col-md-8">
                            <input placeholder="{{ trans('plugins/payment::payment.full_name') }}"
                                    class="form-control" id="stripe-name" type="text" data-stripe="name" autocomplete="off">
                        </div> --}}
                    </div>
                </div>
                <div class="form-group mb-3 @if ($errors->has('expiry') || $errors->has('cvc')) has-error @endif">
                    <div class="row">
                        <div class="col-sm-6">
                            <input name="mm_yy" placeholder="MM/YY" class="form-control"
                                    type="text" id="stripe-exp" data-stripe="exp" autocomplete="off">
                        </div>
                        <div class="col-sm-6">
                            <input name="cvc" placeholder="{{ trans('plugins/payment::payment.cvc') }}" class="form-control"
                                    type="text" id="stripe-cvc" data-stripe="cvc" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
@endif
