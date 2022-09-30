<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\StudentController;
use \App\Http\Controllers\TrainerController;
use \App\Http\Controllers\TrainingCenterController;
use \App\Http\Controllers\AuthController;

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

Route::post('/pass-check', function () {
    return \Illuminate\Support\Facades\Hash::make('admin');
});

Route::post('/register/student', [StudentController::class, 'register']);
Route::post('/register/trainer', [TrainerController::class, 'register']);
Route::post('/register/training-center', [TrainingCenterController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::group(['middleware' => ['jwt.verify', 'training.center']], function () {
    Route::post('/create/trainer', [TrainingCenterController::class, 'createTrainer']);
    Route::delete('/delete/trainer/{id}', [TrainingCenterController::class, 'deleteTrainer']);
    Route::post('/update/trainer/{id}', [TrainingCenterController::class, 'updateTrainer']);
    Route::post('/trainers/list', [TrainingCenterController::class, 'listTrainers']);
    Route::post('/trainer/{id}', [TrainingCenterController::class, 'currentTrainer']);
});
