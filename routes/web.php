<?php

use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotaryAktaDocumentsController;
use App\Http\Controllers\NotaryAktaLogsController;
use App\Http\Controllers\NotaryAktaPartiesController;
use App\Http\Controllers\NotaryAktaTransactionController;
use App\Http\Controllers\NotaryAktaTypesController;
use App\Http\Controllers\NotaryClientDocumentController;
use App\Http\Controllers\NotaryClientProductController;
use App\Http\Controllers\NotaryClientWarkahController;
use App\Http\Controllers\NotaryConsultationController;
use App\Http\Controllers\NotaryCostController;
use App\Http\Controllers\NotaryLaporanAktaController;
use App\Http\Controllers\NotaryLegalisasiController;
use App\Http\Controllers\NotaryLettersController;
use App\Http\Controllers\NotaryPaymenttController;
use App\Http\Controllers\NotaryRelaasAktaController;
use App\Http\Controllers\NotaryRelaasDocumentController;
use App\Http\Controllers\NotaryRelaasLogsController;
use App\Http\Controllers\NotaryRelaasPartiesController;
use App\Http\Controllers\NotaryWaarmerkingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PicDocumentsController;
use App\Http\Controllers\PicHandOverController;
use App\Http\Controllers\PicProcessController;
use App\Http\Controllers\PicStaffController;
use App\Http\Controllers\ProductDocumentsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportPaymentController;
use App\Http\Controllers\ReportProcessController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\SubscriptionsController;
use App\Http\Controllers\UserProfileController;
use App\Models\NotaryAktaTransaction;
use App\Models\NotaryConsultation;
use App\Models\NotaryRelaasAkta;
use Illuminate\Support\Facades\Route;
use Milon\Barcode\Facades\DNS2DFacade;





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
    // revisi / edit (link untuk revisi klien)
    Route::get('/client/revisi/{encryptedClientId}', [ClientController::class, 'editClient'])
        ->name('client.editClient');
    Route::put('/client/revisi/{encryptedClientId}', [ClientController::class, 'updateClient'])
        ->name('client.public.update');


    // public form (link yang dikirim ke klien) — jelas beda URI
    Route::get('/client/public/{encryptedNotarisId}', [ClientController::class, 'publicForm'])
        ->name('client.public.create');


    Route::post('/client/public/{encryptedNotarisId}/store', [ClientController::class, 'storeClient'])
        ->name('client.public.store');

    Route::get('/clients/{uuid}', [ClientController::class, 'showByUuid'])->name('clients.showByUuid');
    Route::post('/client/{uuid}/upload-document', [ClientController::class, 'uploadDocument'])
        ->name('client.uploadDocument');
});

