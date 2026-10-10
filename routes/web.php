<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LanguageController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Admin\LandingContentController as AdminLandingContentController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;

use Illuminate\Support\Facades\Route;

// Language Switcher Route
Route::get('/lang/{locale}', [LanguageController::class, 'switchLang'])->name('lang.switch');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::post('/doctors/book', [DoctorController::class, 'book'])->name('doctors.book');

// Authenticated Routes (Patients & Doctors)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Appointments History for Patients
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments/{id}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');

    // Chat / Online Consultation Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/{id}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::post('/chat/{id}/prescription', [ChatController::class, 'sendPrescription'])->name('chat.prescription');
    Route::get('/prescription/{id}/download', [ChatController::class, 'downloadPrescription'])->name('prescription.download');
});

// Admin Panel Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Doctor Management CRUD
    Route::get('/doctors', [AdminDoctorController::class, 'index'])->name('doctors.index');
    Route::post('/doctors', [AdminDoctorController::class, 'store'])->name('doctors.store');
    Route::put('/doctors/{id}', [AdminDoctorController::class, 'update'])->name('doctors.update');
    Route::delete('/doctors/{id}', [AdminDoctorController::class, 'destroy'])->name('doctors.destroy');

    // Patient Management List
    Route::get('/patients', [AdminPatientController::class, 'index'])->name('patients.index');
    Route::put('/patients/{id}', [AdminPatientController::class, 'update'])->name('patients.update');

    // Appointment Management
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{id}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');

    // Inventory CRUD
    Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('inventory.index');
    Route::post('/inventory', [AdminInventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{id}', [AdminInventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [AdminInventoryController::class, 'destroy'])->name('inventory.destroy');

    // Landing Page Content Config
    Route::post('/landing-content', [AdminLandingContentController::class, 'update'])->name('landing-content.update');
});

require __DIR__.'/auth.php';
