<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BerkasController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DokumenPentingController;
use App\Http\Controllers\DokumentasiKegiatanController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\JadwalKegiatanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TentangController;
use App\Http\Controllers\UnsurKontingenController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ViewUserController;
use App\Http\Controllers\VillagesController;
use App\Models\UnsurKontingen;
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
Route::get('/id-card-villages-{villages_id}', [CardController::class, 'IdCardsKota'])->name('idCardkota');
Route::get('/id-card-unsur-kontingen', [CardController::class, 'generateIDCardsUnsurKontingen'])->name('idCardUnsurKontingen');
Route::get('/id-card-unsur-kontingen-{regency_id}', [CardController::class, 'generateIdCardsRegencyUnsurKontingen'])->name('idCardRegencyUnsurKontingen');
Route::get('/id-card', [CardController::class, 'generateIDCards'])->name('idCard');
Route::get('/id-card-{regency_id}', [CardController::class, 'generateIdCardsRegency'])->name('idCardRegency');
// Route::get('test-card', function () {
//     return view('test-card');
// });
// Auth::routes();
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('auth.authenticate');

// Register
Route::get('/register', [LoginController::class, 'register'])->name('auth.register');
Route::post('/register', [LoginController::class, 'store'])->name('auth.store');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

Route::get('/', [ViewUserController::class, 'index'])->name('viewUser');
Route::get('/tentang', [ViewUserController::class, 'tentang'])->name('viewUser.tentang');
Route::get('/media-unduh', [ViewUserController::class, 'mediaUnduh'])->name('viewUser.media-unduh');
Route::get('/artikel', [ViewUserController::class, 'artikel'])->name('viewUser.artikel');
Route::get('/show-artikel/{slug}', [ViewUserController::class, 'showArtikel'])->name('viewUser.show-artikel');
Route::post('reviewArtikel-store{slug}', [ViewUserController::class, 'reviewArtikelstore'])->name('reviewArtikel.store');
Route::get('/kegiatan', [ViewUserController::class, 'kegiatan'])->name('viewUser.kegiatan');
Route::get('/jadwal-kegiatan', [ViewUserController::class, 'jadwalKegiatan'])->name('viewUser.jadwalKegiatan');
Route::get('/dokumentasi', [ViewUserController::class, 'dokumentasi'])->name('viewUser.dokumentasi');
Route::get('/view-dokumentasi{id}', [ViewUserController::class, 'photo'])->name('viewUserPhoto');
Route::get('/download{id}', [App\Http\Controllers\ViewUserController::class, 'download'])->name('viewUserDownloadPhoto');

Route::resource('/admin-tentang', TentangController::class);


Route::resource('/admin-settings', SettingController::class);
Route::put('/admin-settings-uploadFile{id}', [SettingController::class, 'uploadFile'])->name('admin-setting.file');

Route::get('/admin-create-dkd', [UserController::class, 'createDkd'])->name('createDkd');
Route::get('/admin-create-dkc', [UserController::class, 'createDkc'])->name('createDkc');
Route::get('/admin-create-dkr', [UserController::class, 'createDkr'])->name('createDkr');
Route::get('/admin-edit-dkd-{id}', [UserController::class, 'editDkd'])->name('editDkd');
Route::get('/admin-edit-dkc-{id}', [UserController::class, 'editDkc'])->name('editDkc');
Route::get('/admin-edit-dkr-{id}', [UserController::class, 'editDkr'])->name('editDkr');

Route::get('selectRegencyUser', [RegencyController::class, 'index'])->name('RegencyUser.index');
Route::get('selectRegency', [RegencyController::class, 'regencies'])->name('regency.index');
Route::post('storeRegency', [RegencyController::class, 'store'])->name('regency.store');
Route::get('regency/{id}/edit', [RegencyController::class, 'edit'])->name('regency.edit');
Route::put('regency/{id}', [RegencyController::class, 'update'])->name('regency.update');
Route::delete('regency/{id}', [RegencyController::class, 'destroy'])->name('regency.destroy');
Route::get('selectVillages-{id}', [RegencyController::class, 'villages'])->name('villages.index');
Route::resource('/admin-user', UserController::class);
Route::get('/dataUser-get', [UserController::class, 'getData'])->name('dataUser.get');

