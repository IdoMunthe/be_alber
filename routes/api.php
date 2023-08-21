<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ForkliftController;
use App\Http\Controllers\Api\ExcavatorController;
use App\Http\Controllers\Api\WheelLoaderController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// user
Route::get('/users', [UserController::class, 'index']);
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

Route::get('/forklift', [ForkliftController::class, 'index']);
Route::post('/forklift', [ForkliftController::class, 'store']);

Route::get('/excavator', [ExcavatorController::class, 'index']);
Route::post('/excavator', [ExcavatorController::class, 'store']);

Route::get('/wheelLoader', [WheelLoaderController::class, 'index']);
Route::post('/wheelLoader', [WheelLoaderController::class, 'store']);

Route::put('/status', [StatusController::class, 'status']);