<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
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

Route::middleware(['auth:sanctum','admin'])->group(function(){
    Route::post('/products', [ProductController::class, 'store'])->middleware('auth:sanctum');

    //approve post
    Route::post('/post/approve', [PostController::class, 'approvePost']);
    Route::post('/post/reject', [PostController::class, 'rejectPost']);

    //get
    Route::get('/pending-posts', [PostController::class, 'pendingPosts']);

});
Route::get('/post/{id}/{status}', [PostController::class, 'userPosts'])->middleware('auth:sanctum');


// register new user
Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// get all products
Route::get('/products', [ProductController::class, 'index']); // ->middleware('auth:sanctum');
Route::get('/product/{product}', [ProductController::class, 'getProduct']); // ->middleware('auth:sanctum');

// Post
Route::post('/posts', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::delete('/post/{post}', [PostController::class, 'destroy'])->middleware('auth:sanctum');

// get posts
Route::get('/posts', [PostController::class, 'index']); //public route
Route::get('/post/{post}', [PostController::class, 'getPostById']); //public route

// show post
Route::get('/posts/{post_slug}', [PostController::class, 'show'])->middleware('auth:sanctum');

// edit post
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->middleware('auth:sanctum');

// comment to a post
Route::post('/post/comment', [CommentController::class, 'store'])->middleware('auth:sanctum');

