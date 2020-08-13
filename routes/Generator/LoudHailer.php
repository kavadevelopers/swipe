<?php
/**
 * LoudHailer/Marketing
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

    Route::group( ['namespace' => 'LoudHailer'], function () {
        Route::get('loudhailers/sendmail', 'LoudHailersController@sendMailForm')->name('loudhailers.sendmail');
        Route::post('loudhailers/sendmail', 'LoudHailersController@sendMail')->name('loudhailers.sendmail');
        Route::resource('loudhailers', 'LoudHailersController')->except([
            'edit', 'update', 'delete'
        ]);
        //For Datatable
        Route::post('loudhailers/get', 'LoudHailersTableController')->name('loudhailers.get');
    });

});