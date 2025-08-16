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

Route::get('/', [App\Http\Controllers\LocketController::class, 'index'])->name('loket_antrian.index');
Route::group(['prefix' => '/loket'], function () {
    Route::get('/list', [App\Http\Controllers\LocketController::class, 'locketList'])->name('loket_antrian.list');
    Route::post('/create-queue', [App\Http\Controllers\LocketController::class, 'createQueue'])->name('loket_antrian.createQueue');
    Route::get('/generate_view/{locket_number}', [App\Http\Controllers\LocketController::class, 'generateView'])->name('loket_antrian.generateView');
    Route::get('/sisa-antrian', [App\Http\Controllers\LocketController::class, 'getSisaAntrian'])->name('loket_antrian.sisaAntrian');
    Route::post('/ambil-antrian-selanjutnya', [App\Http\Controllers\LocketController::class, 'getNextQeueue'])->name('loket_antrian.nextQueue');
    Route::get('/queue-recall/{locket_code}/{locket_number}', [App\Http\Controllers\LocketController::class, 'getRecallQueue'])->name('loket_antrian.recall');
});

Route::group(['prefix' => '/poli'], function () {
    Route::get('/list', [App\Http\Controllers\PoliController::class, 'index'])->name('loket_antrian.list');
});

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

    Route::group(['prefix' => 'poli'], function () {
        Route::get('/', [App\Http\Controllers\Admin\RoomController::class, 'index'])->name('admin.poli.index');
        Route::get('/create', [App\Http\Controllers\Admin\RoomController::class, 'create'])->name('admin.poli.create');
        Route::post('/store', [App\Http\Controllers\Admin\RoomController::class, 'store'])->name('admin.poli.store');
        Route::get('/{poli}/edit', [App\Http\Controllers\Admin\RoomController::class, 'edit'])->name('admin.poli.edit');
        Route::put('/{poli}', [App\Http\Controllers\Admin\RoomController::class, 'update'])->name('admin.poli.update');
        Route::delete('/{poli}', [App\Http\Controllers\Admin\RoomController::class, 'destroy'])->name('admin.poli.destroy');
    });

    Route::group(['prefix' => 'loket'], function () {
        Route::get('/', [App\Http\Controllers\Admin\LocketController::class, 'index'])->name('admin.loket.index');
        Route::get('/create', [App\Http\Controllers\Admin\LocketController::class, 'create'])->name('admin.loket.create');
        Route::post('/store', [App\Http\Controllers\Admin\LocketController::class, 'store'])->name('admin.loket.store');
        Route::get('/{loket}/edit', [App\Http\Controllers\Admin\LocketController::class, 'edit'])->name('admin.loket.edit');
        Route::put('/{loket}', [App\Http\Controllers\Admin\LocketController::class, 'update'])->name('admin.loket.update');
        Route::delete('/{loket}', [App\Http\Controllers\Admin\LocketController::class, 'destroy'])->name('admin.loket.destroy');
    });
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
