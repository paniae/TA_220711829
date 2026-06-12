<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\berandaController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LaporanKehilanganController;
use App\Http\Controllers\ProfilPadukuhanController;
use App\Http\Controllers\KontakPadukuhanController;
use App\Http\Controllers\RoleAksesController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\UmkmController;

Route::get('/', [berandaController::class, 'index']);

Route::get('/beranda', [berandaController::class, 'index'])->name('beranda');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'resetPassword'])->name('forgot-password.reset');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/check-uniqueness', function (Illuminate\Http\Request $request) {
    $field = $request->query('field');
    $value = $request->query('value');

    $columnMap = [
        'username' => 'username',
        'nik' => 'nik',
        'nomor_telepon' => 'nomor_telepon_pengguna',
        'email' => 'email_pengguna',
    ];

    if (!isset($columnMap[$field])) {
        return response()->json(['exists' => false]);
    }

    $column = $columnMap[$field];

    if ($field === 'email' && empty($value)) {
        return response()->json(['exists' => false]);
    }

    $exists = \App\Models\Pengguna::where($column, $value)->exists();
    return response()->json(['exists' => $exists]);
})->withoutMiddleware([
    \Illuminate\Session\Middleware\StartSession::class,
    \Illuminate\View\Middleware\ShareErrorsFromSession::class
]);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/kegiatan/kelolaKegiatan', [KegiatanController::class, 'kelola'])->name('kegiatan.kelolaKegiatan');
Route::group(['prefix' => 'kegiatan', 'as' => 'kegiatan.'], function () {
    Route::get('/lihat', [KegiatanController::class, 'lihat'])->name('lihat');
    Route::post('/store', [KegiatanController::class, 'store'])->name('store');
    Route::get('/{id}', [KegiatanController::class, 'show'])->name('show');
    Route::put('/{id}', [KegiatanController::class, 'update'])->name('update');
    Route::delete('/{id}', [KegiatanController::class, 'destroy'])->name('destroy');
    Route::put('/{id}/mulai', [KegiatanController::class, 'mulai'])->name('mulai');
    Route::put('/{id}/selesai', [KegiatanController::class, 'selesai'])->name('selesai');
});

Route::group(['prefix' => 'pengaduan', 'as' => 'pengaduan.'], function () {
    Route::get('/kelola', [PengaduanController::class, 'index'])->name('kelolaPengaduan');
    Route::get('/', [PengaduanController::class, 'create'])->name('indexWarga');
    Route::post('/store', [PengaduanController::class, 'store'])->name('store');
    Route::put('/{id}', [PengaduanController::class, 'update'])->name('update');
    Route::delete('/{id}', [PengaduanController::class, 'destroy'])->name('destroy');
    Route::put('/{id}/terima', [PengaduanController::class, 'terima'])->name('terima');
    Route::put('/{id}/tolak', [PengaduanController::class, 'tolak'])->name('tolak');
    Route::put('/{id}/selesai', [PengaduanController::class, 'selesai'])->name('selesai');
});



Route::get('/profilPadukuhan', [ProfilPadukuhanController::class, 'index'])->name('profilPadukuhan');
Route::put('/profilPadukuhan', [ProfilPadukuhanController::class, 'update'])->name('profilPadukuhan.update');

Route::get('/kontakPadukuhan', [KontakPadukuhanController::class, 'index'])->name('kontakPadukuhan');
Route::put('/kontakPadukuhan', [KontakPadukuhanController::class, 'update'])->name('kontakPadukuhan.update');

// Route gabungan Informasi Umum Padukuhan
Route::get('/informasiUmum', [ProfilPadukuhanController::class, 'index'])->name('informasiUmum');
Route::put('/informasiUmum/profil', [ProfilPadukuhanController::class, 'update'])->name('informasiUmum.profil.update');
Route::put('/informasiUmum/kontak', [KontakPadukuhanController::class, 'update'])->name('informasiUmum.kontak.update');



Route::group(['prefix' => 'penduduk', 'as' => 'penduduk.'], function () {
    Route::get('/', [PendudukController::class, 'index'])->name('index');
    Route::post('/store', [PendudukController::class, 'store'])->name('store');
    Route::put('/{id}', [PendudukController::class, 'update'])->name('update');
    Route::delete('/{id}', [PendudukController::class, 'destroy'])->name('destroy');
});

Route::group(['prefix' => 'pengguna', 'as' => 'pengguna.'], function () {
    Route::get('/profil', [PenggunaController::class, 'profil'])->name('profil.index');
    Route::post('/profil/update', [PenggunaController::class, 'updateProfil'])->name('profil.update');
    Route::post('/profil/update-password', [PenggunaController::class, 'updatePassword'])->name('profil.updatePassword');
    Route::post('/profil/hapus-foto', [PenggunaController::class, 'hapusFotoProfil'])->name('profil.hapusFoto');
    
    Route::get('/kelola', [PenggunaController::class, 'kelola'])->name('kelola');
    Route::post('/store', [PenggunaController::class, 'store'])->name('store');
    Route::put('/{id}', [PenggunaController::class, 'update'])->name('update');
    Route::delete('/{id}', [PenggunaController::class, 'destroy'])->name('destroy');
    Route::put('/{id}/terima', [PenggunaController::class, 'terima'])->name('terima');
    Route::delete('/{id}/tolak', [PenggunaController::class, 'tolak'])->name('tolak');
});



