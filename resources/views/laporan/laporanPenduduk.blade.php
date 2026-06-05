@extends('layouts.app')

@section('title', 'Laporan Rekapitulasi Padukuhan')

@section('content')

<div class="bg-white/90 backdrop-blur rounded-2xl p-4 md:p-6 shadow border border-[#FA8145] mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-5">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-[#A33215] mb-1">
                Laporan Penduduk
            </h1>
            <p class="text-base text-gray-500 font-medium">
                Pantau data rekapitulasi penduduk padukuhan.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <form action="{{ route('laporan.penduduk') }}" method="GET" class="flex flex-col md:flex-row gap-3 w-full lg:w-auto flex-wrap justify-end">
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

                <select name="status" class="px-4 py-2 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all font-bold text-gray-700 w-full md:w-40">
                    <option value="">Semua Status</option>
                    <option value="Aktif"     {{ request('status') == 'Aktif'     ? 'selected' : '' }}>Aktif</option>
                    <option value="Pindah"    {{ request('status') == 'Pindah'    ? 'selected' : '' }}>Pindah</option>
                    <option value="Meninggal" {{ request('status') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none bg-[#C54716] text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 active:scale-95">
                        Filter
                    </button>
                    @if(request('month') || request('year') || request('status'))
                        <a href="{{ route('laporan.penduduk') }}" class="flex-1 md:flex-none bg-gray-100 text-gray-600 px-5 py-2 rounded-xl font-bold hover:bg-gray-200 transition-all text-sm text-center flex items-center justify-center border border-gray-200 shadow-sm active:scale-95">
                            Reset
                        </a>
                    @endif
                </div>

                <a href="{{ route('laporan.exportPdf', ['tab' => 'penduduk', 'month' => request('month'), 'year' => request('year'), 'status' => request('status')]) }}"
                   class="w-full md:w-auto bg-[#A33215] text-white px-5 py-2 rounded-xl font-bold shadow-lg shadow-orange-100 hover:bg-[#69200F] transition-all text-sm text-center flex items-center justify-center gap-2 active:scale-95">
                    Unduh PDF
                </a>
            </form>
        </div>
    </div>
    

</div>

<div id="tableContainer" class="bg-white/90 p-4 md:p-6 rounded-xl shadow border border-[#FA8145] overflow-x-auto">
    <table class="w-full text-base whitespace-nowrap">
        <thead>
            <tr class="text-left border-b border-gray-200 text-gray-900 font-black text-base uppercase tracking-wider">
                <th class="py-3 pr-4 border-r border-gray-200 text-center w-12">No</th>
                <th class="px-4 border-r border-gray-200">NIK</th>
                <th class="px-4 border-r border-gray-200">Nama Lengkap</th>
                <th class="px-4 border-r border-gray-200">Jenis Kelamin</th>
                <th class="px-4 pl-4">Alamat (RT/RW)</th>
            </tr>
        </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($data as $item)
                    <tr class="border-b border-gray-100 hover:bg-orange-50/50 transition-colors text-base">
                        <td class="py-3 pr-4 border-r border-gray-200 text-center">{{ $data->firstItem() + $loop->index }}</td>
                        <td class="px-4 border-r border-gray-200">{{ $item->nomor_induk_kependudukan }}</td>
                        <td class="px-4 border-r border-gray-200 font-bold text-gray-800 whitespace-normal break-words leading-tight">{{ $item->nama_lengkap }}</td>
                        <td class="px-4 border-r border-gray-200">{{ $item->jenis_kelamin }}</td>
                        <td class="py-3 pl-4">RT {{ $item->rt }}/RW {{ $item->rw }}</td>
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
    
    