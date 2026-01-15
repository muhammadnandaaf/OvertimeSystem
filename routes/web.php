<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SplController;
use App\Http\Controllers\UserController;
use App\Models\SplDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $riwayat = [];
    $monitoringKaryawan = [];

    if ($user->role == 'Karyawan') {
        // Karyawan hanya melihat miliknya sendiri
        $riwayat = \App\Models\SplDetail::where('user_id', $user->id)
                    ->with('spl')
                    ->latest()
                    ->get();
    } elseif ($user->role == 'Supervisor') {
        // SPV melihat karyawan di section yang sama
        $monitoringKaryawan = \App\Models\SplDetail::whereHas('user', function($q) use ($user) {
            $q->where('section', $user->section);
        })->with(['user', 'spl'])->latest()->get();
    } elseif ($user->role == 'Manager') {
        // Manager melihat semua di departemen yang sama
        $monitoringKaryawan = \App\Models\SplDetail::whereHas('user', function($q) use ($user) {
            $q->where('department', $user->department);
        })->with(['user', 'spl'])->latest()->get();
    } elseif ($user->role == 'Admin SDM') {
        // Admin SDM melihat semua data
        $monitoringKaryawan = \App\Models\SplDetail::with(['user', 'spl'])->latest()->get();
    }

    return view('dashboard', compact('riwayat', 'monitoringKaryawan'));
})->middleware(['auth'])->name('dashboard');

// --- PROSES SPL & USER MANAGEMENT ---
Route::middleware(['auth'])->group(function () {
    
    // Supervisor: Buat SPL & Kelola Karyawan
    Route::get('/spl/create', [SplController::class, 'create'])->name('spl.create');
    Route::post('/spl/store', [SplController::class, 'store'])->name('spl.store');
    Route::get('/spv/users', [UserController::class, 'indexKaryawan'])->name('spv.users.index');
    Route::post('/spv/users/store', [UserController::class, 'storeKaryawanBySpv'])->name('spv.users.store');

    // Manager: Persetujuan & Penolakan
    Route::get('/manager/approval', [SplController::class, 'indexManager'])->name('manager.index');
    Route::post('/manager/approve/{id}', [SplController::class, 'approveManager'])->name('manager.approve');
    Route::post('/manager/reject/{id}', [SplController::class, 'rejectManager'])->name('manager.reject');

    // Admin SDM: Verifikasi & Kelola Struktural
    Route::get('/sdm/verifikasi', [SplController::class, 'indexSdm'])->name('sdm.index');
    Route::post('/sdm/approve/{id}', [SplController::class, 'approveSdm'])->name('sdm.approve');
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::post('/admin/users/store', [UserController::class, 'store'])->name('admin.users.store');

    // Fitur Download PDF (Berlaku untuk semua role yang punya akses)
    Route::get('/spl/preview/{id}', [SplController::class, 'preview'])->name('spl.preview');
    Route::get('/spl/download/{id}', [SplController::class, 'downloadPdf'])->name('spl.download');
});

require __DIR__.'/auth.php';
