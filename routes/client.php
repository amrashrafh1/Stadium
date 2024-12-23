<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Client'], function () {
    Route::post('/logout', 'AuthController@logout');
    Route::get('/stadiums', 'StadiumController@index');
});

Route::group(['prefix' => 'reservations', 'namespace' => 'Client\Reservation'], function () {
    Route::get('/get-time-slots', 'ReservationController@getTimeSlots');
    Route::post('/book', 'ReservationController@reservation');
    Route::get('/', 'ReservationController@index');
    Route::get('/{id}', 'ReservationController@show');
});
