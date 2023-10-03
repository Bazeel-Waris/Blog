<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    // Route::apiResource('posts', PostController::class);
    // Post Creation Route
    Route::post('/add-post', [PostController::class, 'store']);
    Route::get('/displayAll', [PostController::class, 'index']);
    Route::get('/user-posts/{id}', [PostController::class, 'displayUserPosts']);
    Route::put('/edit-post/{id}', [PostController::class, 'editPost']);
    Route::delete('/delete-post/{id}', [PostController::class, 'deletePost']);

});

Route::middleware('auth:sanctum')->group(function (){

    // Users Routes
    Route::get('/user/{id}', [UserController::class, 'getUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
});

// Users Routes
Route::get('/users', [UserController::class, 'getAllUsers']);

// User Registration & User Login Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


