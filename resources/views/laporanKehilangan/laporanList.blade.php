@forelse($laporan as $item)
@php
    $redirectUrl = route('kehilangan.show', $item->id_laporan);
    if(auth()->check()) {
        if(auth()->user()->hasAkses('kelola_komentar')) {
            $redirectUrl = route('kehilangan.kelolaKomentar', $item->id_laporan);
        } elseif(auth()->user()->hasAkses('tambah_komentar')) {
            $redirectUrl = route('kehilangan.tambahKomentar', $item->id_laporan);
        }
    }
@endphp

<div class="group bg-white rounded-2xl shadow-sm hover:shadow-md transition-all border-2 border-gray-100 flex flex-col h-full overflow-hidden cursor-pointer"
    data-owner-id="{{ $item->id_pengguna ?? '' }}" data-status="{{ $item->status_kehilangan }}"
    data-search="{{ strtolower($item->barang_hilang . ' ' . $item->lokasi_hilang . ' ' . \Carbon\Carbon::parse($item->tanggal_hilang)->translatedFormat('d M Y') . ' ' . \Carbon\Carbon::parse($item->tanggal_hilang)->format('d-m-Y') . ' ' . ($item->deskripsi_laporan ?? '')) }}"
    onclick="window.location='{{ $redirectUrl }}'">
    
    <div class="p-5 flex-1 flex flex-col gap-3">
        <div class="flex justify-between items-start">
            <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border 
                {{ $item->status_kehilangan == 'hilang' ? 'bg-orange-50 text-[#A33215] border-orange-200' : 'bg-orange-50 text-[#C54716] border-orange-100' }}">
                {{ $item->status_kehilangan == 'hilang' ? 'Hilang' : 'Ditemukan' }}
            </span>
            <span class="text-xs font-bold text-gray-500 uppercase">
                {{ \Carbon\Carbon::parse($item->tanggal_hilang)->translatedFormat('d M Y') }}
            </span>
        </div>

        @if($item->foto_barang)
            <div class="mb-4 w-full h-48 rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                <img src="{{ asset('storage/'.$item->foto_barang) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>
        @else
            <div class="mb-4 w-full h-48 rounded-xl bg-gray-50 flex flex-col items-center justify-center border border-gray-100 shadow-sm opacity-60">
                <span class="text-xs font-bold uppercase tracking-widest text-gray-500">Tanpa Foto</span>
            </div>
        @endif

        <h2 class="font-bold text-gray-900 text-lg group-hover:text-[#C54716] transition-colors leading-tight">
            {{ $item->barang_hilang }}
        </h2>
        
        <div class="mt-3 space-y-2">
            <div class="flex items-center gap-2 text-sm text-gray-600">
                <span class="truncate font-medium">{{ $item->lokasi_hilang }}</span>
            </div>
            <p class="text-xs text-gray-500 font-bold uppercase tracking-widest">
                Dilaporkan {{ \Carbon\Carbon::parse($item->tanggal_laporan)->diffForHumans() }}
            </p>
        </div>
    </div>

    <div class="px-5 py-3 bg-gray-50 border-t flex justify-between items-center">
        @php
            $isOwner = auth()->check() && auth()->id() == $item->id_pengguna;
            $canManage = auth()->check() && (auth()->user()->hasAkses('kelola_laporan_kehilangan') || auth()->user()->isDukuh());
        @endphp

        @if($isOwner || $canManage)
            <div class="flex gap-2">
                @if($isOwner && $item->status_kehilangan == 'hilang')
                    <button type="button" onclick="event.stopPropagation(); openEditLaporanModal('{{ $item->id_laporan }}', '{{ addslashes($item->barang_hilang) }}', '{{ \Carbon\Carbon::parse($item->tanggal_hilang)->format('Y-m-d') }}', '{{ addslashes($item->lokasi_hilang) }}', '{{ addslashes($item->deskripsi_laporan ?? '') }}', '{{ $item->status_kehilangan }}')"
                        class="bg-orange-50 text-[#C54716] px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-[#C54716] hover:text-white transition-all shadow-sm uppercase tracking-wider border border-orange-100">
                        Ubah
                    </button>
                @endif
                <button type="button" onclick="event.stopPropagation(); openDeleteLaporanModal('{{ $item->id_laporan }}')"
                    class="bg-orange-50 text-[#69200F] px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-[#69200F] hover:text-white transition-all shadow-sm uppercase tracking-wider border border-orange-200">
                    Hapus
                </button>
            </div>
        @else
            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest py-2.5 block leading-normal">
                Detail
            </span>
        @endif
    </div>
</div>

@empty

<div class="col-span-full bg-white rounded-3xl border-2 border-dashed border-gray-200 p-12 text-center">
    <h3 class="text-lg font-bold text-gray-900">Belum Ada Laporan</h3>
    <p class="text-sm text-gray-400 mt-1">Belum ada warga yang melaporkan kehilangan barang.</p>
</div>

@endforelse
