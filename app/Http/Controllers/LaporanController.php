<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk;
use App\Models\Kegiatan;
use App\Models\Pengaduan;

class LaporanController extends Controller
{
    private function getFilteredData($tab, $month, $year, $status = null, $isPdf = false)
    {
        $data = null;
        switch ($tab) {
            case 'umkm':
                $query = \App\Models\ProdukUmkm::with('umkm');
                if ($month) $query->whereMonth('created_at', $month);
                if ($year) $query->whereYear('created_at', $year);
                $data = $isPdf ? $query->get() : $query->paginate(20);
                break;
            case 'kegiatan':
                $query = \App\Models\KegiatanPadukuhan::where('jenis_kegiatan', 'kegiatan')->orderBy('tgl_waktu_pelaksanaan', 'desc');
                if ($month) $query->whereMonth('tgl_waktu_pelaksanaan', $month);
                if ($year) $query->whereYear('tgl_waktu_pelaksanaan', $year);
                $data = $isPdf ? $query->get() : $query->paginate(20);
                break;
            case 'proker':
                $query = \App\Models\KegiatanPadukuhan::where('jenis_kegiatan', 'proker')->orderBy('tgl_waktu_pelaksanaan', 'desc');
                if ($month) $query->whereMonth('tgl_waktu_pelaksanaan', $month);
                if ($year) $query->whereYear('tgl_waktu_pelaksanaan', $year);
                $data = $isPdf ? $query->get() : $query->paginate(20);
                break;
            case 'pengaduan':
                $query = \App\Models\Pengaduan::orderBy('tgl_waktu_pengaduan', 'desc');
                if ($month) $query->whereMonth('tgl_waktu_pengaduan', $month);
                if ($year) $query->whereYear('tgl_waktu_pengaduan', $year);
                $data = $isPdf ? $query->get() : $query->paginate(20);
                break;
            case 'kehilangan':
                $query = \App\Models\LaporanKehilangan::orderBy('tanggal_laporan', 'desc');
                if ($month) $query->whereMonth('tanggal_laporan', $month);
                if ($year) $query->whereYear('tanggal_laporan', $year);
                $data = $isPdf ? $query->get() : $query->paginate(20);
                break;
            case 'penduduk':
                $query = \App\Models\Penduduk::query();
                if ($status) {
                    $query->where('status_penduduk', $status);
                }
                
                $dateColumn = in_array(strtolower($status), ['pindah', 'meninggal']) ? 'updated_at' : 'created_at';
                
                if ($month) $query->whereMonth($dateColumn, $month);
                if ($year) $query->whereYear($dateColumn, $year);
                
                $data = $isPdf ? $query->get() : $query->paginate(20);
                break;
        }
        return $data;
    }

    public function index(Request $request)
    {
        $tab = $request->tab ?? 'umkm';
        $month = $request->month;
        $year = $request->year;
        $status = $request->status;

        $data = $this->getFilteredData($tab, $month, $year, $status);

        // Data dasar untuk dashboard laporan
        $totalPenduduk = \App\Models\Penduduk::count();
        $totalKegiatan = \App\Models\KegiatanPadukuhan::where('jenis_kegiatan', 'kegiatan')->count();
        $totalProker = \App\Models\KegiatanPadukuhan::where('jenis_kegiatan', 'proker')->count();
        $totalPengaduan = \App\Models\Pengaduan::count();
        $totalKehilangan = \App\Models\LaporanKehilangan::count();
        $totalUmkm = \App\Models\ProdukUmkm::count();
        
        return view('laporan.laporanRekapitulasi', compact('totalPenduduk', 'totalKegiatan', 'totalProker', 'totalPengaduan', 'totalKehilangan', 'totalUmkm', 'tab', 'data', 'month', 'year'));
    }

    public function laporanPenduduk(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $status = $request->status;

        $data = $this->getFilteredData('penduduk', $month, $year, $status);
        
        $totalPenduduk = \App\Models\Penduduk::count();
        $totalLaki = \App\Models\Penduduk::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = \App\Models\Penduduk::where('jenis_kelamin', 'Perempuan')->count();

        return view('laporan.laporanPenduduk', compact('data', 'month', 'year', 'status', 'totalPenduduk', 'totalLaki', 'totalPerempuan'));
    }

    public function exportPdf(Request $request)
    {
        $tab = $request->tab ?? 'umkm';
        $month = $request->month;
        $year = $request->year;
        $status = $request->status;

        $data = $this->getFilteredData($tab, $month, $year, $status, true);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.laporanPdf', compact('data', 'tab', 'month', 'year', 'status'));
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download("laporan_{$tab}_" . date('Ymd_His') . ".pdf");
    }
}
