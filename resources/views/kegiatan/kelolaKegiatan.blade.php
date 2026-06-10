@extends('layouts.app')

@section('title', 'Kegiatan Padukuhan')

@section('content')

<div class="bg-white/90 backdrop-blur rounded-2xl p-4 md:p-6 shadow border border-[#FA8145] mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
        <div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#A33215] leading-tight uppercase tracking-tight">
                Kelola Kegiatan & Proker
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium max-w-md">
                Manajemen agenda kegiatan dan program kerja Padukuhan.
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

@if(session('success'))
<div id="alertSuccess"
     class="bg-orange-50 border border-[#FA8145] text-[#A33215] p-4 rounded-xl mb-6 flex justify-between items-center shadow-sm">
    <div class="flex items-center gap-3">
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    <span class="text-xs opacity-50">{{ now()->format('H:i') }}</span>
</div>
@endif

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

            <button onclick="openModal('modalKegiatan')"
                class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#A33215] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-orange-100 whitespace-nowrap text-center">
                + Tambah {{ $tab == 'kegiatan' ? 'Kegiatan' : 'Program Kerja' }}
            </button>
        </div>
    </div>

    <div class="px-6 pb-6 pt-5 bg-white">
        <div id="dataContainer">
        @if($kegiatan->isEmpty())
        <div class="rounded-3xl border-2 border-dashed border-gray-200 p-12 text-center bg-white">
            <div class="text-sm font-black text-gray-300 uppercase tracking-widest mb-4">TIDAK ADA DATA</div>
            <h3 class="text-lg font-bold text-gray-900">Belum Ada Agenda</h3>
            <p class="text-sm text-gray-400 mt-1">Klik tombol di atas untuk menambah kegiatan baru.</p>
        </div>
        @else

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
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

<div class="group bg-white rounded-3xl border-2 border-orange-100 hover:border-[#FA8145] shadow-md hover:shadow-xl transition-all duration-300 flex flex-col h-full overflow-hidden relative cursor-pointer transform hover:-translate-y-1"
    onclick="window.location='{{ route('kegiatan.dokumentasi', $item->id_kegiatan) }}'"
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
        <div class="mt-2 w-full h-32 sm:h-40 rounded-xl overflow-hidden border border-gray-100">
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

    <div class="px-6 py-5 bg-gray-50 border-t flex flex-col justify-between min-h-[110px]">
        <div class="flex flex-wrap gap-2 w-full mb-4">
            @if($item->status_kegiatan == 'direncanakan')
                <button onclick="event.stopPropagation(); handleEdit(this)"
                    data-id="{{ $item->id_kegiatan }}"
                    data-nama="{{ $item->nama_kegiatan }}"
                    data-tanggal="{{ \Carbon\Carbon::parse($item->tgl_waktu_pelaksanaan)->format('Y-m-d') }}"
                    data-jam="{{ \Carbon\Carbon::parse($item->tgl_waktu_pelaksanaan)->format('H:i') }}"
                    data-kategori="{{ $item->kategori }}"
                    data-deskripsi="{{ $item->deskripsi_kegiatan ?? '' }}"
                    data-lokasi="{{ $item->lokasi }}"
                    data-dana="{{ $item->dana_dikeluarkan ?? 0 }}"
                    data-poster="{{ $item->poster_kegiatan ?? '' }}"
                    class="bg-[#C54716] text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-[#A33215] transition-all uppercase tracking-wider flex-1 text-center shadow-sm">
                    Ubah
                </button>
            @endif

            @if($item->status_kegiatan == 'berlangsung')
                <button onclick="event.stopPropagation(); openSelesaiModal('{{ $item->id_kegiatan }}', '{{ $item->nama_kegiatan }}')"
                    class="bg-[#69200F] text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-[#4A160A] transition-all shadow-sm uppercase tracking-wider flex-1 text-center">
                    Selesai
                </button>
            @endif

            @if($item->status_kegiatan != 'selesai')
                <button onclick="event.stopPropagation(); openDeleteModal('{{ $item->id_kegiatan }}')"
                    class="bg-[#A33215] text-white px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-[#69200F] transition-all shadow-sm uppercase tracking-wider flex-1 text-center">
                    Hapus
                </button>
            @endif
        </div>

        <a href="{{ route('kegiatan.dokumentasi', $item->id_kegiatan) }}" onclick="event.stopPropagation()"
           class="text-xs font-bold text-[#C54716] uppercase tracking-wider hover:text-[#A33215] flex items-center justify-center gap-1.5 transition-all w-full text-center">
            Kelola Dokumentasi
        </a>
    </div>
</div>
@endforeach
</div>
@endif
        </div>
    </div>
</div>


