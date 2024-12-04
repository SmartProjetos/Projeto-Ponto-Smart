<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Panel\RecordAdminController;
use App\Http\Controllers\Panel\RecordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckRole;
use App\Services\UserService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Route::get('/register', function () {
//     return view('auth.login');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        // Redireciona diretamente para a página inicial autenticada
        return redirect()->route('dashboard.index');
    })->name('dashboard');
});


Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::put('/user/update-avatar', [UserController::class, 'updateAvatar'])->name('user.updateAvatar');
    Route::get('/record', [RecordController::class, 'index'])->name('record.index');
    Route::post('/record2', [RecordController::class, 'index'])->name('record.store2');
    Route::post('/record', [RecordController::class, 'store'])->name('record.store');
    Route::get('/record/add', [RecordController::class, 'create'])->name('record.add');
    Route::get('/record/{punch}', [RecordController::class, 'show'])->name('record.show');
    Route::get('/record/{punch}/edit', [RecordController::class, 'edit'])->name('record.edit');
    Route::put('/record/{punch}', [RecordController::class, 'update'])->name('record.update');
    Route::get('/record/{punch}/delete', [RecordController::class, 'destroy'])->name('record.destroy');

    Route::prefix('admin')->middleware(CheckRole::class)->group(function () {
        Route::get('/', [RecordAdminController::class, 'index2'])->name('dashboardadmin.index');
        Route::get('/{user}', [RecordAdminController::class, 'index'])->name('user.index');
        Route::get('/{user}/record/{punch}', [RecordAdminController::class, 'show'])->name('user.show');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
