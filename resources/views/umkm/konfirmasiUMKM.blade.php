@extends('layouts.app')

@section('title', 'Verifikasi UMKM')

@section('content')
@if(auth()->user()->hasAkses('konfirmasi_umkm'))

<div class="relative overflow-hidden bg-white rounded-3xl p-5 md:p-8 shadow-sm border border-[#FA8145] mb-5">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-[#C54716] text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FA8145] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FA8145]"></span>
                </span>
                Pusat Manajemen UMKM
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#A33215] leading-tight uppercase tracking-tight">
                Kelola UMKM <span class="text-gray-300 mx-1">&</span> Produk Master
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium max-w-md">
                Kelola pendaftaran UMKM warga serta pantau daftar produk yang tersedia.
            </p>
        </div>

        <div class="bg-gray-100/80 p-1.5 rounded-2xl flex gap-1 border border-gray-200 shadow-inner w-full md:w-auto overflow-x-auto no-scrollbar">
            <button onclick="switchMainTab('umkm')" id="tabBtn-umkm" 
                class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all bg-white text-[#C54716] shadow-sm">
                Kelola UMKM
            </button>
            <button onclick="switchMainTab('produk')" id="tabBtn-produk" 
                class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all text-gray-500 hover:text-gray-700">
                Kelola Produk Master
            </button>
        </div>
    </div>
</div>

@if(session('success'))
<div id="alertSuccess" class="bg-white border-l-4 border-[#C54716] p-4 rounded-2xl shadow-sm mb-8 flex justify-between items-center animate-fade-in-down">
    <div class="flex items-center gap-3 text-[#C54716]">
        <span class="font-bold text-xs uppercase tracking-tight">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-xs font-bold text-gray-400 hover:text-gray-600 uppercase tracking-wider">Tutup</button>
</div>
@endif

<div id="tabContent-umkm">
<div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] p-5 md:p-8 mb-8">
    <p class="text-xs text-gray-500 font-bold mb-4 uppercase tracking-wider">
        Statistik UMKM
    </p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div onclick="window.location.href='{{ route('umkm.konfirmasi.index', ['kategori' => request('kategori')]) }}'" 
             class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ !$currentStatus ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Semua UMKM</h3>
            <p class="text-2xl font-bold text-[#C54716]">{{ $menunggu + $aktif }}</p>
        </div>

        <div onclick="window.location.href='{{ route('umkm.konfirmasi.index', ['status' => 'menunggu', 'kategori' => request('kategori')]) }}'" 
             class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $currentStatus == 'menunggu' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#FA8145]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Menunggu Konfirmasi</h3>
            <p class="text-2xl font-bold text-[#FA8145]">{{ $menunggu }}</p>
        </div>

        <div onclick="window.location.href='{{ route('umkm.konfirmasi.index', ['status' => 'aktif', 'kategori' => request('kategori')]) }}'" 
             class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $currentStatus == 'aktif' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#E75C16]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">UMKM Aktif</h3>
            <p class="text-2xl font-bold text-[#E75C16]">{{ $aktif }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden mb-8">
    <div class="p-5 md:p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
            <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Daftar UMKM</h2>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">

        <form action="{{ route('umkm.konfirmasi.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            
            <div class="relative w-full sm:w-64">
                <input type="text" name="search_umkm" value="{{ request('search_umkm') }}" placeholder="Cari UMKM..." 
                    class="w-full pl-10 pr-4 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all" autocomplete="off">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <select name="kategori" onchange="this.form.submit()" class="w-full sm:w-auto border border-orange-200 p-2.5 rounded-xl focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] outline-none text-sm font-bold text-gray-600 bg-white hover:bg-orange-50 cursor-pointer transition-all shadow-sm">
                <option value="">Semua Kategori</option>
                <option value="kuliner" {{ request('kategori') == 'kuliner' ? 'selected' : '' }}>Kuliner</option>
                <option value="fashion" {{ request('kategori') == 'fashion' ? 'selected' : '' }}>Fashion</option>
                <option value="agribisnis" {{ request('kategori') == 'agribisnis' ? 'selected' : '' }}>Agribisnis</option>
                <option value="jasa & produk kreatif" {{ request('kategori') == 'jasa & produk kreatif' ? 'selected' : '' }}>Jasa & Produk Kreatif</option>
                <option value="teknologi dan digital" {{ request('kategori') == 'teknologi dan digital' ? 'selected' : '' }}>Teknologi & Digital</option>
            </select>
        </form>
            <button onclick="openModalTambahUmkm()" class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#A33215] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-orange-100 whitespace-nowrap text-center">
                + Tambah UMKM
            </button>
        </div>
    </div>

    <div class="p-6">

    @if($umkm->isEmpty())
        <div class="bg-white rounded-3xl p-16 md:p-20 text-center border-2 border-dashed border-gray-100">
            <p class="text-gray-300 font-bold uppercase tracking-wider text-sm">Belum Ada Data UMKM</p>
        </div>
    @else

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

        @foreach($umkm as $item)

        <div 
            class="bg-orange-50/20 border border-orange-200/60 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-[#FA8145] hover:bg-orange-50/40 transition-all cursor-pointer group flex flex-col h-full relative overflow-hidden active:scale-95 active:bg-orange-100/60 active:border-[#FA8145] active:ring-2 active:ring-[#C54716]"
            onclick="window.location='{{ route('umkm.konfirmasi.show', $item->id_umkm) }}'"
        >

            <div class="flex justify-between items-start mb-3 gap-2">
                <div>
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-tight line-clamp-1 group-hover:text-[#C54716] transition-colors">
                        {{ $item->nama_umkm }}
                    </h2>
                    <p class="text-xs font-semibold text-gray-400 mt-0.5 uppercase tracking-wider line-clamp-1">
                        {{ $item->nama_pemilik }}
                    </p>
                </div>
                
                @if($item->status == 'menunggu')
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-orange-50 text-[#FA8145] uppercase tracking-wider border border-[#FA8145]/30 whitespace-nowrap">
                        Menunggu
                    </span>
                @elseif($item->status == 'aktif')
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-[#E75C16] text-white uppercase tracking-wider shadow-sm shadow-orange-200 whitespace-nowrap">
                        Aktif
                    </span>
                @else
                    <span class="text-[10px] font-bold px-2 py-1 rounded-lg bg-gray-100 text-gray-600 uppercase tracking-wider border border-gray-200 whitespace-nowrap">
                        {{ $item->status }}
                    </span>
                @endif
            </div>

            @php
                $fotoPath = $item->foto;
                if (empty($fotoPath)) {
                    $defaultImages = [
                        'kuliner' => 'images/kuliner.jpg',
                        'fashion' => 'images/fashion.jpg',
                        'agribisnis' => 'images/agribisnis.jpg',
                        'jasa & produk kreatif' => 'images/jasa.jpg',
                        'teknologi dan digital' => 'images/teknologi.jpg',
                    ];
                    $fotoPath = $defaultImages[strtolower($item->bidang_umkm ?? '')] ?? 'images/default.jpg';
                }
            @endphp
            <div class="relative w-full h-36 mb-4 rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                <img src="{{ str_contains($fotoPath, 'images/') ? asset($fotoPath) : asset('storage/' . $fotoPath) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <div class="flex-grow">
                @if($item->alamat)
                <div class="flex items-start gap-2 mb-2">
                    <span class="text-gray-400 mt-0.5 text-xs">📍</span>
                    <p class="text-xs font-medium text-gray-500 leading-relaxed line-clamp-2">
                        {{ $item->alamat }}
                    </p>
                </div>
                @endif
                <p class="text-xs font-medium text-gray-600 line-clamp-2 leading-relaxed">
                    {{ $item->deskripsi ?? 'Tidak ada deskripsi tersedia.' }}
                </p>
            </div>
            
            <div class="mt-4 pt-4 border-t border-orange-100/50 flex justify-between items-center">
                @if($item->status == 'menunggu' && auth()->check() && auth()->user()->hasAkses('konfirmasi_umkm'))
                    <button type="button" onclick="event.stopPropagation(); openConfirmModal('Konfirmasi UMKM', 'Anda akan mengonfirmasi UMKM <strong class=\'text-[#FA8145]\'>{{ addslashes($item->nama_umkm) }}</strong>. UMKM ini akan menjadi aktif.', '{{ route('umkm.konfirmasi.confirm', $item->id_umkm) }}')" class="bg-[#C54716] text-white px-4 py-2 rounded-xl font-bold text-xs uppercase tracking-wider shadow-sm hover:bg-[#A33215] transition-all">
                        Konfirmasi
                    </button>
                @else
                    <div></div>
                @endif
                <span class="text-[10px] font-bold text-[#C54716] uppercase tracking-wider group-hover:underline">Lihat Detail →</span>
            </div>

        </div>

        @endforeach

    </div>

    @endif

    </div>
</div>

</div>
<div id="tabContent-produk" class="hidden">
    
    <div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] p-5 md:p-8 mb-8">
        <p class="text-xs text-gray-500 font-bold mb-4 uppercase tracking-wider">
            Statistik Produk Master
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div onclick="window.location.href='{{ route('umkm.konfirmasi.index', ['tab' => 'produk', 'status_produk' => 'menunggu']) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $currentStatusProduk == 'menunggu' || !$currentStatusProduk ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#FA8145]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Menunggu Konfirmasi</h3>
                <p class="text-2xl font-bold text-[#FA8145]">{{ $menungguProdukMaster ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('umkm.konfirmasi.index', ['tab' => 'produk', 'status_produk' => 'aktif']) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $currentStatusProduk == 'aktif' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#E75C16]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Master Aktif</h3>
                <p class="text-2xl font-bold text-[#E75C16]">{{ $aktifProdukMaster ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden mb-8">
        
        <div class="p-5 md:p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
                <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Kelola Produk Master</h2>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">

                <form action="{{ route('umkm.konfirmasi.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <input type="hidden" name="tab" value="produk">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                
                <div class="relative w-full sm:w-64">
                    <input type="text" name="search_produk" value="{{ request('search_produk') }}" placeholder="Cari Produk Master..." 
                        class="w-full pl-10 pr-4 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all" autocomplete="off">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <select name="status_produk" onchange="this.form.submit()" class="w-full sm:w-auto border border-orange-200 p-2.5 rounded-xl focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] outline-none text-sm font-bold text-gray-600 bg-white hover:bg-orange-50 cursor-pointer transition-all shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status_produk') == 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="aktif" {{ request('status_produk') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                </select>
            </form>
                <button onclick="openModalTambahProdukMaster()" class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#A33215] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-orange-100 whitespace-nowrap text-center">
                    + Tambah Produk Master
                </button>
            </div>
        </div>

        <div class="p-6">
            @if($produkMaster->isEmpty())
                <div class="bg-white rounded-3xl p-16 md:p-20 text-center border-2 border-dashed border-gray-100">
                    <p class="text-gray-300 font-bold uppercase tracking-wider text-sm">Tidak Ada Produk Master Menunggu</p>
                </div>
            @else
                <div class="overflow-x-auto rounded-2xl border border-gray-100">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-orange-50/50 text-[#C54716] text-[10px] sm:text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="p-3 sm:p-4 font-bold whitespace-nowrap w-10">No</th>
                                <th class="p-3 sm:p-4 font-bold whitespace-normal sm:whitespace-nowrap">Nama Produk Umum</th>
                                <th class="p-3 sm:p-4 font-bold whitespace-nowrap hidden sm:table-cell">Status</th>
                                <th class="p-3 sm:p-4 font-bold text-center whitespace-nowrap w-24 sm:w-auto">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs sm:text-sm">
                            @foreach($produkMaster as $index => $pm)
                            <tr class="border-b-2 sm:border-b border-gray-200 sm:border-gray-50 odd:bg-white even:bg-gray-50/40 hover:bg-orange-50/20 transition-all">
                                <td class="p-3 sm:p-4 text-gray-500 font-medium align-top sm:align-middle">{{ $index + 1 }}</td>
                                <td class="p-3 sm:p-4 font-bold text-gray-800 whitespace-normal sm:whitespace-nowrap align-top sm:align-middle">
                                    {{ $pm->nama_produk_master }}
                                    <div class="mt-2 sm:hidden">
                                        <span class="text-[9px] font-bold px-2 py-1 rounded-lg bg-orange-50 text-[#FA8145] uppercase tracking-wider border border-[#FA8145]/30 inline-block">
                                            {{ $pm->status_produk_master }}
                                        </span>
                                    </div>
                                </td>
                                <td class="p-3 sm:p-4 whitespace-nowrap hidden sm:table-cell align-middle">
                                    <span class="text-[9px] sm:text-[10px] font-bold px-2 py-1 rounded-lg bg-orange-50 text-[#FA8145] uppercase tracking-wider border border-[#FA8145]/30">
                                        {{ $pm->status_produk_master }}
                                    </span>
                                </td>
                                <td class="p-3 sm:p-4 flex flex-col sm:flex-row justify-center items-stretch sm:items-center gap-2 align-top sm:align-middle">
                                    @if(strtolower($pm->status_produk_master) == 'menunggu')
                                        <button onclick="openConfirmMasterModal('{{ route('umkm.konfirmasiProdukMaster', $pm->id_produk_master) }}', '{{ $pm->nama_produk_master }}')" class="w-full sm:w-auto px-5 py-2.5 text-xs sm:text-sm font-bold uppercase tracking-wider rounded-xl bg-white border border-[#E75C16] text-[#E75C16] hover:bg-orange-50 transition-all">Konfirmasi</button>
                                        <button onclick="openTolakMasterModal('{{ route('umkm.tolakProdukMaster', $pm->id_produk_master) }}', '{{ $pm->nama_produk_master }}')" class="w-full sm:w-auto px-4 py-2 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-xl bg-white border border-[#7F1911] text-[#7F1911] hover:bg-[#7F1911] hover:text-white transition-all">Tolak / Koreksi</button>
                                    @else
                                        <button onclick="openUbahMasterModal('{{ route('umkm.updateProdukMasterAdmin', $pm->id_produk_master) }}', '{{ $pm->nama_produk_master }}')" class="w-full sm:w-auto px-4 py-2 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-xl bg-white border border-[#C54716] text-[#C54716] hover:bg-orange-50 transition-all">Ubah</button>
                                        <button type="button" onclick="openHapusMasterModal('{{ route('umkm.destroyProdukMasterAdmin', $pm->id_produk_master) }}', '{{ addslashes($pm->nama_produk_master) }}')" class="w-full sm:w-auto px-4 py-2 text-[10px] sm:text-xs font-bold uppercase tracking-wider rounded-xl bg-[#7F1911] text-white hover:bg-[#5A120C] shadow-sm transition-all">Hapus</button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<div id="confirmModal" class="fixed inset-0 bg-black/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 id="confirmTitle" class="text-lg font-bold text-gray-900 mb-2">Konfirmasi</h3>
        <p id="confirmText" class="text-sm text-gray-500 mb-6">Apakah Anda yakin?</p>
        <form id="confirmForm" method="POST" class="flex gap-3 justify-center">
            @csrf
            @method('PUT')
            <button type="button" onclick="closeConfirmModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-[#7F1911] rounded-xl font-bold text-sm hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="flex-1 px-4 py-2.5 bg-[#C54716] text-white rounded-xl font-bold text-sm hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100">Lanjutkan</button>
        </form>
    </div>
</div>

<div id="confirmMasterModal" class="fixed inset-0 bg-black/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Master</h3>
        <p class="text-sm text-gray-500 mb-6">Anda akan mengaktifkan produk master <strong id="cm_product_name" class="text-[#FA8145]"></strong>. Produk ini akan tampil ke publik.</p>
        <form id="cm_form" method="POST" class="flex gap-3 justify-center">
            @csrf
            @method('PUT')
            <button type="button" onclick="closeConfirmMasterModal()" class="flex-1 px-4 py-2.5 bg-gray-100 text-[#7F1911] rounded-xl font-bold text-sm hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="flex-1 px-4 py-2.5 bg-[#C54716] text-white rounded-xl font-bold text-sm hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100">Aktifkan</button>
        </form>
    </div>
</div>

<div id="tolakMasterModal" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden relative">
        <div class="p-6 md:p-8 border-b border-gray-50 bg-gray-50/50">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-bold text-[#69200F] uppercase tracking-tight">Koreksi Produk Master</h3>
            </div>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
        </div>
        <form id="tm_form" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 md:p-8">
                <p class="text-sm text-gray-600 mb-5">
                    Anda menolak pengajuan nama <strong id="tm_old_name" class="text-[#A33215]"></strong>. Silakan masukkan nama koreksi yang tepat. Nama ini akan langsung diperbarui ke antrean.
                </p>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Nama Baru <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="tm_input_name" name="nama_produk_baru" class="w-full border-2 border-gray-100 p-3.5 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-800" required placeholder="Cth: Kopi Susu Aren">
                </div>
            </div>
            <div class="p-6 md:p-8 pt-0 flex justify-end gap-3">
                <button type="button" onclick="closeTolakMasterModal()" class="px-5 py-2.5 text-sm font-bold text-[#7F1911] bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors uppercase tracking-wider">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#E75C16] hover:bg-[#C54716] shadow-md shadow-orange-200 rounded-xl transition-all uppercase tracking-wider">Simpan & Koreksi</button>
            </div>
        </form>
    </div>
</div>

<div id="modalTambahUmkm" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col max-h-[90vh] relative overflow-hidden">
        <div class="p-6 md:p-8 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-[#69200F] uppercase tracking-tight">Tambah UMKM Baru</h3>
                <p class="text-xs text-gray-500 mt-1">UMKM ini akan langsung berstatus <strong class="text-[#E75C16]">Aktif</strong></p>
                <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                    <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
                </p>
            </div>
            <button type="button" onclick="closeModalTambahUmkm()" class="text-gray-400 hover:text-[#A33215] transition-colors p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('umkm.storeAdmin') }}" method="POST" enctype="multipart/form-data" class="flex flex-col overflow-hidden">
            @csrf
            <div class="p-6 md:p-8 overflow-y-auto space-y-4 text-sm font-medium">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Nama UMKM <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="nama_umkm" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-gray-800" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Alamat <span class="text-[#A33215]">*</span></label>
                    <textarea name="alamat_umkm" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all text-gray-600" rows="2" required></textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Nomor Telepon <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="nomor_telepon" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all text-gray-800" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Tampil Publik?</label>
                        <select name="is_nomor_telepon_ditampilkan" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all text-gray-800">
                            <option value="1">Ya, tampilkan</option>
                            <option value="0">Sembunyikan</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Bidang UMKM <span class="text-[#A33215]">*</span></label>
                    <select name="bidang_umkm" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all text-gray-800 uppercase tracking-wider text-xs font-bold" required>
                        <option value="">-- Pilih Bidang --</option>
                        <option value="kuliner">Kuliner</option>
                        <option value="fashion">Fashion</option>
                        <option value="agribisnis">Agribisnis</option>
                        <option value="jasa & produk kreatif">Jasa & Produk Kreatif</option>
                        <option value="teknologi dan digital">Teknologi dan Digital</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all text-gray-600" rows="2"></textarea>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Foto (Opsional)</label>
                    <input type="file" name="foto_umkm" class="w-full border-2 border-gray-100 p-3 rounded-2xl text-xs text-gray-600">
                </div>
            </div>
            <div class="p-6 border-t border-gray-50 bg-gray-50/50 flex justify-end gap-3 shrink-0">
                <button type="button" onclick="closeModalTambahUmkm()" class="px-5 py-2.5 text-sm font-bold text-[#7F1911] bg-white border border-gray-200 hover:bg-gray-50 rounded-xl transition-colors uppercase tracking-wider">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#C54716] hover:bg-[#A33215] shadow-md shadow-orange-200 rounded-xl transition-all uppercase tracking-wider">Simpan & Aktifkan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalTambahProdukMaster" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden relative">
        <div class="p-6 md:p-8 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-[#69200F] uppercase tracking-tight">Tambah Master</h3>
                <p class="text-xs text-gray-500 mt-1">Produk langsung <strong class="text-[#E75C16]">Aktif</strong></p>
                <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                    <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
                </p>
            </div>
            <button type="button" onclick="closeModalTambahProdukMaster()" class="text-gray-400 hover:text-[#A33215] transition-colors p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('umkm.storeProdukMasterAdmin') }}" method="POST">
            @csrf
            <div class="p-6 md:p-8">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Nama Produk Master <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="nama_produk_master" class="w-full border-2 border-gray-100 p-3.5 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-800" required placeholder="Cth: Nasi Goreng">
                </div>
            </div>
            <div class="p-6 pt-0 flex justify-end gap-3">
                <button type="button" onclick="closeModalTambahProdukMaster()" class="px-5 py-2.5 text-sm font-bold text-[#7F1911] bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors uppercase tracking-wider">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#E75C16] hover:bg-[#C54716] shadow-md shadow-orange-200 rounded-xl transition-all uppercase tracking-wider">Tambahkan</button>
            </div>
        </form>
    </div>
</div>

<div id="ubahMasterModal" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden relative">
        <div class="p-6 md:p-8 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
            <div>
                <h3 class="text-lg font-bold text-[#69200F] uppercase tracking-tight">Ubah Master</h3>
                <p class="text-xs text-gray-500 mt-1">Ubah nama produk master yang sudah aktif</p>
                <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                    <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
                </p>
            </div>
            <button type="button" onclick="closeUbahMasterModal()" class="text-gray-400 hover:text-[#A33215] transition-colors p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form id="ubah_master_form" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 md:p-8">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2 block">Nama Produk Master <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="ubah_master_input" name="nama_produk_master" class="w-full border-2 border-gray-100 p-3.5 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-800" required placeholder="Cth: Nasi Goreng">
                </div>
            </div>
            <div class="p-6 pt-0 flex justify-end gap-3">
                <button type="button" onclick="closeUbahMasterModal()" class="px-5 py-2.5 text-sm font-bold text-[#7F1911] bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors uppercase tracking-wider">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-[#E75C16] hover:bg-[#C54716] shadow-md shadow-orange-200 rounded-xl transition-all uppercase tracking-wider">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="hapusMasterModal" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145] relative">
        <button onclick="closeHapusMasterModal()" class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-black rounded-full hover:bg-gray-100">✕</button>
        <h3 class="text-xl font-bold text-[#69200F] uppercase tracking-tight mb-3 mt-4">Hapus Produk Master?</h3>
        <p class="text-sm text-gray-500 mb-8 font-medium">Apakah Anda yakin ingin menghapus produk master <strong id="hm_product_name" class="text-[#A33215]"></strong> secara permanen?</p>
        <form id="hm_form" method="POST" class="flex gap-3 justify-center">
            @csrf @method('DELETE')
            <button type="button" onclick="closeHapusMasterModal()" class="flex-1 px-4 py-3 bg-gray-100 text-[#7F1911] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="flex-1 px-4 py-3 bg-[#7F1911] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#5A120C] transition-all shadow-lg shadow-orange-100">Ya, Hapus</button>
        </form>
    </div>
</div>

@else
<div class="bg-white p-6 rounded-2xl shadow border border-orange-200 text-center mt-6">
    <div class="text-4xl mb-4">⚠️</div>
    <h2 class="text-xl font-bold text-[#A33215]">Akses Ditolak</h2>
    <p class="text-gray-600 mt-2">Anda tidak memiliki hak akses untuk mengakses halaman ini.</p>
</div>
@endif
@endsection

@push('scripts')
<script>

// alert auto hide
setTimeout(() => {
    const alert = document.getElementById('alertSuccess');
    if (alert) {
        alert.style.transition = 'all 0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);

// modal confirm UMKM
function openConfirmModal(title, text, actionUrl) {
    document.getElementById('confirmTitle').innerText = title;
    document.getElementById('confirmText').innerHTML = text;

    document.getElementById('confirmForm').action = actionUrl;

    const modal = document.getElementById('confirmModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Modal Konfirmasi Produk Master
function openConfirmMasterModal(actionUrl, productName) {
    document.getElementById('cm_form').action = actionUrl;
    document.getElementById('cm_product_name').innerText = productName;
    const modal = document.getElementById('confirmMasterModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeConfirmMasterModal() {
    const modal = document.getElementById('confirmMasterModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Modal Tolak/Koreksi Produk Master
function openTolakMasterModal(actionUrl, productName) {
    document.getElementById('tm_form').action = actionUrl;
    document.getElementById('tm_old_name').innerText = productName;
    document.getElementById('tm_input_name').value = productName; // Prepoulate just in case it's a minor typo
    const modal = document.getElementById('tolakMasterModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeTolakMasterModal() {
    const modal = document.getElementById('tolakMasterModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Modal Tambah UMKM
function openModalTambahUmkm() {
    const modal = document.getElementById('modalTambahUmkm');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModalTambahUmkm() {
    const modal = document.getElementById('modalTambahUmkm');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Modal Tambah Produk Master
function openModalTambahProdukMaster() {
    const modal = document.getElementById('modalTambahProdukMaster');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModalTambahProdukMaster() {
    const modal = document.getElementById('modalTambahProdukMaster');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Modal Ubah Produk Master
function openUbahMasterModal(actionUrl, productName) {
    document.getElementById('ubah_master_form').action = actionUrl;
    document.getElementById('ubah_master_input').value = productName;
    const modal = document.getElementById('ubahMasterModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeUbahMasterModal() {
    const modal = document.getElementById('ubahMasterModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Modal Hapus Produk Master
function openHapusMasterModal(actionUrl, productName) {
    document.getElementById('hm_form').action = actionUrl;
    document.getElementById('hm_product_name').innerText = productName;
    const modal = document.getElementById('hapusMasterModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeHapusMasterModal() {
    const modal = document.getElementById('hapusMasterModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Tab Switching Logic
function switchMainTab(tabName) {
    // Hide all
    document.getElementById('tabContent-umkm').classList.add('hidden');
    document.getElementById('tabContent-produk').classList.add('hidden');
    
    // Reset buttons
    const inactiveClass = "tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all text-gray-500 hover:text-gray-700";
    const activeClass = "tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all bg-white text-[#C54716] shadow-sm";

    document.getElementById('tabBtn-umkm').className = inactiveClass;
    document.getElementById('tabBtn-produk').className = inactiveClass;
    
    // Show active
    const content = document.getElementById('tabContent-' + tabName);
    content.classList.remove('hidden');
    content.classList.add('animate-fade-in');
    
    document.getElementById('tabBtn-' + tabName).className = activeClass;
}

document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('tab') === 'produk' || urlParams.get('status_produk') !== null || urlParams.has('search_produk')) {
        switchMainTab('produk');
    } else if (urlParams.get('tab') === 'umkm' || urlParams.has('search_umkm')) {
        switchMainTab('umkm');
    }
});


</script>
<style>
    @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fade-in-down { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
    .animate-fade-in-down { animation: fade-in-down 0.5s ease-out forwards; }
    /* Hide scrollbar for tabs */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endpush
