<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemPenilaianController;
use App\Http\Controllers\JadwalSupervisiController;
use App\Http\Controllers\JawabanSupervisiController;
use App\Http\Controllers\JawabanValidatorController;
use App\Http\Controllers\KategoriPenilaianController;
use App\Http\Controllers\KodeGolonganController;
use App\Http\Controllers\KodeJabatanController;
use App\Http\Controllers\KodeStatusPegawaiController;
use App\Http\Controllers\KodeTindakLanjutHasilSupervisiController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// untuk membuat controller api
// php artisan make:controller UserController --api

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});





// Route::get('/guru', function () {
//     return \App\Models\User::where('role', 'guru, operator, kepala_sekolah')->get();
//     });
Route::get('/guru', [UserController::class, 'index']);
Route::get('/guru/{id}', [UserController::class, 'show']);
Route::post('/guru', [UserController::class, 'store']);
Route::put('/guru/{id}', [UserController::class, 'update']);
Route::delete('/guru/{id}', [UserController::class, 'destroy']);

    // AUTH

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
        // Menghapus token yang digunakan saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out',
            ], 200);
            });

// CREATE AKUN GURU


// Kategori Penilaian
Route::get('/kategori-penilaian', [KategoriPenilaianController::class, 'index']);
Route::get('/kategori-penilaian/{id}', [KategoriPenilaianController::class, 'show']);
Route::post('/kategori-penilaian', [KategoriPenilaianController::class, 'store']);
Route::put('/kategori-penilaian/{id}', [KategoriPenilaianController::class, 'update']);
Route::delete('/kategori-penilaian/{id}', [KategoriPenilaianController::class, 'destroy']);



// Item Penilaian
Route::get('/item-penilaian/get-versi-item', [ItemPenilaianController::class, 'getVersiItem']);
Route::get('/item-penilaian', [ItemPenilaianController::class, 'index']);
Route::post('/item-penilaian', [ItemPenilaianController::class, 'store']);
Route::put('/item-penilaian/{id}', [ItemPenilaianController::class, 'update']);
Route::delete('/item-penilaian/{id}', [ItemPenilaianController::class, 'destroy']);
Route::get('/item-penilaian/group-by-versi', [ItemPenilaianController::class, 'groupByVersi']);
Route::get('/item-penilaian/digunakan', [ItemPenilaianController::class, 'getItemDigunakan']);
Route::post('/item-penilaian/toggle/{id}', [ItemPenilaianController::class, 'toggleDigunakan']);


// SUPERVISI
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/supervisi/simpan-jawaban', [JawabanSupervisiController::class, 'simpanJawabanSupervisi']);
});


Route::get('/supervisi/get-list-guru/{id_jadwal}',
    [JawabanSupervisiController::class, 'getGuruByJadwalSupervisi']
);


// jadwal supervisi
Route::post('/supervisi/tambah-jadwal-supervisi', [JadwalSupervisiController::class, 'tambahJadwalSupervisi'])->middleware('auth:sanctum');
Route::get('/supervisi/get-list-jadwal-supervisi', [JadwalSupervisiController::class, 'getJadwalSupervisi'])->middleware('auth:sanctum');
Route::get('/supervisi/get-list-jadwal-supervisi/{id}', [JadwalSupervisiController::class, 'getJadwalSupervisiById'])->middleware('auth:sanctum');
Route::delete('/supervisi/hapus-jadwal-supervisi/{id}', [JadwalSupervisiController::class, 'hapusJadwalSupervisi'])->middleware('auth:sanctum');
Route::put('/supervisi/ubah-jadwal-supervisi/{id}', [JadwalSupervisiController::class, 'ubahJadwalSupervisi'])->middleware('auth:sanctum');

Route::post('/supervisi/edit-jadwal-supervisi/{id}', [JadwalSupervisiController::class, 'editJadwalSupervisi']);
Route::get('/supervisi/detail-jadwal-supervisi/{id}', [JadwalSupervisiController::class, 'getDetailJadwalSupervisi'])->middleware('auth:sanctum');
Route::delete('/supervisi/delete-jadwal-supervisi/{id}',
    [JadwalSupervisiController::class, 'deleteJadwalSupervisi']
)->middleware('auth:sanctum');

