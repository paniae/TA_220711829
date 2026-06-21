@php
    $user = auth()->user();
    $profil = \App\Models\ProfilPadukuhan::first();
@endphp

<header class="w-full bg-[#A33215] text-white shadow-lg fixed top-0 left-0 z-50 border-b-2 border-[#C54716]">
    <div class="w-full flex items-center justify-between px-4 md:px-10 py-4 md:py-3 overflow-hidden">

        <div class="flex items-center gap-2 md:gap-3 min-w-0">
            <button id="toggleSidebar" class="text-3xl md:text-2xl flex-shrink-0">☰</button>

            <img src="{{ $profil->logo_padukuhan ? $profil->logo_padukuhan : asset('images/logo.png') }}" 
                class="w-10 h-10 md:w-12 md:h-12 object-contain rounded flex-shrink-0">

            <div class="leading-tight truncate">
                <p class="text-sm md:text-base font-bold uppercase tracking-wide truncate">
                    Padukuhan {{ $profil->nama_padukuhan ?? '-' }}
                </p>
                <p class="text-xs md:text-sm text-orange-50/50 font-bold uppercase tracking-widest truncate">
                    Kalurahan {{ $profil->nama_kalurahan ?? '-' }}
                </p>
            </div>
        </div>

        @auth
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="hidden sm:block text-sm">
                    Halo, {{ $user->nama }}
                </span>
            </div>
        @endauth

        @guest
            <div class="flex items-center gap-2 md:gap-3 flex-shrink-0">
                <a href="{{ route('login') }}"
                class="text-sm px-3 md:px-5 py-2 md:py-2 rounded-lg md:rounded-xl bg-[#C54716] text-white font-bold hover:bg-[#E75C16] transition-all shadow-md shadow-orange-900/20 uppercase tracking-widest whitespace-nowrap">
                    Masuk
                </a>
            </div>
        @endguest

    </div>
</header>
