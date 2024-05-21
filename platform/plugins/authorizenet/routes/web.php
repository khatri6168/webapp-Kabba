<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Authorizenet\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    // Route::get('/pay','PaymentController@pay')->name('pay');
    // Route::post('/dopay/online', 'PaymentController@handleonlinepay')->name('dopay.online');
    
    Route::get('payment/authorizenet/success', 'AuthorizenetController@success')->name('payments.authorizenet.success');
    Route::get('payment/authorizenet/error', 'AuthorizenetController@error')->name('payments.authorizenet.error');
});
