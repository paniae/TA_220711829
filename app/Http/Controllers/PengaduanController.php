<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\FotoPengaduan;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->status;
        $search = $request->search;

        $query = Pengaduan::with(['foto', 'pengguna']);

        if ($status) {
            $query->where('status_pengaduan', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('isi_pengaduan', 'like', '%' . $search . '%')
                  ->orWhereHas('pengguna', function($qu) use ($search) {
                      $qu->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        $pengaduan = $query->latest()->get();

        return view('pengaduan.kelolaPengaduan', [
            'pengaduan' => $pengaduan,
            'semua' => Pengaduan::count(),
            'menunggu' => Pengaduan::where('status_pengaduan', 'menunggu')->count(),
            'diterima' => Pengaduan::where('status_pengaduan', 'diterima')->count(),
            'selesai' => Pengaduan::where('status_pengaduan', 'selesai')->count(),
            'currentStatus' => $status,
            'search' => $search
        ]);
    }

    public function create(Request $request)
    {
        $status = $request->status;
        $query = Pengaduan::where('id_pengguna', Auth::id());

        if ($status) {
            $query->where('status_pengaduan', $status);
        }

        $pengaduan = $query->latest()->get();

        return view('pengaduan.tambahPengaduan', compact('pengaduan', 'status'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_pengaduan' => 'required|string',
            'foto_pengaduan.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $pengaduan = Pengaduan::create([
            'id_pengguna' => Auth::id(), 
            'isi_pengaduan' => $request->isi_pengaduan,
            'status_pengaduan' => 'menunggu',
            'tgl_waktu_pengaduan' => now()
        ]);

        if ($request->hasFile('foto_pengaduan')) {
            foreach ($request->file('foto_pengaduan') as $file) {

                $path = $file->store('pengaduan', 'public');

                FotoPengaduan::create([
                    'id_pengaduan' => $pengaduan->id_pengaduan,
                    'foto_pengaduan' => $path
                ]);
            }
        }

        // Mengirim notifikasi email ke Dukuh
        try {
            $dukuhs = \App\Models\Pengguna::whereHas('role', function($q) {
                $q->where('nama_role', 'dukuh');
            })->get();

            foreach ($dukuhs as $dukuh) {
                if ($dukuh->email_pengguna) {
                    \Illuminate\Support\Facades\Mail::to($dukuh->email_pengguna)->send(new \App\Mail\PengaduanBaruMail($pengaduan));
                }
            }
        } catch (\Exception $e) {
            // Log error tapi jangan sampai membatalkan pengaduan
            \Illuminate\Support\Facades\Log::error('Gagal mengirim email pengaduan: ' . $e->getMessage());
        }

        return back()->with('success', 'Pengaduan berhasil dikirim');
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        // 🔐 validasi
        $request->validate([
            'isi_pengaduan' => 'required|string',
            'foto_pengaduan.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // 🔐 cek pemilik
        if ($pengaduan->id_pengguna != Auth::id()) {
            abort(403);
        }

        // 🔐 cek status
        if ($pengaduan->status_pengaduan != 'menunggu') {
            return back()->with('error', 'Tidak bisa diubah');
        }

        // update isi
        $pengaduan->update([
            'isi_pengaduan' => $request->isi_pengaduan
        ]);

        // 🗑 hapus foto lama
        if ($request->delete_foto) {
            foreach ($request->delete_foto as $fotoId) {

                $foto = FotoPengaduan::where('id_foto_pengaduan', $fotoId)
                    ->where('id_pengaduan', $pengaduan->id_pengaduan)
                    ->first();

                if ($foto) {
                    \Storage::disk('public')->delete($foto->foto_pengaduan);
                    $foto->delete();
                }
            }
        }

        // 📸 upload baru
        if ($request->hasFile('foto_pengaduan')) {
            foreach ($request->file('foto_pengaduan') as $file) {

                $path = $file->store('pengaduan', 'public');

                FotoPengaduan::create([
                    'id_pengaduan' => $pengaduan->id_pengaduan,
                    'foto_pengaduan' => $path
                ]);
            }
        }

        return back()->with('success', 'Pengaduan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);

        if ($pengaduan->id_pengguna != Auth::id()) {
            abort(403);
        }

        if ($pengaduan->status_pengaduan != 'menunggu') {
            return back()->with('error', 'Tidak bisa dihapus');
        }

        foreach ($pengaduan->foto as $foto) {
            \Storage::disk('public')->delete($foto->foto_pengaduan);
            $foto->delete();
        }

        $pengaduan->delete();

        return back()->with('success', 'Pengaduan berhasil dihapus');
    }

    public function terima($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status_pengaduan = 'diterima';
        $pengaduan->save();

        return back()->with('success', 'Pengaduan diterima');
    }

    public function tolak($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status_pengaduan = 'ditolak';
        $pengaduan->save();

        return back()->with('success', 'Pengaduan ditolak');
    }

    public function selesai($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->status_pengaduan = 'selesai';
        $pengaduan->save();

        return back()->with('success', 'Pengaduan diselesaikan');
    }
}