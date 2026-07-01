<?php

namespace App\Http\Controllers;

use App\Models\KegiatanPadukuhan;
use App\Models\DokumentasiKegiatan;
use App\Models\Pengguna;
use App\Mail\KegiatanBaruMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use ZipArchive;

class KegiatanController extends Controller
{
    public function kelola(Request $request)
    {
        KegiatanPadukuhan::where('status_kegiatan', 'direncanakan')
            ->where('tgl_waktu_pelaksanaan', '<=', now())
            ->update(['status_kegiatan' => 'berlangsung']);

        $tab = $request->tab ?? 'kegiatan'; 
        $query = KegiatanPadukuhan::where('jenis_kegiatan', $tab);
        
        if ($request->status) {
            $query->where('status_kegiatan', $request->status);
        }
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhere('tgl_waktu_pelaksanaan', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->date) {
            $query->whereDate('tgl_waktu_pelaksanaan', $request->date);
        }
        
        $kegiatan = $query->orderByRaw("FIELD(status_kegiatan, 'berlangsung', 'direncanakan', 'selesai')")
                          ->orderByRaw("ABS(DATEDIFF(tgl_waktu_pelaksanaan, NOW()))")
                          ->get();
        return view('kegiatan.kelolaKegiatan', compact('kegiatan', 'tab'));
    }

    public function lihat(Request $request)
    {
        KegiatanPadukuhan::where('status_kegiatan', 'direncanakan')
            ->where('tgl_waktu_pelaksanaan', '<=', now())
            ->update(['status_kegiatan' => 'berlangsung']);

        $tab = $request->tab ?? 'kegiatan';
        $query = KegiatanPadukuhan::where('jenis_kegiatan', $tab);
        
        if ($request->status) {
            $query->where('status_kegiatan', $request->status);
        }
        
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_kegiatan', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%')
                  ->orWhere('tgl_waktu_pelaksanaan', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->date) {
            $query->whereDate('tgl_waktu_pelaksanaan', $request->date);
        }
        
        $kegiatan = $query->orderByRaw("FIELD(status_kegiatan, 'berlangsung', 'direncanakan', 'selesai')")
                          ->orderByRaw("ABS(DATEDIFF(tgl_waktu_pelaksanaan, NOW()))")
                          ->get();
        return view('kegiatan.lihatKegiatan', compact('kegiatan', 'tab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'lokasi' => 'required',
            'jenis_kegiatan' => 'required',
            'poster_kegiatan' => 'nullable|image|max:2048'
        ]);

        $poster = null;
        if ($request->hasFile('poster_kegiatan')) {
            $poster = $request->file('poster_kegiatan')->store('poster_kegiatan', 'public');
        }

        $waktu = $request->tanggal . ' ' . $request->jam;

        $kegiatan = KegiatanPadukuhan::create([
            'id_pengguna' => Auth::id(),
            'nama_kegiatan' => $request->nama_kegiatan,
            'tgl_waktu_pelaksanaan' => $waktu,
            'waktu_selesai' => null,
            'status_kegiatan' => 'direncanakan',
            'kategori' => $request->kategori,
            'deskripsi_kegiatan' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'jenis_kegiatan' => $request->jenis_kegiatan,
            'poster_kegiatan' => $poster,
        ]);

        $users = Pengguna::whereNotNull('email_pengguna')
            ->where('status_pengguna', 'aktif')
            ->whereHas('role', function($query) {
                $query->where('nama_role', '!=', 'dukuh');
            })
            ->get();

        foreach ($users as $user) {
            try {
                Mail::to($user->email_pengguna)->send(new KegiatanBaruMail($kegiatan));
            } catch (\Exception $e) {}
        }

        return redirect()->back()->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kegiatan = KegiatanPadukuhan::with(['dokumentasi', 'pengguna'])->findOrFail($id);
        return view('kegiatan.lihatDokumentasiKegiatan', compact('kegiatan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'nullable',
            'lokasi' => 'required',
            'poster_kegiatan' => 'nullable|image|max:2048'
        ]);

        $waktu = $request->tanggal . ' ' . $request->jam;

        $kegiatan = KegiatanPadukuhan::findOrFail($id);
        
        $dataUpdate = [
            'nama_kegiatan' => $request->nama_kegiatan,
            'tgl_waktu_pelaksanaan' => $waktu,
            'kategori' => $request->kategori,
            'deskripsi_kegiatan' => $request->deskripsi,
            'lokasi' => $request->lokasi,
        ];

        if ($request->hasFile('poster_kegiatan')) {
            if ($kegiatan->poster_kegiatan && Storage::disk('public')->exists($kegiatan->poster_kegiatan)) {
                Storage::disk('public')->delete($kegiatan->poster_kegiatan);
            }
            $dataUpdate['poster_kegiatan'] = $request->file('poster_kegiatan')->store('poster_kegiatan', 'public');
        }

        $kegiatan->update($dataUpdate);

        return redirect()->back()->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kegiatan = KegiatanPadukuhan::findOrFail($id);
        
