<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FormController;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DocumentsController;

use App\Http\Controllers\MidtransCallbackController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;


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

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'callback']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        if ($request->user()->hasAnyRole(['admin', 'panitia', 'keuangan'])) {
            return Inertia::render('Admin/Dashboard');
        }
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::patch('/notification/{id}', function ($id) {
        auth()->user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        return;
    })->name('notifications.read');

    Route::delete('/notification/{id}', function ($id) {
        auth()->user()->notifications()->where('id', $id)->delete();
        return;
    })->name('notifications.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/submission', [FormController::class, 'submission'])->name('form.submission');
    Route::post('/submission', [FormController::class, 'submissionStore'])->name('form.submission.store');
    Route::post('/submission-final', [FormController::class, 'submitFinalValidation'])->name('form.submission.final');

    Route::get('/payment', [PaymentController::class, 'index'])->name('form.payment');
    Route::post('/payment', [PaymentController::class, 'store'])->name('form.payment.store');
    Route::delete('/payment/{id}', [PaymentController::class, 'userDestroy'])->name('form.payment.destroy');
    Route::get('/payment/status', [PaymentController::class, 'checkPaymentStatus'])->name('form.payment.status');
    Route::get('/payment/invoice/{id}', [PaymentController::class, 'invoice'])->name('payment.invoice');

    Route::middleware(['payform'])->prefix('/form')->name('form.')->group(function () {
        Route::get('/print', [FormController::class, 'pdf'])->name('pdf-print');
        Route::get('/print/kartu', [FormController::class, 'kartuPdf'])->name('print-kartu');
        Route::get('/{id}', [FormController::class, 'edit'])->name('edit');
        Route::patch('/', [FormController::class, 'update'])->name('update');
        Route::post('/validation', [FormController::class, 'validation'])->name('validation');

    });

    Route::middleware(['payform'])->prefix('/documents')->name('documents.')->group(function () {
        Route::get('/', [DocumentsController::class, 'index'])->name('index');
        Route::post('/', [DocumentsController::class, 'update'])->name('update');
    });

    Route::middleware(['formapproved'])->prefix('/exams')->name('exams.')->group(function () {
        Route::middleware(['examaccess:tes_kesehatan'])->group(function () {
            Route::get('/health', [HealthController::class, 'index'])->name('health');
            Route::post('/health', [HealthController::class, 'update'])->name('health.update');
        });

        Route::middleware(['examaccess:tes_ujian'])->group(function () {
            Route::get('/knowledge', [KnowledgeController::class, 'index'])->name('knowledge');
            Route::get('/knowledge/{id}', [KnowledgeController::class, 'exams'])->name('knowledge.exams');
            Route::post('/knowledge/{id}', [KnowledgeController::class, 'start'])->name('knowledge.start');
            Route::patch('/knowledge/{id}', [KnowledgeController::class, 'store'])->name('knowledge.store');
        });

        Route::middleware(['examaccess:tes_wawancara'])->group(function () {
            Route::get('/interview', [InterviewController::class, 'index'])->name('interview');
        });

    });
});
require __DIR__.'/auth.php';