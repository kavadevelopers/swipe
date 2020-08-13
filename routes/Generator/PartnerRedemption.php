<?php
/**
 * PartnerRedemption
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'PartnerRedemption'], function () {
        Route::resource('partnerredemptions', 'PartnerRedemptionsController');
        //For Datatable
        Route::post('partnerredemptions/get', 'PartnerRedemptionsTableController')->name('partnerredemptions.get');
        Route::post('partnerredemption/pdf', 'PartnerRedemptionsController@generatePdf')->name('partnerredemptions.pdf');
        Route::post('partnerredemption/processed', 'PartnerRedemptionsController@processed')->name('partnerredemptions.processed');
        Route::get('partnerredemption/history', 'PartnerRedemptionsController@getHistory')->name('partnerredemptions.history');
        Route::post('partnerredemptions/gethistory', 'PartnerRedemptionsTableController@getHistory')->name('partnerredemptions.gethistory');


        Route::get('partnerredemption/onbordingindex', 'PartnerRedemptionsController@onbordingIndex')->name('partnerredemptions.onbording');
        Route::post('partnerredemptions/onbordingget', 'PartnerRedemptionsTableController@getOnboarding')->name('partnerredemptions.onbordingget');
        
        Route::get('partnerredemption/onbordinghistory', 'PartnerRedemptionsController@getOnboardingHistory')->name('partnerredemptions.onbordinghistory');
        Route::post('partnerredemption/onbordinggethistory', 'PartnerRedemptionsTableController@onboardGetHistory')->name('partnerredemptions.onbordinggethistory');


    });
    
});