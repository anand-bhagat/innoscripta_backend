<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth:sanctum'], function () {
    // Protected routes that require authentication

    Route::post('/feed', [FeedController::class, 'saveFeed']);
    Route::get('/feed', [FeedController::class, 'getFeed']);

    // Get the authenticated user's details
    Route::get('/user', [UserController::class, 'getUser']);

    // Logout the authenticated user
    Route::post('/logout', [UserController::class, 'logout']);
});

// Unprotected routes for authentication
Route::prefix('news')->group(function () {
    Route::post('/', [NewsController::class, 'getNews']);
    Route::get('/categories', [NewsController::class, 'getCategories']);
});

Route::post('/register', [RegisterController::class, 'register']);

//Login with email and password
Route::post('/login', [LoginController::class, 'login']);
