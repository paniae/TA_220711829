@extends('layouts.app')

@section('title', 'Laporan Rekapitulasi Padukuhan')

@section('content')

@php
    $tabs = [
        'umkm'      => 'UMKM',
        'kegiatan'  => 'Kegiatan',
        'proker'    => 'Program Kerja',
        'pengaduan' => 'Pengaduan',
        'kehilangan'=> 'Kehilangan',
        'penduduk'  => 'Penduduk',
    ];
@endphp

<div class="bg-white/90 backdrop-blur rounded-2xl p-4 md:p-6 shadow border border-[#FA8145] mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-5 mb-6 pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-[#A33215] mb-1">
                Laporan &amp; Statistik
            </h1>
            <p class="text-base text-gray-500 font-medium">
                Pantau data rekapitulasi secara menyeluruh.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <form action="{{ request()->url() }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full lg:w-auto flex-wrap justify-end">
                <input type="hidden" name="tab" value="{{ $tab }}">
                
                <select name="month" class="px-4 py-2 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all font-bold text-gray-700 w-full md:w-40">
                    <option value="">Semua Bulan</option>
                    @foreach(range(1, 12) as $m)
                        <option value="{{ sprintf('%02d', $m) }}" {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>

                <select name="year" class="px-4 py-2 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all font-bold text-gray-700 w-full md:w-40">
                    <option value="">Semua Tahun</option>
                    @foreach(range(date('Y') - 5, date('Y')) as $y)
                        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>

                @if($tab == 'penduduk')
                <select name="status" class="px-4 py-2 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all font-bold text-gray-700 w-full md:w-40">
                    <option value="">Semua Status</option>
                    <option value="Aktif"     {{ request('status') == 'Aktif'     ? 'selected' : '' }}>Aktif</option>
                    <option value="Pindah"    {{ request('status') == 'Pindah'    ? 'selected' : '' }}>Pindah</option>
                    <option value="Meninggal" {{ request('status') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
                @endif

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none bg-[#C54716] text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 active:scale-95">
                        Filter
                    </button>
                    @if(request('month') || request('year') || request('status'))
                        <a href="?tab={{ $tab }}" class="flex-1 md:flex-none bg-gray-100 text-gray-600 px-5 py-2 rounded-xl font-bold hover:bg-gray-200 transition-all text-sm text-center flex items-center justify-center border border-gray-200 shadow-sm active:scale-95">
                            Reset
                        </a>
                    @endif
                </div>

                <a href="{{ route('laporan.exportPdf', ['tab' => $tab, 'month' => request('month'), 'year' => request('year'), 'status' => request('status')]) }}"
                   class="w-full md:w-auto bg-[#A33215] text-white px-5 py-2 rounded-xl font-bold shadow-lg shadow-orange-100 hover:bg-[#69200F] transition-all text-sm text-center flex items-center justify-center gap-2 active:scale-95">
                    Unduh PDF
                </a>
            </form>
        </div>
    </div>

    <div>
        <p class="text-xs text-gray-500 font-bold mb-3 uppercase tracking-wider">
            Kategori Data (Klik untuk melihat)
        </p>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
            @foreach([
                'umkm'      => ['label' => 'UMKM', 'val' => $totalUmkm ?? 0],
                'kegiatan'  => ['label' => 'Kegiatan', 'val' => $totalKegiatan ?? 0],
                'proker'    => ['label' => 'Proker', 'val' => $totalProker ?? 0],
                'pengaduan' => ['label' => 'Pengaduan', 'val' => $totalPengaduan ?? 0],
                'kehilangan'=> ['label' => 'Kehilangan', 'val' => $totalKehilangan ?? 0],
                'penduduk'  => ['label' => 'Penduduk', 'val' => $totalPenduduk ?? 0],
            ] as $key => $statData)
            <div onclick="window.location.href='?tab={{ $key }}{{ request('month') ? '&month='.request('month') : '' }}{{ request('year') ? '&year='.request('year') : '' }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $tab == $key ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">{{ $statData['label'] }}</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $statData['val'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div id="tableContainer" class="bg-white/90 p-4 md:p-6 rounded-xl shadow border border-[#FA8145] overflow-x-auto">
    <table class="w-full text-base whitespace-nowrap">
        <thead>
            <tr class="text-left border-b border-gray-200 text-gray-900 font-black text-base uppercase tracking-wider">
                <th class="py-3 pr-4 border-r border-gray-200 text-center w-12">No</th>
                @if($tab == 'umkm')
                    <th class="px-4 border-r border-gray-200">Nama Produk</th>
                    <th class="px-4 border-r border-gray-200">Pemilik (UMKM)</th>
                    <th class="px-4 border-r border-gray-200">Harga</th>
                    <th class="px-4 pl-4">Status</th>
                @elseif($tab == 'kegiatan' || $tab == 'proker')
                    <th class="px-4 border-r border-gray-200">Nama Kegiatan</th>
                    <th class="px-4 border-r border-gray-200">Waktu</th>
                    <th class="px-4 border-r border-gray-200">Kategori</th>
                    <th class="px-4 pl-4">Status</th>
                @elseif($tab == 'pengaduan')
                    <th class="px-4 border-r border-gray-200">Tgl Pengaduan</th>
                    <th class="px-4 border-r border-gray-200">Isi Pengaduan</th>
                    <th class="px-4 pl-4">Status</th>
                @elseif($tab == 'kehilangan')
                    <th class="px-4 border-r border-gray-200">Tgl Laporan</th>
                    <th class="px-4 border-r border-gray-200">Barang Hilang</th>
                    <th class="px-4 border-r border-gray-200">Lokasi</th>
                    <th class="px-4 pl-4">Status</th>
                @elseif($tab == 'penduduk')
                    <th class="px-4 border-r border-gray-200">NIK</th>
                    <th class="px-4 border-r border-gray-200">Nama Lengkap</th>
                    <th class="px-4 border-r border-gray-200">Jenis Kelamin</th>
                    <th class="px-4 pl-4">Alamat (RT/RW)</th>
                @endif
            </tr>
        </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $item)
                    <tr class="border-b border-gray-100 hover:bg-orange-50/50 transition-colors text-base">
                        <td class="py-3 pr-4 border-r border-gray-200 text-center">{{ $data->firstItem() + $loop->index }}</td>

                        @if($tab == 'umkm')
                            <td class="px-4 border-r border-gray-200 font-bold text-gray-800 whitespace-normal break-words leading-tight">{{ $item->nama_produk }}</td>
                            <td class="px-4 border-r border-gray-200">{{ $item->umkm->nama_umkm ?? '-' }}</td>
                            <td class="px-4 border-r border-gray-200">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="py-3 pl-4">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ strtolower($item->status_produk) == 'tersedia' ? 'bg-[#A33215]/10 text-[#A33215]' : 'bg-[#69200F]/10 text-[#69200F]' }}">
                                    {{ $item->status_produk }}
                                </span>
                            </td>
                        @elseif($tab == 'kegiatan' || $tab == 'proker')
                            <td class="px-4 border-r border-gray-200 font-bold text-gray-800 whitespace-normal break-words leading-tight">{{ $item->nama_kegiatan }}</td>
                            <td class="px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($item->tgl_waktu_pelaksanaan)->format('d M Y H:i') }}</td>
                            <td class="px-4 border-r border-gray-200 uppercase">{{ $item->kategori }}</td>
                            <td class="py-3 pl-4">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ $item->status_kegiatan == 'berlangsung' ? 'bg-[#A33215]/10 text-[#A33215]' : ($item->status_kegiatan == 'direncanakan' ? 'bg-[#FA8145]/20 text-[#E75C16]' : 'bg-gray-100 text-gray-700') }}">
                                    {{ $item->status_kegiatan }}
                                </span>
                            </td>
                        @elseif($tab == 'pengaduan')
                            <td class="px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($item->tgl_waktu_pengaduan)->format('d M Y') }}</td>
                            <td class="px-4 border-r border-gray-200 text-gray-800 truncate max-w-xs">{{ $item->isi_pengaduan }}</td>
                            <td class="py-3 pl-4">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ $item->status_pengaduan == 'selesai' ? 'bg-[#A33215]/10 text-[#A33215]' : ($item->status_pengaduan == 'ditolak' ? 'bg-[#69200F]/10 text-[#69200F]' : 'bg-[#FA8145]/20 text-[#E75C16]') }}">
                                    {{ $item->status_pengaduan }}
                                </span>
                            </td>
                        @elseif($tab == 'kehilangan')
                            <td class="px-4 border-r border-gray-200">{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d M Y') }}</td>
                            <td class="px-4 border-r border-gray-200 font-bold text-gray-800 whitespace-normal break-words leading-tight">{{ $item->barang_hilang }}</td>
                            <td class="px-4 border-r border-gray-200">{{ $item->lokasi_hilang }}</td>
                            <td class="py-3 pl-4">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ strtolower($item->status_kehilangan) == 'ditemukan' ? 'bg-[#A33215]/10 text-[#A33215]' : 'bg-[#69200F]/10 text-[#69200F]' }}">
                                    {{ $item->status_kehilangan }}
                                </span>
                            </td>
                        @elseif($tab == 'penduduk')
                            <td class="px-4 border-r border-gray-200">{{ $item->nomor_induk_kependudukan }}</td>
                            <td class="px-4 border-r border-gray-200 font-bold text-gray-800 whitespace-normal break-words leading-tight">{{ $item->nama_lengkap }}</td>
                            <td class="px-4 border-r border-gray-200">{{ $item->jenis_kelamin }}</td>
                            <td class="py-3 pl-4">RT {{ $item->rt }}/RW {{ $item->rw }}</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-400 font-medium italic">
                            Belum ada data untuk kategori ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($data instanceof \Illuminate\Pagination\LengthAwarePaginator && $data->hasPages())
    <div class="mt-6">
        {{ $data->appends(request()->query())->links('components.pagination') }}
    </div>
    @endif

</div>
@endsection
    
    