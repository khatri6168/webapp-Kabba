<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
            Route::resource('', 'OrderController')->parameters(['' => 'order']);

            Route::get('login-customer/{id}', [
                'as' => 'login-customer',
                'uses' => 'OrderController@loginCustomer',
                'permission' => ['orders.index'],
            ]);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'OrderController@deletes',
                'permission' => 'orders.destroy',
            ]);

            Route::get('reorder', [
                'as' => 'reorder',
                'uses' => 'OrderController@getReorder',
                'permission' => 'orders.create',
            ]);

            Route::get('generate-invoice/{id}', [
                'as' => 'generate-invoice',
                'uses' => 'OrderController@getGenerateInvoice',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('confirm', [
                'as' => 'confirm',
                'uses' => 'OrderController@postConfirm',
                'permission' => 'orders.edit',
            ]);

            Route::post('updatelicense', [
                'as' => 'updatelicense',
                'uses' => 'OrderController@Updtelicense',
                'permission' => 'orders.edit',
            ]);

            Route::post('updateByOrderId/{id}', [
                'as' => 'update-by-order-id',
                'uses' => 'OrderController@updateByOrderId',
                'permission' => 'orders.edit',
            ]);

            Route::post('updateImage', [
                'as' => 'updateImage',
                'uses' => 'OrderController@updateImage',
                'permission' => 'orders.edit',
            ]);

            Route::post('send-order-confirmation-email/{id}', [
                'as' => 'send-order-confirmation-email',
                'uses' => 'OrderController@postResendOrderConfirmationEmail',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('create-shipment/{id}', [
                'as' => 'create-shipment',
                'uses' => 'OrderController@postCreateShipment',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('cancel-shipment/{id}', [
                'as' => 'cancel-shipment',
                'uses' => 'OrderController@postCancelShipment',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('update-shipping-address/{id}', [
                'as' => 'update-shipping-address',
                'uses' => 'OrderController@postUpdateShippingAddress',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('update-billing-address/{id}', [
                'as' => 'update-billing-address',
                'uses' => 'OrderController@postUpdateBillingAddress',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('cancel-order/{id}', [
                'as' => 'cancel',
                'uses' => 'OrderController@postCancelOrder',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::get('print-shipping-order/{id}', [
                'as' => 'print-shipping-order',
                'uses' => 'OrderController@getPrintShippingOrder',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('confirm-payment/{id}', [
                'as' => 'confirm-payment',
                'uses' => 'OrderController@postConfirmPayment',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::get('get-shipment-form/{id}', [
                'as' => 'get-shipment-form',
                'uses' => 'OrderController@getShipmentForm',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::post('refund/{id}', [
                'as' => 'refund',
                'uses' => 'OrderController@postRefund',
                'permission' => 'orders.edit',
            ])->wherePrimaryKey();

            Route::get('get-available-shipping-methods', [
                'as' => 'get-available-shipping-methods',
                'uses' => 'OrderController@getAvailableShippingMethods',
                'permission' => 'orders.edit',
            ]);

            Route::post('coupon/apply', [
                'as' => 'apply-coupon-when-creating-order',
                'uses' => 'OrderController@postApplyCoupon',
                'permission' => 'orders.create',
            ]);

            Route::post('check-data-before-create-order', [
                'as' => 'check-data-before-create-order',
                'uses' => 'OrderController@checkDataBeforeCreateOrder',
                'permission' => 'orders.create',
            ]);
        });

        Route::group(['prefix' => 'incomplete-orders', 'as' => 'orders.'], function () {
            Route::match(['GET', 'POST'], '', [
                'as' => 'incomplete-list',
                'uses' => 'OrderController@getIncompleteList',
                'permission' => 'orders.index',
            ]);

            Route::get('view/{id}', [
                'as' => 'view-incomplete-order',
                'uses' => 'OrderController@getViewIncompleteOrder',
                'permission' => 'orders.index',
            ])->wherePrimaryKey();

            Route::post('send-order-recover-email/{id}', [
                'as' => 'send-order-recover-email',
                'uses' => 'OrderController@postSendOrderRecoverEmail',
                'permission' => 'orders.index',
            ])->wherePrimaryKey();
        });

        Route::group(['prefix' => 'order-returns', 'as' => 'order_returns.'], function () {
            Route::resource('', 'OrderReturnController')->parameters(['' => 'order_returns'])->except(['create', 'store']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'OrderReturnController@deletes',
                'permission' => 'order_returns.destroy',
            ]);
        });
    });
});

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers\Fronts', 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::group(['prefix' => 'checkout/{token}', 'as' => 'public.checkout.'], function () {
            Route::get('/', [
                'as' => 'information',
                'uses' => 'PublicCheckoutController@getCheckout',
            ]);

            Route::post('information', [
                'as' => 'save-information',
                'uses' => 'PublicCheckoutController@postSaveInformation',
            ]);

            Route::post('process', [
                'as' => 'process',
                'uses' => 'PublicCheckoutController@postCheckout',
            ]);

            Route::get('success', [
                'as' => 'success',
                'uses' => 'PublicCheckoutController@getCheckoutSuccess',
            ]);

            Route::get('recover', [
                'as' => 'recover',
                'uses' => 'PublicCheckoutController@getCheckoutRecover',
            ]);

            Route::get('sign-terms', [
                'as' => 'sign-terms',
                'uses' => 'PublicCheckoutController@getSignTerms',
            ]);

            Route::post('sign-terms', [
                'as' => 'sign-terms',
                'uses' => 'PublicCheckoutController@postSignTerms',
            ]);
        });
    });
});
