<?php

use App\Http\Controllers\AlberVisualizationController;
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

    // Route to get all visualizations
    Route::get('/alber-visualizations', [AlberVisualizationController::class, 'index']);
    
    // Route to update the color of a specific alber_id
    Route::put('/alber-visualizations/{id}', [AlberVisualizationController::class, 'update']);

    // get alber status by id
    Route::get('/alber-status/{id}', [StatusController::class, 'getAlberStatusById']);

    // get alber that are already finished
    Route::get('/alber-finished', [StatusController::class, 'getFinishedAlbers']);

    // to add no_lambung and operator
    Route::put('/nomor-lambung-dan-operator/{id}', [AlberController::class, 'addNomorLambungAndNamaOperator']);

    // to get no_lambung and operator of certain alber
    Route::get('/nomor-lambung-dan-operator/{id}', [AlberController::class, 'getNomorLambungAndNamaOperator']);
});


















// New Requset Feature || per alber
// Route::get('/wheelLoader', [WheelLoaderController::class, 'index']);
// Route::post('/wheelLoader', [WheelLoaderController::class, 'store']);

// Route::get('/excavator', [ExcavatorController::class, 'index']);
// Route::post('/excavator', [ExcavatorController::class, 'store']);

// Route::get('/forklift', [ForkliftController::class, 'index']);
// Route::post('/forklift', [ForkliftController::class, 'store']);
