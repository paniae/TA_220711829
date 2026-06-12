@forelse($laporan->komentar()->orderBy('created_at','desc')->get() as $komen)
    <div class="border border-gray-200 rounded-2xl p-5 bg-white shadow hover:shadow-lg transition-all duration-300">
        
        <div class="flex items-start sm:items-center justify-between mb-4 pb-3 border-b-2 border-gray-100 gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-xs border border-gray-200 overflow-hidden shadow-sm">
                    @if($komen->pengguna && $komen->pengguna->foto_profil)
                        <img src="{{ asset('storage/'.$komen->pengguna->foto_profil) }}" class="w-full h-full object-cover cursor-pointer hover:opacity-80 transition-all" onclick="openImageModal('{{ asset('storage/'.$komen->pengguna->foto_profil) }}')">
                    @else
                        <img src="{{ asset('images/user.jpg') }}" class="w-full h-full object-cover cursor-pointer hover:opacity-80 transition-all" onclick="openImageModal('{{ asset('images/user.jpg') }}')">
                    @endif
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <p class="text-xs font-bold text-gray-800 tracking-wide">{{ $komen->pengguna->nama ?? 'Warga' }}</p>
                        <span class="text-[10px] font-bold text-gray-500">#{{ $komen->id_komen }}</span>
                    </div>
                    <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ \Carbon\Carbon::parse($komen->tgl_waktu_komen)->translatedFormat('d M Y H:i') }}</p>
                </div>
            </div>
            
            <div class="flex flex-row sm:flex-col gap-2">
                @if((Auth::id() == $komen->id_pengguna || (Auth::check() && Auth::user()->hasAkses('kelola_komentar'))) && $laporan->status_kehilangan != 'ditemukan')
                <button onclick="openEditModal('{{ $komen->id_komen }}', '{{ addslashes($komen->komentar) }}')" 
                    class="bg-white text-[#C54716] border border-[#C54716] px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-50 hover:-translate-y-0.5 transition-all shadow-sm">
                    Ubah
                </button>
                @endif
                @if($isModerator && Auth::check() && (Auth::id() == $komen->id_pengguna || Auth::user()->hasAkses('kelola_komentar') || Auth::user()->isDukuh()))
                <button onclick="openDeleteModal('{{ $komen->id_komen }}')" 
                    class="bg-[#7F1911] text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#5A120C] hover:-translate-y-0.5 transition-all shadow-sm">
                    Hapus
                </button>
                @endif
            </div>
        </div>

        <div class="mb-4">
            <p class="text-sm text-gray-700 leading-relaxed font-medium">
                @if($isModerator)
                    "{{ $komen->komentar }}"
                @else
                    {{ $komen->komentar }}
                @endif
            </p>
        </div>

        @if($komen->foto_komen)
            <div class="flex gap-3 overflow-x-auto mb-2 pb-2">
                <img src="{{ asset('storage/'.$komen->foto_komen) }}" class="w-24 h-24 object-cover rounded-xl border border-gray-100 shadow-sm cursor-pointer hover:opacity-80 transition" onclick="openImageModal('{{ asset('storage/'.$komen->foto_komen) }}')">
            </div>
        @endif
    </div>
@empty
    <div class="text-center py-12">
        <p class="text-gray-400 text-sm font-medium italic">Belum ada diskusi untuk dikelola.</p>
    </div>
@endforelse
