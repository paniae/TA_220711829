@php
    $menuClass = "px-4 py-2.5 rounded-xl transition-all block text-orange-50/60 font-bold text-sm uppercase tracking-widest";
    $hoverClass = "hover:bg-[#A33215] hover:text-white";
    $activeClass = "bg-[#C54716] text-white font-black shadow-lg shadow-orange-900/40 border border-white/10";
@endphp

<aside id="sidebar"
    class="w-64 bg-[#69200F] border-r-2 border-[#A33215]
    h-screen p-4 fixed top-0 left-0 z-40
    transform -translate-x-full transition-transform duration-300 pt-24
    flex flex-col shadow-2xl">

    <div class="flex-1 overflow-y-auto scrollbar-thin pr-2">
        <nav class="flex flex-col gap-2">

            <a href="/"
               class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('/') ? $activeClass : '' }}">
                Beranda
            </a>

            <a href="{{ route('kegiatan.lihat') }}"
               class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('kegiatan*') ? $activeClass : '' }}">
                Kegiatan & Proker
            </a>

            <a href="{{ route('guest.umkm') }}"
               class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('umkm*') ? $activeClass : '' }}">
                UMKM & Produk
            </a>

            <a href="{{ route('kehilangan.index') }}"
               class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('kehilangan*') ? $activeClass : '' }}">
                Laporan Kehilangan
            </a>

        </nav>
    </div>

    <div class="mt-auto pt-4 border-t border-[#A33215]">
        <div class="bg-[#A33215]/50 p-4 rounded-2xl text-center border border-[#A33215]">
            <p class="text-xs mb-3 text-orange-200/60 font-bold uppercase tracking-wider">
                Akses Fitur Lengkap
            </p>
            <a href="{{ route('login') }}"
               class="block bg-[#C54716] text-white text-xs sm:text-sm font-bold py-2.5 rounded-xl hover:bg-[#E75C16] transition-all shadow-md shadow-orange-900/20 uppercase tracking-widest">
                Login
            </a>
        </div>
    </div>

</aside>
