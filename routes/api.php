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
    Route::get('/displayPosts/{id}', [PostController::class, 'displayUserPost']);

});

Route::middleware('auth:sanctum')->group(function (){

});
// User Registration & User Login Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);


