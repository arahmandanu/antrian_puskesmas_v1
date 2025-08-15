<?php

use Illuminate\Support\Facades\Route;

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


Route::group(['prefix' => '/admin', 'middleware' => ['AlreadyLogin']], function () {
    Route::get('login', [App\Http\Controllers\AuthenticationController::class, 'index'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\AuthenticationController::class, 'login'])->name('admin.login.submit');
});


Route::group(['prefix' => '/admin_dashboard', 'middleware' => ['auth:web']], function () {
    route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

    route::get('/logout', [App\Http\Controllers\AuthenticationController::class, 'logout'])->name('admin.logout');
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
        Route::post('/store', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.users.store');
        Route::get('/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});











Route::get('/', function () {
    return view('loket_antrian.index');
    return view('welcome');
});


Route::get('/staff', function () {
    return view('loket_staff.index');
});



Route::get('/poli', function () {
    return view('loket_staff.poli');
});



Route::get('/poli_call', function () {
    return view('loket_staff.call');
});


Route::get('/poli_terpanggil', function () {
    return view('pasien.poli_terpanggil');
});

Route::get('/admin', function () {
    return view('admin.index');
});
