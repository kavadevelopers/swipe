<?php
/**
 * Vehicle
 *
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    
    Route::group( ['namespace' => 'Vehicle'], function () {
        //For Datatable
        Route::post('vehicles/get', 'VehiclesTableController')->name('vehicles.get');
        
        Route::get('system/vehicles/brand', 'VehiclesController@brand')->name('vehicles.brand');
        Route::post('brand/create', 'VehiclesController@brandCreate')->name('brand.create');
        
        Route::get('system/vehicles/model', 'VehiclesController@model')->name('vehicles.model');
        Route::post('model/create', 'VehiclesController@modelCreate')->name('model.create');
        
        Route::get('system/vehicles/vehicaltype', 'VehiclesController@vehicle')->name('vehicles.vehicaltype');
        Route::post('vehicle/create', 'VehiclesController@vehicleCreate')->name('vehicle.create');
        Route::resource('system/vehicles', 'VehiclesController');
    });
    
});