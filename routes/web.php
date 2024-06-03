<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\DokumenPentingController;
use App\Http\Controllers\DokumentasiKegiatanController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UnsurKontingenController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
Route::get('phpinfo', function () {
    return phpinfo();
});
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::resource('/admin-settings', SettingController::class);
Route::resource('/admin-user', UserController::class);

Route::resource('/admin-dokumentasi-kegiatan', DokumentasiKegiatanController::class);
Route::get('/add-Photos{id}', [ImageUploadController::class, 'create'])->name('addPhotos');
Route::post('/add-Photos{id}', [ImageUploadController::class, 'store'])->name('addPhotosStore');
Route::post('photos', [ImageUploadController::class, 'destroy'])->name('destroyPhotos');

Route::resource('/admin-kegiatan', KegiatanController::class);
Route::resource('/admin-jadwal-kegiatan', JadwalKegiatanController::class);
Route::resource('/admin-dokumen-penting', DokumenPentingController::class);
Route::resource('/admin-kategori', KategoriController::class);

Route::resource('/admin-data-berkas-kontingen', BerkasController::class);
Route::put('/berkas-verifikasi{id}', [BerkasController::class, 'verifikasi'])->name('berkas.verifikasi');

Route::resource('/admin-data-peserta', PesertaController::class);
Route::put('/upload-foto{id}', [PesertaController::class, 'uploadFoto'])->name('peserta.foto');
Route::put('/upload-vaksin{id}', [PesertaController::class, 'uploadVaksin'])->name('peserta.vaksin');
Route::put('/upload-kta{id}', [PesertaController::class, 'uploadKta'])->name('peserta.kta');
Route::put('/upload-asuransi{id}', [PesertaController::class, 'uploadAsuransi'])->name('peserta.asuransi');
Route::put('/upload-suket{id}', [PesertaController::class, 'uploadSuket'])->name('peserta.suket');

Route::resource('/admin-data-unsur-kontingen', UnsurKontingenController::class);
Route::put('/upload-foto-unsur-kontingen{id}', [PesertaController::class, 'uploadFoto'])->name('unsur-kontingen.foto');
Route::put('/upload-vaksin-unsur-kontingen{id}', [PesertaController::class, 'uploadVaksin'])->name('unsur-kontingen.vaksin');
Route::put('/upload-kta-unsur-kontingen{id}', [PesertaController::class, 'uploadKta'])->name('unsur-kontingen.kta');
Route::put('/upload-asuransi-unsur-kontingen{id}', [PesertaController::class, 'uploadAsuransi'])->name('unsur-kontingen.asuransi');
Route::put('/upload-suket-unsur-kontingen{id}', [PesertaController::class, 'uploadSuket'])->name('unsur-kontingen.suket');

Route::resource('/admin-data-pembayaran', PembayaranController::class);
Route::get('export-pembayaran', [\App\Http\Controllers\PembayaranController::class, 'export'])->name('export-pembayaran');
Route::put('/pembayaran-verifikasi{id}', [App\Http\Controllers\PembayaranController::class, 'verifikasiPembayaran'])->name('verifikasiPembayaran');


Route::resource('/admin-artikel', ArtikelController::class);
Route::get('/create-artikel', [App\Http\Controllers\ArtikelController::class, 'create'])->name('createArtikel');
Route::get('/edit{slug}', [App\Http\Controllers\ArtikelController::class, 'edit'])->name('editArtikel');
Route::put('/edit-artikel/{slug}', [App\Http\Controllers\ArtikelController::class, 'update'])->name('updateArtikel');
Route::get('/{slug}', [App\Http\Controllers\ArtikelController::class, 'show'])->name('readArtikel');


//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
