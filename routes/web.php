<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Member;
use App\Http\Middleware\Panitia;
use App\Http\Middleware\TimKeuangan;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Panitia\PanitiaController;
use App\Http\Controllers\Panitia\EventController;
use App\Http\Controllers\Member\MemberController;
use App\Http\Controllers\TimKeuangan\TimKeuanganController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/events', [App\Http\Controllers\Panitia\EventController::class, 'publicIndex'])->name('events');


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/events/{event}', [EventController::class, 'show'])
    ->middleware('auth')
    ->name('events.show');
// Route dashboard untuk ADMIN

Route::middleware(['auth', Admin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/committee', [AdminController::class, 'committee'])->name('committee.index');
    Route::get('/finance', [AdminController::class, 'finance'])->name('finance.index');
    Route::get('/members', [AdminController::class, 'members'])->name('members');
    Route::get('/events', [AdminController::class, 'events'])->name('events');
    Route::post('/members/promote', [AdminController::class, 'promote'])->name('members.promote');
});


// Route dashboard untuk MEMBER
Route::middleware(['auth', Member::class])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
    Route::get('/events', [MemberController::class, 'events'])->name('events');
    Route::get('/certificates', [MemberController::class, 'certificates'])->name('certificates');
    Route::get('/payments', [MemberController::class, 'payments'])->name('payments');
    Route::get('/events/{event}', [MemberController::class, 'showEvent'])->name('events.show');
    Route::delete('/registrations/{registration}', [MemberController::class, 'cancelRegistration'])->name('registrations.cancel');
    Route::post('/events/{event}/sessions/{session}/register', [MemberController::class, 'registerSession'])->name('sessions.register');
});

// Route dashboard untuk PANITIA 
Route::middleware(['auth', Panitia::class])->prefix('panitia')->name('panitia.')->group(function () {
    Route::get('/dashboard', [PanitiaController::class, 'dashboard'])->name('dashboard');

    // Event
    Route::get('/events/create', [PanitiaController::class, 'createEvent'])->name('events.create');
    Route::post('/events/store', [PanitiaController::class, 'storeEvent'])->name('events.store');

    // Event Session
    Route::get('/events/{event}/sessions/create', [PanitiaController::class, 'createSession'])->name('sessions.create');
    Route::post('/events/{event}/sessions/store', [PanitiaController::class, 'storeSession'])->name('sessions.store');

    // speaker
    Route::get('/panitia/sessions/{session}/speakers/create', [PanitiaController::class, 'createSpeaker'])->name('panitia.speakers.create');
    Route::post('/panitia/sessions/{session}/speakers/store', [PanitiaController::class, 'storeSpeaker'])->name('panitia.speakers.store');

    Route::get('events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::get('/attendance/scan', [PanitiaController::class, 'scanAttendance'])->name('attendance.scan');
    Route::post('/attendance/scan', [PanitiaController::class, 'storeAttendance'])->name('attendance.store');
});


// Route dashboard untuk TIM KEUANGAN
Route::middleware(['auth', TimKeuangan::class])->prefix('tim-keuangan')->name('tim_keuangan.')->group(function () {
    Route::get('/dashboard', [TimKeuanganController::class, 'dashboard'])->name('dashboard');
    Route::get('/payments', [TimKeuanganController::class, 'payments'])->name('payments');
    Route::get('/payments/index', [TimKeuanganController::class, 'paymentsIndex'])->name('payments.index');
    Route::get('/payments/{registration}', [TimKeuanganController::class, 'showPayment'])->name('payments.show');
    Route::get('/payments/{registration}/verify', [TimKeuanganController::class, 'verifyPayment'])->name('payments.verify');
    Route::post('/payments/{registration}/refund', [TimKeuanganController::class, 'refundPayment'])->name('payments.refund');
});


require __DIR__ . '/auth.php';
