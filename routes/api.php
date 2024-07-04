<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UpdateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('orders', [OrderController::class, 'store']);
Route::get('services', [ServiceController::class, 'index']);
Route::get('employees', [EmployeeController::class, 'index']);

Route::get('/orders-by-date', [OrderController::class, 'getOrdersByDate']);

Route::middleware('auth:sanctum')->get('user', function () {
    return auth()->user();
});
Route::group([
    "middleware" => ['auth:sanctum']
], function () {
    Route::post("logout", [AuthController::class, 'logout']);
    Route::get('/validateToken', [AuthController::class, 'validateToken']);
   Route::get("profile", [UpdateProfile::class, 'getProfileInfo']);
    Route::patch("profile", [UpdateProfile::class, 'setProfileInfo']);


    Route::get("profile", [UpdateProfile::class, 'getProfileInfo']);
    Route::get('orders',  [OrderController::class, 'index']);
   Route::post('employees', [EmployeeController::class, 'store']);
   Route::post('services', [ServiceController::class, 'store']);
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
