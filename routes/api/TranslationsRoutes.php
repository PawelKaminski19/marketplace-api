<?php
Route::group(['middleware' => 'api', 'prefix' => 'translations'], function ($router) {
    Route::group(['prefix' => '{language?}'], function ($router) {
        Route::get('/', 'Api\i18n\TranslationController@index');
    });

    Route::group(['middleware' => ['jwt.verify', 'role:SuperAdmin|Admin'], 'prefix' => 'admin', 'namespace' => 'Api\Admin\i18n'], function ($router) {
        Route::get('/modules', 'i18nController@modules');
        Route::get('/datatables', 'i18nController@datatables');
        Route::post('/save-modules', 'i18nController@saveModules');
        Route::post('/set-translation', 'i18nController@setTranslation');

        Route::group(['prefix' => 'languages'], function ($router) {
            Route::get('/', 'i18nController@languages');
            Route::post('/', 'i18nController@saveLanguage');
            Route::put('/{language}', 'i18nController@saveLanguage');
            Route::delete('/{language}', 'i18nController@deleteLanguage');
        });

        Route::group(['prefix' => 'key'], function ($router) {
            Route::post('/change', 'i18nController@changeKey');
            Route::post('/save', 'i18nController@saveKey');
            Route::post('/exist', 'i18nController@keyExist');
            Route::delete('/{key}', 'i18nController@remove');
        });

        Route::group(['prefix' => '/import'], function ($router) {
            Route::get('/begin', 'i18nImportController@begin');
            Route::get('/end', 'i18nImportController@end');
            Route::get('/step', 'i18nImportController@step');
        });

    });


});
