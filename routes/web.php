<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Seller\BookController;
use App\Http\Controllers\Admin\SellerApprovalController;
use App\Http\Controllers\Admin\UserListController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AccountController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::prefix('users')->name('users.')->middleware(['auth', 'role:Admin'])->group(function () {
        Route::get('{role}', [UserListController::class, 'index'])->name('index');
        Route::get('{user}/edit', [UserListController::class, 'edit'])->name('edit');
        Route::post('add', [UserListController::class, 'store'])->name('add');
        Route::put('{user}/update', [UserListController::class, 'update'])->name('update');
        Route::patch('{user}/change-status', [UserListController::class, 'changeStatus'])->name('changeStatus');
        Route::post('{user}/remove', [UserListController::class, 'destroy'])->name('remove');

        Route::get('sellers/pending', [SellerApprovalController::class, 'index'])->name('sellers.pending');
        Route::post('sellers/{seller}/approve', [SellerApprovalController::class, 'approve'])->name('sellers.approve');
        Route::post('sellers/{seller}/reject', [SellerApprovalController::class, 'reject'])->name('sellers.reject');
    });

    Route::resource('books', BookController::class)->only(['index', 'store', 'edit', 'update', 'destroy']);

    Route::resource('categories', CategoryController::class)->middleware(['auth', 'role:Admin'])->only(['index', 'store', 'edit', 'update', 'destroy']);
    Route::patch('categories/{book}/update-category', [CategoryController::class, 'updateBookCategory'])
        ->name('categories.updateBookCategory')
        ->middleware(['auth', 'role:Admin']);

    Route::resource('account', AccountController::class)->only(['index', 'update']);
});




// Route::get('/', function () {
//     return view('welcome');
// });