// HASIL SUPERVISI
Route::get('/supervisi/hasil-supervisi/{id}', [JawabanSupervisiController::class, 'listHasilSupervisiByGuru']);
Route::get('/supervisi/hasil-supervisi/{id_jadwal}/{id_guru}', [JawabanSupervisiController::class, 'detailHasilSupervisiGurubyJadwal']);
Route::get('/supervisi/statistik-guru/{id}', [JawabanSupervisiController::class, 'statistikSupervisiGuru']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/supervisi/simpan-hasil-supervisi', [JawabanSupervisiController::class, 'simpanHasilSupervisi']);
});

// Kode Tindak Lanjut Hasil Supervisi
Route::get('/kode-tindak-lanjut-hasil-supervisi', [KodeTindakLanjutHasilSupervisiController::class, 'index']);
Route::get('/kode-tindak-lanjut-hasil-supervisi/{kode}', [KodeTindakLanjutHasilSupervisiController::class, 'show']);
Route::post('/kode-tindak-lanjut-hasil-supervisi', [KodeTindakLanjutHasilSupervisiController::class, 'store']);
Route::put('/kode-tindak-lanjut-hasil-supervisi/{kode}', [KodeTindakLanjutHasilSupervisiController::class, 'update']);
Route::delete('/kode-tindak-lanjut-hasil-supervisi/{kode}', [KodeTindakLanjutHasilSupervisiController::class, 'destroy']);

// Jawaban Validator
// Route::post('/jawaban-validator/submit', [JawabanValidatorController::class, 'postJawabanValidator']);
// Route::middleware('auth:sanctum')->post(
//     '/jawaban-validator/submit',
//     [JawabanValidatorController::class, 'postJawabanValidator']
// );


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/jawaban-validator/submit', [JawabanValidatorController::class, 'postJawabanValidator']);
});

Route::middleware('auth:sanctum')->get(
    '/jawaban-validator/status-pengujian',
    [JawabanValidatorController::class, 'postJawabanValidator']
);
// Route::post('/jawaban-validator', [JawabanValidatorController::class, 'store']);
// Route::post('/hitung-aiken/{id}', [JawabanValidatorController::class, 'validasiItem']);
// Route::get('/item-valid', [ItemPenilaianController::class, 'itemValid']);


// ======= JAWABAN VALIDATOR =======
Route::get('/jawaban-validator/status-pengujian', [JawabanValidatorController::class, 'statusPengujian']);
Route::middleware('auth:sanctum')->get(
    '/jawaban-validator/status-pengujian',
    [JawabanValidatorController::class, 'statusPengujian']
);

// KODE GOLONGAN
Route::get('/kode-golongan', [KodeGolonganController::class, 'index']);
Route::get('/kode-golongan/{id}', [KodeGolonganController::class, 'show']);
Route::post('/kode-golongan', [KodeGolonganController::class, 'store']);
Route::put('/kode-golongan/{id}', [KodeGolonganController::class, 'update']);
Route::delete('/kode-golongan/{id}', [KodeGolonganController::class, 'destroy']);

// KODE JABATAN
Route::get('/kode-jabatan', [KodeJabatanController::class, 'index']);
Route::get('/kode-jabatan/{id}', [KodeJabatanController::class, 'show']);
Route::post('/kode-jabatan', [KodeJabatanController::class, 'store']);
Route::put('/kode-jabatan/{id}', [KodeJabatanController::class, 'update']);
Route::delete('/kode-jabatan/{id}', [KodeJabatanController::class, 'destroy']);

// KODE STATUS PEGAWAI
Route::get('/kode-status-pegawai', [KodeStatusPegawaiController::class, 'index']);
Route::get('/kode-status-pegawai/{id}', [KodeStatusPegawaiController::class, 'show']);
Route::post('/kode-status-pegawai', [KodeStatusPegawaiController::class, 'store']);
Route::put('/kode-status-pegawai/{id}', [KodeStatusPegawaiController::class, 'update']);
Route::delete('/kode-status-pegawai/{id}', [KodeStatusPegawaiController::class, 'destroy']);



///
// routes/api.php




// php artisan make:controller KodeTindakLanjutHasilSupervisiController --api
