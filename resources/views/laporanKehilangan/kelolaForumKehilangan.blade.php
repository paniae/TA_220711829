@extends('layouts.app')

@section('title', 'Laporan Kehilangan')

@section('content')

<div class="bg-white rounded-2xl p-5 shadow-sm border border-[#FA8145] mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
    <div class="text-center md:text-left">
        <h1 class="text-xl font-bold text-[#A33215] leading-tight">
            Laporan Kehilangan
        </h1>
        <p class="text-sm text-gray-500 mt-0.5">
            Laporkan barang hilang atau temukan informasi dari warga lain.
        </p>
    </div>
    @auth
    <button onclick="openModal('modalLaporan')"
        class="w-full md:w-auto bg-[#C54716] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-[#A33215] transition-all active:scale-95 flex items-center justify-center gap-2 text-sm shadow-lg shadow-orange-100">
        <span>+</span> Buat Laporan
    </button>
    @endauth
</div>

@if(session('success'))
<div id="alertSuccess"
     class="bg-orange-50 border border-[#FA8145]/40 text-[#C54716] p-4 rounded-xl mb-6 flex justify-between items-center shadow-sm">
    <div class="flex items-center gap-3">
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    <span class="text-xs opacity-50">{{ now()->format('H:i') }}</span>
</div>
@endif

<div class="bg-white rounded-2xl p-6 shadow-sm border border-[#FA8145]">
    <div class="mb-6 pb-6 border-b border-gray-200">
        <p class="text-xs text-gray-500 font-bold mb-3 uppercase tracking-wider">
            Statistik berdasarkan laporan semua warga
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div id="statCard_all" onclick="setForumFilter('all')" class="p-5 rounded-2xl border shadow-sm hover:shadow-md transition-all cursor-pointer active:scale-95 bg-white border-gray-200">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Laporan</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $laporan->count() }}</p>
            </div>

            <div id="statCard_all_hilang" onclick="setForumFilter('all_hilang')" class="p-5 rounded-2xl border shadow-sm hover:shadow-md transition-all cursor-pointer active:scale-95 bg-white border-gray-200">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Barang Hilang</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $laporan->where('status_kehilangan', 'hilang')->count() }}</p>
            </div>

            <div id="statCard_all_found" onclick="setForumFilter('all_found')" class="p-5 rounded-2xl border shadow-sm hover:shadow-md transition-all cursor-pointer active:scale-95 bg-white border-gray-200">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Sudah Ditemukan</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $laporan->where('status_kehilangan', 'ditemukan')->count() }}</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-200">
    <div class="flex items-center gap-2.5">
        <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
        <h2 class="text-lg font-bold text-gray-900 tracking-tight">Daftar Laporan Kehilangan</h2>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full sm:w-auto">
        <div class="relative w-full sm:w-96">
            <input type="text" id="forumSearch" placeholder="Cari barang, lokasi, atau tanggal hilang" 
                class="w-full pl-10 pr-4 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all" autocomplete="off">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <div class="flex items-center gap-2 w-full sm:w-auto">
            <span class="text-sm font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Filter:</span>
            <select id="forumFilter" class="w-full sm:w-auto px-4 py-2 border-2 border-gray-100 rounded-xl focus:border-[#C54716] transition-all font-bold text-sm outline-none text-gray-600 bg-gray-50/50 cursor-pointer">
                <option value="all">Semua Laporan</option>
                <option value="all_hilang" selected>Semua Laporan Hilang</option>
                <option value="all_found">Semua Laporan Ditemukan</option>
                @auth
                <option value="my_all">Semua Laporan Saya</option>
                <option value="my_lost">Laporan Saya Hilang</option>
                <option value="my_found">Laporan Saya Ditemukan</option>
                @endauth
            </select>
        </div>
    </div>
</div>
<div id="reports-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
    @include('laporanKehilangan.laporanList')
</div></div>

