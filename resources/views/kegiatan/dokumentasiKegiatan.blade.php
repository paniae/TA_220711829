@extends('layouts.app')

@section('title', 'Dokumentasi Kegiatan')

@section('content')

@if(session('success'))
<div id="alertSuccess" class="fixed top-20 right-4 z-[9999] bg-white border-l-4 border-[#FA8145] p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-fade-in-down">
    <span class="font-semibold text-sm text-[#A33215]">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div id="alertError" class="fixed top-20 right-4 z-[9999] bg-white border-l-4 border-[#A33215] p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-fade-in-down">
    <span class="font-semibold text-sm text-[#69200F]">{{ session('error') }}</span>
</div>
@endif

@php use Illuminate\Support\Str; @endphp

<div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
    <a href="{{ route('kegiatan.kelolaKegiatan', ['tab' => $kegiatan->jenis_kegiatan]) }}" 
        class="inline-flex items-center justify-center gap-2 bg-white border-2 border-gray-100 text-gray-500 px-5 py-2 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:border-[#FA8145] hover:text-[#A33215] hover:bg-orange-50 transition-all shadow-sm active:scale-95">
        Kembali
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] p-8 mb-8 relative overflow-hidden">
    @php
        $statusData = match($kegiatan->status_kegiatan) {
            'direncanakan' => ['color' => 'bg-[#FA8145]/10 text-[#E75C16] border-[#FA8145]/30', 'badge' => 'Rencana'],
            'berlangsung'  => ['color' => 'bg-[#E75C16]/10 text-[#A33215] border-[#E75C16]/30', 'badge' => 'Aktif'],
            'selesai'      => ['color' => 'bg-[#69200F]/10 text-[#69200F] border-[#69200F]/25', 'badge' => 'Selesai'],
            default        => ['color' => 'bg-gray-50 text-gray-500 border-gray-100', 'badge' => 'Unknown'],
        };
    @endphp

    @if($kegiatan->poster_kegiatan)
    <div class="flex flex-col sm:flex-row gap-8 items-start">

        <div class="flex-shrink-0 flex flex-col items-center">
            <img
                src="{{ asset('storage/' . $kegiatan->poster_kegiatan) }}"
                alt="Poster {{ $kegiatan->nama_kegiatan }}"
                onclick="showImage('{{ asset('storage/' . $kegiatan->poster_kegiatan) }}')"
                class="w-44 sm:w-52 object-contain rounded-2xl border border-orange-100 shadow-md cursor-pointer hover:scale-105 hover:shadow-xl transition-all duration-300">
            <p class="text-[10px] text-gray-400 mt-2 text-center">Klik untuk perbesar</p>
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex flex-col md:flex-row justify-between items-start gap-3 border-b border-gray-50 pb-5 mb-5">
                <div>
                    <span class="px-4 py-1.5 rounded-full bg-orange-50 text-[#C54716] text-xs font-semibold uppercase tracking-wider border border-orange-100 mb-3 inline-block">
                        Dokumentasi Kegiatan
                    </span>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#69200F] leading-tight uppercase tracking-tight">
                        {{ $kegiatan->nama_kegiatan }}
                    </h1>
                </div>
                <div class="bg-orange-50/50 px-5 py-3 rounded-2xl border border-orange-100/50 text-right shrink-0">
                    <p class="text-xs font-semibold text-[#E75C16] uppercase tracking-wider mb-1">Dana Terpakai</p>
                    <p class="text-xl font-bold text-[#C54716]">
                        {{ $kegiatan->dana_dikeluarkan ? 'Rp ' . number_format($kegiatan->dana_dikeluarkan, 0, ',', '.') : '-' }}
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-5">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Mulai</p>
                    <p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->tgl_waktu_pelaksanaan ? \Carbon\Carbon::parse($kegiatan->tgl_waktu_pelaksanaan)->translatedFormat('d M Y • H:i') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Selesai</p>
                    <p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->waktu_selesai ? \Carbon\Carbon::parse($kegiatan->waktu_selesai)->translatedFormat('d M Y • H:i') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Lokasi</p>
                    <p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->lokasi ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</p>
                    <p class="text-sm font-bold text-[#E75C16] uppercase tracking-wider">{{ $kegiatan->kategori ?? '-' }}</p>
                </div>
            </div>

            @if($kegiatan->deskripsi_kegiatan)
            <div class="bg-[#FA8145]/5 p-4 rounded-2xl border border-[#FA8145]/10">
                <p class="text-xs font-semibold text-[#A33215] uppercase tracking-wider mb-1">Deskripsi Kegiatan</p>
                <p class="text-sm text-gray-600 leading-relaxed font-medium">"{{ $kegiatan->deskripsi_kegiatan }}"</p>
            </div>
            @endif
        </div>
    </div>

    @else
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
        <div><p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Mulai</p><p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->tgl_waktu_pelaksanaan ? \Carbon\Carbon::parse($kegiatan->tgl_waktu_pelaksanaan)->translatedFormat('d M Y • H:i') : '-' }}</p></div>
        <div><p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Selesai</p><p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->waktu_selesai ? \Carbon\Carbon::parse($kegiatan->waktu_selesai)->translatedFormat('d M Y • H:i') : '-' }}</p></div>
        <div><p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Lokasi</p><p class="text-sm font-semibold text-[#A33215] uppercase tracking-tight">{{ $kegiatan->lokasi ?? '-' }}</p></div>
        <div><p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kategori</p><p class="text-sm font-bold text-[#E75C16] uppercase tracking-wider">{{ $kegiatan->kategori ?? '-' }}</p></div>
    </div>

    @if($kegiatan->deskripsi_kegiatan)
    <div class="mt-8 bg-[#FA8145]/5 p-6 rounded-2xl border border-[#FA8145]/10">
        <p class="text-xs font-semibold text-[#A33215] uppercase tracking-wider mb-2">Deskripsi Kegiatan</p>
        <p class="text-sm sm:text-base text-gray-600 leading-relaxed font-medium">"{{ $kegiatan->deskripsi_kegiatan }}"</p>
    </div>
    @endif
    @endif
