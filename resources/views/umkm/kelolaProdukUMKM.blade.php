@extends('layouts.app')

@section('title', 'Produk UMKM: ' . $umkm->nama_umkm)

@section('content')

@if(session('success'))
<div id="alertSuccess" class="fixed top-20 right-4 z-[9999] bg-white border-l-4 border-[#FA8145] p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-fade-in-down">
    <span class="font-semibold text-sm text-[#A33215]">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div id="alertError" class="fixed top-20 right-4 z-[9999] bg-white border-l-4 border-[#A33215] p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-fade-in-down">
    <span class="font-semibold text-sm text-[#69200F]">{{ session('error') }}</span>
</div>
@endif

<div class="flex mb-6">
        @php
            $prevUrl = url()->previous();
            $fallbackUrl = !auth()->check() ? route('guest.umkm') : (auth()->user()->hasAkses('konfirmasi_umkm') ? route('umkm.konfirmasi.index') : route('warga.umkm'));
            $backUrl = ($prevUrl !== url()->current()) ? $prevUrl : $fallbackUrl;
        @endphp
        <a href="{{ $backUrl }}" 
            class="inline-flex items-center justify-center gap-2 bg-white border-2 border-gray-100 text-gray-500 px-5 py-2 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:border-[#FA8145] hover:text-[#A33215] hover:bg-orange-50 transition-all shadow-sm active:scale-95">
            Kembali
        </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] p-6 sm:p-8 mb-8 relative overflow-hidden">
    <div class="flex flex-col md:flex-row gap-6 sm:gap-8 items-center md:items-start">

        <div class="flex-shrink-0 w-full sm:w-auto flex justify-center">
            @php
                $fotoUmkmPath = $umkm->foto_umkm;
                if (empty($fotoUmkmPath)) {
                    $defaultImages = [
                        'kuliner' => 'images/kuliner.jpg',
                        'fashion' => 'images/fashion.jpg',
                        'agribisnis' => 'images/agribisnis.jpg',
                        'jasa & produk kreatif' => 'images/jasa.jpg',
                        'teknologi dan digital' => 'images/teknologi.jpg',
                    ];
                    $fotoUmkmPath = $defaultImages[strtolower($umkm->bidang_umkm)] ?? 'images/default.jpg';
                }
            @endphp
            <img src="{{ str_contains($fotoUmkmPath, 'images/') ? asset($fotoUmkmPath) : asset('storage/'.$fotoUmkmPath) }}"
                 class="w-32 h-32 sm:w-44 sm:h-44 md:w-52 md:h-52 object-cover rounded-3xl border border-orange-100 shadow-md transition-all duration-300">
        </div>

        <div class="flex-1 w-full mt-2 md:mt-0 text-center md:text-left">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-start gap-4 border-b border-gray-50 pb-5 mb-5">
                <div>
                    <span class="px-4 py-1.5 rounded-full bg-orange-50 text-[#C54716] text-[10px] font-bold uppercase tracking-widest border border-orange-100 mb-3 inline-block">
                        Detail UMKM
                    </span>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-black text-[#69200F] leading-tight uppercase tracking-tight mb-2">
                        {{ $umkm->nama_umkm }}
                    </h1>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-orange-100/50 text-[#A33215] border border-orange-200/50 justify-center md:justify-start">
                        <span class="text-[10px] font-bold uppercase tracking-wider">{{ $umkm->bidang_umkm ?? '-' }}</span>
                    </div>
                </div>
                <div class="flex flex-col items-center md:items-end gap-2 shrink-0 w-full md:w-auto mt-2 md:mt-0">
                    <div class="bg-orange-50/50 px-5 py-3 rounded-2xl border border-orange-100/50 text-center md:text-right w-full">
                        <p class="text-[10px] font-bold text-[#E75C16] uppercase tracking-widest mb-1">Status</p>
                        <p class="text-base sm:text-xl font-black {{ $umkm->status_umkm == 'aktif' ? 'text-[#C54716]' : 'text-[#FA8145]' }} uppercase">
                            {{ $umkm->status_umkm == 'aktif' ? 'Aktif' : 'Menunggu' }}
                        </p>
                    </div>
                    @if(auth()->check() && auth()->user()->hasAkses('konfirmasi_umkm') && $umkm->status_umkm == 'menunggu')
                    <form action="{{ route('umkm.konfirmasi.confirm', $umkm->id_umkm) }}" method="POST" class="w-full">
                        @csrf
                        @method('PUT')
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi dan mengaktifkan UMKM ini?')" class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl font-bold text-[10px] uppercase tracking-wider shadow-md shadow-orange-100 hover:bg-[#A33215] transition-all active:scale-95 w-full mt-1">
                            ✔ Konfirmasi UMKM
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-5 text-center md:text-left">
                <div class="min-w-0 bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Telepon</p>
                    <p class="text-xs sm:text-sm font-bold text-[#A33215] truncate">{{ $umkm->nomor_telepon_umkm ?? '-' }}</p>
                </div>
                <div class="min-w-0 bg-gray-50/50 p-3 rounded-xl border border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email</p>
                    <p class="text-xs sm:text-sm font-bold text-[#A33215] truncate">{{ $umkm->email_umkm ? strtolower($umkm->email_umkm) : '-' }}</p>
                </div>
                <div class="min-w-0 bg-gray-50/50 p-3 rounded-xl border border-gray-100 sm:col-span-3 md:col-span-1">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Alamat</p>
                    <p class="text-xs sm:text-sm font-bold text-[#A33215] line-clamp-2" title="{{ $umkm->alamat_umkm }}">{{ $umkm->alamat_umkm ?? '-' }}</p>
                </div>
            </div>
            
            @if($umkm->deskripsi_umkm)
            <div class="bg-[#FA8145]/5 p-4 sm:p-5 rounded-2xl border border-[#FA8145]/10 mt-2 text-center md:text-left">
                <p class="text-[10px] font-bold text-[#A33215] uppercase tracking-widest mb-2">Deskripsi</p>
                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed font-medium">"{{ $umkm->deskripsi_umkm }}"</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="mt-12 bg-white rounded-3xl shadow-sm border border-[#FA8145] p-6 md:p-8">
    <div class="flex justify-between items-center mb-8 border-b border-orange-100 pb-4">
        <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight">
            Katalog Produk
        </h2>
        @if(auth()->check() && (auth()->user()->hasAkses('kelola_umkm') || auth()->id() == $umkm->id_pengguna))
        <button onclick="openModal('modalProduk')"
            class="bg-[#C54716] text-white px-5 py-2 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider shadow-lg shadow-orange-100 hover:bg-[#A33215] transition-all active:scale-95">
            + Tambah Produk
        </button>
        @endif
    </div>

    @if($produk->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-100 shadow-sm">
            <p class="text-gray-500 font-medium text-sm">Belum ada produk.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($produk as $item)
            <div class="group bg-white rounded-[2rem] border border-gray-200 hover:border-[#FA8145] shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1 flex flex-col h-full">
                
                @php
                    $defaultImage = match(strtolower($umkm->bidang_umkm)) {
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
                        <span class="text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm w-fit
                            {{ $item->status == 'tersedia' ? 'bg-orange-50 text-[#C54716] border border-orange-200' : 'bg-gray-100 text-gray-500 border border-gray-200' }}">
                            {{ $item->status == 'tersedia' ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                        @if($item->produkMaster && $item->produkMaster->status_produk_master == 'menunggu')
                        <span class="text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm w-fit bg-[#FA8145] text-white border border-[#E75C16]">
                            Menunggu Validasi
                        </span>
                        @endif
                    </div>
                </div>

                <div class="p-6 flex-1 flex flex-col">
                    <h3 class="text-sm font-bold text-[#69200F] uppercase tracking-wider mb-1 line-clamp-1">
                        {{ $item->nama_produk }}
                    </h3>
                    <p class="text-lg font-bold text-[#C54716] mb-4">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </p>

                    @if(auth()->check() && (auth()->user()->hasAkses('kelola_umkm') || auth()->id() == $umkm->id_pengguna))
                    <div class="mt-auto grid grid-cols-2 gap-2">
                        <button type="button" onclick="handleEditProduk(this)" 
                            data-id="{{ $item->id_produk_umkm }}"
                            data-nama="{{ $item->nama_produk }}"
                            data-harga="{{ $item->harga }}"
                            data-deskripsi="{{ $item->deskripsi }}"
                            data-status="{{ $item->status }}"
                            class="bg-white text-[#C54716] border border-[#C54716] py-2 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-orange-50 transition-all text-center">Ubah</button>
                        <button onclick="openDeleteModal({{ $item->id_produk_umkm }})"
                            class="bg-white text-[#A33215] border border-[#A33215] py-2 rounded-xl text-xs font-bold uppercase tracking-wider hover:bg-orange-50 transition-all text-center">Hapus</button>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<div id="modalProduk" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-8 border-b flex justify-between items-center bg-gray-50/50">
            <h2 class="text-xl font-semibold text-[#69200F] uppercase tracking-tight">Tambah Produk</h2>
        </div>
        <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <input type="hidden" name="id_umkm" value="{{ $umkm->id_umkm }}">
            
            <div class="p-8 space-y-6 flex-1 overflow-y-auto">
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Nama Produk Umum <span class="text-[#A33215]">*</span></label>
                    <input list="produk_master_list" name="nama_produk_umum" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" placeholder="Pilih atau ketik nama produk umum..." required>
                    <datalist id="produk_master_list">
                        @foreach($produk_master as $pm)
                            <option value="{{ $pm->nama_produk_master }}">
                        @endforeach
                    </datalist>
                    <p class="text-xs text-gray-500 mt-1 italic">Ketik untuk mencari produk master, atau masukkan nama baru</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Nama Produk <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="nama_produk" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Harga Produk <span class="text-[#A33215]">*</span></label>
                    <input type="number" name="harga" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" required>
                    <p class="text-xs text-gray-500 mt-1 italic">Tanpa titik (cth: 15000)</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-medium text-sm text-gray-700" rows="3"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Status Produk <span class="text-[#A33215]">*</span></label>
                    <select name="status" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak tersedia">Tidak Tersedia</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Foto Produk</label>
                    <input type="file" name="foto_produk_umkm" accept="image/*"
                        class="w-full border-2 border-dashed border-gray-200 p-4 rounded-2xl file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:uppercase file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200 cursor-pointer">
                </div>
            </div>
            
            <div class="p-8 border-t bg-gray-50/50 flex justify-end gap-4">
                <button type="button" onclick="closeModal('modalProduk')" class="px-6 py-3 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-[#A33215] transition-all">Batal</button>
                <button type="submit" class="px-10 py-3 bg-[#C54716] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] shadow-xl shadow-orange-100 transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditProduk" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-8 border-b flex justify-between items-center bg-gray-50/50">
            <h2 class="text-xl font-semibold text-[#69200F] uppercase tracking-tight">Ubah Produk</h2>
        </div>
        <form id="formEditProduk" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf @method('PUT')
            
            <div class="p-8 space-y-6 flex-1 overflow-y-auto">
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Nama Produk <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="edit_nama" name="nama_produk" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" required>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Harga Produk <span class="text-[#A33215]">*</span></label>
                    <input type="number" id="edit_harga" name="harga" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" required>
                    <p class="text-xs text-gray-500 mt-1 italic">Tanpa titik (cth: 15000)</p>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Deskripsi Singkat</label>
                    <textarea id="edit_deskripsi" name="deskripsi" class="w-full border-2 border-gray-100 p-4 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-medium text-sm text-gray-700" rows="3"></textarea>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Status Produk <span class="text-[#A33215]">*</span></label>
                    <select id="edit_status" name="status" class="w-full border-2 border-gray-100 p-3 rounded-2xl focus:border-[#FA8145] outline-none transition-all font-bold text-sm text-gray-700" required>
                        <option value="tersedia">Tersedia</option>
                        <option value="tidak tersedia">Tidak Tersedia</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-semibold text-gray-700 mb-2 block">Ganti Foto (Opsional)</label>
                    <input type="file" name="foto_produk_umkm" accept="image/*"
                        class="w-full border-2 border-dashed border-gray-200 p-4 rounded-2xl file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:uppercase file:bg-gray-100 file:text-gray-600 hover:file:bg-gray-200 cursor-pointer">
                    <p class="text-xs text-gray-500 mt-2 italic">*Kosongkan jika tidak mengubah foto</p>
                </div>
            </div>
            
            <div class="p-8 border-t bg-gray-50/50 flex justify-end gap-4">
                <button type="button" onclick="closeEditModal()" class="px-6 py-3 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-[#A33215] transition-all">Batal</button>
                <button type="submit" class="px-10 py-3 bg-[#C54716] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] shadow-xl shadow-orange-100 transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalDeleteProduk" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-xl font-bold text-[#69200F] uppercase tracking-tight mb-3">Hapus Produk?</h3>
        <p class="text-sm text-gray-500 mb-8 font-medium">Produk ini akan dihapus permanen.</p>
        <form id="formDeleteProduk" method="POST" class="flex flex-col gap-3">
            @csrf @method('DELETE')
            <button type="submit" class="w-full py-4 bg-[#A33215] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#69200F] shadow-xl shadow-orange-100 transition-all">Ya, Hapus</button>
            <button type="button" onclick="closeDeleteModal()" class="w-full py-4 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-gray-600 transition-all">Batal</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-hide alert
setTimeout(() => {
    ['alertSuccess', 'alertError'].forEach(id => {
        const el = document.getElementById(id);
        if(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(-10px)';
            el.style.transition = 'all 0.5s ease';
            setTimeout(() => el.remove(), 500);
        }
    });
}, 3000);

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function handleEditProduk(btn) {
    document.getElementById('modalEditProduk').classList.remove('hidden');
    
    document.getElementById('edit_nama').value = btn.getAttribute('data-nama');
    document.getElementById('edit_harga').value = btn.getAttribute('data-harga');
    document.getElementById('edit_deskripsi').value = btn.getAttribute('data-deskripsi');
    document.getElementById('edit_status').value = btn.getAttribute('data-status');

    document.getElementById('formEditProduk').action = '/produk/' + btn.getAttribute('data-id');
}

function closeEditModal() {
    document.getElementById('modalEditProduk').classList.add('hidden');
}

function openDeleteModal(id) {
    document.getElementById('modalDeleteProduk').classList.remove('hidden');
    document.getElementById('formDeleteProduk').action = '/produk/' + id;
}

function closeDeleteModal() {
    document.getElementById('modalDeleteProduk').classList.add('hidden');
}
</script>
@endpush