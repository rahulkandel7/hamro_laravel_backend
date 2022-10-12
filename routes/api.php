<?php


use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\LoginRegisterController;
use App\Http\Controllers\Api\V1\OtherController;
use App\Http\Controllers\Api\V1\SubcategoryController;
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


Route::prefix('v1')->group(function () {
    Route::post('login', [LoginRegisterController::class, 'login']);
    Route::post('register', [LoginRegisterController::class, 'register']);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LoginRegisterController::class, 'logout']);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('subcategory', SubcategoryController::class);
    Route::get('user', [OtherController::class, 'getUser']);
});
