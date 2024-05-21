<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Contact\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
            Route::resource('', 'ContactController')->parameters(['' => 'contact']);

            Route::get('reply/{id}', [
                'as' => 'reply_view',
                'uses' => 'ContactController@reply',
            ]);

            Route::post('edit/{id}/notes/create', [
                'as' => 'notes_create',
                'uses' => 'ContactController@addNotes',
            ]);
            Route::put('edit/{id}/notes/update', [
                'as' => 'notes_update',
                'uses' => 'ContactController@updateNotes',
            ]);
            Route::delete('edit/{id}/notes/delete', [
                'as' => 'notes_delete',
                'uses' => 'ContactController@deleteNotes',
            ]);
            Route::put('edit/{id}/notes/update', [
                'as' => 'notest_create',
                'uses' => 'ContactController@updateNotes',
            ]);

            Route::get('/contacttags', [
                'as' => 'contacttags',
                'uses' => 'ContactController@Tags',
            ]);
            Route::post('/contacttags', [
                'as' => 'contacttags',
                'uses' => 'ContactController@Tags',
            ]);
            
            Route::post('/createtags', [
                'as' => 'createtags',
                'uses' => 'ContactController@createtags',
            ]);

            Route::get('/company', [
                'as' => 'company',
                'uses' => 'ContactController@companyList',
            ]);
            Route::post('/company', [
                'as' => 'company',
                'uses' => 'ContactController@companyList',
            ]);

            

            Route::post('/createtags2', [
                'as' => 'createtags2',
                'uses' => 'ContactController@CreateTags2',
            ]);
            Route::post('/edittag', [
                'as' => 'edittag',
                'uses' => 'ContactController@EditTag',
            ]);
            Route::post('/updatetag', [
                'as' => 'updatetag',
                'uses' => 'ContactController@UpdateTag',
            ]);
            
            Route::delete('items/destroy', [
                'as' => 'deletes',
                'uses' => 'ContactController@deletes',
                'permission' => 'contacts.destroy',
            ]);
            Route::get('company/create', [
                'as' => 'company/create',
                'uses' => 'ContactController@addCompany',
            ]);

            Route::post('reply/{id}', [
                'as' => 'reply',
                'uses' => 'ContactController@postReply',
                'permission' => 'contacts.edit',
            ])->wherePrimaryKey();
        });
        Route::get('contacts/import', [
            'as' => 'contacts.import',
            'uses' => 'ContactController@bulkImport',
        ]);
        Route::post('contacts/import', [
            'as' => 'contacts.import',
            'uses' => 'ContactController@postBulkImport',
        ]);

        Route::post('contacts/import/download-template', [
            'as' => 'contacts.import.download-template',
            'uses' => 'ContactController@downloadTemplate',
        ]);

        Route::delete('/contacttags/destroy', [
            'as' => 'contacttags.destroy',
            'uses' => 'ContactController@destroyTag',
            
        ]);

        Route::delete('/company/destroy', [
            'as' => 'company.destroy',
            'uses' => 'ContactController@destroyCompany',
            
        ]);

        Route::post('/contacts/editcompany', [
            'as' => 'editcompany',
            'uses' => 'ContactController@EditCompany',
        ]);

        Route::post('/contacttags/checkduplicate', [
            'as' => 'contacttags.checkduplicate',
            'uses' => 'ContactController@CheckDuplicateTag',
            
        ]);
    });

    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::post('contact/send', [
            'as' => 'public.send.contact',
            'uses' => 'PublicController@postSendContact',
        ]);
    });
});

// Route::post('api/create-contact', [
//     'uses' => 'Botble\Contact\Http\Controllers\ContactController@createContact',
// ]);

Route::get('api/contacttags', [
    'uses' => 'Botble\Contact\Http\Controllers\ContactController@ContactTags',
]);

Route::post('api/createtag', [
    'uses' => 'Botble\Contact\Http\Controllers\ContactController@CreateContactTags',
]);

Route::post('api/adminlogin', [
    'uses' => 'Botble\Contact\Http\Controllers\ContactController@AdminLogin',
]);



