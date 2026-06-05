@extends('layouts.app')

@section('title', 'Pengaduan Warga')

@section('content')

<div id="filterSection" class="bg-white/90 backdrop-blur rounded-2xl p-4 md:p-6 shadow border border-[#FA8145] mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6 pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-[#A33215] mb-1">
                Pengaduan Warga
            </h1>
            <p class="text-base text-gray-500 font-medium">
                Kelola dan pantau pengaduan warga padukuhan.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <form action="{{ route('pengaduan.kelolaPengaduan') }}#filterSection" method="GET" class="relative w-full sm:w-64">
                @if(!empty($currentStatus))
                    <input type="hidden" name="status" value="{{ $currentStatus }}">
                @endif
                <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}" placeholder="Cari isi/nama pengadu..." 
                    class="w-full pl-10 pr-4 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all" autocomplete="off">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>
    </div>

    <div>
        <p class="text-xs text-gray-500 font-bold mb-3 uppercase tracking-wider">
            Statistik & Filter Status Pengaduan
        </p>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">

            <a href="{{ route('pengaduan.kelolaPengaduan', ['search' => $search]) }}#filterSection" 
               class="filter-card-link p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md
               {{ !$currentStatus ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Semua Pengaduan</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $semua }}</p>
            </a>

            <a href="{{ route('pengaduan.kelolaPengaduan', ['status' => 'menunggu', 'search' => $search]) }}#filterSection" 
               class="filter-card-link p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md
               {{ $currentStatus == 'menunggu' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Menunggu</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $menunggu }}</p>
            </a>

            <a href="{{ route('pengaduan.kelolaPengaduan', ['status' => 'diterima', 'search' => $search]) }}#filterSection" 
               class="filter-card-link p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md
               {{ $currentStatus == 'diterima' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Diterima</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $diterima }}</p>
            </a>

            <a href="{{ route('pengaduan.kelolaPengaduan', ['status' => 'selesai', 'search' => $search]) }}#filterSection" 
               class="filter-card-link p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md
               {{ $currentStatus == 'selesai' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Selesai</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $selesai }}</p>
            </a>

        </div>
    </div>
</div>