Route::resource('/admin-dokumentasi-kegiatan', DokumentasiKegiatanController::class);
Route::get('/add-Photos{id}', [ImageUploadController::class, 'create'])->name('addPhotos');
Route::post('/add-Photos{id}', [ImageUploadController::class, 'store'])->name('addPhotosStore');
Route::put('/update-Photos{id}', [ImageUploadController::class, 'update'])->name('addPhotosUpdate');
Route::post('photos', [ImageUploadController::class, 'destroy'])->name('destroyPhotos');
Route::delete('photos-{id}', [ImageUploadController::class, 'destroyPhotos'])->name('destroyPhotosShow');

Route::resource('/admin-kegiatan', KegiatanController::class);
Route::resource('/admin-jadwal-kegiatan', JadwalKegiatanController::class);
Route::resource('/admin-dokumen-penting', DokumenPentingController::class);
Route::resource('/admin-kategori', KategoriController::class);
Route::resource('/admin-region', VillagesController::class);

Route::resource('/admin-data-berkas-kontingen', BerkasController::class);
Route::put('/berkas-verifikasi{id}', [BerkasController::class, 'verifikasi'])->name('berkas.verifikasi');

Route::resource('/admin-data-unsur-kontingen', UnsurKontingenController::class);
Route::put('/upload-foto-unsur-kontingen{id}', [UnsurKontingenController::class, 'uploadFoto'])->name('unsur-kontingen.foto');
Route::put('/upload-kta-unsur-kontingen{id}', [UnsurKontingenController::class, 'uploadKta'])->name('unsur-kontingen.kta');
Route::put('/upload-asuransi-unsur-kontingen{id}', [UnsurKontingenController::class, 'uploadAsuransi'])->name('unsur-kontingen.asuransi');
Route::put('/upload-suket-unsur-kontingen{id}', [UnsurKontingenController::class, 'uploadSertif'])->name('unsur-kontingen.sertif');
Route::put('/unsur-kontingen-verifikasi{id}', [UnsurKontingenController::class, 'verifikasi'])->name('unsur-kontingen.verifikasi');
Route::get('/admin-data-unsur-kontingen-regency-{id}', [UnsurKontingenController::class, 'detailRegency'])->name('admin-data-unsurKontingen.detail');

Route::get('unsur-kontingen-exportPDF', [UnsurKontingenController::class, 'exportPDF'])->name('unsur-kontingen.pdf');
Route::get('unsur-kontingen-exportExcel', [UnsurKontingenController::class, 'exportExcel'])->name('unsur-kontingen.excel'); 
Route::get('unsur-kontingen-regency-exportPDF-{id}', [UnsurKontingenController::class, 'exportPDFRegency'])->name('unsur-kontingen-regency.pdf');
Route::get('unsur-kontingen-regency-exportExcel-{id}', [UnsurKontingenController::class, 'exportExcelRegency'])->name('unsur-kontingen-regency.excel'); 

Route::get('/export-pdf-unsur', [UnsurKontingenController::class, 'exportPdf'])->name('export-unsur.pdf');
Route::get('/export-pdf-status', [UnsurKontingenController::class, 'exportPdfStatus'])->name('export-unsur.pdf.status');
Route::post('/start-export', [UnsurKontingenController::class, 'exportPDF'])->name('startExport');
Route::get('/pdf-progress', [UnsurKontingenController::class, 'checkProgress']);
Route::get('/download-pdf', [UnsurKontingenController::class, 'downloadPdf']);

Route::get('/get-regencies', [PesertaController::class, 'getRegencies'])->name('data.getRegenciesPeserta');
Route::get('/get-villages/{regency_id}', [PesertaController::class, 'getVillages'])->name('data.getVillages');
Route::get('/get-peserta/{villages_id}', [PesertaController::class, 'getPeserta'])->name('data.getPeserta');
// Route::get('/get-regenciesKontingen', [UnsurKontingen::class, 'getRegencies'])->name('data.getRegenciesKontingen');
Route::get('/get-kontingen/{regency_id}', [UnsurKontingenController::class, 'getPeserta'])->name('data.getPesertaKontingen');
Route::get('/get-regencies-kontingen', [UnsurKontingenController::class, 'getRegencies'])->name('data.getRegenciesKontingen');

