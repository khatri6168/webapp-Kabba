<section class="sb-p-90-0">
    <div class="container product-details">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form class="form--auth mb-3" method="GET" action="{{ route('public.orders.tracking') }}">
                    <div class="form__header">
                        <h3>{{ __('Order tracking') }}</h3>
                        <p>{{ __('Tracking your order status') }}</p>
                    </div>
                    <div class="form__content">
                        <div class="sb-group-input mb-3">
                            <label for="txt-order-id">{{ __('Order ID') }}<sup>*</sup></label>
                            <input class="form-control" name="order_id" id="txt-order-id" type="text" value="{{ BaseHelper::stringify(old('order_id', request()->input('order_id'))) }}" placeholder="{{ __('Order ID') }}">
                            @if ($errors->has('order_id'))
                                <span class="text-danger">{{ $errors->first('order_id') }}</span>
                            @endif
                        </div>
                        <div class="sb-group-input mb-3">
                            <label for="txt-email">{{ __('Email Address') }}<sup>*</sup></label>
                            <input class="form-control" name="email" id="txt-email" type="email" value="{{ BaseHelper::stringify(old('email', request()->input('email'))) }}" placeholder="{{ __('Please enter your email address') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form__actions">
                            <button type="submit" class="sb-btn px-4 rounded">{{ __('Find') }}</button>
                        </div>
                    </div>
                </form>
                @include('plugins/ecommerce::themes.includes.order-tracking-detail')
            </div>
        </div>
    </div>
</section>
