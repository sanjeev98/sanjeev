<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\postedController;

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
Route::get('home',[PostController::class,'index'])->name('home');
Route::get('users',[PostController::class,'getData'])->name('get.users');


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
//Route::resource('products', postedController::class);
Route::get('/add-post',[PostController::class,'addPost'])->middleware('auth');
Route::post('/create-post',[PostController::class,'createPost'])->name('post.create')->middleware('auth');
Route::get('/posts',[PostController::class,'getPost'])->middleware('auth');
Route::get('/posts/{id}',[PostController::class,'getPostById'])->middleware('auth');
Route::get('/delete-post/{id}',[PostController::class,'deletePost'])->middleware('auth');
Route::get('/edit-post/{id}',[PostController::class,'editPost'])->middleware('auth');
Route::post('/update-post',[PostController::class,'updatePost'])->name('post.updated')->middleware('auth');
