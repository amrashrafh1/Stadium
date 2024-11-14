<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'client', 'namespace' => 'Client'], function () {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/verify-account', 'AuthController@verifyAccount');
});

Route::group(['prefix' => 'provider/auth', 'namespace' => 'Provider\Auth'], function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('/verify-account', 'AuthController@verifyOtp');
});

