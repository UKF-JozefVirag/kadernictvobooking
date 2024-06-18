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

Route::group([
    "middleware" => ['auth:sanctum']
], function (){
   Route::post("logout", [AuthController::class, 'logout']);

   Route::get("profile", [UpdateProfile::class, 'getProfileInfo']);
   Route::patch("profile", [UpdateProfile::class, 'setProfileInfo']);

   Route::resource('orders', OrderController::class);
   Route::resource('employees', EmployeeController::class);
   Route::resource('services', ServiceController::class);
});

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');
