@extends('layouts.app')

@section('title', 'UMKM Warga')

@section('content') 
@if(auth()->user()->hasAkses('kelola_umkm'))

<div class="relative overflow-hidden bg-white rounded-3xl p-5 md:p-8 shadow-sm border border-[#FA8145] mb-5">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-[#C54716] text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FA8145] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FA8145]"></span>
                </span>
                Kelola UMKM
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#A33215] leading-tight uppercase tracking-tight">
                Daftar UMKM Warga
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium max-w-md">
                Jelajahi usaha warga Padukuhan Bruno II dan kelola pendaftaran usaha Anda sendiri.
            </p>
        </div>

        <div class="bg-gray-100/80 p-1.5 rounded-2xl flex gap-1 border border-gray-200 shadow-inner w-full md:w-auto overflow-x-auto no-scrollbar">
            <button onclick="switchMainTab('warga')" id="tabBtn-warga" 
                class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all bg-white text-[#C54716] shadow-sm">
                UMKM Warga
            </button>
            <button onclick="switchMainTab('saya')" id="tabBtn-saya" 
                class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all text-gray-500 hover:text-gray-700">
                UMKM Saya
            </button>
        </div>
    </div>
</div>

@if(session('success'))
<div id="alertSuccess" class="bg-white border-l-4 border-[#C54716] p-4 rounded-2xl shadow-sm mb-8 flex justify-between items-center animate-fade-in-down">
    <div class="flex items-center gap-3 text-[#C54716]">
        <span class="font-bold text-xs uppercase tracking-tight">{{ session('success') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-gray-300 hover:text-gray-500 text-lg">✕</button>
</div>
@endif

<div id="tabContent-warga">
    <div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden mb-8">
        <div class="p-5 md:p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
                <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Katalog UMKM Bruno II</h2>
            </div>
            
            <form action="{{ route('warga.umkm') }}" method="GET" class="flex items-center w-full sm:w-auto">
                <select name="kategori" onchange="this.form.submit()" class="w-full sm:w-auto border-2 border-orange-100/50 p-2.5 rounded-xl focus:border-[#FA8145] outline-none text-xs font-bold text-[#69200F] uppercase tracking-wider bg-orange-50/30 hover:bg-orange-50 cursor-pointer transition-all shadow-sm">
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
                        <span class="text-[10px] font-bold text-[#C54716] uppercase tracking-wider group-hover:underline">Kunjungi Toko →</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div id="tabContent-saya" class="hidden">
<div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden mb-8">
    
    <div class="p-5 md:p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
            <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Daftar Usaha Anda</h2>
        </div>

        <button onclick="openModal('modalUmkm')"
            class="px-4 py-2 text-xs sm:text-sm font-bold uppercase tracking-wider rounded-xl transition-all border bg-[#C54716] text-white border-[#C54716] shadow-md shadow-orange-200">
            + Tambah UMKM
        </button>
    </div>

    <div class="p-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">

            @if($umkmSaya->isEmpty())
                <div class="col-span-full bg-white rounded-3xl p-16 md:p-20 text-center border-2 border-dashed border-gray-100">
                    <p class="text-gray-300 font-bold uppercase tracking-wider text-sm">Belum Ada Data UMKM</p>
                    <p class="text-xs text-gray-400 mt-2 italic">Silakan tambahkan usaha pertama Anda.</p>
                </div>
            @endif

            @foreach($umkmSaya as $item)
            
            <div class="bg-orange-50/20 border border-orange-200/60 rounded-2xl p-4 shadow-sm hover:shadow-md hover:border-[#FA8145] transition-all group flex flex-col h-full relative overflow-hidden
                    {{ trim(strtolower($item->status)) == 'aktif' ? 'cursor-pointer hover:bg-orange-50/40' : '' }}"
                
                @if(trim(strtolower($item->status)) == 'aktif')
                    onclick="window.location='{{ route('warga.produkUMKM', $item->id_umkm) }}'"
                @endif
            >

                <div class="absolute top-3 right-3 z-10">
                    @if(trim(strtolower($item->status)) == 'menunggu')
                        <span class="text-[9px] font-bold px-2 py-1 rounded-lg bg-orange-50 text-[#FA8145] uppercase tracking-wider border border-[#FA8145]/30">
                            Menunggu
                        </span>
                    @else
                        <span class="text-[9px] font-bold px-2 py-1 rounded-lg bg-[#E75C16] text-white uppercase tracking-wider shadow-sm shadow-orange-200">
                            Aktif
                        </span>
                    @endif
                </div>

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

                <div class="mt-4 pt-4 border-t border-orange-100/50 flex gap-2">
                    <button
                        onclick="event.stopPropagation(); handleEdit(this)"
                        data-id="{{ $item->id_umkm }}"
                        data-nama="{{ $item->nama_umkm }}"
                        data-alamat="{{ $item->alamat_umkm }}"
                        data-telepon="{{ $item->nomor_telepon }}"
                        data-tampilkan="{{ $item->is_nomor_telepon_ditampilkan }}"
                        data-email="{{ $item->email }}"
                        data-bidang="{{ $item->bidang_umkm }}"
                        data-deskripsi="{{ $item->deskripsi_umkm }}"
                        class="flex-1 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-orange-200 text-[#C54716] bg-white hover:bg-orange-50 transition-all text-center">
                        Ubah
                    </button>

                    <button
                        onclick="event.stopPropagation(); openDeleteModal('{{ $item->id_umkm }}')"
                        class="flex-1 px-3 py-1.5 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-orange-200 text-[#A33215] bg-white hover:bg-orange-50 transition-all text-center">
                        Hapus
                    </button>
                </div>

            </div>

            @endforeach

        </div>
    </div>
</div>

<div id="modalUmkm"
    class="fixed top-0 left-0 w-screen h-screen 
           bg-black/40 hidden z-[999] 
           flex items-center justify-center">

    <div class="bg-white w-full max-w-lg mx-4 rounded-xl shadow-lg 
                max-h-[85vh] flex flex-col relative">

        <button onclick="closeModal('modalUmkm')"
            class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center
                   text-gray-500 hover:text-black text-lg rounded-full hover:bg-gray-100">
            ✕
        </button>

        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-[#A33215]">
                Daftar UMKM
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                Lengkapi data usaha Anda
            </p>
        </div>

        <form action="{{ route('umkm.store') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col flex-1 overflow-hidden">
            @csrf

            <div class="p-6 space-y-4 flex-1 overflow-y-auto">

                <div>
                    <label class="text-sm font-medium">Nama UMKM <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="nama_umkm"
                        class="w-full border p-2 rounded-lg mt-1" required>
                </div>

                <div>
                    <label class="text-sm font-medium">Alamat <span class="text-[#A33215]">*</span></label>
                    <textarea name="alamat_umkm"
                        class="w-full border p-2 rounded-lg mt-1" rows="2" required></textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">Nomor Telepon <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="nomor_telepon"
                        class="w-full border p-2 rounded-lg mt-1" required>
                </div>

                <div>
                    <label class="text-sm font-medium">Tampilkan Nomor Telepon di Publik?</label>
                    <select name="is_nomor_telepon_ditampilkan" class="w-full border p-2 rounded-lg mt-1">
                        <option value="1">Ya, tampilkan</option>
                        <option value="0">Tidak, sembunyikan</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Email</label>
                    <input type="email" name="email"
                        class="w-full border p-2 rounded-lg mt-1">
                    <p class="text-xs text-gray-500 mt-1">
                        Akan dipublikasikan, kosongkan jika tidak ingin ditampilkan
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium">Bidang UMKM <span class="text-[#A33215]">*</span></label>
                    <select name="bidang_umkm"
                        class="w-full border p-2 rounded-lg mt-1" required>
                        <option value="">-- Pilih Bidang --</option>
                        <option value="kuliner">Kuliner</option>
                        <option value="fashion">Fashion</option>
                        <option value="agribisnis">Agribisnis</option>
                        <option value="jasa & produk kreatif">Jasa & Produk Kreatif</option>
                        <option value="teknologi dan digital">Teknologi dan Digital</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Deskripsi UMKM</label>
                    <textarea name="deskripsi" class="w-full border p-2 rounded-lg mt-1" rows="3" placeholder="Ceritakan secara singkat mengenai UMKM ini..."></textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">Foto UMKM</label>
                    <input type="file" name="foto_umkm"
                        class="w-full border p-2 rounded-lg mt-1 text-sm">
                </div>

            </div>

            <div class="p-4 border-t flex justify-end gap-2">
                <button type="button"
                    onclick="closeModal('modalUmkm')"
                    class="px-4 py-2 bg-gray-200 rounded-lg text-sm">
                    Batal
                </button>

                <button class="bg-[#E75C16] text-white px-4 py-2 rounded-lg text-sm">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<div id="modalEditUmkm"
    class="fixed top-0 left-0 w-screen h-screen 
           bg-black/40 hidden z-[999] 
           flex items-center justify-center">

    <div class="bg-white w-full max-w-lg mx-4 rounded-xl shadow-lg 
                max-h-[85vh] flex flex-col relative">

        <button onclick="closeModal('modalEditUmkm')"
            class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center
                   text-gray-500 hover:text-black text-lg rounded-full hover:bg-gray-100">
            ✕
        </button>

        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-[#A33215]">
                Ubah UMKM
            </h2>
            <p class="text-xs text-gray-500 mt-1">
                Perbarui data usaha Anda
            </p>
        </div>

        <form id="formEditUmkm" method="POST" enctype="multipart/form-data"
            class="flex flex-col flex-1 overflow-hidden">
            @csrf
            @method('PUT')

            <div class="p-6 space-y-4 flex-1 overflow-y-auto">

                <div>
                    <label class="text-sm font-medium">
                        Nama UMKM <span class="text-[#A33215]">*</span>
                    </label>
                    <input type="text" id="edit_nama" name="nama_umkm"
                        class="w-full border p-2 rounded-lg mt-1" required>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Alamat <span class="text-[#A33215]">*</span>
                    </label>
                    <textarea id="edit_alamat" name="alamat_umkm"
                        class="w-full border p-2 rounded-lg mt-1" rows="2" required></textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Nomor Telepon <span class="text-[#A33215]">*</span>
                    </label>
                    <input type="text" id="edit_telepon" name="nomor_telepon"
                        class="w-full border p-2 rounded-lg mt-1" required>
                </div>

                <div>
                    <label class="text-sm font-medium">Tampilkan Nomor Telepon di Publik?</label>
                    <select id="edit_tampilkan_telepon" name="is_nomor_telepon_ditampilkan" class="w-full border p-2 rounded-lg mt-1">
                        <option value="1">Ya, tampilkan</option>
                        <option value="0">Tidak, sembunyikan</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Email
                    </label>
                    <input type="email" id="edit_email" name="email"
                        class="w-full border p-2 rounded-lg mt-1">

                    <p class="text-xs text-gray-500 mt-1">
                        Akan dipublikasikan, kosongkan jika tidak ingin ditampilkan
                    </p>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Bidang UMKM <span class="text-[#A33215]">*</span>
                    </label>
                    <select id="edit_bidang" name="bidang_umkm"
                        class="w-full border p-2 rounded-lg mt-1" required>
                        <option value="kuliner">Kuliner</option>
                        <option value="fashion">Fashion</option>
                        <option value="agribisnis">Agribisnis</option>
                        <option value="jasa & produk kreatif">Jasa & Produk Kreatif</option>
                        <option value="teknologi dan digital">Teknologi dan Digital</option>
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Deskripsi UMKM
                    </label>
                    <textarea id="edit_deskripsi" name="deskripsi" class="w-full border p-2 rounded-lg mt-1" rows="3" placeholder="Ceritakan secara singkat mengenai UMKM ini..."></textarea>
                </div>

                <div>
                    <label class="text-sm font-medium">
                        Foto Baru
                    </label>
                    <input type="file" name="foto_umkm"
                        class="w-full border p-2 rounded-lg mt-1 text-sm">
                </div>

            </div>

            <div class="p-4 border-t flex justify-end gap-2">
                <button type="button"
                    onclick="closeModal('modalEditUmkm')"
                    class="px-4 py-2 bg-gray-200 rounded-lg text-sm">
                    Batal
                </button>

                <button class="bg-[#E75C16] text-white px-4 py-2 rounded-lg text-sm">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<div id="modalDeleteUmkm"
    class="fixed top-0 left-0 w-screen h-screen 
           bg-black/40 hidden z-[999] 
           flex items-center justify-center">

    <div class="bg-white w-full max-w-sm mx-4 rounded-xl shadow-lg relative p-6 text-center">

        <button onclick="closeModal('modalDeleteUmkm')" 
            class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center
                   text-gray-400 hover:text-black rounded-full hover:bg-gray-100">
            ✕
        </button>

        <div class="w-14 h-14 mx-auto flex items-center justify-center 
                    rounded-full bg-orange-50 text-[#A33215] text-2xl mb-4">
            ⚠️
        </div>

        <h2 class="text-lg font-semibold text-gray-800">
            Hapus UMKM?
        </h2>

        <p class="text-sm text-gray-500 mt-2">
            Data UMKM yang dihapus tidak dapat dikembalikan.
        </p>

        <form id="formDeleteUmkm" method="POST" class="mt-5 flex gap-2 justify-center">
            @csrf
            @method('DELETE')

            <button type="button"
                onclick="closeModal('modalDeleteUmkm')"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm hover:bg-gray-300">
                Batal
            </button>

            <button
                class="px-4 py-2 bg-[#A33215] text-white rounded-lg text-sm hover:bg-[#A33215]">
                Ya, Hapus
            </button>
        </form>

    </div>
</div>
@else
<div class="bg-white p-8 rounded-3xl shadow-sm border-2 border-[#A33215] text-center mt-8 max-w-lg mx-auto">
    <div class="w-16 h-16 bg-[#69200F] text-white rounded-2xl flex items-center justify-center mx-auto mb-5 rotate-3">
        <span class="font-bold text-2xl">!</span>
    </div>
    <h2 class="text-xl font-bold text-[#A33215] uppercase tracking-wider">Akses Ditolak</h2>
    <p class="text-gray-600 mt-2 font-medium">Anda tidak memiliki hak akses untuk mengelola halaman ini.</p>
</div>
@endif
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const alert = document.getElementById('alertSuccess');
        if (alert) {
            setTimeout(() => {
                alert.classList.add('opacity-0'); 
                setTimeout(() => {
                    alert.remove(); 
                }, 500);
            }, 3000); 
        }
    });

    window.switchMainTab = function(tabName) {
        document.getElementById('tabContent-warga').classList.add('hidden');
        document.getElementById('tabContent-saya').classList.add('hidden');
        
        const inactiveClass = "tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all text-gray-500 hover:text-gray-700";
        const activeClass = "tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all bg-white text-[#C54716] shadow-sm";
        
        document.getElementById('tabBtn-warga').className = inactiveClass;
        document.getElementById('tabBtn-saya').className = inactiveClass;
        
        const content = document.getElementById('tabContent-' + tabName);
        content.classList.remove('hidden');
        content.classList.add('animate-fade-in');
        
        document.getElementById('tabBtn-' + tabName).className = activeClass;
    }

    window.handleEdit = function(el) {
        const id = el.dataset.id;

        document.getElementById('edit_nama').value = el.dataset.nama;
        document.getElementById('edit_alamat').value = el.dataset.alamat;
        document.getElementById('edit_telepon').value = el.dataset.telepon;
        document.getElementById('edit_tampilkan_telepon').value = el.dataset.tampilkan;
        document.getElementById('edit_email').value = el.dataset.email;
        document.getElementById('edit_bidang').value = el.dataset.bidang;
        document.getElementById('edit_deskripsi').value = el.dataset.deskripsi;

        document.getElementById('formEditUmkm').action = `/umkm/${id}`;

        openModal('modalEditUmkm');
    }

    window.openDeleteModal = function(id) {
        document.getElementById('formDeleteUmkm').action = `/umkm/${id}`;
        openModal('modalDeleteUmkm');
    }
</script>
@endpush