        if ($kegiatan->status_kegiatan === 'selesai') {
            return back()->with('error', 'Kegiatan yang sudah selesai tidak bisa dihapus');
        }

        if ($kegiatan->poster_kegiatan && Storage::disk('public')->exists($kegiatan->poster_kegiatan)) {
            Storage::disk('public')->delete($kegiatan->poster_kegiatan);
        }

        $kegiatan->delete();
        return redirect()->back()->with('success', 'Kegiatan berhasil dihapus!');
    }

    public function selesai($id)
    {
        $kegiatan = KegiatanPadukuhan::findOrFail($id);
        $kegiatan->update([
            'status_kegiatan' => 'selesai',
            'waktu_selesai' => now()
        ]);
        return redirect()->back()->with('success', 'Kegiatan selesai!');
    }

    public function lihatDokumentasi($id)
    {
        if (!auth()->user()->hasAkses('kelola_kegiatan')) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $kegiatan = KegiatanPadukuhan::findOrFail($id);
        if ($kegiatan->status_kegiatan === 'direncanakan' && $kegiatan->tgl_waktu_pelaksanaan <= now()) {
            $kegiatan->update(['status_kegiatan' => 'berlangsung']);
        }

        $kegiatan->load(['dokumentasi', 'pengguna']);
        return view('kegiatan.dokumentasiKegiatan', compact('kegiatan'));
    }

    public function storeDokumentasi(Request $request, $id)
    {
        if (!auth()->user()->hasAkses('kelola_kegiatan')) {
            abort(403, 'Tindakan ini tidak diizinkan.');
        }

        $request->validate([
            'file_kegiatan' => 'required',
            'file_kegiatan.*' => 'required|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:20480',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'nullable|date',
        ]);

        $kegiatan = KegiatanPadukuhan::findOrFail($id);
        
        if ($kegiatan->jenis_kegiatan === 'kegiatan' && $kegiatan->status_kegiatan !== 'selesai') {
            $kegiatan->update([
                'status_kegiatan' => 'selesai',
                'waktu_selesai' => now()
            ]);
        }

        $files = $request->file('file_kegiatan');
        foreach ($files as $file) {
            $path = $file->store('dokumentasi', 'public');
            
            DokumentasiKegiatan::create([
                'id_kegiatan' => $id,
                'file_kegiatan' => $path,
                'deskripsi_dokumentasi' => $request->deskripsi,
                'tanggal_dokumentasi' => $request->tanggal ?? now()->format('Y-m-d'),
            ]);
        }

        return redirect()->back()->with('success', 'Dokumentasi berhasil ditambahkan!');
    }

    public function downloadAllDokumentasi($id)
    {
        $kegiatan = KegiatanPadukuhan::with('dokumentasi')->findOrFail($id);
        
        if ($kegiatan->dokumentasi->isEmpty()) {
            return back()->with('error', 'Belum ada dokumentasi untuk diunduh');
        }

        $zip = new ZipArchive;
        $fileName = 'dokumentasi-' . str_replace(' ', '-', strtolower($kegiatan->nama_kegiatan)) . '.zip';
        $tempPath = storage_path('app/public/' . $fileName);

        if ($zip->open($tempPath, ZipArchive::CREATE) === TRUE) {
            foreach ($kegiatan->dokumentasi as $doc) {
                $filePath = storage_path('app/public/' . $doc->file_kegiatan);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($doc->file_kegiatan));
                }
            }
            $zip->close();
        }

        return response()->download($tempPath)->deleteFileAfterSend(true);
    }

    public function updateDokumentasi(Request $request, $id)
    {
        $request->validate([
            'tanggal_dokumentasi' => 'required|date',
            'deskripsi_dokumentasi' => 'nullable|string',
            'file_kegiatan' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov,avi|max:20480',
        ]);

        $dokumentasi = DokumentasiKegiatan::findOrFail($id);
        
        $data = [
            'tanggal_dokumentasi' => $request->tanggal_dokumentasi,
            'deskripsi_dokumentasi' => $request->deskripsi_dokumentasi,
        ];

        if ($request->hasFile('file_kegiatan')) {
            if (Storage::disk('public')->exists($dokumentasi->file_kegiatan)) {
                Storage::disk('public')->delete($dokumentasi->file_kegiatan);
            }
            
            $path = $request->file('file_kegiatan')->store('dokumentasi', 'public');
            $data['file_kegiatan'] = $path;
        }

        $dokumentasi->update($data);

        return redirect()->back()->with('success', 'Dokumentasi berhasil diperbarui!');
    }

    public function destroyDokumentasi($id)
    {
        if (!auth()->user()->hasAkses('kelola_kegiatan')) {
            abort(403, 'Tindakan ini tidak diizinkan.');
        }

        $dokumentasi = DokumentasiKegiatan::findOrFail($id);
        
        // Hapus file fisik
        if (Storage::disk('public')->exists($dokumentasi->file_kegiatan)) {
            Storage::disk('public')->delete($dokumentasi->file_kegiatan);
        }

        $dokumentasi->delete();
        return redirect()->back()->with('success', 'Dokumentasi berhasil dihapus!');
    }
}
