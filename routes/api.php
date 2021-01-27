<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\V1\UserApiController as v1UserApiController;
use App\Http\Controllers\Api\Auth\AuthApiController;
use App\Http\Controllers\api\Auth\PostController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthApiController::class, 'login']);
    Route::post('logout', [AuthApiController::class, 'logout']);
    Route::post('refresh', [AuthApiController::class, 'refresh']);
    Route::post('me', [AuthApiController::class, 'me']);
    Route::prefix('v1')->group(function () {
        Route::get('/users/{id}', [V1UserApiController::class, 'getPost']);
        Route::apiResource('posts',PostController::class);
    });
});
Route::get('/users/{id}', [UserApiController::class, 'getPost']);
