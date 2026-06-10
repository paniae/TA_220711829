<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KegiatanPadukuhan;
use App\Models\Umkm;
use App\Models\LaporanKehilangan;

class berandaController extends Controller
{
    public function index()
    {
        $profil = \App\Models\ProfilPadukuhan::first();

        if (!auth()->check()) {
            $produkUnggulan = \App\Models\ProdukUmkm::with('umkm')
                            ->where('status_produk', 'tersedia')
                            ->whereHas('umkm', function($q) {
                                $q->where('status_umkm', 'aktif');
                            })
                            ->whereHas('produkMaster', function($q) {
                                $q->where('status_produk_master', 'aktif');
                            })
                            ->latest()
                            ->get()
                            ->unique('id_produk_master')
                            ->take(10);

            if ($produkUnggulan->count() < 8) {
                $sisa = 10 - $produkUnggulan->count();
                $tambahan = \App\Models\ProdukUmkm::with('umkm')
                                ->where('status_produk', 'tersedia')
                                ->whereNotIn('id_produk', $produkUnggulan->pluck('id_produk'))
                                ->whereHas('umkm', function($q) {
                                    $q->where('status_umkm', 'aktif');
                                })
                                ->whereHas('produkMaster', function($q) {
                                    $q->where('status_produk_master', 'aktif');
                                })
                                ->latest()
                                ->take($sisa)
                                ->get();
                $produkUnggulan = $produkUnggulan->merge($tambahan);
            }

            $kegiatan = KegiatanPadukuhan::where('jenis_kegiatan', 'kegiatan')
                            ->where(function($q) {
                                $q->where('status_kegiatan', '!=', 'selesai')
                                  ->where('status_kegiatan', '!=', 'Selesai');
                            })
                            ->orderBy('tgl_waktu_pelaksanaan', 'asc')
                            ->take(4)
                            ->get();
            
            $proker = KegiatanPadukuhan::where('jenis_kegiatan', 'proker')
                            ->where(function($q) {
                                $q->where('status_kegiatan', '!=', 'selesai')
                                  ->where('status_kegiatan', '!=', 'Selesai');
                            })
                            ->orderBy('tgl_waktu_pelaksanaan', 'asc')
                            ->take(4)
                            ->get();

            $kehilangan = LaporanKehilangan::where('status_kehilangan', 'hilang')
                            ->latest()
                            ->take(5)
                            ->get();

            return view('guest.berandaGuest', compact('profil', 'produkUnggulan', 'kegiatan', 'proker', 'kehilangan'));
        }

        $user = auth()->user();

        // Fetch Data for User and Dukuh Dashboard
        $produkUnggulan = \App\Models\ProdukUmkm::with('umkm')
                        ->where('status_produk', 'tersedia')
                        ->whereHas('umkm', function($q) {
                            $q->where('status_umkm', 'aktif');
                        })
                        ->whereHas('produkMaster', function($q) {
                            $q->where('status_produk_master', 'aktif');
                        })
                        ->latest()
                        ->get()
                        ->unique('id_produk_master')
                        ->take(10);

        if ($produkUnggulan->count() < 8) {
            $sisa = 10 - $produkUnggulan->count();
            $tambahan = \App\Models\ProdukUmkm::with('umkm')
                            ->where('status_produk', 'tersedia')
                            ->whereNotIn('id_produk', $produkUnggulan->pluck('id_produk'))
                            ->whereHas('umkm', function($q) {
                                $q->where('status_umkm', 'aktif');
                            })
                            ->whereHas('produkMaster', function($q) {
                                $q->where('status_produk_master', 'aktif');
                            })
                            ->latest()
                            ->take($sisa)
                            ->get();
            $produkUnggulan = $produkUnggulan->merge($tambahan);
        }

        $kegiatan = KegiatanPadukuhan::where('jenis_kegiatan', 'kegiatan')
                        ->where(function($q) {
                            $q->where('status_kegiatan', '!=', 'selesai')
                              ->where('status_kegiatan', '!=', 'Selesai');
                        })
                        ->orderBy('tgl_waktu_pelaksanaan', 'asc')
                        ->take(4)
                        ->get();
        
        $proker = KegiatanPadukuhan::where('jenis_kegiatan', 'proker')
                        ->where(function($q) {
                            $q->where('status_kegiatan', '!=', 'selesai')
                              ->where('status_kegiatan', '!=', 'Selesai');
                        })
                        ->orderBy('tgl_waktu_pelaksanaan', 'asc')
                        ->take(4)
                        ->get();

        $kehilangan = LaporanKehilangan::where('status_kehilangan', 'hilang')
                        ->latest()
                        ->take(5)
                        ->get();

        if ($user->isDukuh()) {
            $umkmMenunggu = \App\Models\Umkm::with('pengguna')->where('status_umkm', 'menunggu')->latest()->get();
            $produkMenunggu = \App\Models\ProdukMaster::where('status_produk_master', 'menunggu')->latest()->get();
            $pengaduanMenunggu = \App\Models\Pengaduan::with('pengguna')->where('status_pengaduan', 'menunggu')->latest()->take(4)->get();
            
            return view('beranda.berandaDukuh', compact('profil', 'produkUnggulan', 'kegiatan', 'proker', 'kehilangan', 'umkmMenunggu', 'produkMenunggu', 'pengaduanMenunggu'));
        }

        return view('beranda.berandaUser', compact('profil', 'produkUnggulan', 'kegiatan', 'proker', 'kehilangan'));
    }
}
