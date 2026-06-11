@extends('layouts.app')

@section('title', 'Kelola Role & Hak Akses')

@section('content')

@php $user = auth()->user(); @endphp

<div class="relative overflow-hidden bg-white rounded-3xl p-5 md:p-8 shadow-sm border border-[#FA8145] mb-8">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-center md:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-50 text-[#C54716] text-xs sm:text-sm font-bold uppercase tracking-wider mb-3">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#FA8145] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-[#FA8145]"></span>
                </span>
                Keamanan & Kontrol Akses
            </div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#A33215] leading-tight uppercase tracking-tight">
                Manajemen Role <span class="text-gray-300 mx-1">&</span> Akses
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium max-w-md">
                Konfigurasi tingkat keamanan dan izin akses fitur untuk efisiensi operasional padukuhan.
            </p>
        </div>

        <div class="bg-gray-100/80 p-1.5 rounded-2xl flex gap-1 border border-gray-200 shadow-inner w-full md:w-auto overflow-x-auto no-scrollbar">
            @if($user->hasAkses('kelola_role'))
                <button onclick="switchTab('role')" id="tab-role" 
                    class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all
                    {{ $user->hasAkses('kelola_role') ? 'bg-white text-[#C54716] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Daftar Role
                </button>
            @endif

            @if($user->hasAkses('kelola_role_akses'))
                <button onclick="switchTab('akses')" id="tab-akses" 
                    class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all
                    {{ !$user->hasAkses('kelola_role') && $user->hasAkses('kelola_role_akses') ? 'bg-white text-[#C54716] shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                    Hak Akses
                </button>
            @endif
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

@if(session('error'))
<div id="alertError" class="bg-white border-l-4 border-[#A33215] p-4 rounded-2xl shadow-sm mb-8 flex justify-between items-center animate-fade-in-down">
    <div class="flex items-center gap-3 text-[#A33215]">
        <span class="font-bold text-xs uppercase tracking-tight">{{ session('error') }}</span>
    </div>
    <button onclick="this.parentElement.remove()" class="text-gray-300 hover:text-gray-500 text-lg">✕</button>
</div>
@endif

<div class="relative">
    
    @if($user->hasAkses('kelola_role'))
    <div id="panel-role" class="space-y-6 {{ $user->hasAkses('kelola_role') ? 'animate-fade-in' : 'hidden' }}">
        <div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
                    <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Daftar Role Aktif</h2>
                </div>
                <button onclick="openTambahRoleModal()" 
                    class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#A33215] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-orange-100">
                    + Tambah Role
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="py-4 px-4 md:px-8 text-xs sm:text-sm font-semibold text-gray-900 uppercase tracking-wider border-r border-gray-300">ID</th>
                            <th class="py-4 px-4 md:px-8 text-xs sm:text-sm font-semibold text-gray-900 uppercase tracking-wider border-r border-gray-300">Nama Role</th>
                            <th class="py-4 px-4 md:px-8 text-xs sm:text-sm font-semibold text-gray-900 uppercase tracking-wider text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($roles as $item)
                        <tr class="hover:bg-orange-50/30 transition-colors group">
                            <td class="py-5 px-4 md:px-8 text-xs sm:text-sm font-medium text-gray-900 border-r border-gray-200">#{{ $item->id_role }}</td>
                            <td class="py-5 px-4 md:px-8 border-r border-gray-200">
                                <span class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs sm:text-sm font-semibold text-gray-700 group-hover:border-orange-200 transition-all uppercase tracking-wide">
                                    {{ $item->nama_role }}
                                </span>
                            </td>
                            <td class="py-5 px-4 md:px-8">
                                <div class="flex justify-center gap-3">
                                    <button onclick="editRole('{{ $item->id_role }}', '{{ $item->nama_role }}')" 
                                        class="bg-[#C54716] text-white px-4 py-1.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#E75C16] transition-all shadow-sm shadow-orange-100">
                                        Ubah
                                    </button>
                                    <button onclick="deleteRole('{{ $item->id_role }}', '{{ $item->nama_role }}')" 
                                        class="bg-orange-50 text-[#A33215] px-4 py-1.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-orange-100 transition-all border border-orange-100">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-20 text-center">
                                <p class="text-gray-400 text-xs font-bold uppercase tracking-widest">Belum ada role terdaftar</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @if($user->hasAkses('kelola_role_akses'))
    <div id="panel-akses" class="space-y-6 {{ !$user->hasAkses('kelola_role') && $user->hasAkses('kelola_role_akses') ? 'animate-fade-in' : 'hidden' }}">
        <div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
                    <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Daftar Hak Akses</h2>
                </div>
                <div class="relative w-full sm:w-80">
                    <input type="text" id="searchAkses" oninput="filterAkses()" 
                        placeholder="Cari nama akses atau nama role..." 
                        class="w-full pl-10 pr-4 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all text-gray-700 placeholder:text-gray-400" autocomplete="off">
                    <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
            
            <div class="px-6 pb-6 pt-3 space-y-4">
                @forelse($permissions as $perm)
                <div class="perm-card bg-orange-50/20 rounded-2xl border border-orange-200/60 shadow-sm overflow-hidden group hover:border-[#FA8145] hover:bg-orange-50/40 transition-all" 
                     data-nama="{{ strtolower($perm->nama_akses) }}" 
                     data-roles="{{ strtolower($perm->role->pluck('nama_role')->implode(',')) }}">
                    <button onclick="toggleAccordion('perm-{{ $perm->id_akses }}')" 
                        class="w-full p-4 md:p-6 flex justify-between items-center hover:bg-orange-50/50 transition-all text-left gap-3">
                        <div class="flex items-center gap-4">
                            <div>
                                <span class="text-xs sm:text-sm font-semibold text-[#FA8145] uppercase tracking-widest">Identitas Izin</span>
                                <h3 class="text-sm sm:text-base font-bold text-gray-800 uppercase tracking-tight">{{ $perm->nama_akses }}</h3>
                                @if($perm->deskripsi_akses)
                                    <p class="text-xs sm:text-sm font-medium text-gray-400 italic mt-0.5">{{ $perm->deskripsi_akses }}</p>
                                @endif
                            </div>
                        </div>
                        <div id="icon-perm-{{ $perm->id_akses }}" class="w-8 h-8 rounded-full border-2 border-gray-100 flex items-center justify-center text-gray-400 transition-all duration-500 ease-in-out">
                            <span class="transform transition-transform duration-500">▼</span>
                        </div>
                    </button>

                    <div id="content-perm-{{ $perm->id_akses }}" class="hidden border-t border-orange-100 bg-white">
                        <div class="p-4 md:p-6">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs sm:text-sm font-bold text-gray-900 uppercase tracking-wider">Role Terkait:</span>
                                <button onclick="openAssignModal('{{ $perm->id_akses }}', '{{ $perm->nama_akses }}')" 
                                    class="text-xs sm:text-sm font-bold text-[#C54716] uppercase tracking-wider hover:underline flex items-center gap-1 bg-orange-50 px-3 py-1 rounded-lg transition-all">
                                    <span>+</span> Hubungkan Role
                                </button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @forelse($perm->role as $role)
                                    <div class="group/role relative">
                                        <span class="pl-4 pr-10 py-2.5 bg-white border border-orange-200 rounded-xl text-xs sm:text-sm font-semibold text-[#A33215] shadow-sm uppercase tracking-wide flex items-center gap-2">
                                            {{ $role->nama_role }}
                                        </span>
                                        <button type="button" 
                                            onclick="openRevokeModal('{{ route('role.akses.revoke', [$role->id_role, $perm->id_akses]) }}', '{{ $role->nama_role }}', '{{ $perm->nama_akses }}')"
                                            class="absolute right-2 top-1/2 -translate-y-1/2 w-5 h-5 rounded-full bg-orange-50 text-[#A33215] flex items-center justify-center text-[10px] hover:bg-[#A33215] hover:text-white transition-all shadow-sm" 
                                            title="Cabut Akses">
                                            ✕
                                        </button>
                                    </div>
                                @empty
                                    <span class="text-xs text-gray-400 italic font-medium py-2">Belum ada role yang diberikan izin ini.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-3xl p-20 text-center border-2 border-dashed border-gray-100">
                    <p class="text-gray-300 font-bold uppercase tracking-wider text-xs">Hak Akses Tidak Ditemukan</p>
                </div>
                @endforelse

                <div id="empty-search-result" class="hidden bg-white rounded-3xl p-20 text-center border-2 border-dashed border-gray-100">
                    <p class="text-gray-400 font-bold uppercase tracking-wider text-sm sm:text-base">Hasil tidak ditemukan</p>
                    <p class="text-xs sm:text-sm text-gray-400 mt-2 font-medium uppercase tracking-widest">Coba gunakan kata kunci lain</p>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

<div id="modalRole" class="fixed inset-0 bg-black/50 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
        <div class="px-6 py-4 border-b-[3px] border-gray-200 flex justify-between items-center bg-white">
            <div>
                <h2 id="modalTitle" class="text-xl font-bold text-gray-900 uppercase tracking-tight">Tambah Role</h2>
                <p class="text-xs sm:text-sm font-medium text-gray-400 uppercase tracking-wider mb-2">Konfigurasi Peran Baru</p>
                <p class="text-[10px] text-[#E75C16] uppercase tracking-widest font-bold">
                    <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
                </p>
            </div>
            <button onclick="closeModal('modalRole')" class="bg-white w-10 h-10 rounded-full shadow-sm flex items-center justify-center text-gray-400 hover:text-black hover:rotate-90 transition-all text-base font-bold">✕</button>
        </div>
        <form action="{{ route('role.store') }}" method="POST" class="px-6 py-4 pt-1 space-y-4">
            @csrf
            <div id="methodField"></div>
            <div>
                <label class="text-sm sm:text-base font-semibold text-gray-700 ml-1">Nama Peran</label>
                <input type="text" id="role_name" name="nama_role" 
                    class="w-full bg-gray-50 border-2 border-transparent p-3.5 rounded-xl mt-1 focus:bg-white focus:border-[#C54716] transition-all font-semibold text-sm sm:text-base text-gray-700" 
                    placeholder="Contoh: BENDAHARA" required>
            </div>
            <div class="flex gap-3 pt-5 border-t-[3px] border-gray-200">
                <button type="button" onclick="closeModal('modalRole')" 
                    class="flex-1 py-3.5 bg-gray-100 text-gray-500 font-bold rounded-xl text-xs sm:text-sm uppercase tracking-wider hover:bg-gray-200 transition-all">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-2 px-8 py-3.5 bg-[#C54716] text-white rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] transition-all shadow-lg shadow-orange-200">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalAssignRole" class="fixed inset-0 bg-black/50 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl overflow-hidden animate-zoom-in">
        <div class="px-6 py-4 border-b-[3px] border-gray-200 flex justify-between items-center bg-white">
            <div>
                <h2 class="text-xl font-bold text-gray-900 uppercase tracking-tight">Hubungkan Role</h2>
                <p id="assignModalSub" class="text-xs sm:text-sm font-medium text-gray-400 uppercase tracking-wider mb-2"></p>
                <p class="text-[10px] text-[#E75C16] uppercase tracking-widest font-bold">
                    <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
                </p>
            </div>
            <button onclick="closeModal('modalAssignRole')" class="bg-white w-10 h-10 rounded-full shadow-sm flex items-center justify-center text-gray-400 hover:text-black transition-all text-base font-bold">✕</button>
        </div>
        <form action="{{ route('role.akses.assign') }}" method="POST" class="px-6 py-4 pt-1 space-y-4">
            @csrf
            <input type="hidden" name="id_akses" id="assign_id_akses">
            <div>
                <label class="text-sm sm:text-base font-semibold text-gray-700 ml-1">Pilih Role</label>
                <select name="id_role" class="w-full bg-gray-50 border-2 border-transparent p-3.5 rounded-xl mt-1 focus:bg-white focus:border-[#C54716] transition-all font-semibold text-sm sm:text-base text-gray-700" required>
                    <option value="" disabled selected>Pilih salah satu...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id_role }}">{{ $role->nama_role }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-5 border-t-[3px] border-gray-200">
                <button type="button" onclick="closeModal('modalAssignRole')" 
                    class="flex-1 py-3.5 bg-gray-100 text-gray-500 font-bold rounded-xl text-xs sm:text-sm uppercase tracking-wider hover:bg-gray-200 transition-all">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-2 px-8 py-3.5 bg-[#C54716] text-white rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#A33215] transition-all shadow-lg shadow-orange-200">
                    Berikan Akses
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalDeleteRole" class="fixed inset-0 bg-black/50 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-7 rounded-2xl text-center w-full max-w-sm shadow-2xl animate-zoom-in">
        <h3 class="text-xl font-bold text-gray-900 mb-4 uppercase tracking-tight">Hapus Role?</h3>
        <p id="deleteText" class="text-xs sm:text-sm text-gray-500 mb-6 font-medium leading-relaxed uppercase tracking-wide"></p>
        <div class="flex gap-3">
            <button type="button" onclick="closeModal('modalDeleteRole')" 
                class="flex-1 py-3.5 bg-gray-100 text-gray-500 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-gray-200 transition-all">
                Batal
            </button>
            <form action="#" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" 
                    class="w-full py-3.5 bg-[#A33215] text-white rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#69200F] transition-all shadow-lg shadow-orange-200">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div id="modalRevokeAkses" class="fixed inset-0 bg-black/50 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-7 rounded-2xl text-center w-full max-w-sm shadow-2xl animate-zoom-in">
        <h3 class="text-xl font-bold text-gray-900 mb-4 uppercase tracking-tight">Cabut Akses?</h3>
        <p id="revokeText" class="text-xs sm:text-sm text-gray-500 mb-6 font-medium leading-relaxed uppercase tracking-wide"></p>
        <div class="flex gap-3">
            <button type="button" onclick="closeModal('modalRevokeAkses')" 
                class="flex-1 py-3.5 bg-gray-100 text-gray-500 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-gray-200 transition-all">
                Batal
            </button>
            <form id="formRevoke" action="#" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit" 
                    class="w-full py-3.5 bg-[#A33215] text-white rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#69200F] transition-all shadow-lg shadow-orange-200">
                    Ya, Cabut
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<style>
    @keyframes fade-in { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes fade-in-down { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes zoom-in { from { opacity: 0; scale: 0.95; } to { opacity: 1; scale: 1; } }
    @keyframes bounce-in { 0% { scale: 0.8; opacity: 0; } 70% { scale: 1.05; } 100% { scale: 1; opacity: 1; } }
    .animate-fade-in { animation: fade-in 0.4s ease-out forwards; }
    .animate-fade-in-down { animation: fade-in-down 0.5s ease-out forwards; }
    .animate-zoom-in { animation: zoom-in 0.3s ease-out forwards; }
    .animate-bounce-in { animation: bounce-in 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; }
</style>

<script>
function switchTab(tab) {
    sessionStorage.setItem('activeRoleAksesTab', tab);
    const panels = ['role', 'akses'];
    panels.forEach(p => {
        const el = document.getElementById('panel-' + p);
        const btn = document.getElementById('tab-' + p);
        if(el) el.classList.add('hidden');
        if(btn) {
            btn.classList.remove('bg-white', 'text-[#C54716]', 'shadow-sm');
            btn.classList.add('text-gray-500', 'hover:text-gray-700');
        }
    });

    const activePanel = document.getElementById('panel-' + tab);
    const activeBtn = document.getElementById('tab-' + tab);
    if(activePanel) activePanel.classList.remove('hidden');
    if(activeBtn) {
        activeBtn.classList.add('bg-white', 'text-[#C54716]', 'shadow-sm');
        activeBtn.classList.remove('text-gray-500', 'hover:text-gray-700');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const isReloadOrBack = (
        performance.getEntriesByType('navigation')[0]?.type === 'reload' ||
        document.referrer.split('?')[0] === window.location.href.split('?')[0]
    );

    if (isReloadOrBack) {
        const savedTab = sessionStorage.getItem('activeRoleAksesTab');
        if (savedTab) {
            switchTab(savedTab);
        }
        
        const savedAccordionId = sessionStorage.getItem('activeAccordionId');
        const savedScrollY = sessionStorage.getItem('roleAksesScrollY');

        if (savedAccordionId) {
            // Open accordion first to restore DOM layout height
            toggleAccordion(savedAccordionId);
            
            // Then immediately scroll to captured position
            if (savedScrollY !== null) {
                window.scrollTo(0, parseInt(savedScrollY, 10));
            }
            sessionStorage.removeItem('activeAccordionId');
            sessionStorage.removeItem('roleAksesScrollY');
        } else if (savedScrollY !== null) {
            window.scrollTo(0, parseInt(savedScrollY, 10));
            sessionStorage.removeItem('roleAksesScrollY');
        }
    } else {
        sessionStorage.removeItem('activeRoleAksesTab');
        sessionStorage.removeItem('activeAccordionId');
        sessionStorage.removeItem('roleAksesScrollY');
    }

    // Capture submit events on forms to restore tab/scroll/accordion state
    const modalRoleForm = document.getElementById('modalRole')?.querySelector('form');
    if (modalRoleForm) {
        modalRoleForm.addEventListener('submit', function() {
            sessionStorage.setItem('roleAksesScrollY', window.scrollY);
            sessionStorage.setItem('activeRoleAksesTab', 'role');
        });
    }

    const modalDeleteRoleForm = document.getElementById('modalDeleteRole')?.querySelector('form');
    if (modalDeleteRoleForm) {
        modalDeleteRoleForm.addEventListener('submit', function() {
            sessionStorage.setItem('roleAksesScrollY', window.scrollY);
            sessionStorage.setItem('activeRoleAksesTab', 'role');
        });
    }

    const modalAssignRoleForm = document.getElementById('modalAssignRole')?.querySelector('form');
    if (modalAssignRoleForm) {
        modalAssignRoleForm.addEventListener('submit', function() {
            sessionStorage.setItem('activeAccordionId', 'perm-' + document.getElementById('assign_id_akses').value);
            sessionStorage.setItem('roleAksesScrollY', window.scrollY);
            sessionStorage.setItem('activeRoleAksesTab', 'akses');
        });
    }

    const formRevoke = document.getElementById('formRevoke');
    if (formRevoke) {
        formRevoke.addEventListener('submit', function() {
            const action = this.action;
            const parts = action.split('/');
            const idAkses = parts[parts.length - 1];
            sessionStorage.setItem('activeAccordionId', 'perm-' + idAkses);
            sessionStorage.setItem('roleAksesScrollY', window.scrollY);
            sessionStorage.setItem('activeRoleAksesTab', 'akses');
        });
    }
});

function openModal(id) {
    document.getElementById(id).classList.remove('hidden');
}

function openTambahRoleModal() {
    document.getElementById('modalTitle').innerText = 'Tambah Role';
    document.getElementById('role_name').value = '';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('modalRole').querySelector('form').action = '{{ route("role.store") }}';
    openModal('modalRole');
}

function openAssignModal(idAkses, namaAkses) {
    document.getElementById('assign_id_akses').value = idAkses;
    document.getElementById('assignModalSub').innerText = 'Izin: ' + namaAkses;
    openModal('modalAssignRole');
}

function closeModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function editRole(id, name) {
    document.getElementById('modalTitle').innerText = 'Ubah Role';
    document.getElementById('role_name').value = name;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('modalRole').querySelector('form').action = '/role/' + id;
    openModal('modalRole');
}

function deleteRole(id, name) {
    document.getElementById('deleteText').innerText = 'Konfirmasi penghapusan role "' + name + '"?';
    document.getElementById('modalDeleteRole').querySelector('form').action = '/role/' + id;
    openModal('modalDeleteRole');
}

function openRevokeModal(url, roleName, accessName) {
    document.getElementById('revokeText').innerText = 'Apakah Anda yakin ingin mencabut akses "' + accessName + '" dari role "' + roleName + '"?';
    document.getElementById('formRevoke').action = url;
    openModal('modalRevokeAkses');
}

function toggleAccordion(id) {
    const content = document.getElementById('content-' + id);
    const iconContainer = document.getElementById('icon-' + id);
    const icon = iconContainer.querySelector('span');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        content.classList.add('animate-fade-in');
        icon.style.transform = 'rotate(180deg)';
        iconContainer.classList.add('border-orange-200', 'text-[#C54716]', 'bg-orange-50');
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
        iconContainer.classList.remove('border-orange-200', 'text-[#C54716]', 'bg-orange-50');
    }
}

function filterAkses() {
    const query = document.getElementById('searchAkses').value.toLowerCase();
    const cards = document.querySelectorAll('.perm-card');
    let hasResult = false;

    cards.forEach(card => {
        const name = card.getAttribute('data-nama');
        const roles = card.getAttribute('data-roles');

        if (name.includes(query) || roles.includes(query)) {
            card.classList.remove('hidden');
            hasResult = true;
        } else {
            card.classList.add('hidden');
        }
    });

    const emptyMsg = document.getElementById('empty-search-result');
    if (hasResult || query === '') {
        emptyMsg.classList.add('hidden');
    } else {
        emptyMsg.classList.remove('hidden');
    }
}

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
}, 4000);
</script>
@endpush
