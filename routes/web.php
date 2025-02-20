<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminKelolaKelasController;
use App\Http\Controllers\Admin\AdminKelolaSiswaController;
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
    Route::middleware('auth:web')->group(function () {
        Route::controller(AdminDashboardController::class)->group(function () {
            Route::get('/dashboard', 'index')->name('admin.dashboard');
        });

        Route::prefix('kelola')->group(function () {
            Route::controller(AdminKelolaKelasController::class)->group(function () {
                Route::prefix('kelas')->group(function () {
                    Route::get('/', 'index')->name('admin.kelola.kelas');
                    Route::post('/store/{id?}', 'store')->name('admin.kelola.kelas.store');
                    Route::get('/data', 'data')->name('admin.kelola.kelas.data');
                    Route::get('/data/{id}', 'dataById')->name('admin.kelola.kelas.data.id');
                    Route::delete('/delete/{id}', 'delete')->name('admin.kelola.kelas.delete');
                });
            });

            Route::controller(AdminKelolaSiswaController::class)->group(function () {
                Route::prefix('siswa')->group(function () {
                    Route::get('/', 'index')->name('admin.kelola.siswa');
                    Route::get('/form/{id?}', 'form')->name('admin.kelola.siswa.form');
                    Route::post('/store/{id?}', 'store')->name('admin.kelola.siswa.store');
                    Route::get('/data', 'data')->name('admin.kelola.siswa.data');
                    Route::delete('/delete/{id}', 'delete')->name('admin.kelola.siswa.delete');
                    Route::post('import', 'importSiswa')->name('admin.kelola.siswa.import');
                });
            });
        });
    });
});
