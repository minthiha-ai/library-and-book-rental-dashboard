<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\RegionController;
use App\Http\Controllers\Api\NewAuthController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CreditPointController;
use App\Http\Controllers\Api\DeliveryFeeController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\MemberSubscribeController;
use App\Http\Controllers\Api\PreorderController;
use App\Http\Controllers\Api\RentController;
use App\Http\Controllers\Api\UserController;

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

Route::prefix('v1')->middleware('auth:api')->group(function() {
    Route::post('subscribe-package', [MemberSubscribeController::class, 'subscribe']);
    Route::post('rent-book', [RentController::class,'rent']);
    Route::post('return-book', [RentController::class, 'returnBook']);
    Route::post('add-member', [ApiController::class,'addMember']);
    Route::get('member', [MemberController::class, 'getData']);
    Route::get('member/order-histories', [MemberController::class, 'getOrderHistories']);

    Route::post('pre-order', [PreorderController::class, 'preOrder']);

    Route::get('user', [UserController::class,'index']);
    Route::put('user', [UserController::class,'update']);
    Route::put('user/update-password', [UserController::class,'updatePassword']);
    // Route::post('rent-book', [ApiController::class,'rentBook']);

    Route::post('check', [NewAuthController::class, 'check']);
});



Route::prefix('v1')->group(function (){
    // Route::post('login', [AuthController::class,'login']);
    // Route::post('register', [AuthController::class,'register']);
    // Route::post('logout', [AuthController::class,'logout'])->middleware('auth:api');

    Route::get('books', [BookController::class, 'index']);
    Route::get('books/{id}', [BookController::class, 'detail']);
    Route::get('books/category/{id}', [BookController::class, 'getBookByCategory']);
    Route::get('books/genres/get', [BookController::class, 'getBookByGenres']);

    Route::get('packages', [PackageController::class, 'index']);
    Route::get('packages/{id}', [PackageController::class, 'detail']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('genres', [GenreController::class, 'index']);
    Route::get('banners', [BannerController::class, 'index']);

    //regions & cash on delivery
    Route::get('regions',[RegionController::class,'list']);
    Route::get('regions/{id}',[RegionController::class,'detail']);

    Route::get('delivery-fees',[DeliveryFeeController::class,'list']);
    Route::get('delivery-fees/{id}',[DeliveryFeeController::class,'detail']);
    Route::get('delivery-fees/regions/{regionId}',[DeliveryFeeController::class,'deliveryFeeByRegion']);

    //payments
    Route::get('payments', [PaymentController::class,'index']);
    Route::get('credit-points', [CreditPointController::class, 'index']);
    Route::post('purchase-points', [CreditPointController::class, 'purchase'])->middleware('auth:api');

});

Route::prefix('auth')->group(function() {
    Route::post('login', [NewAuthController::class, 'login']);
    Route::post('register', [NewAuthController::class, 'register']);
    Route::post('forgot-password', [NewAuthController::class, 'forgotPassword']);
    Route::post('verify-otp', [NewAuthController::class, 'verifyOtp']);
    Route::post('verify-login-otp', [NewAuthController::class, 'verifyLoginOtp']);
    Route::post('verify-forgot-otp', [NewAuthController::class, 'verifyForgotOtp']);
    Route::post('resend-otp', [NewAuthController::class, 'resendOtp']);
    Route::middleware('auth:api')->post('logout', [NewAuthController::class, 'logout']);
    Route::middleware('auth:api')->delete('user', [NewAuthController::class, 'deleteUser']);
});


