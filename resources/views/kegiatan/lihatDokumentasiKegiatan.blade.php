@extends('layouts.app')

@section('title', 'Dokumentasi: ' . $kegiatan->nama_kegiatan)

@section('content')

<div class="mb-6">
    @php
        $fallbackUrl = route('kegiatan.lihat', ['tab' => $kegiatan->jenis_kegiatan ?? 'kegiatan']);
        $backUrl = (url()->previous() !== url()->current()) ? url()->previous() : $fallbackUrl;
    @endphp
    <a href="{{ $backUrl }}" 
        class="inline-flex items-center justify-center gap-2 bg-white border-2 border-gray-100 text-gray-500 px-5 py-2 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:border-[#FA8145] hover:text-[#A33215] hover:bg-orange-50 transition-all shadow-sm active:scale-95">
        Kembali
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] p-8 mb-8 relative overflow-hidden">
    @php
        $statusData = match($kegiatan->status_kegiatan) {
            'direncanakan' => ['color' => 'bg-[#FA8145]/10 text-[#E75C16] border-[#FA8145]/30', 'badge' => 'Rencana'],
            'berlangsung' => ['color' => 'bg-[#E75C16]/10 text-[#A33215] border-[#E75C16]/30', 'badge' => 'Aktif'],
            'selesai' => ['color' => 'bg-[#69200F]/10 text-[#69200F] border-[#69200F]/25', 'badge' => 'Selesai'],
            default => ['color' => 'bg-gray-50 text-gray-500 border-gray-100', 'badge' => 'Unknown'],
        };
    @endphp

    <div class="flex flex-col md:flex-row justify-between items-start gap-4 border-b border-gray-50 pb-6 mb-6">
        <div>
            <span class="px-4 py-1.5 rounded-full bg-orange-50 text-[#C54716] text-xs font-semibold uppercase tracking-wider border border-orange-100 mb-3 inline-block">
                Dokumentasi Kegiatan
            </span>
            <h1 class="text-2xl md:text-3xl font-bold text-[#69200F] leading-tight uppercase tracking-tight">
                {{ $kegiatan->nama_kegiatan }}
            </h1>
        </div>
        <div class="bg-orange-50/50 px-6 py-3 rounded-2xl border border-orange-100/50 w-full md:w-auto text-right">
            <p class="text-xs font-semibold text-[#E75C16] uppercase tracking-wider mb-1">Dana Terpakai</p>
            <p class="text-xl font-bold text-[#C54716]">
                {{ $kegiatan->dana_dikeluarkan ? 'Rp ' . number_format($kegiatan->dana_dikeluarkan, 0, ',', '.') : '-' }}
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="flex items-center gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Mulai</p>
                <p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->tgl_waktu_pelaksanaan ? \Carbon\Carbon::parse($kegiatan->tgl_waktu_pelaksanaan)->translatedFormat('d M Y • H:i') : '-' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Selesai</p>
                <p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->waktu_selesai ? \Carbon\Carbon::parse($kegiatan->waktu_selesai)->translatedFormat('d M Y • H:i') : '-' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Lokasi</p>
                <p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->lokasi ?? '-' }}</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</p>
                <p class="text-sm font-bold text-[#E75C16] uppercase tracking-wider">{{ $kegiatan->kategori ?? '-' }}</p>
            </div>
        </div>
    </div>

    @if($kegiatan->deskripsi_kegiatan)
    <div class="mt-8 bg-[#FA8145]/5 p-6 rounded-2xl border border-[#FA8145]/10">
        <p class="text-xs font-semibold text-[#A33215] uppercase tracking-wider mb-2">Deskripsi Kegiatan</p>
        <p class="text-sm sm:text-base text-gray-600 leading-relaxed font-medium">"{{ $kegiatan->deskripsi_kegiatan }}"</p>
    </div>
    @endif
</div>

