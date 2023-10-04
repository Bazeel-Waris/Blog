<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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


// Post Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/add-post', [PostController::class, 'store']);
    Route::get('/user-posts/{id}', [PostController::class, 'displayUserPosts']);
    Route::put('/edit-post/{id}', [PostController::class, 'editPost']);
    Route::delete('/delete-post/{id}', [PostController::class, 'deletePost']);

});
Route::get('/displayAll', [PostController::class, 'index']);

// Users Routes
Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user/{id}', [UserController::class, 'getUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);
});

// Comments Routes
Route::middleware('auth:sanctum')->group(function (){
    Route::post('/post/{post_id}/add-comment', [CommentController::class, 'createComment']);
    Route::delete('/post/{post_id}/comment/{id}', [CommentController::class, 'deleteComment']);
});

// Comments Routes
Route::get('/post/{post_id}/comments', [CommentController::class, 'getPostComments']);

// User Registration & User Login Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Admin Route
Route::middleware('auth:sanctum')->group(function (){
    Route::get('admin/users', [UserController::class, 'getAllUsers']);
    Route::get('admin/user/{id}', [UserController::class, 'getUser']);
    Route::put('admin/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('admin/delete-user/{id}', [UserController::class, 'deleteUser']);
});
