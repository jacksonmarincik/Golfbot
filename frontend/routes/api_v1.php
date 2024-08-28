<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\SampleDataController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Sample API route
//Route::get('/profits', [SampleDataController::class, 'profits'])->name('profits');

//Route::post('/register', [RegisteredUserController::class, 'apiStore']);

//Route::post('/login', [AuthenticatedSessionController::class, 'apiStore']);

Route::post('/forgot_password', [PasswordResetLinkController::class, 'apiStore']);

Route::post('/verify_token', [AuthenticatedSessionController::class, 'apiVerifyToken']);

Route::get('/users', [SampleDataController::class, 'getUsers']);

Route::post('/login', 'AuthController@login');
Route::post('/usertaskLogin', 'AuthController@usertaskLogin');

Route::post('/register', 'AuthController@register');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/task-detail', 'TaskController@taskDetail');
    Route::post('/task-start-stop', 'TaskController@taskStartStop');
    Route::post('/get-task-comment', 'TaskController@getTaskComments');
    Route::post('/submit-task-comment', 'TaskController@submitTaskComments');
});