@auth
<div id="modalLaporan" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-6 border-b bg-gray-50/50 relative">
            <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight w-11/12">Buat Laporan Kehilangan</h2>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
            <button onclick="closeModal('modalLaporan')" class="absolute top-6 right-6 text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold leading-none">✕</button>
        </div>
        <form action="{{ route('kehilangan.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Nama Barang <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="barang_hilang" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all font-medium text-sm outline-none" placeholder="Contoh: Kunci Motor Honda" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Tanggal Hilang <span class="text-[#A33215]">*</span></label>
                    <input type="date" name="tanggal_hilang" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all text-sm outline-none" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Lokasi Terakhir / Hilang <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="lokasi_hilang" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all font-medium text-sm outline-none" placeholder="Contoh: Depan Balai Padukuhan Bruno II" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Kronologi Kehilangan (Opsional)</label>
                    <textarea name="deskripsi_laporan" rows="3" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all font-medium text-sm outline-none placeholder:text-gray-300 resize-none" placeholder="Jelaskan kronologi kejadian kehilangan barang Anda..."></textarea>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Foto Barang (Opsional)</label>
                    <input type="file" name="foto_barang" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-orange-50 file:text-[#C54716] hover:file:bg-orange-100">
                </div>
            </div>
            <div class="p-4 border-t bg-gray-50 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalLaporan')" class="px-5 py-2 text-[#7F1911] font-bold hover:bg-gray-100 rounded-lg text-xs uppercase tracking-widest">Batal</button>
                <button type="submit" class="px-8 py-2 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all text-xs shadow-lg shadow-orange-100 uppercase tracking-widest">Simpan Laporan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditLaporan" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col overflow-hidden max-h-[90vh]">
        <div class="p-6 border-b bg-gray-50/50 relative">
            <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight w-11/12">Ubah Laporan Kehilangan</h2>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
            <button onclick="closeModal('modalEditLaporan')" class="absolute top-6 right-6 text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold leading-none">✕</button>
        </div>
        <form id="formEditLaporan" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Nama Barang <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="edit_barang_hilang" name="barang_hilang" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all font-medium text-sm outline-none" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Tanggal Hilang <span class="text-[#A33215]">*</span></label>
                    <input type="date" id="edit_tanggal_hilang" name="tanggal_hilang" max="{{ date('Y-m-d') }}" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all text-sm outline-none" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Lokasi Terakhir / Hilang <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="edit_lokasi_hilang" name="lokasi_hilang" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all font-medium text-sm outline-none" required>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Kronologi Kehilangan (Opsional)</label>
                    <textarea id="edit_deskripsi_laporan" name="deskripsi_laporan" rows="3" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all font-medium text-sm outline-none placeholder:text-gray-300 resize-none" placeholder="Jelaskan kronologi kejadian kehilangan barang Anda..."></textarea>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Status Laporan <span class="text-[#A33215]">*</span></label>
                    <select id="edit_status_kehilangan" name="status_kehilangan" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 focus:border-[#C54716] transition-all font-bold text-sm outline-none bg-white cursor-pointer" required>
                        <option value="hilang">Hilang</option>
                        <option value="ditemukan">Ditemukan</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wide">Ganti Foto Barang (Opsional)</label>
                    <input type="file" name="foto_barang" class="w-full border-2 border-gray-100 p-2.5 rounded-xl mt-1 file:mr-4 file:py-1 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-bold file:bg-orange-50 file:text-[#C54716] hover:file:bg-orange-100">
                </div>
            </div>
            <div class="p-4 border-t bg-gray-50 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalEditLaporan')" class="px-5 py-2 text-[#7F1911] font-bold hover:bg-gray-100 rounded-lg text-xs uppercase tracking-widest">Batal</button>
                <button type="submit" class="px-8 py-2 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all text-xs shadow-lg shadow-orange-100 uppercase tracking-widest">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalHapusLaporan" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145] relative animate-fade-in">
        <h3 class="text-xl font-bold text-[#69200F] mb-3 uppercase tracking-tight">Hapus Laporan?</h3>
        <p class="text-sm text-gray-500 mb-8 font-medium">Laporan kehilangan Anda akan dihapus secara permanen beserta semua diskusinya.</p>
        <form id="formHapusLaporan" method="POST" class="flex gap-3 justify-center">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModal('modalHapusLaporan')" class="flex-1 px-4 py-3 bg-gray-100 text-[#7F1911] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="flex-1 px-4 py-3 bg-[#7F1911] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#5A120C] transition-all shadow-lg shadow-orange-100">Ya, Hapus</button>
        </form>
    </div>
</div>
@endauth

@endsection

@push('scripts')
<script>
function openModal(id){
    document.getElementById(id).classList.remove('hidden');
}

function closeModal(id){
    document.getElementById(id).classList.add('hidden');
}

function openEditLaporanModal(id, barang, tanggal, lokasi, deskripsi, status) {
    const form = document.getElementById('formEditLaporan');
    form.action = `/kehilangan/${id}`;
    document.getElementById('edit_barang_hilang').value = barang;
    document.getElementById('edit_tanggal_hilang').value = tanggal;
    document.getElementById('edit_lokasi_hilang').value = lokasi;
    document.getElementById('edit_deskripsi_laporan').value = deskripsi;
    document.getElementById('edit_status_kehilangan').value = status;
    openModal('modalEditLaporan');
}

function openDeleteLaporanModal(id) {
    const form = document.getElementById('formHapusLaporan');
    form.action = `/kehilangan/${id}`;
    openModal('modalHapusLaporan');
}

// Filter & Search functionality
function setForumFilter(value) {
    const filterSelect = document.getElementById('forumFilter');
    if (filterSelect) {
        filterSelect.value = value;
        applyForumFilter();
    }
    updateStatCardHighlight(value);
}

function updateStatCardHighlight(activeValue) {
    const cardKeys = ['all', 'all_hilang', 'all_found'];
    const activeClasses = ['bg-orange-50/40', 'border-[#FA8145]', 'ring-1', 'ring-[#C54716]'];
    const inactiveClasses = ['bg-white', 'border-gray-200'];

    cardKeys.forEach(key => {
        const card = document.getElementById('statCard_' + key);
        if (!card) return;
        if (key === activeValue) {
            inactiveClasses.forEach(c => card.classList.remove(c));
            activeClasses.forEach(c => card.classList.add(c));
        } else {
            activeClasses.forEach(c => card.classList.remove(c));
            inactiveClasses.forEach(c => card.classList.add(c));
        }
    });
}

function applyForumFilter(){
    const filter = document.getElementById('forumFilter').value;
    const query = document.getElementById('forumSearch').value.toLowerCase().trim();
    const cards = document.querySelectorAll('.group[data-search]');
    const currentUserId = '{{ auth()->id() ?? 0 }}';
    
    cards.forEach(card => {
        const ownerId = card.dataset.ownerId;
        const status = card.dataset.status;
        const searchText = card.dataset.search || '';
        
        let matchesFilter = false;
        if(filter === 'all'){
            matchesFilter = true;
        } else if(filter === 'all_hilang'){
            matchesFilter = (status === 'hilang');
        } else if(filter === 'all_found'){
            matchesFilter = (status === 'ditemukan');
        } else if(filter === 'my_all'){
            matchesFilter = (ownerId == currentUserId);
        } else if(filter === 'my_lost'){
            matchesFilter = (ownerId == currentUserId && status === 'hilang');
        } else if(filter === 'my_found'){
            matchesFilter = (ownerId == currentUserId && status === 'ditemukan');
        }
        
        const matchesSearch = query === '' || searchText.includes(query);
        
        card.style.display = (matchesFilter && matchesSearch) ? '' : 'none';
    });
}

// Auto hide alert & AJAX polling
document.addEventListener('DOMContentLoaded', function () {
    const alert = document.getElementById('alertSuccess');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    }
    const filterSelect = document.getElementById('forumFilter');
    if(filterSelect){
        filterSelect.addEventListener('change', applyForumFilter);
    }
    const searchInput = document.getElementById('forumSearch');
    if(searchInput){
        searchInput.addEventListener('input', applyForumFilter);
    }
    
    // Apply initial filter
    applyForumFilter();
    const initialFilter = document.getElementById('forumFilter');
    if (initialFilter) updateStatCardHighlight(initialFilter.value);

    // AJAX Polling for reports
    function pollReports() {
        fetch('{{ route("kehilangan.laporanListPoll") }}')
            .then(response => response.text())
            .then(html => {
                const container = document.getElementById('reports-grid');
                if (container) {
                    container.innerHTML = html;
                    // Immediately re-apply search & filter queries
                    applyForumFilter();
                }
            })
            .catch(err => console.error('Error polling reports:', err));
    }
    // Poll every 5 seconds
    setInterval(pollReports, 5000);
});
</script>
@endpush
