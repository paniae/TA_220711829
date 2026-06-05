@php
    $user = auth()->user();

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

            <a href="{{ route('beranda') }}"
               class="{{ $menuClass }} {{ $hoverClass }} {{ request()->routeIs('beranda') ? $activeClass : '' }}">
                Beranda
            </a>

            @if($user->hasAkses('kelola_kegiatan'))

                <a href="{{ route('kegiatan.kelolaKegiatan') }}"
                    class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('kegiatan*') ? $activeClass : '' }}">
                        Kegiatan & Proker
                </a>

            @elseif($user->hasAkses('lihat_kegiatan'))

                <a href="{{ route('kegiatan.lihat') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('kegiatan*') ? $activeClass : '' }}">
                    Kegiatan & Proker
                </a>

            @endif

            @if($user->hasAkses('kelola_pengaduan'))
                <a href="{{ route('pengaduan.kelolaPengaduan') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->routeIs('pengaduan.kelolaPengaduan') ? $activeClass : '' }}">
                    Pengaduan
                </a>
            @endif

            @if($user->hasAkses('tambah_pengaduan'))
                <a href="{{ route('pengaduan.indexWarga') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->routeIs('pengaduan.indexWarga') ? $activeClass : '' }}">
                    Pengaduan 
                </a>
            @endif

            @if($user->hasAkses('kelola_laporan_kehilangan'))
                <a href="{{ url('/kehilangan') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('kehilangan*') ? $activeClass : '' }}">
                    Forum Kehilangan
                </a>
            @endif

            @if($user->hasAkses('kelola_pengguna'))
                <a href="{{ route('pengguna.kelola') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('pengguna/kelola*') ? $activeClass : '' }}">
                    Data Pengguna
                </a>
            @endif

            @if($user->hasAkses('kelola_penduduk'))
                <a href="{{ url('/penduduk') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('penduduk*') ? $activeClass : '' }}">
                    Data Penduduk
                </a>
            @endif

            @if($user->hasAkses('kelola_laporan_rekapitulasi'))
                <a href="{{ route('laporan.index') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->routeIs('laporan.index') ? $activeClass : '' }}">
                    Laporan Rekapitulasi
                </a>
            @endif

            @if($user->hasAkses('kelola_laporan_penduduk'))
                <a href="{{ route('laporan.penduduk') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->routeIs('laporan.penduduk') ? $activeClass : '' }}">
                    Laporan Penduduk
                </a>
            @endif

            @if($user->hasAkses('kelola_umkm'))
                <a href="{{ url('/umkm') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('umkm') ? $activeClass : '' }}">
                    UMKM Warga
                </a>
            @endif

            @if($user->hasAkses('konfirmasi_umkm'))
                <a href="{{ url('/umkm/konfirmasi') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('umkm/konfirmasi*') ? $activeClass : '' }}">
                    UMKM Warga
                </a>
            @endif

            @if($user->hasAkses('kelola_informasi_umum'))
                <a href="{{ route('informasiUmum') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('informasiUmum*') ? $activeClass : '' }}">
                    Informasi Umum Padukuhan
                </a>
            @endif

            @if($user->hasAkses('kelola_role'))
                <a href="{{ route('role.kelola') }}"
                   class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('role/kelola*') ? $activeClass : '' }}">
                    Role Akses
                </a>
            @endif

            <a href="{{ route('pengguna.profil.index') }}"
               class="{{ $menuClass }} {{ $hoverClass }} {{ request()->is('pengguna/profil*') ? $activeClass : '' }}">
                Profil
            </a>

        </nav>
    </div>

    <div class="mt-auto pt-4 border-t border-[#A33215]">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full text-left {{ $menuClass }} hover:bg-[#A33215] hover:text-white text-[#A33215]">
                Logout
            </button>
        </form>
    </div>

</aside>