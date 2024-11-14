<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Client'], function () {
    Route::post('/logout', 'AuthController@logout');
    Route::get('/stadiums', 'StadiumController@index');
});

Route::group(['prefix' => 'reservations', 'namespace' => 'Client\Reservation'], function () {
    Route::post('/get-time-slots', 'ReservationController@getTimeSlots');
    Route::post('/reservation', 'ReservationController@reservation');
    Route::get('/', 'ReservationController@index');
    Route::get('/{id}', 'ReservationController@show');
});
