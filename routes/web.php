<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\NotaryClientDocumentController;
use App\Http\Controllers\NotaryClientProductController;
use App\Http\Controllers\NotaryClientWarkahController;
use App\Http\Controllers\ProductDocumentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SubscriptionsController;
use App\Models\NotaryConsultation;
use Milon\Barcode\Facades\DNS2DFacade;
use App\Http\Controllers\NotaryConsultationController;


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
    // Public Access
    // Route untuk akses form update dari link revisi (menggunakan encrypted id)
    Route::get('/client/{encryptedId}', [ClientController::class, 'editCLient'])->name('client.editCLient');
    // Route untuk submit update dari form revisi
    Route::put('/client/{encryptedId}', [ClientController::class, 'updateClient'])->name('client.updateClient');
    Route::get('/client/{notaris_id}', [ClientController::class, 'publicForm'])->name('client.public.create');
    Route::post('/client/{notaris_id}/store', [ClientController::class, 'storeClient'])->name('client.public.store');
    Route::get('/clients/{uuid}', [ClientController::class, 'showByUuid'])->name('clients.showByUuid');
});

Route::middleware('auth')->group(function () {
    // HomeController routes
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('consultation', NotaryConsultationController::class);
    Route::get('/consultation/client/{id}', [NotaryConsultationController::class, 'getConsultationByClient'])->name('consultation.getConsultationByClient');
    Route::put('consultation/{id}', [NotaryConsultationController::class, 'update'])->name('consultation.update');
    Route::get('/consultation/client/product/{id}', [NotaryConsultationController::class, 'getConsultationByProduct'])->name('consultation.detail');
    Route::get('/consultation/client/product/creates/{consultationId}', [NotaryConsultationController::class, 'creates'])->name('consultation.creates');
    Route::post('/consultation/client/product/{id}', [NotaryConsultationController::class, 'storeProduct'])->name('consultation.storeProduct');
    Route::delete('/consultation/client/product/{consultationId}/product/{productId}', [NotaryConsultationController::class, 'deleteProduct'])->name('consultation.deleteProduct');

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

    Route::resource('clients', ClientController::class);
    Route::put('/clients/{id}/valid', [ClientController::class, 'markAsValid'])->name('clients.markAsValid');

    Route::resource('management-process', NotaryClientProductController::class);
    Route::post('management-process/mark-done', [NotaryClientProductController::class, 'markDone'])->name('management-process.markDone');
    Route::post('management-process/add-progress', [NotaryClientProductController::class, 'addProgress'])->name('management-process.addProgress');
    Route::resource('documents-product', NotaryClientDocumentController::class);
    Route::resource('warkah', NotaryClientWarkahController::class);


    // Logout route
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
