<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Guest Routes (Frontend)
Route::get('/', [App\Http\Controllers\GuestController::class, 'index'])->name('guest.form');
Route::post('/guest/store', [App\Http\Controllers\GuestController::class, 'store'])->name('guest.store');
Route::get('/guest/success/{id}', [App\Http\Controllers\GuestController::class, 'success'])->name('guest.success')
    ->where('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');
// Survey routes (guest-facing)
Route::get('/survey/{guest?}', [App\Http\Controllers\SurveyController::class, 'create'])->name('survey.create');
Route::post('/survey', [App\Http\Controllers\SurveyController::class, 'store'])->name('survey.store');
Route::get('/survey-thanks', [App\Http\Controllers\SurveyController::class, 'thanks'])->name('survey.thanks');
Route::get('/checkout/{id}', [App\Http\Controllers\GuestController::class, 'checkout'])->name('guest.checkout')
    ->where('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/surveys-dashboard', [App\Http\Controllers\Admin\SurveyDashboardController::class, 'index'])->name('admin.surveys.dashboard');
    Route::get('/surveys-data', [App\Http\Controllers\Admin\SurveyDashboardController::class, 'data'])->name('admin.surveys.data');

    // Guestbook routes
    Route::resource('guestbook', App\Http\Controllers\Admin\GuestbookController::class)->names('admin.guestbook');
    Route::post('guestbook/{id}/checkout', [App\Http\Controllers\Admin\GuestbookController::class, 'checkout'])->name('admin.guestbook.checkout')
        ->where('id', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

    // Reports routes
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
    Route::get('/reports/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');

    // WhatsApp routes
    Route::get('/whatsapp', [App\Http\Controllers\Admin\WhatsAppController::class, 'index'])->name('admin.whatsapp.index');
    Route::get('/whatsapp/test-connection', [App\Http\Controllers\Admin\WhatsAppController::class, 'testConnection'])->name('admin.whatsapp.test-connection');
    Route::post('/whatsapp/test-message', [App\Http\Controllers\Admin\WhatsAppController::class, 'testMessage'])->name('admin.whatsapp.test-message');
});
