<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SellerRegistrationController;
use App\Http\Controllers\Seller\BookController as SellerBookController;
use App\Http\Controllers\Admin\SellerApprovalController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('users')->name('users.')->middleware(['auth', 'role:Admin'])->group(function () {
        // Route::get('sellers', [SellerApprovalController::class, 'index'])->name('sellers.index');
        Route::get('sellers/pending', [SellerApprovalController::class, 'index'])->name('sellers.pending');
        Route::post('sellers/{seller}/approve', [SellerApprovalController::class, 'approve'])->name('sellers.approve');
        Route::post('sellers/{seller}/reject', [SellerApprovalController::class, 'reject'])->name('sellers.reject');
    });
});

// // Public seller registration
// Route::get('seller/register', [SellerRegistrationController::class, 'show'])->name('seller.register');
// Route::post('seller/register', [SellerRegistrationController::class, 'store'])->name('seller.register.store');


// // Route::prefix('seller')->middleware('auth')->name('seller.')->group(function () {
// Route::prefix('seller')->name('seller.')->group(function () {
//     Route::resource('books', SellerBookController::class)->only(['index', 'create', 'store']);
// });


// Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
//     Route::get('sellers', [SellerApprovalController::class, 'index'])->name('sellers.index');
//     Route::post('sellers/{seller}/approve', [SellerApprovalController::class, 'approve'])->name('sellers.approve');
//     Route::post('sellers/{seller}/reject', [SellerApprovalController::class, 'reject'])->name('sellers.reject');
// });



// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
