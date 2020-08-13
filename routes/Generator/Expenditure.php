<?php
/**
 * Expenditure
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Expenditure'], function () {
        Route::get('expenditures/userreward', 'ExpendituresController@userReward')->name('expenditures.userreward');
        Route::get('expenditures/partnerredemptions', 'ExpendituresController@partnerRedemptions')->name('expenditures.partnerredemptions');
        Route::resource('expenditures', 'ExpendituresController');
        //For Datatable
        Route::post('expenditures/get', 'ExpendituresTableController')->name('expenditures.get');
        Route::post('expenditures/getuserreward', 'ExpendituresTableController@getUserReward')->name('expenditures.getuserreward');
        Route::post('expenditures/partnerredemptions', 'ExpendituresTableController@partnerRedemptions')->name('expenditures.partnerredemptions');
    });
    
});