<?php

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
