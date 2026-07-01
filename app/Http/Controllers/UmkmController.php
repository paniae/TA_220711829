<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use Illuminate\Support\Facades\Storage;
use App\Models\ProdukUmkm;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->input('kategori');

        $umkmSaya = Umkm::where('id_pengguna', auth()->id())->latest()->get();
        foreach($umkmSaya as $item) {
            $item->status = $item->status_umkm;
            $item->nomor_telepon = $item->nomor_telepon_umkm;
            $item->email = $item->email_umkm;
        }

        $queryWarga = Umkm::where('status_umkm', 'aktif');
                        
        if ($kategori) {
            $queryWarga->where('bidang_umkm', $kategori);
        }

        $umkmWarga = $queryWarga->latest()->get();

        foreach($umkmWarga as $item) {
            $item->status = $item->status_umkm;
            $item->nomor_telepon = $item->nomor_telepon_umkm;
            $item->email = $item->email_umkm;
        }

        return view('umkm.kelolaUMKM', compact('umkmSaya', 'umkmWarga', 'kategori'));
    }


    public function indexGuest(Request $request)
    {
        $kategori = $request->input('kategori');
        $searchUmkm = $request->input('search_umkm');

        $queryWarga = Umkm::where('status_umkm', 'aktif');
                        
        if ($kategori) {
            $queryWarga->where('bidang_umkm', $kategori);
        }

        if ($searchUmkm) {
            $queryWarga->where(function($q) use ($searchUmkm) {
                $q->where('nama_umkm', 'like', "%{$searchUmkm}%")
                  ->orWhere('alamat_umkm', 'like', "%{$searchUmkm}%");
            });
        }

        $umkmWarga = $queryWarga->latest()->get();

        foreach($umkmWarga as $item) {
            $item->status = $item->status_umkm;
            $item->nomor_telepon = $item->nomor_telepon_umkm;
            $item->email = $item->email_umkm;
        }

        $search = $request->input('search');

        $queryProduk = ProdukUmkm::with(['umkm', 'produkMaster'])
                        ->where('status_produk', 'tersedia')
                        ->whereHas('umkm', function($q) {
                            $q->where('status_umkm', 'aktif');
                        })
                        ->whereHas('produkMaster', function($q) {
                            $q->where('status_produk_master', 'aktif');
                        });

        if ($search) {
            $matchingMasterIdsByProduct = \App\Models\ProdukUmkm::where('nama_produk', 'like', "%{$search}%")
                ->pluck('id_produk_master')
                ->toArray();
                
            $matchingMasterIdsByMaster = \App\Models\ProdukMaster::where('nama_produk_master', 'like', "%{$search}%")
                ->pluck('id_produk_master')
                ->toArray();
                
            $allMatchingMasterIds = array_unique(array_merge($matchingMasterIdsByProduct, $matchingMasterIdsByMaster));

            $queryProduk->where(function($q) use ($search, $allMatchingMasterIds) {
                if (!empty($allMatchingMasterIds)) {
                    $q->whereIn('id_produk_master', $allMatchingMasterIds)
                      ->orWhere('nama_produk', 'like', "%{$search}%");
                } else {
                    $q->where('nama_produk', 'like', "%{$search}%");
                }
            });
        }

        $semuaProduk = $queryProduk->latest()->get();

        if ($search) {
            $semuaProduk = $semuaProduk->sortBy(function($item) use ($search) {
                $searchLower = strtolower($search);
                $namaProduk = strtolower($item->nama_produk);
                $namaMaster = strtolower($item->produkMaster->nama_produk_master ?? '');

                if (strpos($namaMaster, $searchLower) !== false) {
                    return 1;
                } elseif (strpos($namaProduk, $searchLower) !== false) {
                    return 2;
                } else {
                    return 3;
                }
            })->values();
        }
                        
        foreach($semuaProduk as $p) {
            $p->foto_produk_umkm = $p->foto_produk;
            $p->deskripsi = $p->deskripsi_produk;
            $p->status = $p->status_produk;
        }

        return view('guest.lihatUMKMGuest', compact('umkmWarga', 'kategori', 'semuaProduk'));
    }

    public function store(Request $request)
    {

        if ($request->hasFile('foto_umkm')) {
            $path = $request->file('foto_umkm')->store('umkm', 'public');
        } else {
            $defaultImages = [
                'kuliner' => 'images/kuliner.jpg',
                'fashion' => 'images/fashion.jpg',
                'agribisnis' => 'images/agribisnis.jpg',
                'jasa & produk kreatif' => 'images/jasa.jpg',
                'teknologi dan digital' => 'images/teknologi.jpg',
            ];
            $path = $defaultImages[$request->bidang_umkm] ?? 'images/default.jpg';
        }

        $request->validate([
            'nama_umkm' => 'required',
            'alamat_umkm' => 'required',
            'nomor_telepon' => 'required',
            'bidang_umkm' => 'required',
        ]);

        Umkm::create([
            'id_pengguna' => auth()->id() ?? 1,
            'nama_umkm' => $request->nama_umkm,
            'alamat_umkm' => $request->alamat_umkm,
            'nomor_telepon_umkm' => $request->nomor_telepon,
            'is_nomor_telepon_ditampilkan' => $request->is_nomor_telepon_ditampilkan ?? 1,
            'email_umkm' => $request->email,
            'deskripsi_umkm' => $request->deskripsi,
            'bidang_umkm' => $request->bidang_umkm,
            'foto_umkm' => $path,
            'status_umkm' => 'menunggu',
        ]);

        return redirect()->back()->with('success', 'UMKM berhasil didaftarkan');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama_umkm' => 'required',
            'alamat_umkm' => 'required',
            'nomor_telepon' => 'required',
            'bidang_umkm' => 'required',
        ]);

        $defaultImages = [
            'kuliner' => 'images/kuliner.jpg',
            'fashion' => 'images/fashion.jpg',
            'agribisnis' => 'images/agribisnis.jpg',
            'jasa & produk kreatif' => 'images/kreatif.jpg',
            'teknologi dan digital' => 'images/teknologi.jpg',
        ];

        $path = $defaultImages[$request->bidang_umkm] ?? 'images/default.jpg';
        if ($request->hasFile('foto_umkm')) {
            $path = $request->file('foto_umkm')->store('umkm', 'public');
        }

        Umkm::create([
            'id_pengguna' => $request->id_pengguna ?? auth()->id() ?? 1,
            'nama_umkm' => $request->nama_umkm,
            'alamat_umkm' => $request->alamat_umkm,
            'nomor_telepon_umkm' => $request->nomor_telepon,
            'is_nomor_telepon_ditampilkan' => $request->is_nomor_telepon_ditampilkan ?? 1,
            'email_umkm' => $request->email,
            'deskripsi_umkm' => $request->deskripsi,
            'bidang_umkm' => $request->bidang_umkm,
            'foto_umkm' => $path,
            'status_umkm' => 'aktif',
        ]);

        return redirect()->back()->with('success', 'UMKM berhasil didaftarkan dan langsung aktif');
    }

    public function storeProdukMasterAdmin(Request $request)
    {
        $request->validate([
            'nama_produk_master' => 'required|string'
        ]);

        $nama_produk_master = ucwords(strtolower(trim($request->nama_produk_master)));

        $exists = \App\Models\ProdukMaster::where('nama_produk_master', $nama_produk_master)->first();
        if ($exists) {
            return redirect()->back()->with('success', 'Produk Master sudah ada di database');
        }

        \App\Models\ProdukMaster::create([
            'nama_produk_master' => $nama_produk_master,
            'status_produk_master' => 'aktif'
        ]);

        return redirect()->back()->with('success', 'Produk Master berhasil ditambahkan dan langsung aktif');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_umkm' => 'required',
            'alamat_umkm' => 'required',
            'nomor_telepon' => 'required',
            'bidang_umkm' => 'required',
        ]);

        $umkm = Umkm::findOrFail($id);

        $umkm->nama_umkm = $request->nama_umkm;
        $umkm->alamat_umkm = $request->alamat_umkm;
        $umkm->nomor_telepon_umkm = $request->nomor_telepon;
        $umkm->is_nomor_telepon_ditampilkan = $request->is_nomor_telepon_ditampilkan ?? 1;
        $umkm->email_umkm = $request->email;
        $umkm->deskripsi_umkm = $request->deskripsi;
        $umkm->bidang_umkm = $request->bidang_umkm;

        $defaultImages = [
            'kuliner' => 'images/kuliner.jpg',
            'fashion' => 'images/fashion.jpg',
            'agribisnis' => 'images/agribisnis.jpg',
            'jasa & produk kreatif' => 'images/kreatif.jpg',
            'teknologi dan digital' => 'images/teknologi.jpg',
        ];

        if ($request->hapus_foto) {
            if ($umkm->foto_umkm && !str_contains($umkm->foto_umkm, 'images/')) {
                Storage::disk('public')->delete($umkm->foto_umkm);
            }
            $umkm->foto_umkm = $defaultImages[$request->bidang_umkm] ?? 'images/default.jpg';
        }

        if ($request->hasFile('foto_umkm')) {
            if ($umkm->foto_umkm && !str_contains($umkm->foto_umkm, 'images/')) {
                Storage::disk('public')->delete($umkm->foto_umkm);
            }
            $path = $request->file('foto_umkm')->store('umkm', 'public');
            $umkm->foto_umkm = $path;
        }

        $umkm->save();

        return back()->with('success', 'UMKM berhasil diupdate!');
    }

    public function destroy($id)
    {
        $umkm = Umkm::findOrFail($id);

        if ($umkm->foto_umkm && !str_contains($umkm->foto_umkm, 'images/')) {
            Storage::disk('public')->delete($umkm->foto_umkm);
        }

        $umkm->delete();

        return back()->with('success', 'UMKM berhasil dihapus!');
    }

    public function produk($id)
    {
        $umkm = Umkm::findOrFail($id);
        
        $query = ProdukUmkm::with('produkMaster')->where('id_umkm', $id);
        
        $isOwnerOrAdmin = auth()->check() && (auth()->id() == $umkm->id_pengguna || auth()->user()->hasAkses('konfirmasi_umkm'));
        
        if (!$isOwnerOrAdmin) {
            $query->where('status_produk', 'tersedia')
                  ->whereHas('produkMaster', function($q) {
                      $q->where('status_produk_master', 'aktif');
                  });
        }
        
        $produk = $query->get();
        $produk_master = \App\Models\ProdukMaster::all();

        foreach($produk as $p) {
            $p->foto_produk_umkm = $p->foto_produk;
            $p->deskripsi = $p->deskripsi_produk;
            $p->status = $p->status_produk;
        }

        return view('umkm.kelolaProdukUMKM', compact('umkm', 'produk', 'produk_master'));
    }

    public function storeProduk(Request $request)
    {
        $request->validate([
            'id_umkm' => 'required',
            'nama_produk' => 'required',
            'nama_produk_umum' => 'required|string',
            'harga' => 'required|numeric',
            'foto_produk_umkm' => 'nullable|image',
        ]);

        $namaProdukUmum = ucwords(strtolower(trim($request->nama_produk_umum)));

        $produkMaster = \App\Models\ProdukMaster::whereRaw('LOWER(nama_produk_master) = ?', [strtolower(trim($request->nama_produk_umum))])->first();
        if (!$produkMaster) {
            $isUmkmAdmin = auth()->check() && auth()->user()->hasAkses('konfirmasi_umkm');

            $produkMaster = \App\Models\ProdukMaster::create([
                'nama_produk_master' => $namaProdukUmum,
                'status_produk_master' => $isUmkmAdmin ? 'aktif' : 'menunggu',
            ]);

            if (!$isUmkmAdmin) {
                $adminUsers = \App\Models\Pengguna::with('role.akses')
                    ->whereNotNull('email_pengguna')
                    ->where('status_pengguna', 'aktif')
                    ->get()
                    ->filter(function($u) {
                        return $u->hasAkses('konfirmasi_umkm');
                    });

                foreach ($adminUsers as $admin) {
                    try {
                        \Illuminate\Support\Facades\Mail::to($admin->email_pengguna)
                            ->send(new \App\Mail\ProdukMasterBaruMail($produkMaster, auth()->user()));
                    } catch (\Exception $e) {
                    }
                }
            }
        }

        $data = [
            'id_umkm' => $request->id_umkm,
            'id_produk_master' => $produkMaster->id_produk_master,
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'deskripsi_produk' => $request->deskripsi,
            'status_produk' => 'tersedia',
        ];

        if ($request->hasFile('foto_produk_umkm')) {
            $data['foto_produk'] = $request->file('foto_produk_umkm')->store('produk_umkm', 'public');
        }

        ProdukUmkm::create($data);

        return back()->with('success', 'Produk berhasil ditambahkan');
    }

    public function updateProduk(Request $request, $id)
    {
        $produk = ProdukUmkm::with('umkm')->findOrFail($id);

        if ($produk->umkm->id_pengguna != auth()->id()) {
            return back()->with('error', 'Akses ditolak! Anda hanya dapat mengubah produk milik Anda sendiri.');
        }

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'status' => 'required',
            'foto_produk_umkm' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'deskripsi_produk' => $request->deskripsi,
            'status_produk' => $request->status,
        ];

        if ($request->hasFile('foto_produk_umkm')) {
            if ($produk->foto_produk) {
                Storage::disk('public')->delete($produk->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto_produk_umkm')->store('produk_umkm', 'public');
        }

        $produk->update($data);

        return back()->with('success', 'Produk berhasil diubah');
    }

    public function destroyProduk($id)
    {
        $produk = ProdukUmkm::with('umkm')->findOrFail($id);

        if ($produk->umkm->id_pengguna != auth()->id()) {
            return back()->with('error', 'Akses ditolak! Anda hanya dapat menghapus produk milik Anda sendiri.');
        }

        if ($produk->foto_produk) {
            Storage::disk('public')->delete($produk->foto_produk);
        }

        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }

    public function listKonfirmasi(Request $request)
    {
        $status = $request->status;
        $kategori = $request->kategori;
        $searchUmkm = $request->search_umkm;

        $query = Umkm::query();

        if ($status) {
            $query->where('status_umkm', $status);
        }

        if ($kategori) {
            $query->where('bidang_umkm', $kategori);
        }

        if ($searchUmkm) {
            $query->where(function($q) use ($searchUmkm) {
                $q->where('nama_umkm', 'like', "%{$searchUmkm}%")
                  ->orWhere('alamat_umkm', 'like', "%{$searchUmkm}%");
            });
        }

        $umkm = $query->latest()->get();

        foreach($umkm as $item) {
            $item->status = $item->status_umkm;
            $item->nama_pemilik = $item->pengguna->nama ?? 'Tidak diketahui';
            $item->alamat = $item->alamat_umkm;
            $item->deskripsi = $item->deskripsi_umkm;
            $item->foto = $item->foto_umkm;
        }

        $statusProduk = $request->status_produk;
        $searchProduk = $request->search_produk;
        $queryProduk = \App\Models\ProdukMaster::query();

        if ($statusProduk) {
            $queryProduk->where('status_produk_master', $statusProduk);
        } else {
            $queryProduk->orderByRaw("CASE WHEN status_produk_master = 'menunggu' THEN 1 ELSE 2 END");
        }

        if ($searchProduk) {
            $queryProduk->where('nama_produk_master', 'like', "%{$searchProduk}%");
        }

        $produkMaster = $queryProduk->latest()->get();

        return view('umkm.konfirmasiUMKM', [
            'umkm' => $umkm,
            'menunggu' => Umkm::where('status_umkm', 'menunggu')->count(),
            'aktif' => Umkm::where('status_umkm', 'aktif')->count(),
            'currentStatus' => $status,
            'kategori' => $kategori,
            'produkMaster' => $produkMaster,
            'currentStatusProduk' => $statusProduk,
            'totalProdukMaster' => \App\Models\ProdukMaster::count(),
            'menungguProdukMaster' => \App\Models\ProdukMaster::where('status_produk_master', 'menunggu')->count(),
            'aktifProdukMaster' => \App\Models\ProdukMaster::where('status_produk_master', 'aktif')->count(),
            'penggunaList' => \App\Models\Pengguna::where('status_pengguna', 'aktif')->get()
        ]);
    }

    public function konfirmasi($id)
    {
        $umkm = Umkm::findOrFail($id);
        $umkm->status_umkm = 'aktif';
        $umkm->save();

        return back()->with('success', 'UMKM berhasil diaktifkan');
    }

    public function konfirmasiProdukMaster($id)
    {
        $pm = \App\Models\ProdukMaster::findOrFail($id);
        $pm->status_produk_master = 'aktif';
        $pm->save();

        return back()->with('success', 'Produk Master berhasil dikonfirmasi dan diaktifkan');
    }

    public function tolakProdukMaster(Request $request, $id)
    {
        $request->validate([
            'nama_produk_baru' => 'required|string'
        ]);

        $nama_baru = ucwords(strtolower(trim($request->nama_produk_baru)));
        $pm = \App\Models\ProdukMaster::findOrFail($id);

        $existingPM = \App\Models\ProdukMaster::where('nama_produk_master', $nama_baru)
            ->where('id_produk_master', '!=', $id)
            ->first();

        if ($existingPM) {
            \App\Models\ProdukUmkm::where('id_produk_master', $id)->update([
                'id_produk_master' => $existingPM->id_produk_master
            ]);
            $pm->delete();
            return back()->with('success', 'Nama Produk Master telah terhubung dengan data yang sudah ada.');
        }

        $pm->nama_produk_master = $nama_baru;
        $pm->save();

        return back()->with('success', 'Nama Produk Master berhasil dikoreksi dan dikembalikan ke antrean');
    }

    public function updateProdukMasterAdmin(Request $request, $id)
    {
        $request->validate([
            'nama_produk_master' => 'required|string'
        ]);

        $nama_baru = ucwords(strtolower(trim($request->nama_produk_master)));
        $pm = \App\Models\ProdukMaster::findOrFail($id);

        $existingPM = \App\Models\ProdukMaster::where('nama_produk_master', $nama_baru)
            ->where('id_produk_master', '!=', $id)
            ->first();

        if ($existingPM) {
            \App\Models\ProdukUmkm::where('id_produk_master', $id)->update([
                'id_produk_master' => $existingPM->id_produk_master
            ]);
            $pm->delete();
            return back()->with('success', 'Produk Master terhubung ke data yang sudah ada.');
        }

        $pm->nama_produk_master = $nama_baru;
        $pm->save();

        return back()->with('success', 'Nama Produk Master berhasil diubah');
    }

    public function destroyProdukMasterAdmin($id)
    {
        $pm = \App\Models\ProdukMaster::findOrFail($id);
        $pm->delete();

        return back()->with('success', 'Produk Master berhasil dihapus');
    }


}
