<?php
/**
 * PartnerPricing
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'PartnerPricing'], function () {
        Route::resource('partnerpricings', 'PartnerPricingsController');
        //For Datatable
        Route::post('partnerpricings/get', 'PartnerPricingsTableController')->name('partnerpricings.get');
    });
    
});