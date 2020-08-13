<?php
/**
 * PromoCodes
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

    Route::group( ['namespace' => 'PromoCodes'], function () {
        Route::post('promocodes/status', 'PromoCodesController@updateStatus')->name('promocodes.update-status');
        Route::resource('system/promocodes', 'PromoCodesController')->except([
            'edit', 'update', 'show', 'destroy'
        ]);
        //For Datatable
        Route::post('promocodes/get', 'PromoCodesTableController')->name('promocodes.get');
    });

});