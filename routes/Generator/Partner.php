<?php
/**
 * Partners
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Partners'], function () {
        
        //For Datatable
        Route::get('partners/pending', 'PartnersController@pendingPartners')->name('partners.pending');
        Route::get('partners/confirm', 'PartnersController@confirmPartners')->name('partners.confirm');
        Route::get('partners/history', 'PartnersController@historyPartners')->name('partners.history');
        Route::post('partners/get', 'PartnersTableController')->name('partners.get');
        Route::post('partners/pending', 'PartnersTableController@pendingPartners')->name('partners.pending.get');
        Route::post('partners/confirm', 'PartnersTableController@confirmPartners')->name('partners.confirm.get');
        Route::post('partners/history', 'PartnersTableController@historyPartners')->name('partners.history.get');
        
        Route::post('partner/status', 'PartnersController@updateStatus')->name('partners.statusupdate');
        
        Route::resource('partners', 'PartnersController');
    });
    
});