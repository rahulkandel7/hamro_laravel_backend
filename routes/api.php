<?php

use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\LoginRegisterController;
use App\Http\Controllers\Api\V1\OtherController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SubcategoryController;
use App\Http\Controllers\API\v1\User\FrontendController;
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
    Route::get('fetchCategory', [FrontendController::class, 'fetchCategory']);
    Route::get('fetchSubCategory', [FrontendController::class, 'fetchSubCategory']);
    Route::get('fetchBrand', [FrontendController::class, 'fetchBrand']);
    Route::get('category/product/{id}', [FrontendController::class, 'fetchByCategory']);
    Route::get('subcategory/product/{id}', [FrontendController::class, 'fetchBySubCategory']);
    Route::get('products', [FrontendController::class, 'loadAllProduct']);
    Route::get('product/view/{id}', [FrontendController::class, 'fetchProduct']);
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', [LoginRegisterController::class, 'logout']);
    Route::apiResource('category', CategoryController::class);
    Route::apiResource('subcategory', SubcategoryController::class);
    Route::apiResource('brand', BrandController::class);
    Route::apiResource('product', ProductController::class);
    Route::get('user', [OtherController::class, 'getUser']);
});
