{!! Theme::partial('header-top') !!}

<div class="sb-top-bar-frame">
    <div class="sb-top-bar-bg"></div>
    <div class="container">
        <div class="sb-top-bar">
            <a href="{{ route('public.index') }}" class="sb-logo-frame">
                @if (theme_option('logo'))
                    <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}">
                @endif
            </a>

            <div class="sb-right-side" style="width: 100% !important;">
                <nav id="sb-dynamic-menu" class="sb-menu-transition" data-swup="1">
                    {!!
                       Menu::renderMenuLocation('main-menu', [
                           'options' => ['class' => 'sb-navigation'],
                           'view' => 'main-menu',
                       ])
                   !!}
                </nav>
                <div class="sb-buttons-frame">
                    @if (EcommerceHelper::isWishlistEnabled())
                        <div class="sb-btn sb-btn-2 sb-btn-gray sb-btn-icon sb-m-0 sb-btn-wishlist">
                            <a href="{{ route('public.wishlist') }}" class="me-2">
                            <span class="sb-icon">
                                <img src="{{ Theme::asset()->url('images/icons/wishlist.svg') }}" alt="{{ __('Wishlist') }}">
                            </span>
                                @if ($numberItems = Cart::instance('wishlist')->count())
                                    <i class="sb-wishlist-number">{{ $numberItems }}</i>
                                @endif
                            </a>
                        </div>
                    @endif

                    <div class="sb-btn sb-btn-2 sb-btn-gray sb-btn-icon sb-m-0 sb-btn-cart">
                        <span class="sb-icon">
                          <img src="{{ Theme::asset()->url('images/icons/cart.svg') }}" alt="{{ __('Cart') }}">
                        </span>
                        @php($numberItems = Cart::instance('cart')->count())
                        <i class="sb-cart-number">{{ $numberItems }}</i>
                    </div>

                    <div class="sb-menu-btn"><span></span></div>
                    <div class="sb-info-btn"><span></span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="sb-info-bar">
        <div class="sb-infobar-content">
            {!! dynamic_sidebar('information-sidebar') !!}
        </div>
        <div class="sb-info-bar-footer">
            @if($socialLinks = json_decode(theme_option('social_links')))
                <ul class="sb-social">
                    @foreach($socialLinks as $social)
                        @php($social = collect($social)->pluck('value', 'key'))
                        <li>
                            <a href="{{ $social->get('social-url') }}" title="{{ $social->get('social-name') }}"><i class="{{ $social->get('social-icon') }}"></i></a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="sb-minicart">
        {!! Theme::partial('ecommerce.cart-mini.list') !!}
    </div>
</div>
