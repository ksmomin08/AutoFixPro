<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Public Pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/ai-diagnostic', [AiController::class, 'index'])->name('ai.diagnostic');
Route::post('/ai-diagnostic/analyze', [AiController::class, 'analyze'])->name('ai.analyze');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment');
    Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
    Route::get('/bookings', [AppointmentController::class, 'bookings'])->name('bookings');
    Route::get('/history', [AppointmentController::class, 'history'])->name('appointment.history');
    Route::post('/appointment/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointment.cancel');
    
    // Payment Routes
    Route::get('/payment/checkout/{id}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/verify', [PaymentController::class, 'verify'])->name('payment.verify');
    Route::get('/payment/checkout-full/{id}', [PaymentController::class, 'checkoutFull'])->name('payment.checkout-full');
    Route::post('/payment/verify-full', [PaymentController::class, 'verifyFull'])->name('payment.verify-full');
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{id}', [\App\Http\Controllers\AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [\App\Http\Controllers\AdminController::class, 'deleteUser'])->name('users.destroy');
    
    Route::get('/appointments', [\App\Http\Controllers\AdminController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{id}/edit', [\App\Http\Controllers\AdminController::class, 'editAppointment'])->name('appointments.edit');
    Route::put('/appointments/{id}', [\App\Http\Controllers\AdminController::class, 'updateAppointment'])->name('appointments.update');
    Route::delete('/appointments/{id}', [\App\Http\Controllers\AdminController::class, 'deleteAppointment'])->name('appointments.destroy');
    Route::post('/appointments/{id}/accept', [\App\Http\Controllers\AdminController::class, 'acceptAppointment'])->name('appointments.accept');
    Route::post('/appointments/{id}/cancel', [\App\Http\Controllers\AdminController::class, 'cancelAppointment'])->name('appointments.cancel');
    Route::post('/appointments/{id}/pay-final', [\App\Http\Controllers\AdminController::class, 'markFinalPaid'])->name('appointments.payFinal');
    
    Route::get('/queries', [\App\Http\Controllers\AdminController::class, 'queries'])->name('queries');
    Route::delete('/queries/{id}', [\App\Http\Controllers\AdminController::class, 'deleteQuery'])->name('queries.destroy');
});
