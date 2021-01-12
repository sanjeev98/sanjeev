<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\api\v1\UserApiController as v1UserApiController;
use App\Http\Controllers\api\v1\PostController;
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

    Route::post('login', [v1UserApiController::class,'login']);
    Route::post('logout', [v1UserApiController::class,'logout']);
    Route::post('refresh', [v1UserApiController::class,'refresh']);
    Route::post('me', [v1UserApiController::class,'me']);
    Route::prefix('v1')->group(function () {
        Route::get('/users/{id}', [v1UserApiController::class,'getPost']);
        Route::apiResource('posts',PostController::class);
    });

});

Route::get('/users/{id}', [UserApiController::class,'getPost']);

