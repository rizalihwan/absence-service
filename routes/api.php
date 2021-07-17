<?php
date_default_timezone_set('Asia/Jakarta');
use Illuminate\Support\Facades\Route;

Route::namespace('Api')->middleware('auth:api')->group(function(){
    // authentication endpoint
    Route::post('/register', 'AuthController@register')->withoutMiddleware('auth:api');
    Route::post('/login', 'AuthController@login')->withoutMiddleware('auth:api');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'AuthController@me');

    // epresence endpoint
    Route::prefix('epresence')->group(function(){
        Route::post('/make-attendance', 'EpresenceController@attendance');
        Route::get('/{id}/show', 'EpresenceController@show');
    });
});
