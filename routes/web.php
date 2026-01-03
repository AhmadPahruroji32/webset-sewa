<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EquipmentController as AdminEquipmentController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/equipment', [HomeController::class, 'equipment'])->name('equipment.index');
Route::get('/equipment/{id}', [HomeController::class, 'show'])->name('equipment.show');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Routes (Authenticated)
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Rentals
    Route::get('/rentals', [RentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/create/{equipmentId}', [RentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [RentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{id}', [RentalController::class, 'show'])->name('rentals.show');
    Route::delete('/rentals/{id}', [RentalController::class, 'cancel'])->name('rentals.cancel');
    
    Route::get('/reviews/create/{rentalId}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Users
    Route::resource('users', AdminUserController::class);
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Equipment
    Route::resource('equipment', AdminEquipmentController::class);
    
    // Rentals
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/{id}', [AdminRentalController::class, 'show'])->name('rentals.show');
    Route::post('/rentals/{id}/approve', [AdminRentalController::class, 'approve'])->name('rentals.approve');
    Route::post('/rentals/{id}/activate', [AdminRentalController::class, 'activate'])->name('rentals.activate');
    Route::post('/rentals/{id}/complete', [AdminRentalController::class, 'complete'])->name('rentals.complete');
    Route::post('/rentals/{id}/reject', [AdminRentalController::class, 'reject'])->name('rentals.reject');
    
    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

