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
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UnsurKontingenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewUserController;
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

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'root'])->name('root');
Route::get('/', [ViewUserController::class, 'index'])->name('viewUser');
Route::resource('/admin-settings', SettingController::class);
Route::put('/admin-settings-uploadFile{id}', [SettingController::class, 'uploadFile'])->name('admin-setting.file');
Route::resource('/admin-user', UserController::class);

Route::resource('/admin-dokumentasi-kegiatan', DokumentasiKegiatanController::class);
Route::get('/add-Photos{id}', [ImageUploadController::class, 'create'])->name('addPhotos');
Route::post('/add-Photos{id}', [ImageUploadController::class, 'store'])->name('addPhotosStore');
Route::post('photos', [ImageUploadController::class, 'destroy'])->name('destroyPhotos');

Route::resource('/admin-kegiatan', KegiatanController::class);
Route::resource('/admin-jadwal-kegiatan', JadwalKegiatanController::class);
Route::resource('/admin-dokumen-penting', DokumenPentingController::class);
Route::resource('/admin-kategori', KategoriController::class);
Route::resource('/admin-region', RegionController::class);

Route::resource('/admin-data-berkas-kontingen', BerkasController::class);
Route::put('/berkas-verifikasi{id}', [BerkasController::class, 'verifikasi'])->name('berkas.verifikasi');

Route::resource('/admin-data-unsur-kontingen', UnsurKontingenController::class);
Route::put('/upload-foto-unsur-kontingen{id}', [UnsurKontingenController::class, 'uploadFoto'])->name('unsur-kontingen.foto');
Route::put('/upload-kta-unsur-kontingen{id}', [UnsurKontingenController::class, 'uploadKta'])->name('unsur-kontingen.kta');
Route::put('/upload-asuransi-unsur-kontingen{id}', [UnsurKontingenController::class, 'uploadAsuransi'])->name('unsur-kontingen.asuransi');
Route::put('/upload-suket-unsur-kontingen{id}', [UnsurKontingenController::class, 'uploadSertif'])->name('unsur-kontingen.sertif');
Route::put('/unsur-kontingen-verifikasi{id}', [UnsurKontingenController::class, 'verifikasi'])->name('unsur-kontingen.verifikasi');
Route::get('unsur-kontingen-exportPDF{id}', [UnsurKontingenController::class, 'exportPDF'])->name('unsur-kontingen.pdf');
Route::get('unsur-kontingen-exportExcel{id}', [UnsurKontingenController::class, 'exportExcel'])->name('unsur-kontingen.excel');
Route::get('unsur-kontingen-exportadminExcel', [UnsurKontingenController::class, 'exportAdminExcel'])->name('unsur-kontingen.admin-excel');
Route::get('unsur-kontingen-exportadminPDF', [UnsurKontingenController::class, 'exportAdminPDF'])->name('unsur-kontingen.admin-pdf');

Route::resource('/admin-data-peserta', PesertaController::class);
Route::put('/upload-foto{id}', [PesertaController::class, 'uploadFoto'])->name('peserta.foto');
Route::put('/upload-kta{id}', [PesertaController::class, 'uploadKta'])->name('peserta.kta');
Route::put('/upload-asuransi{id}', [PesertaController::class, 'uploadAsuransi'])->name('peserta.asuransi');
Route::put('/upload-sertif{id}', [PesertaController::class, 'uploadSertif'])->name('peserta.sertif');
Route::put('/peserta-verifikasi{id}', [PesertaController::class, 'verifikasi'])->name('peserta.verifikasi');
Route::get('peserta-exportPDF', [PesertaController::class, 'exportPDF'])->name('peserta.pdf');
Route::get('peserta-exportExcel', [PesertaController::class, 'exportExcel'])->name('peserta.excel');


Route::resource('/admin-data-pembayaran', PembayaranController::class);
Route::get('export-pembayaran', [\App\Http\Controllers\PembayaranController::class, 'export'])->name('export-pembayaran');
Route::put('/pembayaran-verifikasi{id}', [App\Http\Controllers\PembayaranController::class, 'verifikasiPembayaran'])->name('verifikasiPembayaran');
Route::get('pembayaran-exportPDF{id}', [PembayaranController::class, 'exportPDF'])->name('pembayaran.pdf');
Route::get('pembayaran-exportExcel{id}', [PembayaranController::class, 'exportExcel'])->name('pembayaran.excel');
Route::get('pembayaran-exportadminExcel', [PembayaranController::class, 'exportAdminExcel'])->name('pembayaran.admin-excel');
Route::get('pembayaran-exportadminPDF', [PembayaranController::class, 'exportAdminPDF'])->name('pembayaran.admin-pdf');



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
