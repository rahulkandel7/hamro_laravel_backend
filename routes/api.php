<?php

use App\Http\Controllers\Api\V1\BannerController;
use App\Http\Controllers\Api\V1\BrandController;
use App\Http\Controllers\Api\V1\CartController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\CouponController;
use App\Http\Controllers\Api\V1\LoginRegisterController;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\OtherController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\RatingController;
use App\Http\Controllers\Api\V1\ShippingController;
use App\Http\Controllers\Api\V1\SubcategoryController;
use App\Http\Controllers\Api\V1\TopPicksController;
use App\Http\Controllers\Api\V1\User\FrontendController;
use App\Http\Controllers\Api\V1\User\OrderController as UserOrderController;
use App\Http\Controllers\Api\V1\User\WishlistController;
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
    Route::get('fetchbanner', [FrontendController::class, 'fetchBanner']);
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
    Route::apiResource('wishlist', WishlistController::class);
    Route::apiResource('cart', CartController::class);
    Route::apiResource('banner', BannerController::class);
    Route::apiResource('coupon', CouponController::class);
    Route::get('user', [OtherController::class, 'getUser']);
    Route::post('cart/update/{id}', [CartController::class, 'updateQuantity']);
    Route::post('cart/update/ordered/{id}', [CartController::class, 'updateOrdered']);
    Route::apiResource('shipping', ShippingController::class);
    Route::apiResource('rating', RatingController::class);
    Route::get('rating/product/{id}', [RatingController::class, 'findRating']);
    Route::get('/coupons', [FrontendController::class, 'fetchCoupon']);
    Route::apiResource('comment', CommentController::class);
    Route::get('comment/product/{id}', [CommentController::class, 'findComment']);
    Route::post('user/update', [OtherController::class, 'updateUser']);
    Route::post('user/changepass', [OtherController::class, 'changePassword']);
    Route::post('order/store', [OrderController::class, 'store']);
    Route::get('order/{status}', [OrderController::class, 'index']);
    Route::get('ordercart/{orderid}', [OrderController::class, 'order_cart']);
    Route::get('order/update/{orderid}/{status}', [OrderController::class, 'update_order']);
    Route::post('order/update', [OrderController::class, 'update_cancelled_order']);
    // Route::get('order/cart/update/{cartid}/{status}', [OrderController::class, 'update_cart']);
    Route::get('order/delete', [OrderController::class, 'delete']);
    Route::get('dashboard', [OtherController::class, 'dashboard']);

    //UserOrder
    Route::get('/user/order',[UserOrderController::class, 'show_order']);

    //Top Picks
    Route::get('/toppicks',[TopPicksController::class,'top_picks']);
});
