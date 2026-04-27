<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ItemPenilaianController;
use App\Http\Controllers\JadwalSupervisiController;
use App\Http\Controllers\JawabanSupervisiController;
use App\Http\Controllers\JawabanValidatorController;
use App\Http\Controllers\KategoriPenilaianController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    // Menghapus token yang digunakan saat ini
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Successfully logged out',
    ], 200);
});

Route::apiResource('users', UserController::class);


// Route::apiResource('kode-tindak-lanjut', KodeTindakLanjutHasilSupervisiController::class);

// Route::post('/login', [LoginController::class, '__invoke']);
// Route::middleware('auth:sanctum')->post('/login', [LoginController::class, '__invoken']);
// Route::post('/login', LoginController::class)->name('login');
// Route::post('/register', RegisterController::class)->name('register');

// Kategori Penilaian
Route::get('/kategori-penilaian', [KategoriPenilaianController::class, 'index']);
Route::get('/kategori-penilaian/{id}', [KategoriPenilaianController::class, 'show']);
Route::post('/kategori-penilaian', [KategoriPenilaianController::class, 'store']);
Route::put('/kategori-penilaian/{id}', [KategoriPenilaianController::class, 'update']);
Route::delete('/kategori-penilaian/{id}', [KategoriPenilaianController::class, 'destroy']);

// Item Penilaian
Route::get('/item-penilaian', [ItemPenilaianController::class, 'index']);
// Route::get('/item-penilaian/{id}', [ItemPenilaianController::class, 'show']);
Route::post('/item-penilaian', [ItemPenilaianController::class, 'store']);
Route::put('/item-penilaian/{id}', [ItemPenilaianController::class, 'update']);
Route::delete('/item-penilaian/{id}', [ItemPenilaianController::class, 'destroy']);
Route::get('/item-penilaian/get-versi-item', [ItemPenilaianController::class, 'getVersiItem']);
Route::get('/item-penilaian/group-by-versi', [ItemPenilaianController::class, 'groupByVersi']);

Route::post('/item-penilaian/toggle/{id}', [ItemPenilaianController::class, 'toggleDigunakan']);
Route::get('/item-penilaian/digunakan', [ItemPenilaianController::class, 'getItemDigunakan']);


// SUPERVISI
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/supervisi/simpan-jawaban', [JawabanSupervisiController::class, 'simpanJawabanSupervisi']);
});
// Route::post('/supervisi/simpan-jawaban', [JawabanSupervisiController::class, 'simpanJawabanSupervisi']);
// Route::get('/supervisi/get-list-guru', [JawabanSupervisiController::class, 'getGuruByJadwalSupervisi']);

Route::get('/supervisi/get-list-guru/{id_jadwal}',
    [JawabanSupervisiController::class, 'getGuruByJadwalSupervisi']
);


// jadwal supervisi
Route::post('/supervisi/tambah-jadwal-supervisi', [JadwalSupervisiController::class, 'tambahJadwalSupervisi'])->middleware('auth:sanctum');
Route::get('/supervisi/get-list-jadwal-supervisi', [JadwalSupervisiController::class, 'getJadwalSupervisi'])->middleware('auth:sanctum');
Route::get('/supervisi/get-list-jadwal-supervisi/{id}', [JadwalSupervisiController::class, 'getJadwalSupervisiById'])->middleware('auth:sanctum');
Route::delete('/supervisi/hapus-jadwal-supervisi/{id}', [JadwalSupervisiController::class, 'hapusJadwalSupervisi'])->middleware('auth:sanctum');
Route::put('/supervisi/ubah-jadwal-supervisi/{id}', [JadwalSupervisiController::class, 'ubahJadwalSupervisi'])->middleware('auth:sanctum');
// Route::post(
//     '/item-penilaian/toggle/{id}',
//     [ItemPenilaianController::class, 'getItemDigunakan']
// );

// Route::get('/item-penilaian/digunakan', [ItemPenilaianController::class, 'getItemDigunakan']);


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

Route::post('/login', [AuthController::class, 'login']);

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
// Route::get('/jawaban-validator/status-pengujian', [JawabanValidatorController::class, 'statusPengujian']);
Route::middleware('auth:sanctum')->get(
    '/jawaban-validator/status-pengujian',
    [JawabanValidatorController::class, 'statusPengujian']
);




// php artisan make:controller KodeTindakLanjutHasilSupervisiController --api
