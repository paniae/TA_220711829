@extends('layouts.app')

@section('title', 'Katalog UMKM & Produk')

@section('content')
<div class="relative overflow-hidden bg-white rounded-3xl p-5 md:p-8 shadow-sm border border-[#FA8145] mb-5">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-[#C54716] text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FA8145] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FA8145]"></span>
                </span>
                Katalog Warga
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#A33215] leading-tight uppercase tracking-tight">
                UMKM Padukuhan Bruno II
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium max-w-md">
                Jelajahi usaha warga Padukuhan Bruno II beserta produk-produk terbaik yang ditawarkan.
            </p>
        </div>

        <div class="bg-gray-100/80 p-1.5 rounded-2xl flex gap-1 border border-gray-200 shadow-inner w-full md:w-auto overflow-x-auto no-scrollbar">
            <button onclick="switchMainTab('warga')" id="tabBtn-warga" 
                class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all bg-white text-[#C54716] shadow-sm">
                Daftar UMKM
            </button>
            <button onclick="switchMainTab('produk')" id="tabBtn-produk" 
                class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all text-gray-500 hover:text-gray-700">
                Katalog Produk
            </button>
        </div>
    </div>
</div>

<div id="tabContent-warga">
    <div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden mb-8">
        <div class="p-5 md:p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
                <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Katalog UMKM</h2>
            </div>
            
            <form action="{{ url()->current() }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto">
                <input type="hidden" name="tab" value="warga">
                
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
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @if($umkmWarga->isEmpty())
                    <div class="col-span-full bg-white rounded-3xl p-16 md:p-20 text-center border-2 border-dashed border-gray-100">
                        <p class="text-gray-300 font-bold uppercase tracking-wider text-sm">Belum Ada UMKM Terdaftar</p>
                    </div>
                @endif
                @foreach($umkmWarga as $item)
                <div class="bg-orange-50/20 border border-orange-200/60 rounded-2xl p-4 shadow-sm hover:shadow-md hover:border-[#FA8145] hover:bg-orange-50/40 transition-all cursor-pointer group flex flex-col h-full relative overflow-hidden"
                    onclick="window.location='{{ route('warga.produkUMKM', $item->id_umkm) }}'">
                    
                    @php
                        $fotoPath = $item->foto_umkm;
                        if (empty($fotoPath)) {
                            $defaultImages = [
                                'kuliner' => 'images/kuliner.jpg',
                                'fashion' => 'images/fashion.jpg',
                                'agribisnis' => 'images/agribisnis.jpg',
                                'jasa & produk kreatif' => 'images/jasa.jpg',
                                'teknologi dan digital' => 'images/teknologi.jpg',
                            ];
                            $fotoPath = $defaultImages[strtolower($item->bidang_umkm)] ?? 'images/default.jpg';
                        }
                    @endphp
                    <div class="relative w-full h-32 mb-4 rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                        <img src="{{ str_contains($fotoPath, 'images/') ? asset($fotoPath) : asset('storage/'.$fotoPath) }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <div class="flex-grow">
                        <p class="text-sm font-bold text-gray-800 uppercase tracking-tight line-clamp-1 mb-1">
                            {{ $item->nama_umkm }}
                        </p>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-1.5 h-3 bg-[#E75C16] rounded-full"></div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest">
                                {{ $item->bidang_umkm }}
                            </p>
                        </div>
                        <div class="flex items-start gap-2 mt-1">
                            <span class="text-[10px] bg-orange-100/50 text-[#C54716] px-1.5 py-0.5 rounded uppercase tracking-wider shrink-0 mt-0.5">Alamat</span>
                            <p class="text-[11px] font-medium text-gray-500 line-clamp-2 leading-relaxed">
                                {{ $item->alamat_umkm }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-orange-100/50 flex justify-end">
                        <span class="text-[10px] font-bold text-[#C54716] uppercase tracking-wider group-hover:underline">Kunjungi UMKM →</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div id="tabContent-produk" class="hidden">
    <div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] p-5 md:p-8 mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8 border-b border-gray-50 pb-5">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
                <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Katalog Produk Warga</h2>
            </div>

            <form action="{{ url()->current() }}" method="GET" class="relative w-full sm:w-64">
                <input type="hidden" name="tab" value="produk">
                @if(request('kategori'))
                    <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." 
                    class="w-full pl-10 pr-4 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all" autocomplete="off">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>
        </div>

        @if($semuaProduk->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100 shadow-sm">
                <p class="text-gray-500 font-medium text-sm uppercase tracking-wider">Belum ada produk yang ditawarkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @foreach($semuaProduk as $item)
                <div onclick="openProdukModal('{{ addslashes($item->nama_produk) }}', '{{ $item->foto_produk_umkm ? asset('storage/'.$item->foto_produk_umkm) : '' }}', '{{ number_format($item->harga, 0, ',', '.') }}', '{{ addslashes($item->deskripsi) }}', '{{ $item->status_produk }}', '{{ addslashes($item->umkm->nama_umkm ?? '-') }}', '{{ strtolower($item->umkm->bidang_umkm ?? '') }}', '{{ route('warga.produkUMKM', $item->id_umkm) }}')" class="group cursor-pointer bg-white rounded-[2rem] border border-gray-200 hover:border-[#FA8145] shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1 flex flex-col h-full active:scale-95">
                    
                    @php
                        $defaultImage = match(strtolower($item->umkm->bidang_umkm ?? '')) {
                            'kuliner' => 'images/kuliner.jpg',
                            'fashion' => 'images/fashion.jpg',
                            'agribisnis' => 'images/agribisnis.jpg',
                            'jasa & produk kreatif' => 'images/jasa.jpg',
                            'teknologi dan digital' => 'images/teknologi.jpg',
                            default => 'images/default.jpg',
                        };
                    @endphp

                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        <img src="{{ $item->foto_produk_umkm ? asset('storage/'.$item->foto_produk_umkm) : asset($defaultImage) }}" 
                            onerror="this.src='{{ asset($defaultImage) }}'"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                            <span class="text-[8px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm w-fit
                                {{ $item->status_produk == 'tersedia' ? 'bg-orange-50 text-[#C54716] border border-orange-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                                {{ $item->status_produk == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                            @if($item->produkMaster && $item->produkMaster->status_produk_master == 'menunggu')
                            <span class="text-[8px] font-bold px-2 py-1 rounded-full uppercase tracking-wider shadow-sm w-fit bg-[#FA8145] text-white border border-[#E75C16]">
                                Menunggu Validasi
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-xs font-bold text-[#69200F] uppercase tracking-wider mb-1 line-clamp-1">
                            {{ $item->nama_produk }}
                        </h3>
                        <p class="text-sm font-black text-[#C54716] mb-2">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </p>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest line-clamp-1 mb-2">
                            UMKM: {{ $item->umkm->nama_umkm ?? '-' }}
                        </p>
                        <div class="mt-auto pt-3 border-t border-orange-50 flex justify-end">
                            <a href="{{ route('warga.produkUMKM', $item->id_umkm) }}" onclick="event.stopPropagation()" class="text-[10px] font-bold text-[#C54716] uppercase tracking-wider hover:underline">Lihat UMKM →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div id="modalDetailProduk" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-6 border-b flex justify-between items-center bg-gray-50/50">
            <h2 class="text-lg font-semibold text-[#69200F] uppercase tracking-tight">Detail Produk</h2>
            <button type="button" onclick="closeProdukModal()" class="text-gray-400 hover:text-[#A33215] transition-colors p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <div class="p-6 overflow-y-auto">
            <div class="flex flex-col items-center mb-6">
                <div class="w-48 h-48 rounded-2xl overflow-hidden border border-orange-100 shadow-sm mb-4">
                    <img id="detailFoto" src="" class="w-full h-full object-cover">
                </div>
                <h3 id="detailNama" class="text-xl font-bold text-[#69200F] uppercase tracking-wider text-center"></h3>
                <p id="detailUMKM" class="text-xs font-semibold text-gray-500 uppercase tracking-widest mt-1"></p>
                <div class="mt-3">
                    <span id="detailStatus" class="text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm"></span>
                </div>
            </div>

            <div class="space-y-4">
                <div class="bg-orange-50/30 p-4 rounded-xl border border-orange-100/50">
                    <p class="text-[10px] font-bold text-[#C54716] uppercase tracking-widest mb-1">Harga</p>
                    <p id="detailHarga" class="text-lg font-black text-[#A33215]"></p>
                </div>
                <div class="bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Deskripsi</p>
                    <p id="detailDeskripsi" class="text-sm text-gray-600 leading-relaxed"></p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-gray-100 flex justify-end">
                <a id="detailLinkToko" href="#" class="bg-[#C54716] text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg hover:bg-[#A33215] transition-all active:scale-95">
                    Kunjungi UMKM →
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    window.switchMainTab = function(tabName) {
        document.getElementById('tabContent-warga').classList.add('hidden');
        document.getElementById('tabContent-produk').classList.add('hidden');
        
        const inactiveClass = "tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all text-gray-500 hover:text-gray-700";
        const activeClass = "tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all bg-white text-[#C54716] shadow-sm";
        
        document.getElementById('tabBtn-warga').className = inactiveClass;
        document.getElementById('tabBtn-produk').className = inactiveClass;
        
        const content = document.getElementById('tabContent-' + tabName);
        content.classList.remove('hidden');
        content.classList.add('animate-fade-in');
        
        document.getElementById('tabBtn-' + tabName).className = activeClass;
    }

    // Auto-switch ke tab produk jika ada pencarian atau parameter tab=produk
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('tab') === 'produk' || (!urlParams.has('tab') && urlParams.has('search'))) {
            switchMainTab('produk');
        } else if (urlParams.get('tab') === 'warga' || (!urlParams.has('tab') && urlParams.has('search_umkm'))) {
            switchMainTab('warga');
        }
    });

    function openProdukModal(nama, fotoUrl, harga, deskripsi, status, toko, bidang, linkToko) {
        document.getElementById('detailNama').innerText = nama;
        document.getElementById('detailHarga').innerText = 'Rp ' + harga;
        document.getElementById('detailUMKM').innerText = 'UMKM: ' + toko;
        document.getElementById('detailDeskripsi').innerText = deskripsi ? deskripsi : 'Tidak ada deskripsi.';
        document.getElementById('detailLinkToko').href = linkToko;
        
        const statusEl = document.getElementById('detailStatus');
        if (status === 'tersedia') {
            statusEl.innerText = 'Tersedia';
            statusEl.className = 'text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm bg-orange-50 text-[#C54716] border border-orange-200';
        } else {
            statusEl.innerText = 'Tidak Tersedia';
            statusEl.className = 'text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm bg-gray-100 text-gray-500 border border-gray-200';
        }

        const fotoEl = document.getElementById('detailFoto');
        if (fotoUrl) {
            fotoEl.src = fotoUrl;
        } else {
            const defaultImages = {
                'kuliner': 'images/kuliner.jpg',
                'fashion': 'images/fashion.jpg',
                'agribisnis': 'images/agribisnis.jpg',
                'jasa & produk kreatif': 'images/jasa.jpg',
                'teknologi dan digital': 'images/teknologi.jpg'
            };
            fotoEl.src = '{{ asset("") }}' + (defaultImages[bidang] || 'images/default.jpg');
        }

        document.getElementById('modalDetailProduk').classList.remove('hidden');
    }

    function closeProdukModal() {
        document.getElementById('modalDetailProduk').classList.add('hidden');
    }
</script>
@endpush
