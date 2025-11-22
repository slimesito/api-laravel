<?php

use Illuminate\Support\Facades\Route;

// Auth Routes
Route::group(['prefix' => 'auth'], function ($router) {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

// Resource Routes (Protegidos por Middleware en el constructor del controlador)
Route::apiResource('authors', 'AuthorController');
Route::get('authors-export', 'AuthorController@export');

Route::apiResource('books', 'BookController');
Route::get('books-export', 'BookController@export');
