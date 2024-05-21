<?php

use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Theme\Starbelly\Http\Controllers\EcommerceController;
use Theme\Starbelly\Http\Controllers\StarbellyController;

// Custom routes
Route::group(['middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::group(['prefix' => 'ajax', 'as' => 'public.ajax.'], function () {
            Route::group(['controller' => StarbellyController::class], function () {
                Route::post('add-to-wishlist/{id?}', [
                    'uses' => 'ajaxAddProductToWishlist',
                    'as' => 'add-to-wishlist',
                ]);
            });

            Route::group(['controller' => EcommerceController::class], function () {
                Route::get('ajax-cart', [
                    'uses' => 'ajaxCart',
                    'as' => 'cart',
                ]);
            });
        });
    });
});

Theme::routes();