Route::get('/regencies', [PesertaController::class, 'showRegencies'])->name('data.showRegencies');
Route::get('/villages/{regency_id}', [PesertaController::class, 'showVillages'])->name('data.showVillages');
Route::get('/peserta/{villages_id}', [PesertaController::class, 'showPeserta'])->name('data.showPeserta');
Route::get('/regencies-kontingen', [UnsurKontingenController::class, 'showRegencies'])->name('data.showRegenciesKontingen');
Route::get('/kontingen/{regency_id}', [UnsurKontingenController::class, 'showPeserta'])->name('data.showKontingen');

Route::resource('/admin-data-peserta', PesertaController::class);
Route::get('/admin-data-peserta-regency-{id}', [PesertaController::class, 'detailRegency'])->name('admin-data-peserta.detailRegency');
Route::get('/admin-data-peserta-villages-{id}', [PesertaController::class, 'detailVillages'])->name('admin-data-peserta.detailVillages');
Route::put('/upload-foto{id}', [PesertaController::class, 'uploadFoto'])->name('peserta.foto');
Route::put('/upload-kta{id}', [PesertaController::class, 'uploadKta'])->name('peserta.kta');
Route::put('/upload-asuransi{id}', [PesertaController::class, 'uploadAsuransi'])->name('peserta.asuransi');
Route::put('/upload-sertif{id}', [PesertaController::class, 'uploadSertif'])->name('peserta.sertif');
Route::put('/peserta-verifikasi{id}', [PesertaController::class, 'verifikasi'])->name('peserta.verifikasi');

Route::get('peserta-exportPDF', [PesertaController::class, 'exportPDF'])->name('peserta.pdf');
Route::get('peserta-exportExcel', [PesertaController::class, 'exportExcel'])->name('peserta.excel');
Route::get('peserta-regency-exportPDF-{regency_id}', [PesertaController::class, 'exportPDFRegency'])->name('peserta-regency.pdf');
Route::get('peserta-villages-exportPDF-{villages_id}', [PesertaController::class, 'exportPDFVillages'])->name('peserta-villages.pdf');
Route::get('peserta-regency-exportExcel-{id}', [PesertaController::class, 'exportExcelRegency'])->name('peserta-regency.excel');
Route::get('peserta-villages-exportExcel-{id}', [PesertaController::class, 'exportExcelVillages'])->name('peserta-villages.excel');
Route::get('/export-pdf-status-peserta', [PesertaController::class, 'exportPdfStatus'])->name('export-peserta.pdf.status');

Route::resource('/admin-data-pembayaran', PembayaranController::class);
Route::get('export-pembayaran', [\App\Http\Controllers\PembayaranController::class, 'export'])->name('export-pembayaran');
Route::put('/pembayaran-verifikasi{id}', [App\Http\Controllers\PembayaranController::class, 'verifikasiPembayaran'])->name('verifikasiPembayaran');
Route::get('pembayaran-exportExcel{id}', [PembayaranController::class, 'exportExcel'])->name('pembayaran.excel');
Route::get('pembayaran-exportadminExcel', [PembayaranController::class, 'exportAdminExcel'])->name('pembayaran.admin-excel');
Route::get('pembayaran-export-PDF', [PembayaranController::class, 'exportPDF'])->name('pembayaran.pdf');



Route::resource('/admin-artikel', ArtikelController::class);
Route::get('/create-artikel', [App\Http\Controllers\ArtikelController::class, 'create'])->name('createArtikel');
Route::get('/edit{slug}', [App\Http\Controllers\ArtikelController::class, 'edit'])->name('editArtikel');
Route::put('/edit-artikel/{slug}', [App\Http\Controllers\ArtikelController::class, 'update'])->name('updateArtikel');
Route::get('/{slug}', [App\Http\Controllers\ArtikelController::class, 'show'])->name('readArtikel');


//Update User Details
Route::post('/update-profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
