<?php
/**
 * Liability
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Liability'], function () {
        Route::post('liabilities/getbankdetail', 'LiabilitiesController@getBackDetail')->name('liabilities.getbankdetail');
        Route::resource('liabilities', 'LiabilitiesController');
        //For Datatable
        Route::post('liabilities/get', 'LiabilitiesTableController')->name('liabilities.get');
    });
    
});