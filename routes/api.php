<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ArticleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



Route::middleware('mustBeLoggedInWithBearerToken')->group(function () {


    Route::post('/validate-token', [AuthController::class, 'validateToken']);
    Route::post('/logout', [AuthController::class, 'logout']);




    Route::post('/preferences', [UserController::class, 'getPreferences']);
    Route::put('/preferences', [UserController::class, 'updatePreferences']);
    Route::post('/articles', [ArticleController::class, 'getArticles']);
});
