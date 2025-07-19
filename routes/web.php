<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\ProductDocumentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubscriptionsController;


Route::middleware('guest')->group(function () {
    // LoginController routes
    Route::controller(LoginController::class)->group(function () {
        Route::get('/', 'show')->name('login');
        Route::post('/login', 'login')->name('login.perform');
        Route::get('/alert-forgot-password', 'alertForgotPassword')->name('alertForgotPassword');
    });
    // RegisterController routes
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'create')->name('register');
        Route::post('/register', 'store')->name('register.perform');
    });
    // ResetPassword routes
    Route::controller(ResetPassword::class)->group(function () {
        Route::get('/reset-password', 'show')->name('reset-password');
        Route::post('/reset-password', 'send')->name('reset.perform');
    });
    // ChangePassword routes
    Route::controller(ChangePassword::class)->group(function () {
        Route::get('/change-password', 'show')->name('change-password');
        Route::post('/change-password', 'update')->name('change.perform');
    });
});

Route::middleware('auth')->group(function () {
    // HomeController routes
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // PageController routes
    // Route::controller(PageController::class)->group(function () {
    //     Route::get('/virtual-reality', 'vr')->name('virtual-reality');
    //     Route::get('/rtl', 'rtl')->name('rtl');
    //     Route::get('/profile-static', 'profile')->name('profile-static');
    //     Route::get('/sign-in-static', 'signin')->name('sign-in-static');
    //     Route::get('/sign-up-static', 'signup')->name('sign-up-static');
    //     Route::get('/{page}', 'index')->name('page');
    // });

    // UserProfileController routes
    Route::controller(UserProfileController::class)->group(function () {
        Route::get('/profile', 'show')->name('profile');
        Route::put('/profile', 'update')->name('profile.update');
    });

    Route::controller(SubscriptionsController::class)->group(function () {
        Route::get('/subscriptions', 'index')->name('subscriptions');
    });

    Route::resource('products', ProductsController::class)->except('show');
    Route::put('products/{product}/deactivate', [ProductsController::class, 'deactivate'])->name('products.deactivate');

    Route::resource('documents', DocumentsController::class);
    Route::put('documents/{document}/deactivate', [DocumentsController::class, 'deactivate'])->name('documents.deactivate');

    Route::get('/product-documents', [ProductDocumentsController::class, 'selectProduct'])->name('products.documents.selectProduct');

    Route::prefix('products/{product}/documents')->name('products.documents.')->group(function () {
        Route::get('/', [ProductDocumentsController::class, 'index'])->name('index');
        Route::post('/', [ProductDocumentsController::class, 'store'])->name('store');
        Route::put('/{document}', [ProductDocumentsController::class, 'update'])->name('update');
        Route::delete('/{document}', [ProductDocumentsController::class, 'destroy'])->name('destroy');
    });

    // Logout route
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
