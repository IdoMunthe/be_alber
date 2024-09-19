<?php

use App\Http\Controllers\api\AlberController;
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
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');

//SUBMISSION TRACKING
// status update
Route::middleware('auth:sanctum')->group(function () {
    //log out
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // updating status of each heavy equipment
    Route::put('/history-order', [StatusController::class, 'historyOrder']);

    // New Requset Feature || united alber in database (scroll below to compare)
    Route::post('/request-alber', [AlberController::class, 'requestAlber']);

    // To auto-increment no. order
    Route::get('/next-order/{jenis_alber}', [AlberController::class, 'getNextOrder']);

    // Admin_pcs 'Manage Alber'
    Route::put('/manage-alber', [AlberController::class, 'manageAlber']);

    // Getting Alber
    Route::get('/user-albers', [AlberController::class, 'getAlberForUser']);

    // Getting Specific Alber
    Route::get('/alber/{id}', [AlberController::class, 'getAlberById']);

    Route::get('/user-info', [UserController::class, 'getUserInfo']);
});

Route::get('/check-extensions', function () {
    $extensions = [
        'pdo_mysql',
        'mbstring',
        'openssl',
        'xml',
        'ctype',
        'fileinfo',
    ];

    $missing = array_filter($extensions, function ($ext) {
        return !extension_loaded($ext);
    });

    return count($missing) > 0 ? $missing : 'All required PHP extensions are installed';
});




















// New Requset Feature || per alber
Route::get('/wheelLoader', [WheelLoaderController::class, 'index']);
Route::post('/wheelLoader', [WheelLoaderController::class, 'store']);

Route::get('/excavator', [ExcavatorController::class, 'index']);
Route::post('/excavator', [ExcavatorController::class, 'store']);

Route::get('/forklift', [ForkliftController::class, 'index']);
Route::post('/forklift', [ForkliftController::class, 'store']);
