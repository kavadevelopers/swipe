<?php
/**
 * UsersList
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

    Route::group( ['namespace' => 'UsersList'], function () {
        Route::resource('userlists', 'UserListsController')->except([
            'create', 'store', 'edit', 'update', 'destroy'
        ]);
        //For Datatable
        Route::post('userlists/get', 'UserListsTableController')->name('userlists.get');

        Route::get('userlists/{userlist}/activities', 'UserListsController@userActivities')->name('userlists.activities');
        Route::post('userlists/{userlist}/activities', 'UserListsController@userActivitiesDatatable')->name('userlists.get-activities');

        Route::get('partnerlists', 'UserListsController@showPartnerList')->name('partnerlists.index');
        Route::post('partnerlists/get', 'UserListsController@getPartnerList')->name('partnerlists.get');
        Route::get('partnerlists/{partner}/activities', 'UserListsController@partnerActivities')->name('partnerlists.activities');

        Route::put('userlists/{bookingId}/cancel', 'UserListsController@cancelBooking')->name('userlists.activity.cancel');
    });

});