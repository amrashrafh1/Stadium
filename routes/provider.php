<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'auth', 'namespace' => 'Provider\Auth'], function () {
        Route::post('/logout', 'AuthController@logout');
    });
    Route::group(['middleware' => 'PackageCheckMiddleware'], function () {
        Route::group(['prefix' => 'auth/profile', 'namespace' => 'Provider\Profile'], function () {
            Route::get('/', 'ProfileController@show');
            Route::put('/', 'ProfileController@update');
            Route::delete('/delete', 'ProfileController@destroy');
            Route::post('mobile/change', 'ChangeMobileController@changeMobile');
            Route::post('mobile/resend', 'ChangeMobileController@resend');
            Route::post('mobile/verify', 'ChangeMobileController@verify');
            Route::put('mobile/update', 'ChangeMobileController@updateMobile');
            Route::put('/change-password', 'ProfileController@changePassword');
            Route::get('/banks', 'ProfileController@getBanks');
            Route::put('/bank-setting', 'ProfileController@bankSetting');
        });


        Route::group(['namespace' => 'Provider'], function () {
            Route::delete('/images/{id}', 'ProviderController@deleteImage');
            Route::get('/services/main', 'ServiceController@main');
            Route::put('/services/{id}/toggle-status', 'ServiceController@toggleStatus');
            Route::apiResource('services', 'ServiceController');

            Route::group(['prefix' => 'salons'], function () {
                Route::get('/', 'ProviderController@index');
                Route::get('/show', 'ProviderController@show');
                Route::put('/', 'ProviderController@update');
                Route::put('/{id}/toggle-status', 'ProviderController@toggleStatus');
                Route::put('/{id}/toggle-is-active', 'ProviderController@toggleIsActive');
                Route::delete('/{id}', 'ProviderController@destroy');
            });

            Route::put('/barbers/{id}/toggle-status', 'BarberController@toggleStatus');
            Route::apiResource('barbers', 'BarberController');
            Route::apiResource('reservations', 'ReservationController')->except('destroy');
            Route::put('/reservations/{id}/toggle-status', 'ReservationController@toggleStatus');
            Route::post('/get-barber-time-slots', [\App\Http\Controllers\API\Client\Reservation\ReservationController::class, 'getBarberDateTimeSlots']);
            Route::group(['prefix' => 'schedules'], function () {
                Route::get('/buffer-times', 'BufferTimeController@index');
                Route::post('/buffer-times', 'BufferTimeController@store');
                Route::get('/buffer-times/{id}', 'BufferTimeController@show');
                Route::put('/buffer-times/{id}', 'BufferTimeController@update');
                Route::delete('/buffer-times/{id}', 'BufferTimeController@destroy');
            });

            Route::group(['prefix' => 'wallet'], function () {
                Route::get('/balance', 'WalletController@get_wallet_balance');
                Route::get('/transactions', 'WalletController@wallet_transactions');
                Route::get('/transactions/{id}', 'WalletController@show_wallet_transactions');
            });

            Route::get('home', 'HomeController@index');
        });
    });

    Route::group(['namespace' => 'General'], function () {
        Route::get('notifications', 'NotificationController@index');
        Route::get('read-notifications', 'NotificationController@readNotifications');
    });
    Route::group(['prefix' => 'packages', 'namespace' => 'Provider'], function () {
        Route::get('/', 'SubscriptionController@packages')->name('packages.index');
        Route::post('/subscribePackage', 'SubscriptionController@subscribe')->name('packages.index');
        Route::get('/activeSubscribedPackage', 'SubscriptionController@my_subscription')->name('packages.index');
    });

});
