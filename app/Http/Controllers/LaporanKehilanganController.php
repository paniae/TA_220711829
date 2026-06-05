<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaporanKehilangan;
use App\Models\KomentarForum;
use Illuminate\Support\Facades\Auth;

class LaporanKehilanganController extends Controller
{
    public function index()
    {
        $laporan = LaporanKehilangan::latest()->get();
        return view('laporanKehilangan.kelolaForumKehilangan', compact('laporan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_hilang' => 'required',
            'tanggal_hilang' => 'required|date',
            'lokasi_hilang' => 'required',
            'deskripsi_laporan' => 'nullable|string',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $foto = null;
        if ($request->hasFile('foto_barang')) {
            $foto = $request->file('foto_barang')->store('kehilangan', 'public');
        }

        $laporan = LaporanKehilangan::create([
            'id_pengguna' => Auth::id(),
            'barang_hilang' => $request->barang_hilang,
            'tanggal_hilang' => $request->tanggal_hilang,
            'lokasi_hilang' => $request->lokasi_hilang,
            'foto_barang' => $foto,
            'tanggal_laporan' => now(),
            'deskripsi_laporan' => $request->deskripsi_laporan,
            'status_kehilangan' => 'hilang'
        ]);

        // Mengirim notifikasi email ke semua user kecuali pembuat laporan
        try {
            $penerima = \App\Models\Pengguna::where('id_pengguna', '!=', Auth::id())
                ->whereNotNull('email_pengguna')
                ->where('email_pengguna', '!=', '')
                ->get();

            foreach ($penerima as $user) {
                \Illuminate\Support\Facades\Mail::to($user->email_pengguna)->send(new \App\Mail\LaporanKehilanganBaruMail($laporan));
            }
        } catch (\Exception $e) {
            // Log error tapi jangan sampai membatalkan posting laporan
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email laporan kehilangan baru: ' . $e->getMessage());
        }

        return back()->with('success', 'Laporan berhasil dibuat!');
    }

    public function show($id)
    {
        $laporan = LaporanKehilangan::findOrFail($id);
        return view('laporanKehilangan.tambahKomentarForum', compact('laporan'));
    }

    public function tambahKomentar($id)
    {
        $laporan = LaporanKehilangan::findOrFail($id);
        return view('laporanKehilangan.tambahKomentarForum', compact('laporan'));
    }

    public function kelolaKomentar($id)
    {
        $laporan = LaporanKehilangan::findOrFail($id);
        return view('laporanKehilangan.kelolaKomentarForum', compact('laporan'));
    }

    public function storeKomentar(Request $request, $id)
    {
        $laporan = LaporanKehilangan::findOrFail($id);
        if ($laporan->status_kehilangan == 'ditemukan') {
            return back()->with('error', 'Forum ini telah ditutup karena barang sudah ditemukan!');
        }

        $request->validate([
            'komentar' => 'required',
            'foto_komen' => 'nullable|image|max:2048'
        ]);

        $foto = null;
        if ($request->hasFile('foto_komen')) {
            $foto = $request->file('foto_komen')->store('komentar', 'public');
        }

        KomentarForum::create([
            'id_laporan' => $id,
            'id_pengguna' => Auth::id(),
            'komentar' => $request->komentar,
            'tgl_waktu_komen' => now(),
            'foto_komen' => $foto
        ]);

        return back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function updateKomentar(Request $request, $id_komen)
    {
        $komen = KomentarForum::findOrFail($id_komen);
        
        if ($komen->laporan->status_kehilangan == 'ditemukan') {
            return back()->with('error', 'Komentar tidak dapat diubah karena forum telah ditutup!');
        }
        
        if ($komen->id_pengguna != Auth::id()) {
            return back()->with('error', 'Anda hanya dapat mengubah komentar Anda sendiri!');
        }
        
        $request->validate([
            'komentar' => 'required',
            'foto_komen' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto_komen')) {
            $foto = $request->file('foto_komen')->store('komentar', 'public');
            $komen->foto_komen = $foto;
        }

        $komen->komentar = $request->komentar;
        $komen->save();

        return back()->with('success', 'Komentar berhasil diperbarui!');
    }

    public function destroyKomentar($id_komen)
    {
        $komen = KomentarForum::findOrFail($id_komen);
        
        $user = Auth::user();
        $canDelete = $komen->id_pengguna == $user->id_pengguna || $user->hasAkses('kelola_komentar') || $user->isDukuh();
                     
        if (!$canDelete) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus komentar ini!');
        }
        
        $komen->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $laporan = LaporanKehilangan::findOrFail($id);

        if ($laporan->id_pengguna != Auth::id()) {
            return back()->with('error', 'Anda hanya dapat mengubah laporan milik Anda sendiri!');
        }

        if ($laporan->status_kehilangan == 'ditemukan') {
            return back()->with('error', 'Laporan yang sudah ditemukan tidak dapat diubah kembali!');
        }

        $request->validate([
            'barang_hilang' => 'required',
            'tanggal_hilang' => 'required|date',
            'lokasi_hilang' => 'required',
            'deskripsi_laporan' => 'nullable|string',
            'status_kehilangan' => 'required|in:hilang,ditemukan',
            'foto_barang' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($request->hasFile('foto_barang')) {
            if ($laporan->foto_barang && \Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->foto_barang)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto_barang);
            }
            $foto = $request->file('foto_barang')->store('kehilangan', 'public');
            $laporan->foto_barang = $foto;
        }

        $laporan->barang_hilang = $request->barang_hilang;
        $laporan->tanggal_hilang = $request->tanggal_hilang;
        $laporan->lokasi_hilang = $request->lokasi_hilang;
        $laporan->deskripsi_laporan = $request->deskripsi_laporan;
        $laporan->status_kehilangan = $request->status_kehilangan;
        $laporan->save();

        return back()->with('success', 'Laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $laporan = LaporanKehilangan::findOrFail($id);
        $user = Auth::user();

        $canDelete = ($laporan->id_pengguna == $user->id_pengguna) || $user->hasAkses('kelola_laporan_kehilangan') || $user->isDukuh();

        if (!$canDelete) {
            return back()->with('error', 'Anda tidak memiliki akses untuk menghapus laporan ini!');
        }

        if ($laporan->foto_barang && \Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->foto_barang)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto_barang);
        }

        $laporan->delete();

        return back()->with('success', 'Laporan berhasil dihapus!');
    }

    public function tutup($id)
    {
        $laporan = LaporanKehilangan::findOrFail($id);

        if ($laporan->id_pengguna != Auth::id()) {
            return back()->with('error', 'Anda hanya dapat menutup laporan milik Anda sendiri!');
        }

        $laporan->status_kehilangan = 'ditemukan';
        $laporan->save();

        return back()->with('success', 'Berhasil menutup forum, benda sudah ditemukan!');
    }

    public function getKomentarList(Request $request, $id)
    {
        $laporan = LaporanKehilangan::findOrFail($id);
        $isModerator = $request->query('moderator') == 1;

        return view('laporanKehilangan.komentarList', compact('laporan', 'isModerator'));
    }

    public function getLaporanListPoll()
    {
        $laporan = LaporanKehilangan::latest()->get();
        return view('laporanKehilangan.laporanList', compact('laporan'));
    }
}
