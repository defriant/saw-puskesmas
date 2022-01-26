<?php

use App\Http\Controllers\WebController;
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

Route::middleware(['guest'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('index');
    Route::post('/login-attempt', [WebController::class, 'login_attempt']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/check-this-user-role', [WebController::class, 'check_role']);
    Route::get('/logout', [WebController::class, 'logout']);
    Route::post('user/change-password', [WebController::class, 'change_password']);

    Route::get('/kriteria/get', [WebController::class, 'get_kriteria']);
    Route::get('/kriteria-normalisasi/get', [WebController::class, 'get_kriteria_normalisasi']);
    Route::post('/penilaian-karyawan/get', [WebController::class, 'get_penilaian_karyawan']);
    Route::post('/normalisasi-penilaian-karyawan/get', [WebController::class, 'get_normalisasi_penilaian_karyawan']);
    Route::post('/penilaian-karyawan/final-result/get', [WebController::class, 'get_final_result']);
});

Route::middleware(['auth', 'karyawanRole'])->group(function () {
    Route::get('/karyawan/dashboard', function () {
        return view('karyawan.dashboard');
    });
    Route::get('/karyawan/dashboard/get', [WebController::class, 'karyawan_dashboard']);
    Route::get('/karyawan/peringkat', function () {
        return view('karyawan.peringkat');
    });
});

Route::middleware(['auth', 'adminRole'])->group(function () {
    Route::get('/dashboard', [WebController::class, 'dashboard'])->name('dashboard');
    Route::get('/data-karyawan', function () {
        return view('data-karyawan');
    });
    Route::get('/data-karyawan/get', [WebController::class, 'get_data_karyawan']);
    Route::post('/data-karyawan/input', [WebController::class, 'input_data_karyawan']);
    Route::post('/data-karyawan/update', [WebController::class, 'update_data_karyawan']);
    Route::post('/data-karyawan/delete', [WebController::class, 'delete_data_karyawan']);

    Route::get('/penilaian-kinerja', function () {
        return view('penilaian-kinerja');
    });
    Route::post('/kriteria/add', [WebController::class, 'add_kriteria']);
    Route::post('/kriteria/update', [WebController::class, 'update_kriteria']);
    Route::post('/kriteria/delete', [WebController::class, 'delete_kriteria']);

    Route::post('/penilaian-karyawan/create', [WebController::class, 'create_penilaian_karyawan']);
    Route::post('/penilaian-karyawan/update/get', [WebController::class, 'update_get_penilaian_karyawan']);
    Route::post('/penilaian-karyawan/update', [WebController::class, 'update_penilaian_karyawan']);
});
