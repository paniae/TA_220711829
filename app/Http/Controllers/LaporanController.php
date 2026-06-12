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
                if (request('kategori')) {
                    $kategori = request('kategori');
                    $query->whereHas('umkm', function($q) use ($kategori) {
                        $q->where('bidang_umkm', $kategori);
                    });
                }
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

        // Siapkan Chart Data
        $chartData = [];
        $currentYear = $year ?: date('Y');
        $isPerMonth = empty($month);
        $chartData['isPerMonth'] = $isPerMonth;

        if ($tab == 'umkm') {
            $umkmCounts = \App\Models\Umkm::select('bidang_umkm', \DB::raw('count(*) as total'))
                ->groupBy('bidang_umkm')
                ->pluck('total', 'bidang_umkm')->toArray();
            $chartData['umkm'] = [
                'labels' => array_keys($umkmCounts),
                'data' => array_values($umkmCounts)
            ];
        } elseif ($tab == 'kegiatan' || $tab == 'proker') {
            $jenis = $tab == 'kegiatan' ? 'kegiatan' : 'proker';
            $query = \App\Models\KegiatanPadukuhan::where('jenis_kegiatan', $jenis)
                ->whereYear('tgl_waktu_pelaksanaan', $currentYear);
            
            if (!$isPerMonth) {
                $query->whereMonth('tgl_waktu_pelaksanaan', $month);
            }
            $kegiatan = $query->get();
            
            $limit = $isPerMonth ? 12 : 5;
            $monthlyData = [
                'RT/RW' => array_fill(1, $limit, 0),
                'Padukuhan' => array_fill(1, $limit, 0),
                'Kalurahan' => array_fill(1, $limit, 0)
            ];

            foreach ($kegiatan as $k) {
                $time = strtotime($k->tgl_waktu_pelaksanaan);
                $index = $isPerMonth ? (int) date('n', $time) : (int) ceil(date('j', $time) / 7);
                if ($index > 5) $index = 5;

                $kategori = $k->kategori; 
                // Normalisasi string
                if (stripos($kategori, 'rt') !== false) {
                    $monthlyData['RT/RW'][$index]++;
                } elseif (stripos($kategori, 'kalurahan') !== false) {
                    $monthlyData['Kalurahan'][$index]++;
                } else {
                    $monthlyData['Padukuhan'][$index]++;
                }
            }
            $chartData['kegiatan_proker'] = $monthlyData;
        } elseif ($tab == 'pengaduan') {
            $query = \App\Models\Pengaduan::whereYear('tgl_waktu_pengaduan', $currentYear);
            if (!$isPerMonth) $query->whereMonth('tgl_waktu_pengaduan', $month);
            $pengaduan = $query->get();

            $limit = $isPerMonth ? 12 : 5;
            $monthlyData = array_fill(1, $limit, 0);
            foreach ($pengaduan as $p) {
                $time = strtotime($p->tgl_waktu_pengaduan);
                $index = $isPerMonth ? (int) date('n', $time) : (int) ceil(date('j', $time) / 7);
                if ($index > 5) $index = 5;
                $monthlyData[$index]++;
            }
            $chartData['pengaduan'] = array_values($monthlyData);
        } elseif ($tab == 'kehilangan') {
            $query = \App\Models\LaporanKehilangan::whereYear('tanggal_laporan', $currentYear);
            if (!$isPerMonth) $query->whereMonth('tanggal_laporan', $month);
            $kehilangan = $query->get();

            $limit = $isPerMonth ? 12 : 5;
            $monthlyData = array_fill(1, $limit, 0);
            foreach ($kehilangan as $k) {
                $time = strtotime($k->tanggal_laporan);
                $index = $isPerMonth ? (int) date('n', $time) : (int) ceil(date('j', $time) / 7);
                if ($index > 5) $index = 5;
                $monthlyData[$index]++;
            }
            $chartData['kehilangan'] = array_values($monthlyData);
        } elseif ($tab == 'penduduk') {
            $genderCounts = \App\Models\Penduduk::select('jenis_kelamin', \DB::raw('count(*) as total'))
                ->groupBy('jenis_kelamin')->pluck('total', 'jenis_kelamin')->toArray();
            $chartData['penduduk_gender'] = [
                'labels' => array_keys($genderCounts),
                'data' => array_values($genderCounts)
            ];

            $penduduks = \App\Models\Penduduk::whereNotNull('tanggal_lahir')->get();
            $ages = ['Anak-anak (<12)' => 0, 'Remaja (12-25)' => 0, 'Dewasa (26-45)' => 0, 'Lansia (>45)' => 0];
            foreach ($penduduks as $p) {
                $age = \Carbon\Carbon::parse($p->tanggal_lahir)->age;
                if ($age < 12) $ages['Anak-anak (<12)']++;
                elseif ($age <= 25) $ages['Remaja (12-25)']++;
                elseif ($age <= 45) $ages['Dewasa (26-45)']++;
                else $ages['Lansia (>45)']++;
            }
            $chartData['penduduk_umur'] = [
                'labels' => array_keys($ages),
                'data' => array_values($ages)
            ];
        }
        
        return view('laporan.laporanRekapitulasi', compact('totalPenduduk', 'totalKegiatan', 'totalProker', 'totalPengaduan', 'totalKehilangan', 'totalUmkm', 'tab', 'data', 'month', 'year', 'chartData'));
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

        $chartData = [];
        $genderCounts = \App\Models\Penduduk::select('jenis_kelamin', \DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')->pluck('total', 'jenis_kelamin')->toArray();
        $chartData['penduduk_gender'] = [
            'labels' => array_keys($genderCounts),
            'data' => array_values($genderCounts)
        ];

        $penduduks = \App\Models\Penduduk::whereNotNull('tanggal_lahir')->get();
        $ages = ['Anak-anak (<12)' => 0, 'Remaja (12-25)' => 0, 'Dewasa (26-45)' => 0, 'Lansia (>45)' => 0];
        foreach ($penduduks as $p) {
            $age = \Carbon\Carbon::parse($p->tanggal_lahir)->age;
            if ($age < 12) $ages['Anak-anak (<12)']++;
            elseif ($age <= 25) $ages['Remaja (12-25)']++;
            elseif ($age <= 45) $ages['Dewasa (26-45)']++;
            else $ages['Lansia (>45)']++;
        }
        $chartData['penduduk_umur'] = [
            'labels' => array_keys($ages),
            'data' => array_values($ages)
        ];

        return view('laporan.laporanPenduduk', compact('data', 'month', 'year', 'status', 'totalPenduduk', 'totalLaki', 'totalPerempuan', 'chartData'));
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
