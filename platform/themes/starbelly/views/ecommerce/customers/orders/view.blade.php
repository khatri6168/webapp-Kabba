@extends(Theme::getThemeNamespace('views.ecommerce.customers.layout'))

@section('content')
    <div class="customer-order-detail">
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    @php
                        $logo = theme_option('logo_in_the_checkout_page') ?: theme_option('logo');
                    @endphp
                    @if ($logo)
                        <img width="100" src="{{ RvMedia::getImageUrl($logo) }}"
                             alt="{{ theme_option('site_title') }}">
                        <br/>
                    @endif
                    {{ setting('contact_address') }}
                </div>
            </div>
        </div>
        @include('plugins/ecommerce::themes.includes.order-tracking-detail')
        <br>
        <div>
            @if ($order->isInvoiceAvailable())
                <a href="{{ route('customer.print-order', $order->id) }}" class="btn btn-secondary mr-2">
                    <i class="fa fa-download"></i> {{ __('Download invoice') }}
                </a>
            @endif

            @if ($order->canBeCanceled())
                <a href="{{ route('customer.orders.cancel', $order->id) }}" onclick="return confirm('{{ __('Are you sure?') }}')" class="btn btn-danger">
                    {{ __('Cancel order') }}
                </a>
            @endif

            @if ($order->canBeReturned())
                <a href="{{ route('customer.order_returns.request_view', $order->id) }}"
                   class="btn btn-danger">
                    {{ __('Return Product(s)') }}
                </a>
            @endif
        </div>
    </div>
@endsection