<div class="bg-white/90 backdrop-blur p-4 md:p-6 rounded-2xl shadow border border-[#FA8145] mt-6">

    <h2 class="text-base font-bold text-[#A33215] mb-4 uppercase tracking-widest">
        Daftar Pengaduan
    </h2>

    @if($pengaduan->isEmpty())
        <div class="text-center text-gray-500 text-sm py-6">
            Belum ada pengaduan
        </div>
    @else

    <div class="space-y-3">

        @foreach($pengaduan as $item)

        <div class="border border-gray-200 rounded-2xl p-5 bg-white shadow hover:shadow-lg transition-all duration-300">
                
                <div class="flex items-start sm:items-center justify-between mb-4 pb-3 border-b-2 border-gray-100 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-orange-100 text-[#C54716] flex items-center justify-center font-bold shadow-inner">
                            {{ strtoupper(substr($item->pengguna->nama ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800 tracking-wide">{{ $item->pengguna->nama ?? 'Anonim' }}</p>
                            <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ \Carbon\Carbon::parse($item->tgl_waktu_pengaduan)->translatedFormat('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div>
                        @if($item->status_pengaduan == 'menunggu')
                            <span class="px-3 py-1.5 rounded-full bg-orange-50 text-[#C54716] border border-orange-100 text-[10px] font-black uppercase tracking-widest shadow-sm">Menunggu</span>
                        @elseif($item->status_pengaduan == 'diterima')
                            <span class="px-3 py-1.5 rounded-full bg-orange-50 text-[#A33215] border border-orange-200 text-[10px] font-black uppercase tracking-widest shadow-sm">Diterima</span>
                        @elseif($item->status_pengaduan == 'selesai')
                            <span class="px-3 py-1.5 rounded-full bg-orange-100/50 text-[#69200F] border border-orange-200 text-[10px] font-black uppercase tracking-widest shadow-sm">Selesai</span>
                        @elseif($item->status_pengaduan == 'ditolak')
                            <span class="px-3 py-1.5 rounded-full bg-gray-50 text-gray-500 border border-gray-200 text-[10px] font-black uppercase tracking-widest shadow-sm">Ditolak</span>
                        @else
                            <span class="px-3 py-1.5 rounded-full bg-gray-50 text-gray-700 border border-gray-100 text-[10px] font-black uppercase tracking-widest shadow-sm">{{ $item->status_pengaduan }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-700 leading-relaxed font-medium">{{ $item->isi_pengaduan }}</p>
                </div>

                @if($item->foto && $item->foto->count())
                    <div class="flex gap-3 overflow-x-auto mb-2 pb-2">
                        @foreach($item->foto as $foto)
                            <img src="{{ asset('storage/' . $foto->foto_pengaduan) }}"
                                class="w-24 h-24 object-cover rounded-xl border border-gray-100 shadow-sm cursor-pointer hover:opacity-80 transition"
                                onclick="openImageModal(this.src)">
                        @endforeach
                    </div>
                @endif

                @if($item->status_pengaduan == 'menunggu' || $item->status_pengaduan == 'diterima')
                    <div class="pt-4 border-t-2 border-gray-100 flex justify-end gap-3 mt-2">
                        @if($item->status_pengaduan == 'menunggu')
                            <button type="button"
                                onclick="openConfirmModal(
                                    'Terima Pengaduan',
                                    'Yakin ingin menerima pengaduan ini?',
                                    '{{ route('pengaduan.terima', $item->id_pengaduan) }}'
                                )"
                                class="bg-[#C54716] text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#E75C16] hover:-translate-y-0.5 transition-all shadow-md shadow-orange-100">
                                Terima
                            </button>
                        @endif

                        @if($item->status_pengaduan == 'diterima')
                            <button type="button"
                                onclick="openConfirmModal(
                                    'Selesaikan Pengaduan',
                                    'Yakin pengaduan ini sudah selesai?',
                                    '{{ route('pengaduan.selesai', $item->id_pengaduan) }}'
                                )"
                                class="bg-[#69200F] text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#A33215] hover:-translate-y-0.5 transition-all shadow-md shadow-orange-100">
                                Selesai
                            </button>
                        @endif
                    </div>
                @endif
            </div>

        @endforeach

    </div>

    @endif

</div>

<div id="imageModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 flex items-center justify-center" onclick="closeImageModal()">
    <span onclick="closeImageModal()" 
          class="absolute top-5 right-5 text-white text-4xl cursor-pointer hover:text-[#FA8145] transition-colors">✕</span>
    <img id="modalImage"
        class="max-w-[90%] max-h-[90%] rounded-2xl shadow-2xl border-4 border-white/10"
        onclick="event.stopPropagation()">
</div>

<div id="confirmModal"
     class="fixed inset-0 bg-[#69200F]/40 hidden z-50 flex items-center justify-center p-4 backdrop-blur-sm">

    <div class="bg-white w-full max-w-sm mx-4 rounded-[2.5rem] shadow-2xl p-8 text-center relative border border-[#FA8145]">

        <button onclick="closeConfirmModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold">
            ✕
        </button>

        <h2 id="confirmTitle" class="text-xl font-bold text-[#69200F] mb-3 uppercase tracking-tight">
            Judul
        </h2>

        <p id="confirmText" class="text-sm text-gray-500 mb-8 font-medium">
            Isi konfirmasi
        </p>

        <form id="confirmForm" method="POST" class="flex flex-col gap-3">
            @csrf
            @method('PUT')

            <button
                class="w-full py-4 bg-[#C54716] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] shadow-xl shadow-orange-100 transition-all">
                Ya, Lanjutkan
            </button>

            <button type="button"
                onclick="closeConfirmModal()"
                class="w-full py-4 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-gray-600 transition-all">
                Batal
            </button>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');

    img.src = src;
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');

    modal.classList.add('hidden');
    document.body.style.overflow = '';
}

function openConfirmModal(title, text, actionUrl) {
    document.getElementById('confirmTitle').innerText = title;
    document.getElementById('confirmText').innerText = text;

    const form = document.getElementById('confirmForm');
    form.action = actionUrl;

    const modal = document.getElementById('confirmModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endpush