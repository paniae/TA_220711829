<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Storage;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');
        $query = Penduduk::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nomor_induk_kependudukan', 'like', "%{$search}%")
                  ->orWhere('nomor_kk', 'like', "%{$search}%");
            });
        }

        // Apply demography filter
        if ($filter) {
            switch ($filter) {
                case 'laki_aktif':
                    $query->where('jenis_kelamin', 'L')->where('status_penduduk', 'Aktif');
                    break;
                case 'perempuan':
                    $query->where('jenis_kelamin', 'P');
                    break;
                case 'lansia':
                    $query->where('tanggal_lahir', '<=', now()->subYears(60)->toDateString());
                    break;
                case 'dewasa':
                    $query->where('tanggal_lahir', '>', now()->subYears(60)->toDateString())
                          ->where('tanggal_lahir', '<=', now()->subYears(19)->toDateString());
                    break;
                case 'remaja':
                    $query->where('tanggal_lahir', '>', now()->subYears(19)->toDateString())
                          ->where('tanggal_lahir', '<=', now()->subYears(12)->toDateString());
                    break;
                case 'anak':
                    $query->where('tanggal_lahir', '>', now()->subYears(12)->toDateString());
                    break;
                case 'pindah':
                    $query->where('status_penduduk', 'Pindah')->whereYear('updated_at', date('Y'));
                    break;
                case 'meninggal':
                    $query->where('status_penduduk', 'Meninggal')->whereYear('updated_at', date('Y'));
                    break;
            }
        }

        $data = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total_kk' => Penduduk::distinct('nomor_kk')->count('nomor_kk'),
            'total_penduduk' => Penduduk::count(),
            'perempuan' => Penduduk::where('jenis_kelamin', 'P')->count(),
            'laki_aktif' => Penduduk::where('jenis_kelamin', 'L')->where('status_penduduk', 'Aktif')->count(),
            'pindah_tahun_ini' => Penduduk::where('status_penduduk', 'Pindah')->whereYear('updated_at', date('Y'))->count(),
            'meninggal_tahun_ini' => Penduduk::where('status_penduduk', 'Meninggal')->whereYear('updated_at', date('Y'))->count(),
            'lansia' => Penduduk::where('tanggal_lahir', '<=', now()->subYears(60)->toDateString())->count(),
            'dewasa' => Penduduk::where('tanggal_lahir', '>', now()->subYears(60)->toDateString())
                                ->where('tanggal_lahir', '<=', now()->subYears(19)->toDateString())
                                ->count(),
            'remaja' => Penduduk::where('tanggal_lahir', '>', now()->subYears(19)->toDateString())
                                ->where('tanggal_lahir', '<=', now()->subYears(12)->toDateString())
                                ->count(),
            'anak' => Penduduk::where('tanggal_lahir', '>', now()->subYears(12)->toDateString())->count(),
        ];

        return view('penduduk.kelolaPenduduk', compact('data', 'search', 'stats', 'filter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nomor_induk_kependudukan',
            'nomor_kk' => 'required|digits:16',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'tempat_lahir' => 'required',
            'agama' => 'required',
            'pendidikan' => 'required',
            'jenis_pekerjaan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'desa_kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'status_perkawinan' => 'required',
            'alamat' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem. Silakan gunakan NIK lain.',
            'nik.digits' => 'NIK wajib berupa angka dan terdiri dari 16 digit.',
            'nomor_kk.digits' => 'Nomor KK wajib berupa angka dan terdiri dari 16 digit.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh setelah hari ini.'
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = Storage::url($request->file('foto')->store('penduduk', 'public'));
        }

        Penduduk::create([
            'nomor_induk_kependudukan' => $request->nik,
            'nomor_kk' => $request->nomor_kk,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'desa_kelurahan' => $request->desa_kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'status_perkawinan' => $request->status_perkawinan,
            'status_penduduk' => 'Aktif',
            'foto_penduduk' => $fotoPath,
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $penduduk = Penduduk::findOrFail($id);

        $request->validate([
            'nik' => 'required|digits:16|unique:penduduk,nomor_induk_kependudukan,' . $id . ',nomor_induk_kependudukan',
            'nomor_kk' => 'required|digits:16',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date|before_or_equal:today',
            'tempat_lahir' => 'required',
            'agama' => 'required',
            'pendidikan' => 'required',
            'jenis_pekerjaan' => 'required',
            'rt' => 'required',
            'rw' => 'required',
            'desa_kelurahan' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'provinsi' => 'required',
            'status_perkawinan' => 'required',
            'alamat' => 'required',
            'status_penduduk' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem. Silakan gunakan NIK lain.',
            'nik.digits' => 'NIK wajib berupa angka dan terdiri dari 16 digit.',
            'nomor_kk.digits' => 'Nomor KK wajib berupa angka dan terdiri dari 16 digit.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak boleh setelah hari ini.'
        ]);

        $fotoPath = $penduduk->foto_penduduk;

        if ($request->hasFile('foto')) {
            $fotoPath = Storage::url($request->file('foto')->store('penduduk', 'public'));
        }

        $penduduk->update([
            'nomor_induk_kependudukan' => $request->nik,
            'nomor_kk' => $request->nomor_kk,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'agama' => $request->agama,
            'pendidikan' => $request->pendidikan,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'desa_kelurahan' => $request->desa_kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten,
            'provinsi' => $request->provinsi,
            'status_perkawinan' => $request->status_perkawinan,
            'status_penduduk' => $request->status_penduduk,
            'foto_penduduk' => $fotoPath,
        ]);

        return back()->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}