<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API;

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

Route::post('signin', [API\AuthController::class, 'signin'])->name('login');
Route::post('signup', [API\AuthController::class, 'signup']);

Route::get('posts', [API\PostController::class, 'index']);
Route::get('posts/{post}', [API\PostController::class, 'show']);

Route::get('posts/{post}/comments', [API\CommentController::class, 'index']);
Route::get('posts/{post}/comments/{comment}', [API\CommentController::class, 'show']);

//routes with auth
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::post('posts', [API\PostController::class, 'store']);
    Route::put('posts/{post}', [API\PostController::class, 'update']);
    Route::delete('posts/{post}', [API\PostController::class, 'delete']);

    Route::post('posts/{post}/comments', [API\CommentController::class, 'store']);
    Route::put('posts/{post}/comments/{comment}', [API\CommentController::class, 'update']);
    Route::delete('posts/{post}/comments/{comment}', [API\CommentController::class, 'delete']);

    Route::post('posts/{post}/upvote', [API\VoteController::class, 'upvote']);
    Route::post('posts/{post}/downvote', [API\VoteController::class, 'downvote']);
});