Route::group(['prefix' => 'kehilangan', 'as' => 'kehilangan.'], function () {
    Route::get('/', [LaporanKehilanganController::class, 'index'])->name('index');
    Route::post('/store', [LaporanKehilanganController::class, 'store'])->name('store');
    Route::get('/{id}', [LaporanKehilanganController::class, 'show'])->name('show');
    Route::put('/{id}', [LaporanKehilanganController::class, 'update'])->name('update');
    Route::delete('/{id}', [LaporanKehilanganController::class, 'destroy'])->name('destroy');
    Route::put('/{id}/tutup', [LaporanKehilanganController::class, 'tutup'])->name('tutup');
    Route::get('/{id}/komentar/tambah', [LaporanKehilanganController::class, 'tambahKomentar'])->name('tambahKomentar');
    Route::post('/{id}/komentar/tambah', [LaporanKehilanganController::class, 'storeKomentar'])->name('storeKomentar');
    Route::put('/komentar/{id_komen}', [LaporanKehilanganController::class, 'updateKomentar'])->name('updateKomentar');
    Route::get('/{id}/komentar/kelola', [LaporanKehilanganController::class, 'kelolaKomentar'])->name('kelolaKomentar');
    Route::delete('/komentar/{id_komen}', [LaporanKehilanganController::class, 'destroyKomentar'])->name('destroyKomentar');
    Route::get('/{id}/komentar-list', [LaporanKehilanganController::class, 'getKomentarList'])->name('komentarList');
    Route::get('/list/poll', [LaporanKehilanganController::class, 'getLaporanListPoll'])->name('laporanListPoll');
});

Route::get('/role/kelola', [RoleAksesController::class, 'index'])->name('role.kelola');
Route::post('/role/store', [RoleAksesController::class, 'store'])->name('role.store');
Route::put('/role/{id}', [RoleAksesController::class, 'update'])->name('role.update');
Route::delete('/role/{id}', [RoleAksesController::class, 'destroy'])->name('role.destroy');
Route::post('/role/akses/assign', [RoleAksesController::class, 'assignRole'])->name('role.akses.assign');
Route::delete('/role/akses/revoke/{id_role}/{id_akses}', [RoleAksesController::class, 'revokeRole'])->name('role.akses.revoke');

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/laporan-penduduk', [LaporanController::class, 'laporanPenduduk'])->name('laporan.penduduk');
Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
Route::get('/kegiatan/{id}/dokumentasi', [KegiatanController::class, 'lihatDokumentasi'])->name('kegiatan.dokumentasi');
Route::post('/kegiatan/{id}/dokumentasi', [KegiatanController::class, 'storeDokumentasi'])->name('kegiatan.dokumentasi.store');
Route::get('/kegiatan/{id}/dokumentasi/download-all', [KegiatanController::class, 'downloadAllDokumentasi'])->name('kegiatan.dokumentasi.downloadAll');
Route::put('/dokumentasi/{id}', [KegiatanController::class, 'updateDokumentasi'])->name('kegiatan.dokumentasi.update');
Route::delete('/dokumentasi/{id}', [KegiatanController::class, 'destroyDokumentasi'])->name('kegiatan.dokumentasi.destroy');

// Routes UMKM
Route::get('/umkm/guest', [UmkmController::class, 'indexGuest'])->name('guest.umkm');
Route::get('/umkm', [UmkmController::class, 'index'])->name('warga.umkm');
Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store');
Route::get('/umkm/produk/{id}', [UmkmController::class, 'produk'])->name('warga.produkUMKM');
Route::post('/produk', [UmkmController::class, 'storeProduk'])->name('produk.store');
Route::put('/produk/{id}', [UmkmController::class, 'updateProduk'])->name('produk.update');
Route::delete('/produk/{id}', [UmkmController::class, 'destroyProduk'])->name('produk.destroy');

Route::put('/umkm/{id}', [UmkmController::class, 'update'])->name('umkm.update');
Route::delete('/umkm/{id}', [UmkmController::class, 'destroy'])->name('umkm.destroy');

Route::get('/umkm/konfirmasi', [UmkmController::class, 'listKonfirmasi'])->name('umkm.konfirmasi.index');
Route::post('/umkm/admin', [UmkmController::class, 'storeAdmin'])->name('umkm.storeAdmin');
Route::post('/umkm/produk-master-admin', [UmkmController::class, 'storeProdukMasterAdmin'])->name('umkm.storeProdukMasterAdmin');
Route::get('/umkm/konfirmasi/{id}', [UmkmController::class, 'show'])->name('umkm.konfirmasi.show');
Route::put('/umkm/konfirmasi/{id}', [UmkmController::class, 'konfirmasi'])->name('umkm.konfirmasi.confirm');
Route::put('/umkm/konfirmasi-produk-master/{id}', [UmkmController::class, 'konfirmasiProdukMaster'])->name('umkm.konfirmasiProdukMaster');
Route::put('/umkm/tolak-produk-master/{id}', [UmkmController::class, 'tolakProdukMaster'])->name('umkm.tolakProdukMaster');
Route::put('/umkm/produk-master-admin/{id}', [UmkmController::class, 'updateProdukMasterAdmin'])->name('umkm.updateProdukMasterAdmin');
Route::delete('/umkm/produk-master-admin/{id}', [UmkmController::class, 'destroyProdukMasterAdmin'])->name('umkm.destroyProdukMasterAdmin');