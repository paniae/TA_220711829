@extends('layouts.app')

@section('title', 'Detail Laporan & Komentar')

@section('content')

<div class="flex mb-6">
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('kehilangan.index') }}" class="inline-flex items-center justify-center gap-2 bg-white border-2 border-gray-100 text-gray-500 px-5 py-2 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:border-[#FA8145] hover:text-[#A33215] hover:bg-orange-50 transition-all shadow-sm active:scale-95">
        Kembali
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-[#FA8145] overflow-hidden mb-8">
    <div class="p-6">
        <div class="flex flex-col md:flex-row gap-6">
            <div class="w-full md:w-64 h-64 bg-gray-50 rounded-2xl overflow-hidden border-2 border-gray-100 flex-shrink-0">
                @if($laporan->foto_barang)
                    <img src="{{ asset('storage/'.$laporan->foto_barang) }}" class="w-full h-full object-cover cursor-pointer" onclick="openImageModal('{{ asset('storage/'.$laporan->foto_barang) }}')">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center opacity-20">
                        <p class="text-xs font-bold mt-2 uppercase tracking-widest text-gray-500">Tanpa Foto</p>
                    </div>
                @endif
            </div>

            <div class="flex-1 space-y-4">
                <div class="flex justify-between items-start">
                    <span class="px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider border 
                        {{ $laporan->status_kehilangan == 'hilang' ? 'bg-orange-50 text-[#A33215] border-orange-200' : 'bg-orange-50 text-[#C54716] border-orange-100' }}">
                        {{ $laporan->status_kehilangan == 'hilang' ? 'Barang Hilang' : 'Barang Ditemukan' }}
                    </span>
                    <span class="text-xs font-bold text-gray-500 uppercase">
                        ID: #{{ $laporan->id_laporan }}
                    </span>
                </div>

                <h1 class="text-xl font-bold text-gray-900 leading-tight">
                    {{ $laporan->barang_hilang }}
                </h1>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Tanggal Kejadian</p>
                        <p class="text-base font-bold text-gray-700">{{ \Carbon\Carbon::parse($laporan->tanggal_hilang)->translatedFormat('l, d F Y') }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Lokasi Terakhir</p>
                        <p class="text-base font-bold text-gray-700">{{ $laporan->lokasi_hilang }}</p>
                    </div>
                </div>

                @if($laporan->deskripsi_laporan)
                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Kronologi Kehilangan</p>
                    <p class="text-base text-gray-700 font-medium leading-relaxed">{{ $laporan->deskripsi_laporan }}</p>
                </div>
                @endif

                <div class="pt-4 border-t">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">Informasi Pelapor</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200 overflow-hidden shadow-sm">
                                @if($laporan->pengguna && $laporan->pengguna->foto_profil)
                                    <img src="{{ asset('storage/'.$laporan->pengguna->foto_profil) }}" class="w-full h-full object-cover cursor-pointer hover:opacity-80 transition-all" onclick="openImageModal('{{ asset('storage/'.$laporan->pengguna->foto_profil) }}')">
                                @else
                                    <img src="{{ asset('images/user.jpg') }}" class="w-full h-full object-cover cursor-pointer hover:opacity-80 transition-all" onclick="openImageModal('{{ asset('images/user.jpg') }}')">
                                @endif
                            </div>
                            <p class="text-base font-bold text-gray-800">{{ $laporan->pengguna->nama ?? 'Warga' }}</p>
                        </div>
                        <div class="flex flex-col items-end gap-3.5">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest bg-gray-50 px-3 py-1 rounded-full border">
                                {{ $laporan->komentar->count() }} Komentar
                            </span>
                            @if($laporan->status_kehilangan == 'hilang' && auth()->id() == $laporan->id_pengguna)
                                <button type="button" onclick="openTutupForumModal()" class="bg-[#C54716] text-white px-5 py-2 rounded-xl text-xs font-bold hover:bg-[#A33215] transition-all shadow-md active:scale-95 uppercase tracking-wide cursor-pointer">
                                    Tutup Forum
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-[#FA8145] p-6 max-w-4xl mx-auto space-y-8 pb-12">
    
    @if($laporan->status_kehilangan == 'hilang')
        @if(auth()->check())
        <div class="space-y-4">
            <h3 class="text-base font-bold text-[#A33215] flex items-center gap-2 uppercase tracking-widest">
                Tambah Komentar Anda
            </h3>
            
            <div class="bg-white rounded-2xl shadow-md border-2 border-[#C54716] p-1 overflow-hidden transition-all focus-within:shadow-xl focus-within:shadow-orange-50">
                <form action="{{ route('kehilangan.storeKomentar', $laporan->id_laporan) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="imagePreviewContainer" class="hidden p-4 bg-gray-50 border-b-2 border-dashed border-gray-100 relative">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Pratinjau Lampiran:</p>
                        <div class="relative inline-block">
                            <img id="imagePreview" src="#" alt="Preview" class="h-32 w-auto rounded-xl border-2 border-white shadow-md object-cover">
                            <button type="button" onclick="clearImage()" class="absolute -top-2 -right-2 bg-[#A33215] text-white w-6 h-6 flex items-center justify-center rounded-full text-xs shadow-lg hover:bg-[#A33215] transition-all">✕</button>
                        </div>
                    </div>

                    <div class="p-3">
                        <p class="text-[9px] font-bold text-[#C54716] uppercase tracking-widest px-3 mb-1">Komentar Warga</p>
                        <textarea name="komentar" rows="3" 
                            class="w-full border-none p-3 focus:ring-0 font-medium text-sm text-gray-700 placeholder:text-gray-300 resize-none" 
                            placeholder="Tuliskan bantuan atau informasi Anda..." required></textarea>
                        
                        <div class="flex justify-between items-center pt-2 border-t border-gray-50">
                            <div class="flex items-center gap-2">
                                <label for="fileInput" class="flex items-center gap-2 bg-gray-50 hover:bg-orange-50 text-gray-500 hover:text-[#C54716] px-3 py-1.5 rounded-lg cursor-pointer transition-all border border-gray-100 font-bold text-[10px]">
                                    <span>Lampirkan Gambar</span>
                                </label>
                                <input type="file" id="fileInput" name="foto_komen" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </div>

                            <button type="submit" class="bg-[#C54716] text-white px-8 py-2 rounded-lg font-bold shadow-lg shadow-orange-100 hover:bg-[#A33215] transition-all text-xs flex items-center gap-2">
                                <span>Kirim Komentar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    @else
        <div class="bg-orange-50 border border-[#FA8145]/40 text-[#C54716] p-4 rounded-xl flex items-center justify-center text-center shadow-sm">
            <span class="font-bold text-sm">Forum ini telah ditutup karena barang sudah ditemukan.</span>
        </div>
    @endif

    <div class="pt-8 border-t space-y-6">
        <div class="flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                Diskusi Forum
            </h3>
            <span id="comments-count-badge" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest bg-gray-50 px-3 py-1 rounded-full border">
                {{ $laporan->komentar->count() }} Pesan
            </span>
        </div>

        @if(session('success'))
        <div id="alertComment" class="bg-orange-50 border border-[#FA8145]/40 text-[#C54716] p-4 rounded-xl flex items-center gap-3 shadow-sm animate-bounce-short">
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
        @endif

        <div id="comments-container" class="space-y-4">
            @include('laporanKehilangan.komentarList', ['isModerator' => false])
        </div>
    </div>
</div>

<div id="modalEdit" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-6 border-b flex justify-between items-center bg-gray-50/50">
            <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight">
                Ubah Komentar
            </h2>
            <button onclick="closeModal('modalEdit')" class="text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold">✕</button>
        </div>
        <form id="formEdit" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf @method('PUT')
            <div class="p-6 space-y-5 flex-1 overflow-y-auto">
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 block">Pesan Anda</label>
                    <textarea id="edit_komentar" name="komentar" rows="4" class="w-full border-2 border-gray-200 p-3 rounded-xl mt-1 focus:border-[#E75C16] transition-all font-medium text-sm text-gray-700" required></textarea>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1 block">Ganti Foto (Opsional)</label>
                    <div class="flex items-center gap-3">
                        <label for="editFileInput" class="bg-orange-50 text-[#E75C16] px-4 py-2 rounded-xl border border-orange-100 font-bold text-[10px] cursor-pointer hover:bg-[#E75C16] hover:text-white transition-all uppercase tracking-wide">
                            Pilih File
                        </label>
                        <input type="file" id="editFileInput" name="foto_komen" class="hidden" accept="image/*">
                        <span id="editFileName" class="text-[9px] text-gray-400 italic">Klik untuk mengganti foto</span>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t bg-gray-50/50 flex justify-end gap-3">
                <button type="submit" class="px-8 py-4 bg-[#C54716] text-white rounded-2xl font-bold hover:bg-[#A33215] transition-all text-xs shadow-xl shadow-orange-100">Simpan Perubahan</button>
                <button type="button" onclick="closeModal('modalEdit')" class="px-5 py-4 text-gray-500 font-bold hover:text-gray-600 transition-all text-xs">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes bounce-short {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }
    .animate-bounce-short {
        animation: bounce-short 1s ease-in-out;
    }
</style>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    const container = document.getElementById('imagePreviewContainer');
    const preview = document.getElementById('imagePreview');
    const fileName = document.getElementById('fileName');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.classList.remove('hidden');
        }
        reader.readAsDataURL(input.files[0]);
        fileName.textContent = input.files[0].name;
    }
}

function clearImage() {
    const input = document.getElementById('fileInput');
    const container = document.getElementById('imagePreviewContainer');
    const fileName = document.getElementById('fileName');
    
    input.value = '';
    container.classList.add('hidden');
    fileName.textContent = 'Pilih file...';
}

function openEditModal(id, text) {
    const form = document.getElementById('formEdit');
    form.action = `/kehilangan/komentar/${id}`;
    document.getElementById('edit_komentar').value = text;
    document.getElementById('modalEdit').classList.remove('hidden');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

document.getElementById('editFileInput')?.addEventListener('change', function(e) {
    const fileName = e.target.files[0]?.name || 'Pilih untuk mengganti foto lama';
    document.getElementById('editFileName').textContent = fileName;
});
</script>
<div id="imageModal" class="fixed inset-0 bg-black/70 hidden z-[999] flex items-center justify-center p-4">
    <div class="relative max-w-lg w-full">
        <button onclick="closeImageModal()" class="absolute -top-2 -right-2 bg-white rounded-full w-8 h-8 flex items-center justify-center text-gray-600 hover:text-black">✕</button>
        <img id="imageModalImg" src="#" class="w-full h-auto rounded-xl shadow-lg">
    </div>
</div>

<div id="modalTutupForum" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm animate-fade-in">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145] relative">
        <h3 class="text-xl font-bold text-[#69200F] mb-3 uppercase tracking-tight">Tutup Forum Kehilangan?</h3>
        <p class="text-sm text-gray-500 mb-8 font-medium">Apakah barang yang hilang sudah ditemukan? Tindakan ini akan menutup forum diskusi secara permanen.</p>
        <form id="formTutupForum" action="{{ route('kehilangan.tutup', $laporan->id_laporan) }}" method="POST" class="flex flex-col gap-3">
            @csrf
            @method('PUT')
            <button type="submit" class="w-full py-4 bg-[#C54716] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] shadow-xl shadow-orange-100 transition-all">Ya, Ditemukan!</button>
            <button type="button" onclick="closeModal('modalTutupForum')" class="w-full py-4 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-gray-600 transition-all">Batal</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const alert = document.getElementById('alertComment');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    }

    // AJAX Polling for comments
    function pollComments() {
        fetch('{{ route("kehilangan.komentarList", $laporan->id_laporan) }}?moderator=0')
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('comments-container');
                if (container) {
                    container.innerHTML = html;
                    
                    // Update count badge
                    const badge = document.getElementById('comments-count-badge');
                    if (badge) {
                        const count = container.querySelectorAll('.group').length;
                        badge.textContent = `${count} Pesan`;
                    }
                }
            })
            .catch(err => console.error('Error polling comments:', err));
    }
    // Poll every 5 seconds
    setInterval(pollComments, 5000);
});

function openImageModal(src) {
    const img = document.getElementById('imageModalImg');
    img.src = src;
    document.getElementById('imageModal').classList.remove('hidden');
}
function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}
function openTutupForumModal() {
    document.getElementById('modalTutupForum').classList.remove('hidden');
}
</script>
@endpush
