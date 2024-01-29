<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\CreditPointController;
use App\Http\Controllers\Backend\DeliveryFeeController;
use App\Http\Controllers\Backend\EventController;
use App\Http\Controllers\Backend\MemberSubscribeController;
use App\Http\Controllers\Backend\OrderPointController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\PromotionController;
use App\Http\Controllers\Backend\RegionController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\LibraryBookController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\TestController;
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
    return redirect()->route('login');
});
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth','isAdmin'])->group(function(){
    Route::resources([
        'banner' => BannerController::class,
        'category' => CategoryController::class,
        'book' => BookController::class,
        'genre' => GenreController::class,
        'library-book' => LibraryBookController::class,
        'rent' => RentController::class,
        'opportunities' => OpportunityController::class,
        'packages' => PackageController::class,
        'payments' => PaymentController::class,
        'regions' => RegionController::class,
        'delivery-fees' => DeliveryFeeController::class,
        'members' => MemberController::class,
        'credit-points' => CreditPointController::class,
        'order-points' => OrderPointController::class,
        'events' => EventController::class,
        'promotions' => PromotionController::class,
    ]);
    Route::get('/rent-pending', [RentController::class, 'pending'])->name('rent.pending');
    Route::get('/rent-confirmed', [RentController::class, 'confirmed'])->name('rent.confirmed');
    Route::get('/rent-reserved', [RentController::class, 'reserved'])->name('rent.reserved');

    Route::post('/import-books', [BookController::class, 'importBooks'])->name('import.books');

    Route::get('/book-status',[BookController::class,'bookStatus']);
    Route::get('/member-request',[MemberController::class,'member.request']);
    Route::get('/users',[AdminController::class,'users'])->name('user.index');
    Route::get('/member-request',[AdminController::class,'memberRequest'])->name('member.request');
    Route::get('/accept-member/{id}',[AdminController::class,'acceptMember'])->name('member.accept');

    Route::get('/package-subscribe', [MemberSubscribeController::class, 'index'])->name('subscribe.index');
    Route::get('/package-subscribe/{id}', [MemberSubscribeController::class, 'edit'])->name('subscribe.edit');
    Route::put('/package-subscribe/{id}', [MemberSubscribeController::class, 'update'])->name('subscribe.update');
    Route::delete('/package-subscribe/{id}', [MemberSubscribeController::class, 'destroy'])->name('subscribe.delete');

    Route::get('/rent-books',[AdminController::class,'rentBooks'])->name('rent.book');
    Route::get('/book-return/{id}',[AdminController::class,'returnBook'])->name('book.return');
    Route::get('/rent-book-list/{id}',[AdminController::class,'rentBookList'])->name('rent-book-list');
    Route::get('/rent-accept/{id}',[AdminController::class,'acceptRent'])->name('rent.accept');
    Route::get('/user-rent/{id}',[AdminController::class,'userRent'])->name('user.rent');

    Route::get('/change-password',[AdminController::class,'changePassword'])->name('change-password');
    Route::get('/update-password',[AdminController::class,'updatePassword'])->name('update-password');
    Route::get('/ban-user/{id}',[AdminController::class,'banUser'])->name('ban.user');
    Route::get('/restore-user{id}',[AdminController::class,'restoreUser'])->name('restore.user');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings/change/{id}', [SettingController::class, 'changeSetting'])->name('settings.change');
    Route::post('/settings/change-day', [SettingController::class, 'changeDay'])->name('settings.changeDay');
});

Route::get('/privacy-policy',function(){
    return view('privacy-policy');
})->name('privacyPolicy');


Route::get('test', [TestController::class, 'test']);
