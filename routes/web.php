<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\ReservationController;

// Admin Account Routes
Route::get('/admin-accounts', [AdminAccountController::class, 'index'])->name('admin.accounts.index');
Route::post('/admin-accounts', [AdminAccountController::class, 'store'])->name('admin.accounts.store');
Route::put('/admin-accounts/{id}', [AdminAccountController::class, 'update'])->name('admin.accounts.update');
Route::delete('/admin-accounts/{id}', [AdminAccountController::class, 'destroy'])->name('admin.accounts.destroy');

// Reservation Routes
Route::get('/reservation', [ReservationController::class, 'index'])->name('reservation.index');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('reservation.update');
Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
Route::post('/reservation/details', [ReservationController::class, 'showReservationDetails'])->name('reservation.details');

// Homepage Route
Route::get('/', function () {
    return view('home');
})->name('home');

// Reservation Page Route
Route::get('/reservation', function () {
    return view('reservation');
})->name('reservation');

// About Page Route
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Page Route
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Admin Login Page Route (GET)
Route::get('/admin_login', function () {
    return view('admin_login');
})->name('admin.login');

// Admin Login Form Submission Route (POST)
Route::post('/admin_login', function () {
    $username = request('admin_username');
    $password = request('admin_password');

    try {
        $conn = new PDO('mysql:host=localhost;dbname=hotelreservationl_laravel', 'root', '');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare('SELECT * FROM admin_accounts WHERE username = :username AND password = :password');
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            session([
                'admin_logged_in' => true,
                'admin_username' => $username
            ]);
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->with('error', 'Invalid username or password');
        }
    } catch (PDOException $e) {
        return redirect()->route('admin.login')->with('error', 'Connection failed: ' . $e->getMessage());
    }
})->name('admin.login.submit');

// Admin Dashboard Route
Route::get('/admin', [ReservationController::class, 'index'])->name('admin.dashboard');

// Add Reservation Route
Route::post('/admin/reservations', [ReservationController::class, 'store'])->name('reservations.store');

// Update Reservation Route
Route::put('/admin/reservations/{id}', [ReservationController::class, 'update'])->name('reservations.update');

// Delete Reservation Route
Route::delete('/admin/reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');