<div id="modalKegiatan" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-6 border-b bg-gray-50/50 relative">
            <h2 class="text-lg font-bold text-[#69200F] uppercase tracking-tight w-11/12">Tambah {{ $tab == 'kegiatan' ? 'Kegiatan' : 'Program Kerja' }}</h2>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
            <button onclick="closeModal('modalKegiatan')" class="absolute top-6 right-6 text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold leading-none">✕</button>
        </div>
        <form action="{{ route('kegiatan.store') }}" method="POST" class="flex flex-col flex-1 overflow-hidden" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="status" value="direncanakan">
            <input type="hidden" name="jenis_kegiatan" value="{{ $tab }}">
            <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Nama {{ $tab == 'kegiatan' ? 'Kegiatan' : 'Program Kerja' }} <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="nama_kegiatan" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-medium text-sm text-gray-700" placeholder="Masukkan nama" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Tanggal <span class="text-[#A33215]">*</span></label>
                        <input type="date" name="tanggal" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all text-sm text-gray-700" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Jam <span class="text-[#A33215]">*</span></label>
                        <input type="time" name="jam" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all text-sm text-gray-700" required>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Kategori <span class="text-[#A33215]">*</span></label>
                    <select name="kategori" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none bg-white transition-all font-medium text-sm text-gray-700" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="rt/rw">RT/RW</option>
                        <option value="padukuhan">Padukuhan</option>
                        <option value="kalurahan">Kalurahan</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Lokasi <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="lokasi" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-medium text-sm text-gray-700" placeholder="Contoh: Balai Padukuhan" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Deskripsi</label>
                    <textarea name="deskripsi" class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-medium text-sm text-gray-700" rows="3"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Poster / Gambar (Opsional)</label>
                    <input type="file" name="poster_kegiatan" accept="image/*" class="w-full border-2 border-dashed border-gray-200 p-4 rounded-2xl file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200 cursor-pointer">
                </div>
            </div>
            <div class="p-4 border-t bg-gray-50/50 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalKegiatan')" class="px-5 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-lg text-xs sm:text-sm uppercase tracking-wider">Batal</button>
                <button type="submit" class="px-8 py-2 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all text-xs sm:text-sm shadow-lg shadow-orange-100 uppercase tracking-wider">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditKegiatan" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-6 border-b bg-gray-50/50 relative">
            <h2 class="text-lg font-bold text-[#69200F] uppercase tracking-tight w-11/12">Ubah Kegiatan</h2>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
            <button onclick="closeModal('modalEditKegiatan')" class="absolute top-6 right-6 text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold leading-none">✕</button>
        </div>
        <form id="formEditKegiatan" method="POST" class="flex flex-col flex-1 overflow-hidden" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Nama Kegiatan <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="edit_nama" name="nama_kegiatan" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-medium text-sm text-gray-700" required>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Tanggal <span class="text-[#A33215]">*</span></label>
                        <input type="date" id="edit_tanggal" name="tanggal" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none text-sm text-gray-700" required>
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-2 block">Jam <span class="text-[#A33215]">*</span></label>
                        <input type="time" id="edit_jam" name="jam" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none text-sm text-gray-700" required>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Kategori <span class="text-[#A33215]">*</span></label>
                    <select id="edit_kategori" name="kategori" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none bg-white font-medium text-sm text-gray-700" required>
                        <option value="rt/rw">RT/RW</option>
                        <option value="padukuhan">Padukuhan</option>
                        <option value="kalurahan">Kalurahan</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Lokasi <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="edit_lokasi" name="lokasi" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none font-medium text-sm text-gray-700" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Deskripsi</label>
                    <textarea id="edit_deskripsi" name="deskripsi" class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#FA8145] outline-none font-medium text-sm text-gray-700" rows="3"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Ganti Poster (Opsional)</label>
                    <div id="edit_poster_preview" class="mb-3 hidden">
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Poster Saat Ini</p>
                        <img id="current_poster_img" src="" class="w-32 h-32 object-cover rounded-xl border border-gray-200">
                    </div>
                    <input type="file" id="edit_poster_kegiatan" name="poster_kegiatan" accept="image/*" class="w-full border-2 border-dashed border-gray-200 p-4 rounded-2xl file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2 italic">Abaikan jika tidak ingin mengubah poster saat ini.</p>
                </div>
            </div>
            <div class="p-4 border-t bg-gray-50/50 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalEditKegiatan')" class="px-5 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-lg text-xs sm:text-sm uppercase tracking-wider">Batal</button>
                <button type="submit" class="px-8 py-2 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all text-xs sm:text-sm shadow-lg shadow-orange-100 uppercase tracking-wider">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalDeleteKegiatan" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-xl font-semibold text-[#69200F] mb-3 uppercase tracking-tight">Hapus Kegiatan?</h3>
        <p class="text-sm text-gray-500 mb-6 font-medium">Data kegiatan ini akan dihapus secara permanen.</p>
        <form id="formDeleteKegiatan" method="POST" class="flex flex-col gap-3">
            @csrf @method('DELETE')
            <button type="submit" class="w-full py-4 bg-[#A33215] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#69200F] shadow-xl shadow-orange-100 transition-all">Hapus Sekarang</button>
            <button type="button" onclick="closeModal('modalDeleteKegiatan')" class="w-full py-4 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-gray-600 transition-all">Batal</button>
        </form>
    </div>
</div>

<div id="modalMulaiKegiatan" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-xl font-semibold text-[#69200F] mb-3 uppercase tracking-tight">Mulai Kegiatan</h3>
        <p id="textMulai" class="text-sm text-gray-500 mb-6 font-medium">Ubah status kegiatan menjadi 'Berlangsung'?</p>
        <form id="formMulaiKegiatan" method="POST" class="flex flex-col gap-3">
            @csrf @method('PUT')
            <button type="submit" class="w-full py-4 bg-[#C54716] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] shadow-xl shadow-orange-100 transition-all">Ya, Mulai</button>
            <button type="button" onclick="closeModal('modalMulaiKegiatan')" class="w-full py-4 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-gray-600 transition-all">Batal</button>
        </form>
    </div>
</div>

<div id="modalSelesaiKegiatan" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-xl font-semibold text-[#69200F] mb-3 uppercase tracking-tight">Selesaikan Kegiatan</h3>
        <p id="textSelesai" class="text-sm text-gray-500 mb-6 font-medium">Kegiatan telah selesai dilaksanakan?</p>
        <form id="formSelesaiKegiatan" method="POST" class="flex flex-col gap-3">
            @csrf @method('PUT')
            <button type="submit" class="w-full py-4 bg-[#69200F] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#4A160A] shadow-xl shadow-orange-100 transition-all">Selesai</button>
            <button type="button" onclick="closeModal('modalSelesaiKegiatan')" class="w-full py-4 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-gray-600 transition-all">Batal</button>
        </form>
    </div>
</div>

<div id="modalImagePreview" class="fixed inset-0 bg-black/90 hidden z-[9999] flex items-center justify-center p-2 md:p-6 backdrop-blur-sm" onclick="closeModal('modalImagePreview')">
    <div class="relative w-full max-w-6xl h-[90vh] flex items-center justify-center">
        <button onclick="closeModal('modalImagePreview')" class="absolute -top-4 right-0 md:-right-8 md:-top-4 text-white hover:text-gray-300 text-5xl font-black z-50 drop-shadow-lg">&times;</button>
        <img id="previewImage" src="" class="w-full h-full object-contain drop-shadow-2xl" onclick="event.stopPropagation()">
    </div>
</div>

@endsection

@push('scripts')
<script>
setTimeout(() => {
    const alert = document.getElementById('alertSuccess');
    if (alert) {
        alert.style.transition = 'all 0.5s ease';
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);    

function handleEdit(el) {
    const id = el.dataset.id;
    document.getElementById('edit_nama').value = el.dataset.nama || '';
    document.getElementById('edit_tanggal').value = el.dataset.tanggal || '';
    document.getElementById('edit_jam').value = el.dataset.jam || '';

    document.getElementById('edit_kategori').value = (el.dataset.kategori || '').toLowerCase();
    document.getElementById('edit_deskripsi').value = el.dataset.deskripsi || '';
    document.getElementById('edit_lokasi').value = el.dataset.lokasi || '';
    
    // Poster Preview
    const posterPreview = document.getElementById('edit_poster_preview');
    const currentPosterImg = document.getElementById('current_poster_img');
    if (el.dataset.poster) {
        posterPreview.classList.remove('hidden');
        currentPosterImg.src = "{{ asset('storage') }}/" + el.dataset.poster;
    } else {
        posterPreview.classList.add('hidden');
        currentPosterImg.src = '';
    }

    document.getElementById('formEditKegiatan').action = `/kegiatan/${id}`;
    openModal('modalEditKegiatan');
}

function openDeleteModal(id) {
    document.getElementById('formDeleteKegiatan').action = `/kegiatan/${id}`;
    openModal('modalDeleteKegiatan');
}

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


function openSelesaiModal(id, nama) {
    document.getElementById('formSelesaiKegiatan').action = `/kegiatan/${id}/selesai`;
    document.getElementById('textSelesai').innerText = `Selesaikan agenda kegiatan "${nama}" sekarang?`;
    openModal('modalSelesaiKegiatan');
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
    url.searchParams.delete('page'); // Reset ke halaman 1

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
    // Posisikan kursor di akhir teks saat pertama kali di-load
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