</div>

<div class="mt-12 bg-white rounded-3xl shadow-sm border border-[#FA8145] p-6 md:p-8">
    <div class="flex justify-between items-center mb-8 border-b border-orange-100 pb-4">
        <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight">
            Galeri Dokumentasi
        </h2>
        <div class="flex gap-2">
            @if(!$kegiatan->dokumentasi->isEmpty())
                <button onclick="openModal('modalDownloadAll')"
                    class="bg-orange-50 text-[#C54716] border border-orange-200 px-5 sm:px-6 py-2.5 rounded-xl font-bold text-[10px] sm:text-xs uppercase tracking-wider shadow-sm shadow-orange-100 hover:bg-orange-100 hover:text-[#A33215] transition-all active:scale-95 hidden sm:block">
                    Simpan Semua
                </button>
                <button onclick="openModal('modalDownloadAll')"
                    class="bg-orange-50 text-[#C54716] border border-orange-200 px-4 py-2.5 rounded-xl font-bold text-[10px] sm:text-xs uppercase tracking-wider shadow-sm shadow-orange-100 hover:bg-orange-100 hover:text-[#A33215] transition-all active:scale-95 block sm:hidden">
                    Simpan
                </button>
            @endif
            <button onclick="openModal('modalDokumentasi')"
                class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#A33215] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-orange-100 whitespace-nowrap text-center">
                + Tambah
            </button>
        </div>
    </div>

    @if($kegiatan->dokumentasi->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100 shadow-sm">
            <p class="text-gray-500 font-medium text-sm">Belum ada dokumentasi.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
            @foreach($kegiatan->dokumentasi as $item)
            @php $isVideo = Str::endsWith($item->file_kegiatan, ['.mp4', '.mov', '.avi']); @endphp

            <div class="group bg-white rounded-[2rem] border border-gray-200 hover:border-[#FA8145] shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1">
                <div class="relative aspect-video overflow-hidden bg-black cursor-pointer group-hover:shadow-md transition-all" onclick="openPreview('{{ asset('storage/' . $item->file_kegiatan) }}', {{ $isVideo ? 'true' : 'false' }}, '{{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->translatedFormat('d M Y') }}', '{{ addslashes($item->deskripsi_dokumentasi ?? 'Dokumentasi untuk ' . $kegiatan->nama_kegiatan) }}')">
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

                <div class="p-6 cursor-pointer" onclick="openPreview('{{ asset('storage/' . $item->file_kegiatan) }}', {{ $isVideo ? 'true' : 'false' }}, '{{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->translatedFormat('d M Y') }}', '{{ addslashes($item->deskripsi_dokumentasi ?? 'Dokumentasi untuk ' . $kegiatan->nama_kegiatan) }}')">
                    <p class="text-xs font-bold text-[#FA8145] uppercase tracking-wider mb-2">
                        {{ \Carbon\Carbon::parse($item->tanggal_dokumentasi)->translatedFormat('d M Y') }}
                    </p>
                    <p class="text-sm text-gray-700 line-clamp-2 min-h-[2.5rem] leading-relaxed mb-6 font-medium group-hover:text-[#C54716] transition-colors">
                        {{ $item->deskripsi_dokumentasi ?? 'Dokumentasi untuk ' . $kegiatan->nama_kegiatan }}
                    </p>

                    <div class="grid grid-cols-2 gap-2" onclick="event.stopPropagation()">
                        <a href="{{ asset('storage/' . $item->file_kegiatan) }}" download
                            class="bg-orange-50 text-[#C54716] border border-orange-200 py-2 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-orange-100 hover:text-[#A33215] text-center transition-all shadow-sm shadow-orange-50">Simpan</a>
                        <button onclick="openEditDokumentasi('{{ $item->id_dokumentasi }}', '{{ $item->tanggal_dokumentasi }}', '{{ addslashes($item->deskripsi_dokumentasi) }}', '{{ asset('storage/' . $item->file_kegiatan) }}', {{ $isVideo ? 'true' : 'false' }})"
                            class="bg-orange-50 text-[#C54716] border border-orange-200 py-2 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-orange-100 hover:text-[#A33215] transition-all shadow-sm shadow-orange-50">Ubah</button>
                        <button onclick="openDeleteDokumentasi('{{ $item->id_dokumentasi }}')"
                            class="col-span-2 bg-[#7F1911] text-white py-2 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-[#5A120C] transition-all shadow-sm shadow-orange-50">Hapus</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<div id="modalEditDokumentasi" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-8 border-b bg-gray-50/50 relative">
            <h2 class="text-xl font-semibold text-[#69200F] uppercase tracking-tight w-11/12">Ubah Dokumentasi</h2>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
            <button onclick="closeModal('modalEditDokumentasi')" class="absolute top-8 right-8 text-gray-400 hover:text-[#A33215] text-2xl transition-colors leading-none">✕</button>
        </div>
        <form id="formEditDokumentasi" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf @method('PUT')
            <div class="p-8 space-y-6 flex-1 overflow-y-auto">
                <div id="currentFilePreview" class="mb-4">
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Ubah File (Opsional)</label>
                    <input type="file" name="file_kegiatan" id="edit_file_kegiatan" accept="image/*,video/*"
                        class="w-full border-2 border-dashed border-gray-200 p-4 rounded-2xl file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:uppercase file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2 italic">*Kosongkan jika tidak ingin mengubah foto/video</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Tanggal Dokumentasi</label>
                    <input type="date" name="tanggal_dokumentasi" id="edit_tanggal_dokumentasi"
                        class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Keterangan / Deskripsi</label>
                    <textarea name="deskripsi_dokumentasi" id="edit_deskripsi_dokumentasi" class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-medium text-sm text-gray-700" rows="3" placeholder="Ceritakan sedikit tentang dokumentasi ini..."></textarea>
                </div>
            </div>
            <div class="p-8 border-t bg-gray-50/50 flex justify-end gap-4">
                <button type="button" onclick="closeModal('modalEditDokumentasi')" class="px-6 py-3 text-xs sm:text-sm font-bold text-[#7F1911] uppercase tracking-wider hover:text-[#5A120C] transition-all">Batal</button>
                <button type="submit" class="px-10 py-3 bg-[#C54716] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] shadow-xl shadow-orange-100 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalDokumentasi" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-8 border-b bg-gray-50/50 relative">
            <h2 class="text-xl font-semibold text-[#69200F] uppercase tracking-tight w-11/12">Tambah Dokumentasi</h2>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
            <button onclick="closeModal('modalDokumentasi')" class="absolute top-8 right-8 text-gray-400 hover:text-[#A33215] text-2xl transition-colors leading-none">✕</button>
        </div>
        <form action="{{ route('kegiatan.dokumentasi.store', $kegiatan->id_kegiatan) }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" name="id_kegiatan" value="{{ $kegiatan->id_kegiatan }}">
            <div class="p-8 space-y-6 flex-1 overflow-y-auto">

                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Tanggal Dokumentasi</label>
                    <input type="date" name="tanggal" value="{{ now()->format('Y-m-d') }}"
                        class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Keterangan / Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-medium text-sm text-gray-700" rows="3" placeholder="Ceritakan sedikit tentang dokumentasi ini..."></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Pilih File (Foto/Video)</label>
                    <input type="file" name="file_kegiatan[]" id="inputFoto" multiple accept="image/*,video/*" required
                        class="w-full border-2 border-dashed border-gray-200 p-8 rounded-3xl mt-1 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:text-xs file:font-bold file:uppercase file:bg-[#FA8145] file:text-white hover:file:bg-[#E75C16] cursor-pointer">
                    <div id="previewFoto" class="grid grid-cols-3 gap-3 mt-6"></div>
                </div>
            </div>
            <div class="p-8 border-t bg-gray-50/50 flex justify-end gap-4">
                <button type="button" onclick="closeModal('modalDokumentasi')" class="px-6 py-3 text-xs sm:text-sm font-bold text-[#7F1911] uppercase tracking-wider hover:text-[#5A120C] transition-all">Batal</button>
                <button type="submit" class="px-10 py-3 bg-[#C54716] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] shadow-xl shadow-orange-100 transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalPreview" class="hidden fixed inset-0 bg-[#69200F]/60 z-[999] flex items-center justify-center p-4 md:p-8 backdrop-blur-md transition-all">
    <div class="relative max-w-6xl w-full flex flex-col md:flex-row bg-white rounded-[2.5rem] shadow-2xl overflow-hidden max-h-[90vh] animate-zoom-in border border-[#FA8145]/30">
        <button onclick="closePreview()" class="absolute top-4 right-6 text-gray-400 hover:text-[#A33215] text-3xl font-light transition-colors z-10 bg-white/80 hover:bg-white rounded-full w-10 h-10 flex items-center justify-center backdrop-blur-sm">✕</button>
        
        <!-- Media Section -->
        <div class="w-full md:w-[65%] bg-black flex items-center justify-center min-h-[40vh] md:min-h-[70vh] relative">
            <img id="previewImage" class="hidden max-w-full max-h-[70vh] object-contain">
            <video id="previewVideo" controls class="hidden max-w-full max-h-[70vh] object-contain"></video>
        </div>
        
        <!-- Detail Section -->
        <div class="w-full md:w-[35%] p-8 md:p-10 flex flex-col bg-gray-50/50">
            <div class="mb-6">
                <span id="previewDate" class="inline-block px-4 py-1.5 rounded-full bg-orange-50 text-[#C54716] text-[10px] sm:text-xs font-bold uppercase tracking-wider border border-orange-100"></span>
            </div>
            <h3 class="text-xl font-bold text-[#69200F] uppercase tracking-tight mb-4">Detail Dokumentasi</h3>
            <div class="w-12 h-1.5 bg-[#FA8145] rounded-full mb-6"></div>
            <div class="flex-grow overflow-y-auto pr-2 custom-scrollbar">
                <p id="previewDesc" class="text-sm text-gray-600 leading-relaxed font-medium"></p>
            </div>
        </div>
    </div>
</div>

<div id="modalImagePreview" class="hidden fixed inset-0 bg-black/80 z-[999] flex items-center justify-center p-4 backdrop-blur-sm" onclick="closeModal('modalImagePreview')">
    <div class="relative max-w-4xl w-full flex justify-center">
        <button onclick="closeModal('modalImagePreview')" class="absolute -top-12 right-0 text-white text-4xl font-light hover:text-[#FA8145] transition-colors">✕</button>
        <img id="simplePreviewImage" src="" class="max-w-full max-h-[80vh] rounded-3xl shadow-2xl object-contain border-4 border-white/10" onclick="event.stopPropagation()">
    </div>
</div>

<div id="modalDeleteDokumentasi" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-xl font-bold text-[#69200F] uppercase tracking-tight mb-3">Hapus Data?</h3>
        <p class="text-sm text-gray-500 mb-8 font-medium">Data yang dihapus tidak dapat dikembalikan lagi.</p>
        <form id="formDeleteDokumentasi" method="POST" class="flex gap-3 justify-center">
            @csrf @method('DELETE')
            <button type="button" onclick="closeModal('modalDeleteDokumentasi')" class="flex-1 px-4 py-3 bg-gray-100 text-[#7F1911] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="flex-1 px-4 py-3 bg-[#7F1911] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#5A120C] transition-all shadow-lg shadow-orange-100">Ya, Hapus</button>
        </form>
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
            <button type="button" onclick="closeModal('modalDownloadAll')" class="w-full py-4 text-xs sm:text-sm font-bold text-[#7F1911] uppercase tracking-wider hover:text-[#5A120C] transition-all">Batal</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let selectedFiles = [];

document.getElementById('inputFoto').addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    files.forEach(file => {
        selectedFiles.push(file);
    });
    renderPreview();
});

function renderPreview() {
    const preview = document.getElementById('previewFoto');
    preview.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const div = document.createElement('div');
        div.className = 'relative group';

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-xl border-2 border-gray-100">
                    <button type="button" onclick="removeImage(${index})" class="absolute top-1 right-1 bg-black/70 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs hover:bg-[#A33215] transition-all">✕</button>
                `;
            };
            reader.readAsDataURL(file);
        } else {
            div.innerHTML = `
                <div class="w-full h-24 bg-gray-100 flex items-center justify-center rounded-xl border-2 border-gray-100 text-2xl">🎬</div>
                <button type="button" onclick="removeImage(${index})" class="absolute top-1 right-1 bg-black/70 text-white w-6 h-6 flex items-center justify-center rounded-full text-xs hover:bg-[#A33215] transition-all">✕</button>
            `;
        }
        preview.appendChild(div);
    });
    updateInputFiles(); 
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
}

function updateInputFiles() {
    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => {
        dataTransfer.items.add(file);
    });
    document.getElementById('inputFoto').files = dataTransfer.files;
}

function showImage(src) {
    document.getElementById('simplePreviewImage').src = src;
    openModal('modalImagePreview');
}

function openPreview(src, isVideo, date, desc) {
    const modal = document.getElementById('modalPreview');
    const img = document.getElementById('previewImage');
    const vid = document.getElementById('previewVideo');
    const dateEl = document.getElementById('previewDate');
    const descEl = document.getElementById('previewDesc');

    dateEl.innerText = date;
    descEl.innerText = desc || 'Tidak ada deskripsi tersedia.';

    modal.classList.remove('hidden');

    if (isVideo) {
        vid.src = src;
        vid.classList.remove('hidden');
        img.classList.add('hidden');
    } else {
        img.src = src;
        img.classList.remove('hidden');
        vid.classList.add('hidden');
    }
}

function closePreview() {
    const modal = document.getElementById('modalPreview');
    const vid = document.getElementById('previewVideo');
    modal.classList.add('hidden');
    vid.pause();
    vid.src = '';
}

// Auto-hide alert
setTimeout(() => {
    ['alertSuccess', 'alertError'].forEach(id => {
        const el = document.getElementById(id);
        if(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-10px)';
            el.style.transition = 'all 0.5s ease';
            setTimeout(() => el.remove(), 500);
        }
    });
}, 3000);

function openEditDokumentasi(id, tanggal, deskripsi, fileUrl, isVideo) {
    document.getElementById('formEditDokumentasi').action = `/dokumentasi/${id}`;
    
    // Pastikan format tanggal YYYY-MM-DD tanpa konversi timezone JS
    // Jika tanggal datang dengan format "YYYY-MM-DD HH:mm:ss", ambil 10 karakter pertama
    const formattedDate = tanggal.substring(0, 10);
    
    document.getElementById('edit_tanggal_dokumentasi').value = formattedDate;
    document.getElementById('edit_deskripsi_dokumentasi').value = deskripsi;

    // Preview file saat ini
    const previewContainer = document.getElementById('currentFilePreview');
    if (isVideo) {
        previewContainer.innerHTML = `
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Video Saat Ini</p>
            <video class="w-full h-32 object-cover rounded-2xl border-2 border-gray-100" muted>
                <source src="${fileUrl}">
            </video>
        `;
    } else {
        previewContainer.innerHTML = `
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Foto Saat Ini</p>
            <img src="${fileUrl}" class="w-full h-32 object-cover rounded-2xl border-2 border-gray-100">
        `;
    }

    openModal('modalEditDokumentasi');
}

function openDeleteDokumentasi(id) {
    document.getElementById('formDeleteDokumentasi').action = `/dokumentasi/${id}`;
    openModal('modalDeleteDokumentasi');
}

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}
</script>
@endpush
