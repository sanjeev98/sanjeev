<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

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

Route::get('dashboard', function(){
    return view('posts.dashboard');
});

Route::get('get-role', [RoleController::class, 'getRoleData'])->name('roles.get');
Route::get('get-post', [PostController::class, 'getPostTable'])->name('posts.table');
Route::get('get-user', [UserController::class, 'getUserData'])->name('roles.table');
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('posts', PostController::class);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::put('posts/comments/{id}', [CommentController::class, 'update']);
Route::post('posts/comments', [CommentController::class, 'store']);
Route::get('posts/comments/{id}/edit', [CommentController::class, 'edit']);
Route::delete('posts/comments/{id}', [CommentController::class, 'delete']);
