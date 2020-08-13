<?php
/**
 * Partnerfaq
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Partnerfaq'], function () {
        Route::resource('partnerfaqs', 'PartnerfaqsController');
        //For Datatable
        Route::post('partnerfaqs/get', 'PartnerfaqsTableController')->name('partnerfaqs.get');
    });
    
});