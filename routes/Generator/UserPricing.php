<?php
/**
 * UserPricing
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'UserPricing'], function () {
        Route::resource('userpricings', 'UserPricingsController');
        //For Datatable
        Route::post('userpricings/get', 'UserPricingsTableController')->name('userpricings.get');
    });
    
});