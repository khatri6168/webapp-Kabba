<div class="header-top">
    <div class="container">
        <div class="top-bar d-inline-block" style="width: 100%;">
            <div class="top-bar-left float-start d-flex">
                @if ($hotline = theme_option('hotline'))
                    <a class="text-body-text line-right phone" href="tel:(615) 815-6734">(615) 815-6734</a>
                @endif
                @if (EcommerceHelper::isOrderTrackingEnabled())
                    <a class="btn-order-tracking" href="{{ route('public.orders.tracking') }}">{{ __('Order Tracking') }}</a>
                @endif
                <span id="language-switcher">
                    {!! Theme::partial('language-switcher') !!}
                </span>
                <span id="language-switcher-mobile">
                    {!! Theme::partial('language-switcher-mobile') !!}
                </span>
                {!! Theme::partial('currency-switcher') !!}
            </div>
            <div class="top-bar-right float-end d-inline">
                @if (EcommerceHelper::isCompareEnabled())
                    <a href="{{ route('public.compare') }}" class="ms-3 compare">
                        <i class="fa fa-random"></i>&nbsp;<span class="name">{{ __('Compare') }}</span>
                        (<span class="compare-counter">{{ Cart::instance('compare')->count() }}</span>)
                    </a>
                @endif
                @if (auth('customer')->check())
                    <a href="{{ route('customer.overview') }}">
                        <img src="{{ auth('customer')->user()->avatar_url }}" class="rounded-circle ms-3" title="{{ auth('customer')->user()->name }}" width="16" alt="{{ auth('customer')->user()->name }}">
                        <span class="customer-name">{{ auth('customer')->user()->name }}</span>&nbsp;<span class="d-inline-block ms-1"></span>
                    </a>
                @else
                    <a href="{{ route('customer.login') }}" class="ms-3">
                        <i class="fa fa-sign-in-alt"></i>&nbsp;<span>{{ __('Login') }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
