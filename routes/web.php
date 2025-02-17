<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKelolaKelasController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/', '/login');
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'indexLogin')->name('login');
    Route::post('/login', 'login')->name('post.login');
    Route::post('/logout', 'logout')->name('logout');
});

Route::prefix('admin')->group(function () {
    Route::middleware('auth:web')->group(function() {
        Route::controller(AdminDashboardController::class)->group(function() {
            Route::get('/dashboard', 'index')->name('admin.dashboard');
        });
    
        Route::prefix('kelola')->group(function() {
            Route::controller(AdminKelolaKelasController::class)->group(function() {
                Route::get('/kelas', 'index')->name('admin.kelola.kelas');
            });
        });
    });
});
