@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<div class="relative overflow-hidden bg-white/90 backdrop-blur rounded-2xl p-6 shadow border border-[#FA8145] mb-6 w-full">
    <div class="relative z-10 w-full max-w-full">
        <h1 class="text-lg md:text-4xl font-black text-[#A33215] mb-3 uppercase tracking-tighter leading-tight break-words">
            Halo, {{ auth()->user()->nama }}!
        </h1>
        <p class="text-sm md:text-lg text-gray-500 font-medium leading-relaxed max-w-full">
            Pusat informasi digital untuk akses kegiatan, layanan publik, dan pemberdayaan ekonomi warga Padukuhan {{ $profil->nama_padukuhan ?? 'Bruno II' }}.
        </p>
    </div>
</div>

<div class="mb-10 relative group w-full overflow-hidden">
    <div id="profilCarousel" class="relative overflow-hidden rounded-3xl shadow-sm border border-[#FA8145] bg-white w-full">
        
        <div id="carouselInner" class="flex transition-transform duration-700 ease-in-out">
            
            <div class="w-full flex-shrink-0 p-5 md:p-12 flex flex-col md:flex-row gap-6 md:gap-12 items-center">
                <div class="w-full md:w-1/2 h-44 md:h-80 overflow-hidden rounded-2xl md:rounded-3xl shadow-lg flex-shrink-0">
                    @if($profil && $profil->foto_kebersamaan)
                        <img src="{{ $profil->foto_kebersamaan }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-orange-50 flex items-center justify-center text-orange-200 text-xs font-bold uppercase tracking-widest">Tidak Ada Foto</div>
                    @endif
                </div>
                <div class="w-full md:w-1/2 space-y-3 md:space-y-4 text-center md:text-left pb-6 md:pb-0">
                    <span class="text-xs font-black text-[#FA8145] uppercase tracking-[0.4em]">Warisan Budaya</span>
                    <h2 class="text-base md:text-3xl font-black text-[#A33215] uppercase tracking-tighter">Sejarah Padukuhan</h2>
                    <div class="max-h-40 md:max-h-64 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-orange-200">
                        <p class="text-xs md:text-base text-gray-500 leading-relaxed italic">
                            {{ $profil->sejarah ?? 'Padukuhan kami memiliki sejarah panjang dalam membangun kebersamaan dan kemandirian warga. Terletak di jantung Kalurahan ' . ($profil->nama_kalurahan ?? 'Ngestirejo') . ', kami berkomitmen untuk terus menjaga nilai-nilai luhur leluhur dalam kehidupan modern.' }}
                        </p>
                    </div>
                </div>
            </div>


            <div class="w-full flex-shrink-0 bg-[#A33215] p-5 md:p-12 flex items-center justify-center text-center text-white min-h-[250px] md:min-h-[400px]">
                <div class="max-w-2xl space-y-5 md:space-y-8">
                    <div class="space-y-2 md:space-y-4">
                        <span class="text-xs font-black text-[#FA8145] uppercase tracking-[0.4em]">Arah Masa Depan</span>
                        <h2 class="text-xl md:text-4xl font-black uppercase tracking-tighter">Visi & Misi</h2>
                    </div>
                    <div class="space-y-4 md:space-y-6">
                        <div>
                            <p class="text-[8px] md:text-[10px] font-black text-white/40 uppercase tracking-widest mb-1 md:mb-2">Visi Kami</p>
                            <p class="text-sm md:text-2xl font-bold italic text-orange-50 px-2">
                                "{{ $profil->visi ?? 'Mewujudkan padukuhan yang mandiri, sejahtera, dan religius.' }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full flex-shrink-0 bg-orange-50 p-5 md:p-12 flex flex-col md:flex-row gap-6 md:gap-12 items-center">
                <div class="w-full md:w-1/2 space-y-4 md:space-y-6 text-center md:text-left">
                    <span class="text-[8px] md:text-[10px] font-black text-[#FA8145] uppercase tracking-[0.4em]">Pelayanan Publik</span>
                    <h2 class="text-base md:text-3xl font-black text-[#69200F] uppercase tracking-tighter">Informasi Balai</h2>
                    <div class="space-y-3 md:space-y-4 inline-block text-left">
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">Pelayanan</p>
                                <p class="text-sm md:text-xl font-bold text-[#A33215] leading-none">{{ $profil->jam_operasional ?? 'Senin - Jumat | 08:00 - 16:00' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat</p>
                                <p class="text-xs md:text-base font-bold text-gray-600 line-clamp-1 max-w-[150px] md:max-w-none">{{ $profil->alamat_balai ?? 'Kalurahan Ngestirejo, Gunungkidul' }}</p>
                            </div>
                        </div>
                        @if($profil && $profil->link_maps_balai)
                            <div class="pt-2">
                                <a href="{{ $profil->link_maps_balai }}" target="_blank" class="inline-flex items-center gap-2 bg-[#C54716] text-white px-4 py-2 rounded-xl text-[10px] font-bold hover:bg-[#A33215] transition-all uppercase tracking-widest shadow-sm">
                                    Buka di Google Maps
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="w-full md:w-1/2 h-44 md:h-80 bg-white rounded-2xl md:rounded-3xl overflow-hidden shadow-lg border-4 md:border-8 border-white flex-shrink-0">
                    @if($profil && $profil->foto_balai)
                        <img src="{{ $profil->foto_balai }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-orange-100 flex items-center justify-center text-[#FA8145] text-xs font-bold uppercase tracking-widest">Tidak Ada Foto</div>
                    @endif
                </div>
            </div>

        </div>
        
        <button onclick="prevSlide()" class="absolute left-2 md:left-6 top-1/2 -translate-y-1/2 w-8 h-8 md:w-14 md:h-14 bg-white/90 hover:bg-white text-[#A33215] rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 border border-orange-100/50">
            <span class="text-lg md:text-2xl font-bold">❮</span>
        </button>
        <button onclick="nextSlide()" class="absolute right-2 md:right-6 top-1/2 -translate-y-1/2 w-8 h-8 md:w-14 md:h-14 bg-white/90 hover:bg-white text-[#A33215] rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all z-20 border border-orange-100/50">
            <span class="text-lg md:text-2xl font-bold">❯</span>
        </button>

        <div class="absolute bottom-3 md:bottom-6 left-1/2 -translate-x-1/2 flex gap-1.5 md:gap-2">
            <button onclick="goToSlide(0)" class="carousel-dot w-5 h-1 md:w-8 md:h-1.5 rounded-full bg-black/10 transition-all"></button>
            <button onclick="goToSlide(1)" class="carousel-dot w-5 h-1 md:w-8 md:h-1.5 rounded-full bg-black/10 transition-all"></button>
            <button onclick="goToSlide(2)" class="carousel-dot w-5 h-1 md:w-8 md:h-1.5 rounded-full bg-black/10 transition-all"></button>
        </div>
    </div>
</div>

@if(isset($produkUnggulan) && $produkUnggulan->count() > 0)
<div class="bg-white p-6 rounded-3xl shadow-sm border border-[#FA8145] mb-10 w-full flex flex-col">
    <div class="flex justify-between items-end mb-4 md:mb-6">
        <div>
            <h2 class="text-[10px] md:text-xs font-black text-[#FA8145] uppercase tracking-widest mb-1">Katalog Warga</h2>
            <h3 class="text-lg md:text-2xl font-black text-[#69200F] uppercase tracking-tighter">Produk Terbaru</h3>
        </div>
        <a href="{{ route('guest.umkm', ['tab' => 'produk']) }}" class="text-[10px] md:text-xs font-black text-[#C54716] uppercase tracking-widest hover:underline text-right shrink-0 ml-2 md:ml-4">Lihat Semua Produk</a>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-5">
        @foreach($produkUnggulan as $p)
            @php
                $defaultImage = match(strtolower($p->umkm->bidang_umkm ?? '')) {
                    'kuliner' => 'images/kuliner.jpg',
                    'fashion' => 'images/fashion.jpg',
                    'agribisnis' => 'images/agribisnis.jpg',
                    'jasa & produk kreatif' => 'images/jasa.jpg',
                    'teknologi dan digital' => 'images/teknologi.jpg',
                    default => 'images/default.jpg',
                };
                $fotoPath = $p->foto_produk ?: $defaultImage;
            @endphp
            <div onclick="openProdukModal('{{ addslashes($p->nama_produk) }}', '{{ $p->foto_produk ? asset('storage/'.$p->foto_produk) : '' }}', '{{ number_format($p->harga, 0, ',', '.') }}', '{{ addslashes($p->deskripsi ?? '') }}', '{{ $p->status_produk }}', '{{ addslashes($p->umkm->nama_umkm ?? '-') }}', '{{ strtolower($p->umkm->bidang_umkm ?? '') }}', '{{ route('guest.umkm', ['search_umkm' => $p->umkm->nama_umkm ?? '']) }}')" class="group bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border-2 border-gray-100 flex flex-col h-full overflow-hidden cursor-pointer hover:-translate-y-1">
                <div class="p-4 flex-1 flex flex-col gap-3">
                    <div class="flex flex-col gap-1.5 items-start">
                        <span class="px-2 py-1 rounded-md text-[8px] font-bold uppercase tracking-wider border bg-orange-50 text-[#C54716] border-orange-100 truncate max-w-full">
                            {{ $p->umkm->nama_umkm ?? 'UMKM' }}
                        </span>
                        @if($p->produkMaster && $p->produkMaster->status_produk_master == 'menunggu')
                        <span class="px-2 py-1 rounded-md text-[8px] font-bold uppercase tracking-wider border bg-[#FA8145] text-white border-[#E75C16] truncate max-w-full shadow-sm">
                            Menunggu Validasi
                        </span>
                        @endif
                    </div>

                    <div class="w-full aspect-square md:h-32 md:aspect-auto rounded-xl overflow-hidden border border-gray-100 shadow-sm relative">
                        <img src="{{ str_contains($fotoPath, 'images/') ? asset($fotoPath) : asset('storage/'.$fotoPath) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <h4 class="text-xs md:text-sm font-bold text-gray-900 group-hover:text-[#C54716] transition-colors leading-snug line-clamp-2">
                        {{ $p->nama_produk }}
                    </h4>
                    
                    <p class="text-[10px] md:text-xs font-black text-[#C54716] mt-auto">
                        Rp {{ number_format($p->harga, 0, ',', '.') }}
                    </p>
                </div>
                <div class="px-4 py-2.5 bg-gray-50 border-t text-center">
                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block">Lihat Detail</span>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif



<div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8 w-full mb-10">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-[#FA8145] flex flex-col">
        <div class="flex justify-between items-center mb-6 md:mb-8">
            <h2 class="text-xs md:text-sm font-black text-[#A33215] uppercase tracking-[0.3em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-[#C54716] animate-pulse"></span> Kegiatan Warga
            </h2>
            <a href="{{ url('/kegiatan/lihat?tab=kegiatan') }}" class="text-[10px] md:text-xs font-black text-[#FA8145] uppercase tracking-widest hover:underline text-right shrink-0 ml-2 md:ml-4">Semua Kegiatan</a>
        </div>
        <div class="space-y-3 flex-1">
            @if(isset($kegiatan) && $kegiatan->count() > 0)
                @foreach($kegiatan as $k)
                @php
                    $tgl = \Carbon\Carbon::parse($k->tgl_waktu_pelaksanaan);
                @endphp
                <div onclick="window.location='{{ route('kegiatan.show', $k->id_kegiatan) }}'" class="bg-gray-50 p-4 rounded-2xl border border-gray-200 flex items-center gap-3 hover:bg-orange-50 hover:border-[#FA8145] hover:shadow-md transition-all cursor-pointer group">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-xl md:rounded-2xl flex flex-col items-center justify-center shadow-sm group-hover:bg-[#A33215] group-hover:text-white transition-all flex-shrink-0">
                        <span class="text-[8px] md:text-[10px] font-black uppercase leading-none">{{ $tgl->translatedFormat('M') }}</span>
                        <span class="text-sm md:text-base font-bold leading-none mt-1">{{ $tgl->format('d') }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs md:text-sm font-bold text-gray-800 truncate">{{ $k->nama_kegiatan }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest truncate">{{ $tgl->format('H:i') }} • {{ $k->lokasi ?? '-' }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="h-full flex flex-col items-center justify-center text-center p-6 border-2 border-dashed border-orange-100 rounded-2xl">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tidak ada agenda terdekat</p>
                </div>
            @endif
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow-sm border border-[#FA8145] flex flex-col">
        <div class="flex justify-between items-center mb-6 md:mb-8">
            <h2 class="text-xs md:text-sm font-black text-[#A33215] uppercase tracking-[0.3em] flex items-center gap-2">
                <span class="w-1.5 h-1.5 md:w-2 md:h-2 rounded-full bg-[#E75C16] animate-pulse"></span> Program Kerja
            </h2>
            <a href="{{ url('/kegiatan/lihat?tab=proker') }}" class="text-[10px] md:text-xs font-black text-[#FA8145] uppercase tracking-widest hover:underline text-right shrink-0 ml-2 md:ml-4">Semua Program Kerja</a>
        </div>
        <div class="space-y-3 flex-1">
            @if(isset($proker) && $proker->count() > 0)
                @foreach($proker as $p)
                @php
                    $tgl = \Carbon\Carbon::parse($p->tgl_waktu_pelaksanaan);
                @endphp
                <div onclick="window.location='{{ route('kegiatan.show', $p->id_kegiatan) }}'" class="bg-gray-50 p-4 rounded-2xl border border-gray-200 flex items-center gap-3 hover:bg-orange-50 hover:border-[#FA8145] hover:shadow-md transition-all cursor-pointer group">
                    <div class="w-10 h-10 md:w-12 md:h-12 bg-white rounded-xl md:rounded-2xl flex flex-col items-center justify-center shadow-sm group-hover:bg-[#E75C16] group-hover:text-white transition-all flex-shrink-0">
                        <span class="text-[8px] md:text-[10px] font-black uppercase leading-none">{{ $tgl->translatedFormat('M') }}</span>
                        <span class="text-sm md:text-base font-bold leading-none mt-1">{{ $tgl->format('d') }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs md:text-sm font-bold text-gray-800 truncate">{{ $p->nama_kegiatan }}</p>
                        <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest truncate">{{ $tgl->format('H:i') }} • {{ $p->lokasi ?? '-' }}</p>
                    </div>
                </div>
                @endforeach
            @else
                <div class="h-full flex flex-col items-center justify-center text-center p-6 border-2 border-dashed border-orange-100 rounded-2xl">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tidak ada proker terdekat</p>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-3xl shadow-sm border border-[#FA8145] w-full mb-10 flex flex-col">
    <div class="flex justify-between items-center mb-6 md:mb-8">
        <div>
            <h2 class="text-[10px] md:text-xs font-black text-[#FA8145] uppercase tracking-widest mb-1">Forum Warga</h2>
            <h3 class="text-lg md:text-2xl font-black text-[#69200F] uppercase tracking-tighter">Laporan Kehilangan</h3>
        </div>
        <a href="{{ url('/kehilangan') }}" class="text-[10px] md:text-xs font-black text-[#C54716] uppercase tracking-widest hover:underline text-right shrink-0 ml-2 md:ml-4">Semua Laporan Kehilangan</a>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-3 md:gap-5">
        @if(isset($kehilangan) && $kehilangan->count() > 0)
            @foreach($kehilangan as $hilang)
            <div onclick="window.location='{{ url('/kehilangan/'.$hilang->id_laporan) }}'" class="group bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border-2 border-gray-100 flex flex-col h-full overflow-hidden cursor-pointer hover:-translate-y-1">
                <div class="p-4 flex-1 flex flex-col gap-3">
                    <div class="flex justify-between items-start">
                        <span class="px-2 py-1 rounded-md text-[8px] font-bold uppercase tracking-wider border {{ strtolower($hilang->status_kehilangan) == 'hilang' ? 'bg-orange-50 text-[#A33215] border-orange-200' : 'bg-orange-50 text-[#C54716] border-orange-100' }}">
                            {{ strtolower($hilang->status_kehilangan) == 'hilang' ? 'Hilang' : 'Ditemukan' }}
                        </span>
                        <span class="text-[9px] font-bold text-gray-400 uppercase">
                            {{ \Carbon\Carbon::parse($hilang->tanggal_hilang)->translatedFormat('d M Y') }}
                        </span>
                    </div>

                    @php
                        $fotoHilang = $hilang->foto_barang ?: 'images/default.jpg';
                    @endphp
                    <div class="w-full aspect-square md:h-32 md:aspect-auto rounded-xl overflow-hidden border border-gray-100 shadow-sm relative">
                        <img src="{{ str_contains($fotoHilang, 'images/') ? asset($fotoHilang) : asset('storage/'.$fotoHilang) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <h4 class="text-xs md:text-sm font-bold text-gray-900 group-hover:text-[#C54716] transition-colors leading-snug line-clamp-2">
                        {{ $hilang->barang_hilang }}
                    </h4>
                    
                    <p class="text-[10px] font-medium text-gray-500 mt-auto truncate flex items-center gap-1">
                        Lokasi: {{ $hilang->lokasi_hilang }}
                    </p>
                </div>
                <div class="px-4 py-2.5 bg-gray-50 border-t text-center">
                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block">Lihat Detail</span>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-span-full py-10 flex flex-col items-center justify-center text-center p-6 border-2 border-dashed border-orange-100 rounded-2xl">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tidak ada laporan kehilangan terbaru</p>
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

@push('scripts')
<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('#carouselInner > div');
    const inner = document.getElementById('carouselInner');
    const dots = document.querySelectorAll('.carousel-dot');

    function updateCarousel() {
        inner.style.transform = `translateX(-${currentSlide * 100}%)`;
        dots.forEach((dot, index) => {
            if (index === currentSlide) {
                dot.className = 'carousel-dot w-8 md:w-12 h-1 md:h-1.5 rounded-full bg-[#A33215] transition-all';
            } else {
                dot.className = 'carousel-dot w-4 md:w-8 h-1 md:h-1.5 rounded-full bg-black/10 transition-all';
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        updateCarousel();
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        updateCarousel();
    }

    function goToSlide(index) {
        currentSlide = index;
        updateCarousel();
    }

    setInterval(nextSlide, 8000);
    updateCarousel();

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

@endsection


