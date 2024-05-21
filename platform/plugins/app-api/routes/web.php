<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\AppApi\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {

    });

    // comment below code because of some error from admin side
    // Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
    //     Route::post('contact/send', [
    //         'as' => 'public.send.contact',
    //         'uses' => 'PublicController@postSendContact',
    //     ]);
    // });
});

Route::group(['prefix' => 'api/v1'], function () {
    Route::post('create-contact', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@createContact',
    ]);
    Route::get('getstates', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@getStates',
    ]);
    Route::get('getorders', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@getOrders',
    ]);
    Route::post('getorderdetail', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@getOrderDetail',
    ]);
    Route::get('getcategories', [
        'uses' => 'Botble\AppApi\Http\Controllers\ProductController@getAllCategories',
    ]);
    Route::post('getcategoryproducts', [
        'uses' => 'Botble\AppApi\Http\Controllers\ProductController@getCategoryProducts',
    ]);

    Route::post('getProductDetails', [
        'uses' => 'Botble\AppApi\Http\Controllers\ProductController@getProductDetails',
    ]);

    Route::get('getStores', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@getStores',
    ]);

    Route::get('contact-tags', [
        'uses' => 'Botble\AppApi\Http\Controllers\ContactController@ContactTags',
    ]);

    Route::post('create-contact-tag', [
        'uses' => 'Botble\AppApi\Http\Controllers\ContactController@CreateContactTags',
    ]);

    Route::post('admin/login', [
        'uses' => 'Botble\AppApi\Http\Controllers\ContactController@AdminLogin',
    ]);

    Route::post('place-order', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@placeOrder',
    ]);

    Route::post('order/payment', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@orderPayment',
    ]);

    Route::post('order/upload/license', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@uploadLicense',
    ]);

    Route::post('order/upload/images', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@uploadImages',
    ]);

    Route::post('order/remove/image', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@removeImage',
    ]);

    // Route::post('order/update/product-hours', [
    //     'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@updateOrderProductHours',
    // ]);

    Route::post('order/update/multiple/product-hours', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@updateOrderMultipleProductHours',
    ]);

    Route::post('order/update/multiple/product-hours', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@updateOrderMultipleProductHours',
    ]);

    Route::post('order/delivery-pickup-list', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@getDeliveryPickUpList',
    ]);

    Route::get('order/delivery-pickup-count', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@getDeliveryPickUpCount',
    ]);

    Route::post('order/delivery-pickup-update', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@updateDeliveryPickUpStatus',
    ]);

    Route::post('order/address/update', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@orderAddressUpdate',
    ]);

    Route::post('order/note/update', [
        'uses' => 'Botble\AppApi\Http\Controllers\AppApiController@orderNotUpdate',
    ]);
});






