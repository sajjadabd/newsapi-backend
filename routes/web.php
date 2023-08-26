<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use \App\Http\Controllers\AuthController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\ArticleController;


Route::get('/', function () {
    return view('welcome');
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/validate-token', [AuthController::class, 'validateToken']);

Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/user', [AuthController::class, 'user']);

Route::get('/preferences', [UserController::class, 'getPreferences']);
Route::put('/preferences', [UserController::class, 'updatePreferences']);
Route::get('/articles', [ArticleController::class, 'getArticles']);

/*
Route::middleware('auth:api')->group(function () {
    Route::get('/preferences', 'UserController@getPreferences');
    Route::put('/preferences', 'UserController@updatePreferences');
    Route::get('/articles', 'ArticleController@getArticles');
});
*/



Route::middleware('auth:sanctum')->group(function () {
    
});