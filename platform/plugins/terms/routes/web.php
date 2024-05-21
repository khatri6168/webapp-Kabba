<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Terms\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'terms', 'as' => 'terms.'], function () {
            Route::resource('', 'TermsController')->parameters(['' => 'terms']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'TermsController@deletes',
                'permission' => 'terms.destroy',
            ]);
        });
        Route::group(['prefix' => 'globalterms', 'as' => 'globalterms.'], function () {
            Route::resource('', 'GlobalTermsController')->parameters(['' => 'terms']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'GlobalTermsController@deletes',
                'permission' => 'globalterms.destroy',
            ]);
        });
    });
});
