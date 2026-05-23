<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;           // ← Single Profile Controller

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\VehicleController as AdminVehicleController;
use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

// Driver Controllers
use App\Http\Controllers\DriverController;

// Middleware
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DriverMiddleware;

Route::redirect('/', '/home')->name('welcome');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', fn() => view('about'))->name('about');

// ==================== PUBLIC ROUTES ====================
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.store');

// Vehicles
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

// ==================== AUTHENTICATED ROUTES ====================
Route::middleware(['auth', 'verified'])->group(function () {

    // Smart Dashboard Redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isDriver()) {
            return redirect()->route('driver.dashboard');
        }
        return app(DashboardController::class)->index();
    })->name('dashboard');

    // ==================== COMMON PROFILE ROUTES (Single Controller) ====================
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==================== CUSTOMER ROUTES ====================
    Route::resource('bookings', BookingController::class);
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/check-driver-availability', [BookingController::class, 'checkDriverAvailability'])
         ->name('bookings.checkDriverAvailability');
});

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', AdminMiddleware::class])->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('vehicles', AdminVehicleController::class);
    Route::resource('drivers', AdminDriverController::class);
    Route::resource('bookings', AdminBookingController::class);

    // Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{user}', [AdminCustomerController::class, 'show'])->name('customers.show');
    Route::delete('/customers/{user}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');

    // Extra Booking Actions
    Route::post('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/complete', [AdminBookingController::class, 'complete'])->name('bookings.complete');

    // Vehicle Availability
    Route::patch('/vehicles/{vehicle}/toggle', [AdminVehicleController::class, 'toggleAvailability'])
         ->name('vehicles.toggle');

    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/generate', [AdminReportController::class, 'generate'])->name('reports.generate');
    Route::get('/reports/{report}/download', [AdminReportController::class, 'download'])->name('reports.download');
    Route::delete('/reports/{report}', [AdminReportController::class, 'destroy'])->name('reports.destroy');
});

// ==================== DRIVER ROUTES ====================
Route::prefix('driver')->name('driver.')->middleware(['auth', 'verified', DriverMiddleware::class])->group(function () {

    Route::get('/dashboard', [DriverController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [DriverController::class, 'bookings'])->name('bookings.index');
    Route::get('/bookings/{booking}', [DriverController::class, 'showBooking'])->name('bookings.show');
    Route::post('/bookings/{booking}/complete', [DriverController::class, 'markAsCompleted'])->name('bookings.complete');
});

require __DIR__.'/auth.php';