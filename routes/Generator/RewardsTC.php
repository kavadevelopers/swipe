<?php
/**
 * UserRewardsT&C
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {

    Route::group( ['namespace' => 'RewardsTC'], function () {
        Route::resource('rewardstcs', 'RewardsTCsController');
        //For Datatable
        Route::post('rewardstcs/get', 'RewardsTCsTableController')->name('rewardstcs.get');
    });

});