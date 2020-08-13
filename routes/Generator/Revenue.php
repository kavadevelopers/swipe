<?php
/**
 * Revenue
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Revenue'], function () {
        Route::post('revenues/get', 'RevenuesTableController')->name('revenues.get');
        
        Route::get('revenues/userbooking', 'RevenuesController@userBooking')->name('revenues.userbooking');
        Route::post('revenues/getbooking', 'RevenuesController@getBooking')->name('revenues.getbooking');
        
        Route::get('revenues/viewuserbooking/{id}', 'RevenuesController@viewBooking')->name('revenues.viewbooking');
        Route::resource('revenues', 'RevenuesController');
        //For Datatable
    });
    
});