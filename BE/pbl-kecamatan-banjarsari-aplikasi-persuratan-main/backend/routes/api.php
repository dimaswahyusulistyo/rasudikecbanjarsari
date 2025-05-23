<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KategoriPerihalController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\TiersController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\FotoNotulensiController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Users
Route::get('/users', [UsersController::class, 'indexapi']);
Route::get('/users/{id}', [UsersController::class, 'showapi']);
Route::delete('/users/{id}', [UsersController::class, 'destroyapi']);
Route::put('/users/{id}', [UsersController::class, 'updateapi']);

//Arsip Surat
Route::get('/arsipsurat/view/{id}', [ArsipController::class, 'view']);
Route::get('/arsipsurat/search', [ArsipController::class, 'search']);
Route::get('/arsipsurat', [ArsipController::class, 'indexapi']);
Route::get('/arsipsurat/agenda/internal', [ArsipController::class, 'agendaInternal']);
Route::get('/arsipsurat/agenda/keluar', [ArsipController::class, 'agendaKeluar']);

//Pegawai
Route::get('/pegawai/total', [PegawaiController::class, 'totalpgw']);
Route::get('/pegawai/search', [PegawaiController::class, 'search']);
Route::get('/pegawai', [PegawaiController::class, 'indexapi']);
Route::get('/pegawai/{id}', [PegawaiController::class, 'showapi']);
Route::post('/pegawai', [PegawaiController::class, 'storeapi']);
Route::put('/pegawai/{id}', [PegawaiController::class, 'updateapi']);
Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroyapi']);

//Kategori Perihal
Route::get('/kategoriperihal', [KategoriPerihalController::class, 'indexapi']);
Route::get('/kategoriperihal/{id}', [KategoriPerihalController::class, 'showapi']);
Route::post('/kategoriperihal', [KategoriPerihalController::class, 'storeapi']);
Route::put('/kategoriperihal/{id}', [KategoriPerihalController::class, 'updateapi']);
Route::delete('/kategoriperihal/{id}', [KategoriPerihalController::class, 'destroyapi']);

//Surat Keluar
Route::get('/suratkeluar/total', [SuratKeluarController::class, 'totalsk']);
Route::get('/suratkeluar/viewsurat/{id}', [SuratKeluarController::class, 'view']);
Route::get('/suratkeluar/search', [SuratKeluarController::class, 'search']);
Route::get('/suratkeluar', [SuratKeluarController::class, 'indexapi']);
Route::get('/suratkeluar/{id}', [SuratKeluarController::class, 'showapi']);
Route::post('/suratkeluar', [SuratKeluarController::class, 'storeapi']);
Route::put('/suratkeluar/{id}', [SuratKeluarController::class, 'updateapi']);
Route::delete('/suratkeluar/{id}', [SuratKeluarController::class, 'destroyapi']);

//Surat Masuk
Route::get('/suratmasuk/today', [SuratMasukController::class, 'smtoday']);
Route::get('/suratmasuk/total/undisposed', [SuratMasukController::class, 'smblmterdisposisi']);
Route::get('/suratmasuk/total', [SuratMasukController::class, 'totalsm']);
Route::get('/suratmasuk/viewsurat/{id}', [SuratMasukController::class, 'view']);
Route::get('/suratmasuk/search', [SuratMasukController::class, 'search']);
Route::get('/suratmasuk', [SuratMasukController::class, 'indexapi']);
Route::get('/suratmasuk/{id}', [SuratMasukController::class, 'showapi']);
Route::post('/suratmasuk', [SuratMasukController::class, 'storeapi']);
Route::put('/suratmasuk/{id}', [SuratMasukController::class, 'updateapi']);
Route::delete('/suratmasuk/{id}', [SuratMasukController::class, 'destroyapi']);

//Jabatan
Route::get('/jabatan/search', [JabatanController::class, 'search']);
Route::get('/jabatan', [JabatanController::class, 'indexapi']);
Route::get('/jabatannotier', [JabatanController::class, 'indexnotier']);
Route::get('/jabatan/{id}', [JabatanController::class, 'showapi']);
Route::post('/jabatan', [JabatanController::class, 'storeapi']);
Route::put('/jabatan/{id}', [JabatanController::class, 'updateapi']);
Route::delete('/jabatan/{id}', [JabatanController::class, 'destroyapi']);
Route::put('/jabatan/{id}/removetier', [JabatanController::class, 'removetier']);

//Tiers
Route::get('/tiers', [TiersController::class, 'indexapi']);
Route::get('/tiers/{id}', [TiersController::class, 'showapi']);
Route::post('/tiers', [TiersController::class, 'storeapi']);
Route::put('/tiers/{id}', [TiersController::class, 'updateapi']);
Route::delete('/tiers/{id}', [TiersController::class, 'destroyapi']);

//Disposisi Notulensi
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/disposisi', [DisposisiController::class, 'indexapi']);
    Route::get('/disposisi/search', [DisposisiController::class, 'search']);
    Route::get('/disposisi/total', [DisposisiController::class, 'getTotalDisposisiSaya']);
    Route::get('/cekdisposisi', [DisposisiController::class, 'cekDisposisiSaya']);
    Route::get('/disposisipegawai', [PegawaiController::class, 'getPegawaiForDisposisi']);
    Route::get('/disposisi/{id}', [DisposisiController::class, 'showapi']);
    Route::post('/disposisi', [DisposisiController::class, 'storeapi']);
    Route::put('/disposisi/{id}', [DisposisiController::class, 'updateapi']);
    Route::delete('/disposisi/{id}', [DisposisiController::class, 'destroyapi']);
    Route::put('/notulensi/{id}', [DisposisiController::class, 'updateNotulensi']);
});

//Foto Notulensi
Route::get('foto_notulensi/download/{id}', [FotoNotulensiController::class, 'downloadFoto']);
Route::get('foto_notulensi', [FotoNotulensiController::class, 'indexapi']);
Route::get('foto_notulensi/{id}', [FotoNotulensiController::class, 'showapi']);
Route::post('foto_notulensi', [FotoNotulensiController::class, 'storeapi']);
Route::put('foto_notulensi/{id}', [FotoNotulensiController::class, 'updateapi']);
Route::delete('foto_notulensi/{id}', [FotoNotulensiController::class, 'destroyapi']);
Route::get('foto_notulensi/disposisi/{id_disposisi}', [FotoNotulensiController::class, 'getFotosByDisposisiId']);

//Pesan
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pesan', [PesanController::class, 'indexapi']);
    Route::get('/pesan/{id}', [PesanController::class, 'showapi']);
    Route::post('/pesan', [PesanController::class, 'storeapi']);
    Route::put('/pesan/{id}', [PesanController::class, 'updateapi']);
    Route::delete('/pesan/{id}', [PesanController::class, 'destroyapi']);
});

//Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::get('/validate-token', [AuthController::class, 'validateToken']);
});
