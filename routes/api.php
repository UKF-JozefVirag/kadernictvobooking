<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\QuickStatsController;
use App\Http\Controllers\UpdateProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::post('orders', [OrderController::class, 'store']);
Route::get('/getEmployeeOrders', [OrderController::class, 'getEmployeeOrders']);

Route::get('services', [ServiceController::class, 'index']);

Route::get('employees', [EmployeeController::class, 'index']);

//Route::get('/orders-by-date', [OrderController::class, 'getOrdersByDate']);

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

    Route::post('employees', [EmployeeController::class, 'store']);
    Route::patch('employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('employees/{employee}', [EmployeeController::class, 'destroy']);


    Route::post('services', [ServiceController::class, 'store']);
    Route::patch('services/{id}', [ServiceController::class, 'update']);
    Route::delete('services/{service}', [ServiceController::class, 'destroy']);

    Route::get('orders',  [OrderController::class, 'index']);
    Route::delete('orders/{order}', [OrderController::class, 'destroy']);

    Route::get('stats/orders', [QuickStatsController::class, 'getOrders']);
    Route::get('stats/revenue', [QuickStatsController::class, 'getRevenue']);
    Route::get('stats/latest-orders', [QuickStatsController::class, 'getLatestOrders']);
    Route::get('stats/getEmployeeValue', [QuickStatsController::class, 'getMostValuableEmployees']);
    Route::get('stats/getNewCustomers', [QuickStatsController::class, 'getNewCustomers']);


});
