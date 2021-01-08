<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::put('posts/comments/{id}', [CommentController::class, 'update']);
Route::post('posts/comments', [CommentController::class, 'store']);
Route::get('posts/comments/{id}/edit', [CommentController::class, 'edit']);
Route::delete('posts/comments/{id}', [CommentController::class, 'delete']);
Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/table', [PostController::class, 'getPostTable'])->name('posts.table');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::Delete('posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::put('posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
