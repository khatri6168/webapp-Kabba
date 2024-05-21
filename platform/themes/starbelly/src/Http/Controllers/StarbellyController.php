<?php

namespace Theme\Starbelly\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Ecommerce\Models\Customer;
use Botble\Ecommerce\Models\Product;
use Botble\Ecommerce\Repositories\Interfaces\ProductInterface;
use Botble\Ecommerce\Repositories\Interfaces\WishlistInterface;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Facades\Cart;

class StarbellyController extends PublicController
{
    public function ajaxAddProductToWishlist(
        $productId = null,
        Request $request,
        ProductInterface $productRepository,
        WishlistInterface $wishlistRepository,
        BaseHttpResponse $response
    ) {
        if (! EcommerceHelper::isWishlistEnabled()) {
            abort(404);
        }

        if (! $productId) {
            $productId = $request->input('product_id');
        }

        if (! $productId) {
            return $response->setError()->setMessage(__('This product is not available.'));
        }

        $product = $productRepository->findOrFail($productId);

        $messageAdded = __('Added product :product successfully!', ['product' => $product->name]);
        $messageRemoved = __('Removed product :product from wishlist successfully!', ['product' => $product->name]);

        if (! auth('customer')->check()) {
            $duplicates = Cart::instance('wishlist')->search(function ($cartItem) use ($productId) {
                return $cartItem->id == $productId;
            });

            if (! $duplicates->isEmpty()) {
                $added = false;
                Cart::instance('wishlist')->search(function ($cartItem, $rowId) use ($productId) {
                    if ($cartItem->id == $productId) {
                        Cart::instance('wishlist')->remove($rowId);

                        return true;
                    }

                    return false;
                });
            } else {
                $added = true;
                Cart::instance('wishlist')
                    ->add($productId, $product->name, 1, $product->front_sale_price)
                    ->associate(Product::class);
            }

            return $response
                ->setMessage($added ? $messageAdded : $messageRemoved)
                ->setData([
                    'count' => Cart::instance('wishlist')->count(),
                    'added' => $added,
                ]);
        }

        /**
         * @var Customer $customer
         */
        $customer = auth('customer')->user();

        if (is_added_to_wishlist($productId)) {
            $added = false;
            $wishlistRepository->deleteBy([
                'product_id' => $productId,
                'customer_id' => $customer->getKey(),
            ]);
        } else {
            $added = true;
            $wishlistRepository->createOrUpdate([
                'product_id' => $productId,
                'customer_id' => $customer->getKey(),
            ]);
        }

        return $response
            ->setMessage($added ? $messageAdded : $messageRemoved)
            ->setData([
                'count' => $customer->wishlist()->count(),
                'added' => $added,
            ]);
    }
}
