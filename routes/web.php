<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Seller\BookController;
use App\Http\Controllers\Admin\SellerApprovalController;
use App\Http\Controllers\Admin\UserListController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('users')->name('users.')->middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('{role}', [UserListController::class, 'index'])->name('index');
        // Route::get('{user}/edit', [UserListController::class, 'edit'])->name('edit');
        Route::post('add', [UserListController::class, 'store'])->name('add');
        Route::put('{user}/update', [UserListController::class, 'update'])->name('update');
        Route::patch('{user}/change-status', [UserListController::class, 'changeStatus'])->name('changeStatus');
        Route::post('{user}/remove', [UserListController::class, 'destroy'])->name('remove');

        Route::get('sellers/pending', [SellerApprovalController::class, 'index'])->name('sellers.pending');
        Route::post('sellers/{seller}/approve', [SellerApprovalController::class, 'approve'])->name('sellers.approve');
        Route::post('sellers/{seller}/reject', [SellerApprovalController::class, 'reject'])->name('sellers.reject');
    });
    // Route::prefix('books')->name('books.')->group(function () {
    //     Route::get('', [UserListController::class, 'index'])->name('index');
    // });
    Route::resource('books', BookController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);
});


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
