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

Route::get('/tes', function () {
    return view('tes');
});

Route::middleware(['ValidApps'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/refresh-csrf', function () {
        return response()->json(['csrf_token' => csrf_token()]);
    })->name('refreshToken');

    Route::get('/show-all-queue/{lantai}', [App\Http\Controllers\MasterController::class, 'showAllQueueByLantai'])->name('master.showAllQueueByLantai');

    Route::group(['prefix' => '/play_suara'], function () {
        Route::get('/', [App\Http\Controllers\PlaySoundController::class, 'start'])->name('play_suara');
        // Route::get('/choosed_lantai/{lantai}', [App\Http\Controllers\PlaySoundController::class, 'index'])->name('play_suara.choosedLantai');
        Route::get('/choosed_lantai/{lantai}',  [App\Http\Controllers\MasterController::class, 'showAllQueueByLantai'])->name('play_suara.choosedLantai');
        Route::get('/get_next_call/{lantai}', [App\Http\Controllers\PlaySoundController::class, 'getNextCall'])->name('play_suara.getNextCall');
    });

    Route::group(['prefix' => '/loket'], function () {
        Route::get('/', [App\Http\Controllers\LocketController::class, 'index'])->name('loket_antrian.index');
        Route::get('/list', [App\Http\Controllers\LocketController::class, 'locketList'])->name('loket_antrian.list');
        Route::post('/create-queue', [App\Http\Controllers\LocketController::class, 'createQueue'])->name('loket_antrian.createQueue');
        Route::get('/generate_view/{locket_number}', [App\Http\Controllers\LocketController::class, 'generateView'])->name('loket_antrian.generateView');
        Route::get('/sisa-antrian', [App\Http\Controllers\LocketController::class, 'getSisaAntrian'])->name('loket_antrian.sisaAntrian');
        Route::post('/call-queue', [App\Http\Controllers\LocketController::class, 'getNextQeueue'])->name('loket_antrian.nextQueue');
        Route::get('/queue-recall/{locket_code}/{locket_number}', [App\Http\Controllers\LocketController::class, 'getRecallQueue'])->name('loket_antrian.recall');

        Route::get('/show_poli/{locket_number}', [App\Http\Controllers\LocketController::class, 'loketGetPoli'])->name('loket_antrian.showPoli');
        Route::post('/create_poli_queue', [App\Http\Controllers\LocketController::class, 'loketCreatePoliQueue'])->name('loket_antrian.createPoliQueue');

        Route::get('/print_queue/{queue}', [App\Http\Controllers\LocketController::class, 'loketGetPrintPoliQueue'])->name('loket_antrian.getPrintPoliQueue');
    });

    Route::group(['prefix' => '/poli'], function () {
        Route::get('/list', [App\Http\Controllers\PoliController::class, 'index'])->name('loket_antrian.poli_list');
        Route::get('/generate_view/{room}', [App\Http\Controllers\PoliController::class, 'generateView'])->name('poli.generateView');
        Route::get('/get-queue/{room}', [App\Http\Controllers\PoliController::class, 'getQueueByRoom'])->name('poli.getQueueByRoom');
        Route::post('/call-queue/{room}', [App\Http\Controllers\PoliController::class, 'callQueueByRoom'])->name('poli.callQueueByRoom');
        Route::post('/recall-queue/{room}', [App\Http\Controllers\PoliController::class, 'recallQueueByRoom'])->name('poli.recallQueueByRoom');

        Route::get('/show-current-queue/{room}', [App\Http\Controllers\PoliController::class, 'showQueueByRoom'])->name('poli.showQueueByRoom');
        Route::get('/next-queue/{room}', [App\Http\Controllers\PoliController::class, 'getNextQueueByRoom'])->name('poli.getNextQueueByRoom');
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

        Route::group(['prefix' => 'company'], function () {
            Route::get('/', [App\Http\Controllers\Admin\CompanyController::class, 'index'])->name('admin.company.index');
            Route::put('/{company}', [App\Http\Controllers\Admin\CompanyController::class, 'update'])->name('admin.company.update');
        });
    });
});
