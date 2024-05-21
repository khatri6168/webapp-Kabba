<?php

namespace Theme\Starbelly\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Theme\Facades\Theme;
use Botble\Ecommerce\Facades\Cart;
use Botble\Theme\Http\Controllers\PublicController;

class EcommerceController extends PublicController
{
    public function ajaxCart(BaseHttpResponse $response)
    {
        return $response->setData([
            'count' => Cart::instance('cart')->count(),
            'total_price' => format_price(Cart::instance('cart')->rawSubTotal() + Cart::instance('cart')->rawTax()),
            'html' => Theme::partial('ecommerce.cart-mini.list'),
        ]);
    }
}
