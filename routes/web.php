<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerRegistrationController;
use App\Http\Controllers\Seller\BookController as SellerBookController;
use App\Http\Controllers\Admin\SellerApprovalController;

Route::get('/', function() {
    return 'Welcome to Book Selling Platform!';
});

// Public seller registration
Route::get('seller/register', [SellerRegistrationController::class, 'show'])->name('seller.register');
Route::post('seller/register', [SellerRegistrationController::class, 'store'])->name('seller.register.store');


// Route::prefix('seller')->middleware('auth')->name('seller.')->group(function () {
Route::prefix('seller')->name('seller.')->group(function () {
    Route::resource('books', SellerBookController::class)->only(['index', 'create', 'store']);
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('sellers', [SellerApprovalController::class, 'index'])->name('sellers.index');
    Route::post('sellers/{seller}/approve', [SellerApprovalController::class, 'approve'])->name('sellers.approve');
    Route::post('sellers/{seller}/reject', [SellerApprovalController::class, 'reject'])->name('sellers.reject');
});



// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