<div class="mt-12 bg-white rounded-3xl shadow-sm border border-[#FA8145] p-6 md:p-8">
    <div class="flex justify-between items-center mb-8 border-b border-orange-100 pb-4">
        <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight">
            Galeri Dokumentasi
        </h2>
        @if(!$kegiatan->dokumentasi->isEmpty())
            <button onclick="openModal('modalDownloadAll')"
                class="bg-[#A33215] text-white px-6 py-2.5 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider shadow-lg shadow-orange-100 hover:bg-[#69200F] transition-all active:scale-95">
                Simpan Semua
            </button>
        @endif
    </div>

    @if($kegiatan->dokumentasi->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100 shadow-sm">
            <p class="text-gray-500 font-medium text-sm">Belum ada dokumentasi.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($kegiatan->dokumentasi as $item)
            @php $isVideo = Str::endsWith($item->file_kegiatan, ['.mp4', '.mov', '.avi']); @endphp

            <div class="group bg-white rounded-[2rem] border-2 border-orange-100 hover:border-[#FA8145] shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1">
                <div class="relative aspect-video overflow-hidden bg-black cursor-pointer group-hover:shadow-md transition-all" onclick="openPreview('{{ asset('storage/' . $item->file_kegiatan) }}', {{ $isVideo ? 'true' : 'false' }})">
                    @if($isVideo)
                        <video class="w-full h-full object-cover opacity-80" muted>
                            <source src="{{ asset('storage/' . $item->file_kegiatan) }}">
                        </video>
                    @else
                        <img src="{{ asset('storage/' . $item->file_kegiatan) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    @endif
                    
                    <div class="absolute top-3 left-3 flex gap-2">
                        <span class="text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm
                            {{ $isVideo ? 'bg-[#C54716] text-white' : 'bg-white/90 text-[#A33215]' }}">
                            {{ $isVideo ? 'Video' : 'Foto' }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <p class="text-xs font-bold text-[#FA8145] uppercase tracking-wider mb-2">
                        {{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->translatedFormat('d M Y') }}
                    </p>
                    <p class="text-sm text-gray-700 line-clamp-2 min-h-[2.5rem] leading-relaxed mb-6 font-medium">
                        {{ $item->deskripsi_dokumentasi ?? 'Dokumentasi untuk ' . $kegiatan->nama_kegiatan }}
                    </p>

                    <a href="{{ asset('storage/' . $item->file_kegiatan) }}" download
                        class="block w-full bg-[#E75C16] text-white py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-[#C54716] text-center transition-all shadow-sm shadow-orange-50">Simpan</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<div id="modalPreview" class="hidden fixed inset-0 bg-[#69200F]/40 z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="relative max-w-5xl w-full flex flex-col items-center">
        <button onclick="closePreview()" class="absolute -top-12 right-0 text-white text-4xl font-light hover:text-[#FA8145] transition-colors">✕</button>
        <img id="previewImage" class="hidden max-w-full max-h-[80vh] rounded-3xl shadow-2xl border-4 border-white/10" onclick="event.stopPropagation()">
        <video id="previewVideo" controls class="hidden max-w-full max-h-[80vh] rounded-3xl shadow-2xl border-4 border-white/10" onclick="event.stopPropagation()"></video>
    </div>
</div>

<div id="modalDownloadAll" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-xl font-bold text-[#69200F] uppercase tracking-tight mb-3">Simpan Semua?</h3>
        <p class="text-sm text-gray-500 mb-8 font-medium">Seluruh file akan dibungkus dalam ZIP untuk diunduh.</p>
        <div class="flex flex-col gap-3">
            <a href="{{ route('kegiatan.dokumentasi.downloadAll', $kegiatan->id_kegiatan) }}" 
               onclick="closeModal('modalDownloadAll')"
               class="w-full py-4 bg-[#A33215] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#69200F] shadow-xl shadow-orange-100 transition-all text-center">Ya, Unduh</a>
            <button type="button" onclick="closeModal('modalDownloadAll')" class="w-full py-4 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-gray-600 transition-all">Batal</button>
        </div>
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

    function openPreview(url, isVideo) {
        const modal = document.getElementById('modalPreview');
        const img = document.getElementById('previewImage');
        const vid = document.getElementById('previewVideo');
        
        modal.classList.remove('hidden');
        
        if (isVideo) {
            img.classList.add('hidden');
            vid.classList.remove('hidden');
            vid.src = url;
            vid.play();
        } else {
            vid.classList.add('hidden');
            vid.pause();
            img.classList.remove('hidden');
            img.src = url;
        }
    }

    // Close preview
    function closePreview() {
        const modal = document.getElementById('modalPreview');
        const vid = document.getElementById('previewVideo');
        
        modal.classList.add('hidden');
        vid.pause();
        vid.src = '';
    }

    // Close modal when clicking outside
    document.getElementById('modalPreview').addEventListener('click', function(e) {
        if (e.target === this) {
            closePreview();
        }
    });
</script>
@endpush
