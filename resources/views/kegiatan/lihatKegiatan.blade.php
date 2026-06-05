@extends('layouts.app')

@section('title', 'Kegiatan Padukuhan')

@section('content')

<div class="bg-white/90 backdrop-blur rounded-2xl p-4 md:p-6 shadow border border-[#FA8145] mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#A33215] leading-tight uppercase tracking-tight">
                Agenda Kegiatan & Proker
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium max-w-md">
                Informasi agenda kegiatan rutin dan program kerja di Padukuhan.
            </p>
        </div>

        <div class="bg-gray-100/80 p-1.5 rounded-2xl flex gap-1 border border-gray-200 shadow-inner w-full md:w-auto overflow-x-auto no-scrollbar">
            <a href="{{ request()->url() }}?tab=kegiatan{{ request('status') ? '&status='.request('status') : '' }}{{ request('search') ? '&search='.request('search') : '' }}"
               class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm font-semibold transition-all uppercase tracking-wider text-center
               {{ $tab == 'kegiatan' ? 'bg-white text-[#C54716] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Kegiatan
            </a>
            <a href="{{ request()->url() }}?tab=proker{{ request('status') ? '&status='.request('status') : '' }}{{ request('search') ? '&search='.request('search') : '' }}"
               class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm font-semibold transition-all uppercase tracking-wider text-center
               {{ $tab == 'proker' ? 'bg-white text-[#C54716] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                Program Kerja
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden mb-8">
    <div class="p-6 border-b border-gray-50 flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 bg-white">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
            <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">
                Daftar {{ $tab == 'kegiatan' ? 'Kegiatan' : 'Program Kerja' }}
            </h2>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto items-stretch sm:items-center">
            <form id="filterForm" action="{{ request()->url() }}" method="GET" onsubmit="event.preventDefault(); applyFilters();" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-stretch sm:items-center">
                @if(request('tab'))
                    <input type="hidden" name="tab" value="{{ request('tab') }}">
                @endif
                
                <div class="relative w-full sm:w-44">
                    <select name="status" onchange="applyFilters()" 
                        class="w-full pl-4 pr-10 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all bg-white text-gray-700 font-semibold cursor-pointer appearance-none">
                        <option value="" {{ !request('status') ? 'selected' : '' }}>Semua Status</option>
                        <option value="direncanakan" {{ request('status') == 'direncanakan' ? 'selected' : '' }}>Rencana</option>
                        <option value="berlangsung" {{ request('status') == 'berlangsung' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                        </svg>
                    </div>
                </div>

                <div class="relative w-full sm:w-64 md:w-80">
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}" 
                        placeholder="Cari nama/kategori/tanggal..." 
                        class="w-full pl-10 pr-4 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all text-gray-700 placeholder:text-gray-400" autocomplete="off">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>
        </div>
    </div>

    <div class="px-6 pb-6 pt-5 bg-white">
        <div id="dataContainer">
        @if($kegiatan->isEmpty())
        <div class="rounded-3xl border-2 border-dashed border-orange-200 p-12 text-center bg-white shadow-inner">
            <div class="text-sm font-bold text-gray-300 uppercase tracking-wider mb-4">TIDAK ADA DATA</div>
            <h3 class="text-xl font-bold text-[#69200F]">Belum Ada Agenda</h3>
            <p class="text-gray-400 mt-2 font-medium italic">Saat ini belum ada kegiatan yang terjadwal untuk kategori ini.</p>
        </div>
        @else

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($kegiatan as $item)
        @php
            $waktu = \Carbon\Carbon::parse($item->tgl_waktu_pelaksanaan);
            $statusData = match($item->status_kegiatan) {
                'direncanakan' => [
                    'color' => 'bg-[#FA8145]/10 text-[#E75C16] border-[#FA8145]/30', 
                    'badge' => 'Direncanakan'
                ],
                'berlangsung' => [
                    'color' => 'bg-[#E75C16]/10 text-[#A33215] border-[#E75C16]/30', 
                    'badge' => 'Berlangsung'
                ],
                'selesai' => [
                    'color' => 'bg-[#69200F]/10 text-[#69200F] border-[#69200F]/25', 
                    'badge' => 'Selesai'
                ],
                default => [
                    'color' => 'bg-gray-50 text-gray-500 border-gray-100', 
                    'badge' => 'Unknown'
                ],
            };
        @endphp

        <div class="group bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col h-full overflow-hidden relative
            {{ in_array($item->status_kegiatan, ['berlangsung', 'selesai']) ? 'cursor-pointer transform hover:-translate-y-1' : '' }}"
            @if(in_array($item->status_kegiatan, ['berlangsung', 'selesai']))
                onclick="window.location='{{ route('kegiatan.show', $item->id_kegiatan) }}'"
            @endif
        >
            <div class="absolute top-4 right-4 z-10">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider border shadow-sm {{ $statusData['color'] }}">
                    {{ $statusData['badge'] }}
                </span>
            </div>

            <div class="p-6 flex-1 flex flex-col gap-4">
                <div class="flex items-center">
                    <span class="text-xs font-bold text-[#FA8145] uppercase tracking-wider">
                        {{ $item->kategori }}
                    </span>
                </div>

                <h2 class="font-bold text-gray-900 text-lg md:text-xl group-hover:text-[#C54716] transition-colors leading-tight">
                    {{ $item->nama_kegiatan }}
                </h2>
                
                @if($item->poster_kegiatan)
                <div class="mt-2 w-full h-32 sm:h-40 rounded-xl overflow-hidden border border-gray-100 cursor-pointer" onclick="event.stopPropagation(); showImage('{{ asset('storage/'.$item->poster_kegiatan) }}')">
                    <img src="{{ asset('storage/'.$item->poster_kegiatan) }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                </div>
                @endif
                
                <div class="space-y-3 mt-2">
                    <div class="flex items-center gap-4 text-sm text-gray-600 bg-orange-50/50 p-3 rounded-2xl border border-orange-100/50">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu Pelaksanaan</p>
                            <p class="font-bold text-[#A33215]">{{ $waktu->translatedFormat('l, d M Y') }} • {{ $waktu->format('H:i') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-gray-600 bg-gray-50 p-3 rounded-2xl border border-gray-100">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Lokasi</p>
                            <p class="font-bold text-gray-700 truncate max-w-[180px]">{{ $item->lokasi }}</p>
                        </div>
                    </div>
                </div>

                @if($item->deskripsi_kegiatan)
                <div class="mt-2">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Keterangan</p>
                    <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed italic">
                        "{{ $item->deskripsi_kegiatan }}"
                    </p>
                </div>
                @endif
            </div>

            @if(in_array($item->status_kegiatan, ['berlangsung', 'selesai']))
            <div class="px-6 py-4 bg-orange-50 border-t border-orange-100 flex justify-between items-center group-hover:bg-orange-100 transition-colors">
                <span class="text-xs font-bold text-[#C54716] uppercase tracking-wider">Lihat Dokumentasi</span>
            </div>
            @else
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-center items-center">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Agenda Belum Dimulai</span>
            </div>
            @endif
        </div>
        @endforeach
        </div>
        @endif
        </div>
    </div>
</div>

<div id="modalImagePreview" class="fixed inset-0 bg-[#69200F]/90 hidden z-[9999] flex items-center justify-center p-2 md:p-6 backdrop-blur-sm" onclick="closeModal('modalImagePreview')">
    <div class="relative w-full max-w-6xl h-[90vh] flex items-center justify-center">
        <button onclick="closeModal('modalImagePreview')" class="absolute -top-4 right-0 md:-right-8 md:-top-4 text-white hover:text-gray-300 text-5xl font-light z-50 drop-shadow-lg">&times;</button>
        <img id="previewImage" src="" class="w-full h-full object-contain drop-shadow-2xl" onclick="event.stopPropagation()">
    </div>
</div>

@endsection

@push('scripts')
<script>
function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function showImage(src) {
    document.getElementById('previewImage').src = src;
    openModal('modalImagePreview');
}

// Live Search & Filter Script
let searchTimeout;
const searchInput = document.getElementById('searchInput');

function applyFilters() {
    const query = searchInput ? searchInput.value : '';
    const statusSelect = document.querySelector('select[name="status"]');
    const status = statusSelect ? statusSelect.value : '';
    
    const url = new URL(window.location.href);
    
    if (query) {
        url.searchParams.set('search', query);
    } else {
        url.searchParams.delete('search');
    }
    
    if (status) {
        url.searchParams.set('status', status);
    } else {
        url.searchParams.delete('status');
    }
    
    url.searchParams.set('tab', '{{ $tab }}');
    url.searchParams.delete('page'); // Reset to page 1

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newDataContainer = doc.getElementById('dataContainer');
            if(newDataContainer) {
                document.getElementById('dataContainer').innerHTML = newDataContainer.innerHTML;
            }
            window.history.pushState({}, '', url);
        })
        .catch(err => console.error("Filter fetch error:", err));
}

if (searchInput) {
    const len = searchInput.value.length;
    if (len > 0) {
        searchInput.focus();
        searchInput.setSelectionRange(len, len);
    }

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 400); // 400ms debounce
    });
}
</script>
@endpush
