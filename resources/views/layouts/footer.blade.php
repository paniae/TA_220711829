@php
    $profil = \App\Models\ProfilPadukuhan::first();
    $kontak = \App\Models\KontakPadukuhan::first();
@endphp

<footer class="w-full bg-[#A33215] text-white py-10 md:py-16 border-t-2 border-[#C54716] relative z-10">
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-12 text-center md:text-left">
            
            <div class="flex flex-col items-center md:items-start space-y-4">
                <div class="flex flex-col md:flex-row items-center gap-4">
                    @if($profil && $profil->logo_padukuhan)
                        <img src="{{ $profil->logo_padukuhan }}" alt="Logo" class="h-12 md:h-14 w-auto object-contain">
                    @else
                        <div class="w-12 h-12 bg-white/10 rounded-xl flex items-center justify-center font-black text-[10px] italic">LOGO</div>
                    @endif
                    <div class="leading-tight">
                        <h3 class="text-lg md:text-xl font-black uppercase tracking-tighter">
                            Padukuhan {{ $profil->nama_padukuhan ?? '' }}
                        </h3>
                        <p class="text-[10px] text-orange-200 font-bold uppercase tracking-[0.2em] opacity-80">
                            Kalurahan {{ $profil->nama_kalurahan ?? '' }}
                        </p>
                    </div>
                </div>
                <p class="text-[10px] md:text-xs text-orange-50/70 leading-relaxed uppercase tracking-widest font-bold max-w-xs">
                    {{ $profil->nama_kecamatan ?? '' }}{{ $profil->nama_kabupaten ? ', ' . $profil->nama_kabupaten : '' }}
                </p>
            </div>

            <div class="flex flex-col items-center md:items-start space-y-6">
                <h4 class="text-[10px] font-black text-[#FA8145] uppercase tracking-[0.4em] border-b border-[#FA8145]/20 pb-2">Informasi Kontak</h4>
                <div class="space-y-4 w-full flex flex-col items-center md:items-start">
                    @if($kontak && strtolower($kontak->status_kontak) === 'aktif')
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $kontak->nomor_telepon ?? '');
                            if (strpos($waNumber, '0') === 0) {
                                $waNumber = '62' . substr($waNumber, 1);
                            }
                        @endphp
                        @if($kontak->nomor_telepon)
                        <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="flex items-center gap-4 group">
                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-base group-hover:bg-[#C54716] transition-all">💬</div>
                            <span class="text-sm font-bold tracking-widest group-hover:text-orange-200 transition-colors">{{ $kontak->nomor_telepon }}</span>
                        </a>
                        @endif
                        @if($kontak->email)
                        <a href="mailto:{{ $kontak->email }}" class="flex items-center gap-4 group">
                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-base group-hover:bg-[#C54716] transition-all">📧</div>
                            <span class="text-sm font-bold lowercase group-hover:text-orange-200 transition-colors">{{ $kontak->email }}</span>
                        </a>
                        @endif
                        @if($kontak->instagram)
                        <a href="https://instagram.com/{{ $kontak->instagram }}" target="_blank" class="flex items-center gap-4 group">
                            <div class="w-9 h-9 rounded-xl bg-white/10 flex items-center justify-center text-base group-hover:bg-[#C54716] transition-all">📸</div>
                            <span class="text-sm font-bold group-hover:text-orange-200 transition-colors">@ {{ $kontak->instagram }}</span>
                        </a>
                        @endif
                    @else
                        <div class="flex items-center gap-3 opacity-60">
                            <div class="w-9 h-9 rounded-xl bg-white/5 flex items-center justify-center text-base">📴</div>
                            <span class="text-xs font-bold uppercase tracking-widest">Kontak Tidak Aktif</span>
                        </div>
                        <p class="text-[10px] text-orange-200/70 max-w-xs text-center md:text-left leading-relaxed">
                            Informasi kontak pengurus saat ini sedang tidak tersedia.
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex flex-col items-center md:items-end space-y-6">
                <h4 class="text-[10px] font-black text-[#FA8145] uppercase tracking-[0.4em] border-b border-[#FA8145]/20 pb-2 w-full text-center md:text-right">Layanan Masyarakat</h4>
                <div class="space-y-4 w-full flex flex-col items-center md:items-end">
                    <p class="text-sm md:text-base font-black text-orange-100 leading-relaxed max-w-xs text-center md:text-right">
                        {{ $profil->jam_operasional ?? '' }}
                    </p>
                    @if($profil && $profil->link_maps_balai)
                    <a href="{{ $profil->link_maps_balai }}" 
                        target="_blank"
                        class="inline-flex items-center justify-center gap-2 bg-white/10 hover:bg-[#C54716] px-5 py-2.5 rounded-xl text-[10px] text-orange-100 font-bold uppercase tracking-widest hover:text-white transition-all shadow-sm">
                        <span>Lokasi di Maps</span>
                        <span class="text-[10px]">➜</span>
                    </a>
                    @endif
                </div>
            </div>

        </div>

        <div class="mt-12 md:mt-16 pt-8 border-t border-white/10 flex flex-col items-center gap-4">
            <p class="text-[9px] font-black text-orange-100/30 uppercase tracking-[0.5em]">
                &copy; {{ date('Y') }} WEBSITE PADUKUHAN {{ strtoupper($profil->nama_padukuhan ?? '') }}
            </p>
        </div>

    </div>
</footer>
