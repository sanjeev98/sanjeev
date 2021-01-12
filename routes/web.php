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




//Route::get('dashboard1', function(){
//    return view('posts.dashboard');
//});
//
////Route::get('posts/{id}/show', [CommentController::class,'show']);
//
Route::get('get-post', [RoleController::class,'getdata'])->name('roles.get');
Route::get('get-user', [UserController::class,'getdata'])->name('roles.table');
Route::resource('roles',RoleController::class);
Route::resource('users',UserController::class);
Route::resource('posts',PostController::class);
//Route::get('/home',[HomeController::class,'index'])->name('home');
//Route::put('posts/comments/{id}', [CommentController::class,'update']);
////Route::resource('posts', PostController::class);
//Route::post('posts/comments/{id}', [CommentController::class,'store']);
//Route::get('posts/comments/{id}/edit', [CommentController::class,'edit']);
//Route::delete('posts/comments/{id}', [CommentController::class,'delete']);
////Route::get('posts',[PostController::class,'index'])->name('posts.index');
////Route::post('posts',[PostController::class,'store'])->name('posts.store');
////Route::get('posts/create',[PostController::class,'create'])->name('posts.create');
////Route::Delete('posts/{id}',[PostController::class,'destroy'])->name('posts.destroy');
////Route::put('posts/{id}',[PostController::class,'update'])->name('posts.update');
////Route::get('posts/{id}',[PostController::class,'show'])->name('posts.show');
////Route::get('posts/{id}/edit',[PostController::class,'edit'])->name('posts.edit');

