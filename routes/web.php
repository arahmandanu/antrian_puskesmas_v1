<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MasterController,
    PlaySoundController,
    LocketController,
    PoliController,
    AuthenticationController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    UserController,
    RoomController,
    LocketController as AdminLocketController,
    CompanyController,
    LocketReportQueueController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| All routes for this application.
| Organized by feature groups, using proper naming and route grouping.
|
*/

// ---------------------------------------------------------------------
// Utility routes (accessible without ValidApps middleware)
// ---------------------------------------------------------------------
Route::get('/close/app/killit', function () {
    $commands = [
        'powershell Stop-Process -Name "msedge" -Force',
        'powershell Stop-Process -Name "firefox" -Force',
    ];

    foreach ($commands as $command) {
        exec($command, $output, $return_var);
        echo $return_var === 0
            ? "Perintah berhasil: $command\n"
            : "Gagal menjalankan: $command\n";
    }
})->name('master.CloseApp');


// ---------------------------------------------------------------------
// Main application routes (protected by ValidApps middleware)
// ---------------------------------------------------------------------
Route::middleware(['ValidApps'])->group(function () {

    Route::view('/', 'welcome');

    Route::get(
        '/refresh-csrf',
        fn() =>
        response()->json(['csrf_token' => csrf_token()])
    )->name('refreshToken');

    Route::get('/show-all-queue/{lantai}', [MasterController::class, 'showAllQueueByLantai'])
        ->name('master.showAllQueueByLantai');

    // -----------------------------------------------------------------
    // PLAY SUARA
    // -----------------------------------------------------------------
    Route::prefix('play_suara')->group(function () {
        Route::get('/', [PlaySoundController::class, 'start'])->name('play_suara');
        Route::get('/choosed_lantai/{lantai}', [MasterController::class, 'showAllQueueByLantai'])
            ->name('play_suara.choosedLantai');
        Route::get('/choosed_lantai_v2/{lantai}', [MasterController::class, 'showAllQueueByLantaiV2'])
            ->name('play_suara.choosedLantaiV2');
        Route::get('/get_next_call/{lantai}', [PlaySoundController::class, 'getNextCall'])
            ->name('play_suara.getNextCall');
    });

    // -----------------------------------------------------------------
    // LOKET
    // -----------------------------------------------------------------
    Route::prefix('loket')->group(function () {
        Route::get('/', [LocketController::class, 'index'])->name('loket_antrian.index');
        Route::get('/list', [LocketController::class, 'locketList'])->name('loket_antrian.list');
        Route::get('/generate_view/{locket_number}', [LocketController::class, 'generateView'])
            ->name('loket_antrian.generateView');
        Route::get('/show_poli/{locket_number}', [LocketController::class, 'loketGetPoli'])
            ->name('loket_antrian.showPoli');
        Route::get('/print_queue/{queue}', [LocketController::class, 'loketGetPrintPoliQueue'])
            ->name('loket_antrian.getPrintPoliQueue');

        Route::middleware(['jsonOnly'])->group(function () {
            Route::post('/create-queue', [LocketController::class, 'createQueue'])
                ->name('loket_antrian.createQueue');
            Route::get('/sisa-antrian/{staff}', [LocketController::class, 'getSisaAntrian'])
                ->name('loket_antrian.sisaAntrian');
            Route::post('/call-queue', [LocketController::class, 'getNextQeueue'])
                ->name('loket_antrian.nextQueue');
            Route::get('/queue-recall/{locket_code}/{locket_number}', [LocketController::class, 'getRecallQueue'])
                ->name('loket_antrian.recall');
            Route::post('/create_poli_queue', [LocketController::class, 'loketCreatePoliQueue'])
                ->name('loket_antrian.createPoliQueue');
        });
    });

    // -----------------------------------------------------------------
    // POLI
    // -----------------------------------------------------------------
    Route::prefix('poli')->group(function () {
        Route::get('/list', [PoliController::class, 'index'])->name('loket_antrian.poli_list');
        Route::get('/generate_view/{room}', [PoliController::class, 'generateView'])->name('poli.generateView');
        Route::get('/show-current-queue/{room}', [PoliController::class, 'showQueueByRoom'])
            ->name('poli.showQueueByRoom');

        Route::middleware(['jsonOnly'])->group(function () {
            Route::get('/get-queue/{room}', [PoliController::class, 'getQueueByRoom'])->name('poli.getQueueByRoom');
            Route::get('/next-queue/{room}', [PoliController::class, 'getNextQueueByRoom'])->name('poli.getNextQueueByRoom');
            Route::post('/call-queue/{room}', [PoliController::class, 'callQueueByRoom'])->name('poli.callQueueByRoom');
            Route::post('/recall-queue/{room}', [PoliController::class, 'recallQueueByRoom'])->name('poli.recallQueueByRoom');
            Route::post('/finish-queue/{room}', [PoliController::class, 'finishQueueByRoom'])->name('poli.finishQueueByRoom');
        });
    });

    // -----------------------------------------------------------------
    // ADMIN AREA
    // -----------------------------------------------------------------
    Route::prefix('admin')->middleware(['AlreadyLogin'])->group(function () {
        Route::get('login', [AuthenticationController::class, 'index'])->name('admin.login');
        Route::post('login', [AuthenticationController::class, 'login'])->name('admin.login.submit');
    });

    Route::prefix('admin_dashboard')->middleware(['auth:web'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [AuthenticationController::class, 'logout'])->name('admin.logout');

        // Users
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
            Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
            Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('admin.users.update');
            Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        });

        // Poli
        Route::prefix('poli')->group(function () {
            Route::get('/', [RoomController::class, 'index'])->name('admin.poli.index');
            Route::get('/create', [RoomController::class, 'create'])->name('admin.poli.create');
            Route::post('/store', [RoomController::class, 'store'])->name('admin.poli.store');
            Route::get('/{poli}/edit', [RoomController::class, 'edit'])->name('admin.poli.edit');
            Route::put('/{poli}', [RoomController::class, 'update'])->name('admin.poli.update');
            Route::delete('/{poli}', [RoomController::class, 'destroy'])->name('admin.poli.destroy');
        });

        // Loket
        Route::prefix('loket')->group(function () {
            Route::get('/', [AdminLocketController::class, 'index'])->name('admin.loket.index');
            Route::get('/create', [AdminLocketController::class, 'create'])->name('admin.loket.create');
            Route::post('/store', [AdminLocketController::class, 'store'])->name('admin.loket.store');
            Route::get('/{loket}/edit', [AdminLocketController::class, 'edit'])->name('admin.loket.edit');
            Route::put('/{loket}', [AdminLocketController::class, 'update'])->name('admin.loket.update');
            Route::delete('/{loket}', [AdminLocketController::class, 'destroy'])->name('admin.loket.destroy');
        });

        // Company
        Route::prefix('company')->group(function () {
            Route::get('/', [CompanyController::class, 'index'])->name('admin.company.index');
            Route::put('/{company}', [CompanyController::class, 'update'])->name('admin.company.update');
        });

        // Report
        Route::prefix('report/loket')->group(function () {
            Route::get('/', [LocketReportQueueController::class, 'index'])->name('admin.loket.report.index');
        });
    });
});
