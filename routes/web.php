<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::post('api/register', 'AuthController@register');
//Route::post('api/login', 'AuthController@login');
//Route::post('api/login', [AuthController::class, 'login']);

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('user', function () {
    return auth()->user();
});
