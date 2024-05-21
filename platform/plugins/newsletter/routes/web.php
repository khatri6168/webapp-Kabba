<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Newsletter\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'newsletters', 'as' => 'newsletter.'], function () {
            Route::resource('', 'NewsletterController')->only(['index', 'destroy'])->parameters(['' => 'newsletter']);

            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'NewsletterController@deletes',
                'permission' => 'newsletter.destroy',
            ]);
        });
        Route::get('/newsletter/emailtemplate/create', [
            'as' => 'newsletter.emailtemplate.create',
            'uses' => 'NewsletterController@emailTemplateCreate',
        ]);
        Route::get('/smsbrodcast', [
            'as' => 'smsbrodcast',
            'uses' => 'NewsletterController@SMSindex',
        ]);
        Route::get('/smslogs', [
            'as' => 'smslogs',
            'uses' => 'NewsletterController@SMSLogindex',
        ]);
        Route::delete('/smslogs', [
            'as' => 'smslogs.distroy',
            'uses' => 'NewsletterController@SmsLogDelete',
        ]);
        Route::post('/smslogs', [
            'as' => 'smslogs',
            'uses' => 'NewsletterController@SMSLogindex',
        ]);
        Route::post('/updatesmsstatus', [
            'as' => 'updatesmsstatus',
            'uses' => 'NewsletterController@UpdateSMSStatus',
        ]);
        Route::post('/getsmscontent', [
            'as' => 'getsmscontent',
            'uses' => 'NewsletterController@GetSMSContent',
        ]);
        Route::get('/smsbrodcast/process', [
            'as' => 'smsbrodcast.process',
            'uses' => 'NewsletterController@SMSBrodcastTemplate',
        ]);
        Route::post('/smsbrodcast/searchcontacts', [
            'as' => 'smsbrodcast.searchcontacts',
            'uses' => 'NewsletterController@SearchContacts',
        ]);
        Route::post('/smsbrodcast', [
            'as' => 'smsbrodcast',
            'uses' => 'NewsletterController@SMSindex',
        ]);
        Route::post('/smsbrodcast/crete', [
            'as' => 'smsbrodcast.create',
            'uses' => 'NewsletterController@CreateSMSTemplate',
        ]);
        Route::post('/editsms', [
            'as' => 'editsms',
            'uses' => 'NewsletterController@EditSMS',
        ]);
        Route::get('/newsletter/email/send', [
            'as' => 'newsletter.bulk.send',
            'uses' => 'NewsletterController@newsletterBulkEmailSend',
        ]);

        Route::get('/sms/send', [
            'as' => 'sms.bulk.send',
            'uses' => 'NewsletterController@BulkSMSSend',
        ]);

        Route::post('/updatesms', [
            'as' => 'updatesms',
            'uses' => 'NewsletterController@UpdateSMSRecords',
        ]);

        Route::post('/copysms', [
            'as' => 'copysms',
            'uses' => 'NewsletterController@CopySMS',
        ]);

        Route::post('/copymail', [
            'as' => 'copymail',
            'uses' => 'NewsletterController@CopyMail',
        ]);

        Route::delete('email-template/destroy', [
            'as' => 'emailtemplate.destroy',
            'uses' => 'NewsletterController@emailTemplateDeletes',
        ]);
    });

    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::post('newsletter/subscribe', [
            'as' => 'public.newsletter.subscribe',
            'uses' => 'PublicController@postSubscribe',
        ]);

        Route::get('newsletter/unsubscribe/{user}', [
            'as' => 'public.newsletter.unsubscribe',
            'uses' => 'PublicController@getUnsubscribe',
        ]);
    });
});
