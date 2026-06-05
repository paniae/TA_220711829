@extends('layouts.app')

@section('title', 'Pengaduan Warga')

@section('content')
<div class="bg-white/90 backdrop-blur rounded-2xl p-6 shadow border border-[#FA8145] mb-6">
    <h1 class="text-xl font-bold text-[#A33215] mb-1">
        Pengaduan Warga
    </h1>
    <p class="text-sm text-gray-500 font-medium">
        Sampaikan keluhan, saran, atau laporan Anda secara langsung kepada pengurus padukuhan.
    </p>
</div>

<div class="bg-white p-5 rounded-2xl shadow border border-[#FA8145] mb-6">
    <h2 class="text-xs font-bold text-[#A33215] mb-4 uppercase tracking-widest flex items-center gap-2">
        <span class="w-2 h-2 rounded-full bg-[#C54716]"></span> Buat Pengaduan Baru
    </h2>

    @if(session('success'))
        <div id="alertSuccess" class="mb-4 bg-orange-50 border border-orange-200 text-[#C54716] px-4 py-3 rounded-lg text-sm transition-opacity duration-500">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 bg-orange-50 border border-orange-200 text-[#A33215] px-4 py-3 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-6">
            <label class="block text-base font-bold text-gray-900 mb-2 uppercase tracking-wide">
                Isi Pengaduan <span class="text-[#A33215]">*</span>
            </label>
            <textarea name="isi_pengaduan" rows="5" required
                class="w-full text-lg rounded-2xl border-2 border-gray-400 shadow-sm focus:border-[#C54716] focus:ring-4 focus:ring-[#C54716]/20 placeholder:text-gray-400 p-4 text-gray-900 font-medium"
                placeholder="Tuliskan detail pengaduan Anda di sini dengan jelas..."></textarea>
            <p class="text-xs text-gray-500 mt-2 italic font-medium">Mohon ceritakan kronologi atau keluhan Anda secara mendetail agar mudah kami tindak lanjuti.</p>
        </div>

        <div class="mb-6">
            <label class="block text-base font-bold text-gray-900 mb-2 uppercase tracking-wide">Foto Bukti (Opsional)</label>
            <div class="p-4 border-2 border-dashed border-gray-300 rounded-2xl bg-gray-50/50">
                <input type="file" id="foto_pengaduan" name="foto_pengaduan[]" multiple accept="image/*"
                    class="w-full text-sm text-gray-600 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-[#C54716] file:text-white hover:file:bg-[#A33215] uppercase tracking-widest cursor-pointer transition-all">
                <p class="text-[10px] text-gray-400 mt-2 font-bold uppercase tracking-widest">Format: JPG, PNG • Max: 2MB per foto</p>
            </div>
            
            <div id="previewContainer" class="mt-4 flex flex-wrap gap-3"></div>
        </div>

        <button type="submit" class="bg-[#C54716] text-white px-8 py-3 rounded-xl text-xs font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 uppercase tracking-widest active:scale-95">
            Kirim Pengaduan
        </button>
    </form>
</div>

<div id="historySection" class="bg-white/90 backdrop-blur p-4 md:p-6 rounded-2xl shadow border border-[#FA8145] mt-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
        <h2 class="text-xs font-bold text-[#A33215] uppercase tracking-widest flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-[#E75C16]"></span> Riwayat Pengaduan Anda
        </h2>
        
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('pengaduan.indexWarga') }}#historySection" 
               class="filter-card-link px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-lg border transition-all
               {{ !request('status') ? 'bg-[#C54716] text-white shadow-md shadow-orange-100' : 'bg-white text-gray-500 hover:text-[#C54716]' }}">
                Semua
            </a>
            <a href="{{ route('pengaduan.indexWarga', ['status' => 'menunggu']) }}#historySection" 
               class="filter-card-link px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-lg border transition-all
               {{ request('status') == 'menunggu' ? 'bg-[#E75C16] text-white shadow-md shadow-orange-100 border-[#E75C16]' : 'bg-white text-gray-500 hover:text-[#E75C16]' }}">
                Menunggu
            </a>
            <a href="{{ route('pengaduan.indexWarga', ['status' => 'diterima']) }}#historySection" 
               class="filter-card-link px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-lg border transition-all
               {{ request('status') == 'diterima' ? 'bg-[#A33215] text-white shadow-md shadow-red-100 border-[#A33215]' : 'bg-white text-gray-500 hover:text-[#A33215]' }}">
                Diterima
            </a>
            <a href="{{ route('pengaduan.indexWarga', ['status' => 'selesai']) }}#historySection" 
               class="filter-card-link px-3 py-1.5 text-[10px] font-bold uppercase tracking-widest rounded-lg border transition-all
               {{ request('status') == 'selesai' ? 'bg-[#69200F] text-white shadow-md shadow-orange-100 border-[#69200F]' : 'bg-white text-gray-500 hover:text-[#69200F]' }}">
                Selesai
            </a>
        </div>
    </div>

    @if($pengaduan->isEmpty())
        <div class="text-center text-gray-500 text-sm py-6">
            Belum ada riwayat pengaduan.
        </div>
    @else
        <div class="space-y-3">
            @foreach($pengaduan as $item)
            <div class="border border-gray-200 rounded-2xl p-5 bg-white shadow hover:shadow-lg transition-all duration-300">
                
                <div class="flex items-start sm:items-center justify-between mb-4 pb-3 border-b-2 border-gray-100 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-orange-100 text-[#C54716] flex items-center justify-center font-bold shadow-inner">
                            {{ strtoupper(substr($item->pengguna->nama ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-800 tracking-wide">{{ $item->pengguna->nama ?? 'Anonim' }}</p>
                            <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ \Carbon\Carbon::parse($item->tgl_waktu_pengaduan)->translatedFormat('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div>
                        @if($item->status_pengaduan == 'menunggu')
                            <span class="px-3 py-1.5 rounded-full bg-orange-50 text-[#C54716] border border-orange-100 text-[10px] font-black uppercase tracking-widest shadow-sm">Menunggu</span>
                        @elseif($item->status_pengaduan == 'diterima')
                            <span class="px-3 py-1.5 rounded-full bg-orange-50 text-[#A33215] border border-orange-200 text-[10px] font-black uppercase tracking-widest shadow-sm">Diterima</span>
                        @elseif($item->status_pengaduan == 'selesai')
                            <span class="px-3 py-1.5 rounded-full bg-orange-100/50 text-[#69200F] border border-orange-200 text-[10px] font-black uppercase tracking-widest shadow-sm">Selesai</span>
                        @elseif($item->status_pengaduan == 'ditolak')
                            <span class="px-3 py-1.5 rounded-full bg-gray-50 text-gray-500 border border-gray-200 text-[10px] font-black uppercase tracking-widest shadow-sm">Ditolak</span>
                        @else
                            <span class="px-3 py-1.5 rounded-full bg-gray-50 text-gray-700 border border-gray-100 text-[10px] font-black uppercase tracking-widest shadow-sm">{{ $item->status_pengaduan }}</span>
                        @endif
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-sm text-gray-700 leading-relaxed font-medium">{{ $item->isi_pengaduan }}</p>
                </div>

                @if($item->foto && $item->foto->count())
                    <div class="flex gap-3 overflow-x-auto mb-2 pb-2">
                        @foreach($item->foto as $foto)
                            <img src="{{ asset('storage/' . $foto->foto_pengaduan) }}"
                                class="w-24 h-24 object-cover rounded-xl border border-gray-100 shadow-sm cursor-pointer hover:opacity-80 transition"
                                onclick="openImageModal(this.src)">
                        @endforeach
                    </div>
                @endif

                @if($item->status_pengaduan == 'menunggu')
                    <div class="pt-4 border-t-2 border-gray-100 flex justify-end gap-3 mt-2">
                        <button onclick="openUbahModal({{ $item->id_pengaduan }}, '{{ addslashes($item->isi_pengaduan) }}', this.getAttribute('data-fotos'))" 
                            data-fotos="{{ json_encode($item->foto) }}"
                            class="bg-orange-50 text-[#C54716] px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-100 hover:-translate-y-0.5 transition-all shadow-sm">
                            Ubah
                        </button>
                        <button onclick="openHapusModal({{ $item->id_pengaduan }})" 
                            class="bg-orange-50 text-[#A33215] px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-50 hover:-translate-y-0.5 transition-all shadow-sm">
                            Hapus
                        </button>
                    </div>
                @endif
            </div>
            @endforeach
        </div>
    @endif
</div>

<div id="modalUbahPengaduan" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 items-center justify-center" onclick="closeModal('modalUbahPengaduan')">
    <div class="bg-white rounded-[2rem] p-8 max-w-2xl w-full mx-4 shadow-2xl relative" onclick="event.stopPropagation()">
        <button type="button" onclick="closeModal('modalUbahPengaduan')" class="absolute top-6 right-6 text-gray-400 hover:text-[#C54716] text-2xl font-black transition-colors">✕</button>
        <h3 class="text-xl font-bold text-[#A33215] mb-6 uppercase tracking-widest">Ubah Pengaduan</h3>
        <form id="formUbahPengaduan" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-widest">Isi Pengaduan <span class="text-[#A33215]">*</span></label>
                <textarea name="isi_pengaduan" id="editIsiPengaduan" rows="5" required
                    class="w-full text-sm rounded-xl border-2 border-gray-200 focus:border-[#C54716] focus:ring-0 p-4 font-medium transition-colors"></textarea>
            </div>
            
            <div id="containerFotoLama" class="mb-6 hidden">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-widest">Hapus Foto Lama (Pilih untuk menghapus)</label>
                <div id="listFotoLama" class="flex flex-wrap gap-2"></div>
            </div>

            <div class="mb-8">
                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-widest">Tambah Foto Baru (Opsional)</label>
                <input type="file" name="foto_pengaduan[]" multiple accept="image/*"
                    class="w-full text-xs text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-black file:bg-orange-50 file:text-[#C54716] hover:file:bg-orange-100 cursor-pointer transition-all border-2 border-dashed border-gray-200 rounded-xl p-2">
            </div>

            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeModal('modalUbahPengaduan')" class="px-6 py-2.5 rounded-xl font-bold text-gray-500 hover:bg-gray-50 uppercase text-xs tracking-widest transition-colors">Batal</button>
                <button type="submit" class="px-6 py-2.5 rounded-xl font-bold bg-[#C54716] text-white hover:bg-[#A33215] uppercase text-xs tracking-widest transition-colors shadow-md shadow-orange-100">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalHapusPengaduan" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 items-center justify-center" onclick="closeModal('modalHapusPengaduan')">
    <div class="bg-white rounded-[2rem] p-8 max-w-sm w-full mx-4 shadow-2xl text-center relative" onclick="event.stopPropagation()">
        <h3 class="text-lg font-bold text-gray-900 mb-2 uppercase tracking-tight">Hapus Pengaduan</h3>
        <p class="text-xs text-gray-500 mb-8 font-medium">Yakin ingin menghapus pengaduan ini? Tindakan ini tidak dapat dibatalkan.</p>
        <form id="formHapusPengaduan" method="POST" class="flex justify-center gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModal('modalHapusPengaduan')" class="flex-1 px-4 py-2.5 rounded-xl font-bold text-gray-500 bg-gray-50 hover:bg-gray-100 uppercase text-[10px] tracking-widest transition-colors">Batal</button>
            <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl font-bold bg-[#A33215] text-white hover:bg-[#A33215] uppercase text-[10px] tracking-widest transition-colors shadow-md shadow-red-100">Hapus</button>
        </form>
    </div>
</div>

<div id="imageModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm hidden z-50 items-center justify-center" onclick="closeImageModal()">
    <span onclick="closeImageModal()" 
          class="absolute top-5 right-5 text-white text-4xl cursor-pointer hover:text-[#FA8145] transition-colors">✕</span>
    <img id="modalImage"
        class="max-w-[90%] max-h-[90%] rounded-2xl shadow-2xl border-4 border-white/10"
        onclick="event.stopPropagation()">
</div>

<script>
let selectedFiles = [];
const fileInput = document.getElementById('foto_pengaduan');
const previewContainer = document.getElementById('previewContainer');

fileInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    
    // Tambahkan file baru ke array
    files.forEach(file => {
        // Cek jika file sudah ada berdasarkan nama dan ukuran (sederhana)
        const isDuplicate = selectedFiles.some(f => f.name === file.name && f.size === file.size);
        if (!isDuplicate) {
            selectedFiles.push(file);
        }
    });

    renderPreviews();
    updateInputFiles();
});

function renderPreviews() {
    previewContainer.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative w-24 h-24 group animate-in zoom-in duration-200';
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover rounded-xl border-2 border-orange-100 shadow-sm">
                <button type="button" onclick="removeFile(${index})" 
                    class="absolute -top-2 -right-2 bg-[#A33215] text-white rounded-full w-6 h-6 flex items-center justify-center text-[10px] shadow-lg hover:bg-[#A33215] transition-all active:scale-90">
                    ✕
                </button>
                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 rounded-xl transition-all pointer-events-none"></div>
            `;
            previewContainer.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function removeFile(index) {
    selectedFiles.splice(index, 1);
    renderPreviews();
    updateInputFiles();
}

function updateInputFiles() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
}

function openImageModal(src) {
    const modal = document.getElementById('imageModal');
    const img = document.getElementById('modalImage');
    img.src = src;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
}

function openHapusModal(id) {
    const modal = document.getElementById('modalHapusPengaduan');
    const form = document.getElementById('formHapusPengaduan');
    form.action = '/pengaduan/' + id;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function openUbahModal(id, isi, fotoData) {
    const modal = document.getElementById('modalUbahPengaduan');
    const form = document.getElementById('formUbahPengaduan');
    const inputIsi = document.getElementById('editIsiPengaduan');
    const containerFoto = document.getElementById('containerFotoLama');
    const listFoto = document.getElementById('listFotoLama');
    
    form.action = '/pengaduan/' + id;
    inputIsi.value = isi;
    
    let fotoList = [];
    if (fotoData) {
        fotoList = JSON.parse(fotoData);
    }
    
    if (fotoList.length > 0) {
        containerFoto.classList.remove('hidden');
        listFoto.innerHTML = '';
        fotoList.forEach(foto => {
            const label = document.createElement('label');
            label.className = 'cursor-pointer relative block';
            label.innerHTML = `
                <input type="checkbox" name="delete_foto[]" value="${foto.id_foto_pengaduan}" class="peer hidden">
                <img src="/storage/${foto.foto_pengaduan}" class="w-16 h-16 object-cover rounded-lg border-2 border-transparent peer-checked:border-[#A33215] peer-checked:opacity-50 transition-all">
                <div class="absolute inset-0 bg-[#A33215]/20 text-[#A33215] flex items-center justify-center rounded-lg opacity-0 peer-checked:opacity-100 transition-all">
                    <span class="font-black text-2xl">✕</span>
                </div>
            `;
            listFoto.appendChild(label);
        });
    } else {
        containerFoto.classList.add('hidden');
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Auto hide alert success
document.addEventListener('DOMContentLoaded', function() {
    const alertSuccess = document.getElementById('alertSuccess');
    if (alertSuccess) {
        setTimeout(() => {
            alertSuccess.style.opacity = '0';
            setTimeout(() => {
                alertSuccess.style.display = 'none';
            }, 500); // Wait for transition
        }, 3000); // Hide after 3 seconds
    }
});
</script>
@endsection
