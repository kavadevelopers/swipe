<?php
/**
 * Policies
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

    Route::group( ['namespace' => 'Policies'], function () {

        Route::resource('policies', 'PoliciesController')->except([
            'index', 'create', 'store', 'destroy'
        ]);

        // //For Datatable
        // Route::post('policies/get', 'PoliciesTableController')->name('policies.get');
    });

});