<?php

use App\Http\Controllers\Comment;
use App\Http\Controllers\Photo;
use App\Http\Controllers\User;
use App\Http\Controllers\Post;
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

Route::get('/', function () {
    return view('welcome');
});

Route::controller(User::class)->prefix("users")->group(function(){
    Route::get('{id?}', 'show');
    Route::post('/', 'insert');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'delete');
});

Route::controller(Photo::class)->prefix("photos")->group(function(){
    Route::get('{id?}', 'show');
    Route::post('/', 'insert');
});

Route::controller(Post::class)->prefix("posts")->group(function(){
    Route::get('{id?}', 'show');
    Route::get('{id}/comments', 'showComments');
    Route::post('/', 'insert');
    Route::put('{id}', 'update');
    Route::delete('{id}', 'delete');
});

Route::controller(Comment::class)->prefix("comments")->group(function(){
    Route::get('{id?}', 'show');
    Route::post('/', 'insert');
    Route::delete('{id}', 'delete');
});