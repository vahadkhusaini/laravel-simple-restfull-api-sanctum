<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

    Route::post('/login', 'API\AuthController@login');
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::post('/register', 'API\AuthController@register');
        Route::get('/logout', 'API\AuthController@logout');
        Route::get('/users', 'API\UserController@index');
        Route::resource('products', 'API\ProductController');
    });