Route::middleware('auth')->group(function () {
    // HomeController routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

    Route::resource('documents', DocumentsController::class)->except('show');
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
    Route::put('/clients/{id}/set-revision', [ClientController::class, 'setRevision'])
        ->name('clients.setRevision');
    Route::get('/client/revision/{encryptedClientId}', [ClientController::class, 'showRevisionForm'])
        ->name('client.public.revision');

    Route::post('/client/revision/{encryptedClientId}', [ClientController::class, 'submitRevision'])
        ->name('client.revision.submit');


    Route::get('/clients-info', [ClientController::class, 'indexClient'])->name('clients-info.index');


    // Proses pEngurusan
    Route::get('client-progress', [PicProcessController::class, 'indexProcess'])->name('pic-progress.indexProcess');
    Route::post('pic_process/progress/store', [PicProcessController::class, 'storeProgress'])
        ->name('pic-progress.storeProgress');
    Route::resource('management-process', NotaryClientProductController::class);
    Route::put('/management-process/{id}/valid', [NotaryClientProductController::class, 'markAsValid'])->name('management-process.markAsValid');
    Route::post('management-process/mark-done', [NotaryClientProductController::class, 'markDone'])->name('management-process.markDone');
    Route::post('management-process/add-progress', [NotaryClientProductController::class, 'addProgress'])->name('management-process.addProgress');
    // BackOffice Dokumen
    Route::get('management-document', [NotaryClientDocumentController::class, 'index'])->name('management-document.index');
    Route::post('management-document/store', [NotaryClientDocumentController::class, 'addDocument'])->name('management-document.addDocument');
    Route::post('management-document/mark-done', [NotaryClientDocumentController::class, 'markDone'])->name(
        'management-document.markDone'
    );
    Route::post('management-document/status', [NotaryClientDocumentController::class, 'updateStatus'])->name('management-document.updateStatus');
    // update status
    // Route::post('management-document/mark-done', [NotaryClientProductController::class, 'markDone'])->name(
    //     'management-document.markDone'
    // );
    // Route::post('management-document/add-document', [NotaryClientProductController::class, 'addDocument'])->name(
    //     'management-document.addDocument'
    // );
    // Update status document
    // Route::post('management-document/update-status', [NotaryClientProductController::class, 'updateStatusValid'])->name(
    //     'management-document.updateStatus'
    // );

    // Warkah
    // Route::resource('warkah', NotaryClientWarkahController::class);
    Route::get('warkah', [NotaryClientWarkahController::class, 'index'])->name('warkah.index');
    Route::post('warkah/store', [NotaryClientWarkahController::class, 'addDocument'])->name('warkah.addDocument');
    Route::post('warkah/status', [NotaryClientWarkahController::class, 'updateStatus'])->name('warkah.updateStatus');
    // Route::post('warkah/mark-done', [NotaryClientWarkahController::class, 'markDone'])->name(
    //     'warkah.markDone'
    // );
    // // Update status document
    // Route::post('warkah/update-status', [NotaryClientWarkahController::class, 'updateStatusValid'])->name(
    //     'warkah.updateStatus'
    // );
    // // End
    // Partij Akta
    Route::resource('akta-types', NotaryAktaTypesController::class);
    Route::resource('akta-transactions', NotaryAktaTransactionController::class);
    Route::resource('akta-documents', NotaryAktaDocumentsController::class);

    Route::get('/akta-documents/create/{akta_transaction_id}', [NotaryAktaDocumentsController::class, 'createData'])
        ->name('akta-documents.createData');

    Route::post('/akta-documents/store/{akta_transaction_id}', [NotaryAktaDocumentsController::class, 'storeData'])
        ->name('akta-documents.storeData');
    Route::resource('akta-parties', NotaryAktaPartiesController::class)->except('create', 'store', 'show');
    Route::get('akta-parties/createData/{akta_transaction_id}', [NotaryAktaPartiesController::class, 'createData'])
        ->name('akta-parties.createData');
    Route::post('/akta-parties,store/{akta_transaction_id}', [NotaryAktaPartiesController::class, 'storeData'])->name('akta-parties.storeData');
    Route::get('akta-number', [NotaryAktaTransactionController::class, 'indexNumber'])->name('akta_number.index');
    Route::post('akta-number/store', [NotaryAktaTransactionController::class, 'storeNumber'])->name(
        'akta_number.store'
    );
    Route::resource('akta-logs', NotaryAktaLogsController::class);


    // Relaas Akta
    Route::resource('relaas-aktas', NotaryRelaasAktaController::class);
    Route::resource('relaas-parties', NotaryRelaasPartiesController::class);
    Route::get('/relaas-parties/createData/{relaas_id}', [NotaryRelaasPartiesController::class, 'create'])->name('relaas-parties.create');
    Route::post('/relaas-parties/store/{relaas_id}', [NotaryRelaasPartiesController::class, 'store'])->name('relaas-parties.store');
    Route::get('/relaas-parties/edit/{relaas_id}/{id}', [NotaryRelaasPartiesController::class, 'edit'])->name('relaas-parties.edit');
    Route::put('/relaas-parties/update/{relaas_id}/{id}', [NotaryRelaasPartiesController::class, 'update'])->name('relaas-parties.update');
    Route::get('/relaas-akta/number_akta',  [NotaryRelaasAktaController::class, 'indexNumber'])->name('relaas_akta.indexNumber');
    Route::post('/relaas-akta/store', [NotaryRelaasAktaController::class, 'storeNumber'])->name(
        'relaas-akta.store'
    );
    Route::resource('relaas-documents', NotaryRelaasDocumentController::class);
    Route::get('/relaas-documents/create/{relaas_id}', [NotaryRelaasDocumentController::class, 'create'])->name('relaas-documents.create');
    Route::post('/relaas-documents/store/{relaas_id}', [NotaryRelaasDocumentController::class, 'store'])->name('relaas-documents.store');
    Route::get('/relaas-documents/edit/{relaas_id}/{id}', [NotaryRelaasDocumentController::class, 'edit'])->name('relaas-documents.edit');
    Route::put('/relaas-documents/update/{relaas_id}/{id}', [NotaryRelaasDocumentController::class, 'update'])->name('relaas-documents.update');
    Route::resource('relaas-logs', NotaryRelaasLogsController::class);

    Route::resource('notary-legalisasi', NotaryLegalisasiController::class);
    Route::resource('notary-waarmerking', NotaryWaarmerkingController::class);
    Route::resource('notary-letters', NotaryLettersController::class);
    Route::get('laporan-akta', [NotaryLaporanAktaController::class, 'index'])->name('laporan-akta.index');
    Route::get('laporan-akta/export-pdf', [NotaryLaporanAktaController::class, 'exportPdf'])
        ->name('laporan-akta.export-pdf');


    //PIC
    Route::resource('pic_documents', PicDocumentsController::class);
    Route::resource('pic_staff', PicStaffController::class);
    Route::resource('pic_process', PicProcessController::class);
    Route::put('/pic_process/{id}/complete', [PicProcessController::class, 'markComplete'])->name('pic_process.markComplete');
    Route::resource('pic_handovers', PicHandOverController::class);
    Route::get('pic_handovers/{id}/print', [PicHandoverController::class, 'print'])->name('pic_handovers.print');

    // Biaya
    Route::resource('notary_costs', NotaryCostController::class);
    Route::get('notary_costs/{id}/print', [NotaryCostController::class, 'print'])->name('notary_costs.print');
    Route::resource('notary_payments', NotaryPaymenttController::class);
    Route::get('notary_payments/{id}/print', [NotaryPaymenttController::class, 'print'])->name('notary_payments.print');
    Route::PATCH('notary_payments/{id}/valid', [NotaryPaymenttController::class, 'valid'])->name('notary_payments.valid');
    Route::get('report-payment', [ReportPaymentController::class, 'index'])->name('report-payment.index');
    Route::get('report-payment/print', [ReportPaymentController::class, 'print'])->name('report-payment.print');
    Route::get('report-progress', [ReportProcessController::class, 'index'])->name('report-progress.index');
    Route::get('report-progress/print', [ReportProcessController::class, 'print'])->name('report-progress.print');
    // Logout route
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
