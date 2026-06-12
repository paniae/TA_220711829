@extends('layouts.app')

@section('title', 'Kelola Pengguna')

@section('content')

<div class="relative overflow-hidden bg-white rounded-3xl p-5 md:p-8 shadow-sm border border-[#FA8145] mb-6">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-5">
        <div>
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#A33215] leading-tight uppercase tracking-tight">
                Kelola Pengguna
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1 font-medium">
                Kelola pendaftaran warga baru dan tambah akun perangkat padukuhan.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full md:w-auto">
            <div class="bg-gray-100/80 p-1.5 rounded-2xl flex gap-1 border border-gray-200 shadow-inner">
                <button onclick="switchTab('tabPending')" id="btnTabPending"
                    class="tab-btn flex-1 md:flex-none px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all bg-white text-[#C54716] shadow-sm">
                    Pendaftar <span class="font-black">({{ $pendingUsers->count() }})</span>
                </button>
                <button onclick="switchTab('tabAktif')" id="btnTabAktif"
                    class="tab-btn flex-1 md:flex-none px-5 py-2 rounded-xl text-xs sm:text-sm font-semibold transition-all text-gray-500 hover:text-gray-700">
                    Aktif <span class="font-black">({{ $activeUsers->count() }})</span>
                </button>
            </div>

            <button onclick="openModal('modalTambahPengguna')"
                class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#A33215] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-orange-100 whitespace-nowrap text-center">
                + Tambah Akun
            </button>
        </div>
    </div>
</div>

@if(session('success'))
<div id="alertSuccess" class="bg-white border-l-4 border-[#C54716] p-4 rounded-2xl shadow-sm mb-4 flex justify-between items-center">
    <span class="font-bold text-xs text-[#C54716] uppercase tracking-tight">{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" class="text-gray-300 hover:text-gray-500 text-lg">✕</button>
</div>
@endif

@if($errors->any())
<div class="bg-white border-l-4 border-[#A33215] p-4 rounded-2xl shadow-sm mb-4">
    <ul class="list-disc list-inside text-xs text-[#A33215] font-bold space-y-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-white rounded-3xl shadow-sm border border-[#FA8145] overflow-hidden">

<div id="tabPending">

    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
            <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Daftar Pendaftar Baru</h2>
        </div>
        <div class="relative w-full sm:w-72">
            <input type="text" id="searchPending" oninput="filterPengguna('searchPending','pendingTableBody','empty-search-pending')"
                placeholder="Cari nama, NIK, telepon..."
                class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all bg-gray-50" autocomplete="off">
            <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    @if($pendingUsers->isEmpty())
        <div class="p-10 text-center">
            <p class="text-gray-600 text-sm font-medium mb-1">Tidak ada pendaftar baru</p>
            <p class="text-sm text-gray-400">Semua pendaftaran telah diproses.</p>
        </div>
    @else
        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full text-left text-gray-600">
                <thead class="bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-bold text-[10px] md:text-sm uppercase tracking-wider border-r border-gray-200">Pendaftar</th>
                        <th class="px-4 py-3 font-bold text-[10px] md:text-sm uppercase tracking-wider border-r border-gray-200">Validasi NIK</th>
                        <th class="px-4 py-3 font-bold text-[10px] md:text-sm uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100" id="pendingTableBody">
                    @foreach($pendingUsers as $user)
                    <tr class="hover:bg-gray-50 pengguna-row cursor-pointer"
                        onclick="showDetail(this)"
                        data-nama="{{ $user->nama }}"
                        data-nik="{{ $user->nik }}"
                        data-hp="{{ $user->nomor_telepon_pengguna }}"
                        data-email="{{ $user->email_pengguna ?? '-' }}"
                        data-jk="{{ $user->jenis_kelamin_pengguna }}"
                        data-tgl="{{ \Carbon\Carbon::parse($user->tanggal_lahir_pengguna)->translatedFormat('d F Y') }}"
                        data-alamat="{{ $user->alamat_pengguna }}"
                        data-role="Calon Warga"
                        data-search="{{ strtolower($user->nama . ' ' . $user->nik . ' ' . $user->nomor_telepon_pengguna . ' ' . ($user->email_pengguna ?? '') . ' ' . $user->jenis_kelamin_pengguna . ' ' . $user->alamat_pengguna) }}">
                        <td class="px-4 py-4 border-r border-gray-100">
                            <div class="text-xs md:text-base font-black text-gray-900 uppercase tracking-tight">{{ $user->nama }}</div>
                            @if($user->nomor_telepon_pengguna)
                            <div class="text-[10px] md:text-xs text-gray-400 font-bold mt-0.5">{{ $user->nomor_telepon_pengguna }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 border-r border-gray-100">
                            <div class="text-xs md:text-sm font-mono font-bold text-gray-700 bg-gray-50 px-2 py-1 rounded-lg border border-gray-100 inline-block">{{ $user->nik }}</div>
                            @if($user->dataPenduduk)
                                <div class="mt-2 flex items-center gap-1.5">
                                    <div class="p-1 rounded-full bg-orange-50 text-[#C54716]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="text-[9px] md:text-[10px] text-[#C54716] font-black uppercase tracking-tight">
                                        Sesuai: <span class="text-[#C54716]">{{ $user->dataPenduduk->nama_lengkap }}</span>
                                    </p>
                                </div>
                            @else
                                <div class="mt-2 flex items-center gap-1.5">
                                    <div class="p-1 rounded-full bg-orange-50 text-[#A33215]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <p class="text-[9px] md:text-[10px] text-[#A33215] font-black uppercase tracking-tight">
                                        NIK tidak terdaftar di data penduduk
                                    </p>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex justify-center gap-2">
                                <button type="button" onclick="event.stopPropagation(); showDetail(this.closest('tr'))" class="bg-gray-100 text-gray-600 px-3 md:px-4 py-1.5 md:py-2 rounded-lg text-[10px] md:text-sm font-bold hover:bg-gray-200 transition-colors">Detail</button>
                                <button type="button" onclick="event.stopPropagation(); confirmTerima('{{ route('pengguna.terima', $user->id_pengguna) }}', '{{ $user->nama }}')" 
                                    class="bg-[#C54716] text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg text-[10px] md:text-sm font-bold hover:bg-[#A33215] transition-colors shadow-sm">
                                    Terima
                                </button>
                                <button type="button" onclick="event.stopPropagation(); confirmTolak('{{ route('pengguna.tolak', $user->id_pengguna) }}', '{{ $user->nama }}')" 
                                    class="bg-[#7F1911] text-white px-3 md:px-4 py-1.5 md:py-2 rounded-lg text-[10px] md:text-sm font-bold hover:bg-[#5A120C] transition-colors shadow-sm">
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div id="empty-search-pending" class="hidden p-20 text-center">
        <p class="text-gray-400 font-bold text-sm">Pendaftar tidak ditemukan</p>
        <p class="text-xs text-gray-300 mt-1">Coba gunakan kata kunci lain</p>
    </div>
</div>

<div id="tabAktif" class="hidden">

    <div class="p-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-1.5 h-6 bg-[#C54716] rounded-full"></div>
            <h2 class="font-bold text-gray-800 text-sm sm:text-base uppercase tracking-widest">Daftar Pengguna Aktif</h2>
        </div>
        <div class="relative w-full sm:w-72">
            <input type="text" id="searchAktif" oninput="filterPengguna('searchAktif','activeTableBody','empty-search-aktif')"
                placeholder="Cari nama, NIK, role..."
                class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all bg-gray-50" autocomplete="off">
            <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    @if($activeUsers->isEmpty())
            <div class="p-10 text-center">
                <p class="text-gray-600 text-sm font-medium mb-1">Pengguna tidak ditemukan</p>
                <p class="text-sm text-gray-400">Coba gunakan kata kunci pencarian lain.</p>
            </div>
        @else
            <div class="overflow-x-auto scrollbar-thin">
                <table class="w-full text-left text-gray-600">
                    <thead class="bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 font-bold text-gray-900 text-[10px] md:text-sm uppercase tracking-wider border-r border-gray-200">Nama</th>
                            <th class="px-4 py-3 font-bold text-gray-900 text-[10px] md:text-sm uppercase tracking-wider hidden md:table-cell border-r border-gray-200">NIK</th>
                            <th class="px-4 py-3 font-bold text-gray-900 text-[10px] md:text-sm uppercase tracking-wider border-r border-gray-200">Role</th>
                            <th class="px-4 py-3 font-bold text-gray-900 text-[10px] md:text-sm uppercase tracking-wider text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="activeTableBody">
                        @foreach($activeUsers as $user)
                        <tr class="hover:bg-gray-50 cursor-pointer pengguna-row" 
                            onclick="showDetail(this)"
                            data-search="{{ strtolower($user->nama . ' ' . $user->username . ' ' . $user->nik . ' ' . $user->nomor_telepon_pengguna . ' ' . ($user->email_pengguna ?? '') . ' ' . $user->jenis_kelamin_pengguna . ' ' . $user->alamat_pengguna . ' ' . ($user->role->nama_role ?? '')) }}"
                            data-nama="{{ $user->nama }}"
                            data-username="{{ $user->username }}"
                            data-nik="{{ $user->nik }}"
                            data-hp="{{ $user->nomor_telepon_pengguna }}"
                            data-email="{{ $user->email_pengguna ?? '-' }}"
                            data-jk="{{ $user->jenis_kelamin_pengguna }}"
                            data-tgl="{{ \Carbon\Carbon::parse($user->tanggal_lahir_pengguna)->translatedFormat('d F Y') }}"
                            data-tgl_raw="{{ \Carbon\Carbon::parse($user->tanggal_lahir_pengguna)->format('Y-m-d') }}"
                            data-alamat="{{ $user->alamat_pengguna }}"
                            data-id="{{ $user->id_pengguna }}"
                            data-role_id="{{ $user->id_role }}"
                            data-role="{{ ucwords(str_replace('_', ' ', $user->role->nama_role ?? '-')) }}"
                            data-padukuhan="{{ $user->padukuhan ?? '-' }}"
                            data-img="{{ $user->foto_pengguna ?? '' }}"
                            data-status="{{ $user->status_pengguna ?? '-' }}">
                            
                            <td class="px-4 py-4 font-bold text-gray-900 text-xs md:text-base border-r border-gray-100">{{ $user->nama }}</td>
                            <td class="px-4 py-4 font-mono text-sm hidden md:table-cell border-r border-gray-100">{{ $user->nik }}</td>
                            <td class="px-4 py-4 border-r border-gray-100">
                                <span class="px-2 md:px-3 py-1 rounded-full bg-orange-50 text-[#E75C16] text-[9px] md:text-xs font-black border border-orange-100 whitespace-nowrap uppercase tracking-wider">
                                    {{ ucwords(str_replace('_', ' ', $user->role->nama_role ?? '-')) }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex justify-center gap-2">
                                    <button type="button" onclick="event.stopPropagation(); showDetail(this.closest('tr'))"
                                        class="bg-gray-100 text-gray-600 px-3 md:px-4 py-1.5 rounded-lg text-[10px] md:text-sm font-bold hover:bg-gray-200 transition-colors">
                                        Detail
                                    </button>
                                    <button type="button" onclick="event.stopPropagation(); editPengguna(this)"
                                        class="bg-white text-[#C54716] border border-[#C54716] px-3 md:px-4 py-1.5 rounded-lg text-[10px] md:text-sm font-bold hover:bg-orange-50 transition-colors shadow-sm">
                                        Ubah
                                    </button>
                                    <button type="button" onclick="event.stopPropagation(); confirmDelete('{{ $user->id_pengguna }}', '{{ $user->nama }}')"
                                        class="bg-[#7F1911] text-white px-3 md:px-4 py-1.5 rounded-lg text-[10px] md:text-sm font-bold hover:bg-[#5A120C] transition-colors shadow-sm">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div id="empty-search-aktif" class="hidden p-20 text-center">
            <p class="text-gray-400 font-bold text-sm">Pengguna tidak ditemukan</p>
            <p class="text-xs text-gray-300 mt-1">Coba gunakan kata kunci lain</p>
        </div>
</div>
</div>
<div id="modalTambahPengguna"
    class="fixed top-0 left-0 w-screen h-screen 
           bg-black/40 hidden z-[999] 
           flex items-center justify-center">

    <div class="bg-white w-full max-w-md mx-2 sm:mx-4 rounded-xl shadow-lg 
       max-h-[90vh] flex flex-col relative">

        <button onclick="closeModal('modalTambahPengguna')"
            class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center
                   text-gray-600 hover:text-black text-lg rounded-full hover:bg-gray-100">
            ✕
        </button>

        <div class="p-6 border-b bg-orange-50/20">
            <h2 class="text-xl font-bold text-[#A33215]">
                Tambah Akun Pengguna
            </h2>
            <p class="text-xs leading-relaxed text-gray-500 mt-1 italic">
                Akun yang ditambahkan di sini otomatis berstatus aktif.
            </p>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
        </div>

        <form action="{{ route('pengguna.store') }}" method="POST"
            class="flex flex-col flex-1 overflow-hidden">
            @csrf

            <div class="p-6 space-y-4 flex-1 overflow-y-auto">

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Nama Lengkap <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="m_nama" name="nama" value="{{ old('nama') }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716] @error('nama') border-[#A33215] @enderror"
                        required>
                    <p id="m_err_nama" class="text-[#A33215] text-xs mt-1 hidden"></p>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Username <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="m_username" name="username" value="{{ old('username') }}"
                        placeholder="Masukkan username"
                        class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716] @error('username') border-[#A33215] @enderror"
                        required>
                    <p id="m_err_username" class="text-[#A33215] text-xs mt-1 hidden"></p>
                    @error('username') <p class="text-[#A33215] text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">NIK <span class="text-[#A33215]">*</span></label>
                    <input type="text" id="m_nik" name="nik" value="{{ old('nik') }}"
                        placeholder="Masukkan NIK (16 digit)" maxlength="16"
                        class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716] @error('nik') border-[#A33215] @enderror"
                        required>
                    <p id="m_err_nik" class="text-[#A33215] text-xs mt-1 hidden"></p>
                    @error('nik') <p class="text-[#A33215] text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Nomor Telepon <span class="text-[#A33215]">*</span></label>
                    <input type="tel" id="m_hp" name="nomor_telepon" value="{{ old('nomor_telepon') }}"
                        placeholder="08xxxxxxxxxx (10–13 digit)"
                        class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716] @error('nomor_telepon') border-[#A33215] @enderror"
                        required>
                    <p id="m_err_hp" class="text-[#A33215] text-xs mt-1 hidden"></p>
                    @error('nomor_telepon') <p class="text-[#A33215] text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Email <span class="text-[#A33215]">*</span></label>
                    <input type="email" id="m_email" name="email" value="{{ old('email') }}"
                        placeholder="masukkan email aktif"
                        class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716] @error('email_pengguna') border-[#A33215] @enderror"
                        required>
                    <p id="m_err_email" class="text-[#A33215] text-xs mt-1 hidden"></p>
                    @error('email_pengguna') <p class="text-[#A33215] text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Jenis Kelamin <span class="text-[#A33215]">*</span></label>
                        <select id="m_jk" name="jenis_kelamin"
                            class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716] bg-white"
                            required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        <p id="m_err_jk" class="text-[#A33215] text-xs mt-1 hidden"></p>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Tanggal Lahir <span class="text-[#A33215]">*</span></label>
                        <input type="date" id="m_tgl" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            max="{{ date('Y-m-d') }}"
                            class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]"
                            required>
                        <p id="m_err_tgl" class="text-[#A33215] text-xs mt-1 hidden"></p>
                    </div>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Alamat <span class="text-[#A33215]">*</span></label>
                    <textarea id="m_alamat" name="alamat" rows="2"
                        placeholder="Masukkan alamat lengkap"
                        class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]"
                        required>{{ old('alamat') }}</textarea>
                    <p id="m_err_alamat" class="text-[#A33215] text-xs mt-1 hidden"></p>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Role <span class="text-[#A33215]">*</span></label>
                    <select name="id_role"
                        class="w-full mt-1 px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716] bg-white"
                        required>
                        <option value="">-- Pilih Role --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ ucwords(str_replace('_', ' ', $role->nama_role)) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Password <span class="text-[#A33215]">*</span></label>
                    <div class="relative mt-1">
                        <input type="password" id="m_password" name="password"
                            placeholder="Min. 8 karakter &amp; mengandung angka"
                            class="w-full px-4 py-2.5 pr-10 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]"
                            required>
                        <button type="button" onclick="togglePwd('m_password', this)"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#C54716] transition-colors">
                            <svg class="w-5 h-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <svg class="w-5 h-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                        </button>
                    </div>
                    <p id="m_err_password" class="text-[#A33215] text-xs mt-1 hidden"></p>
                </div>

                <div>
                    <label class="text-xs font-bold text-gray-700 uppercase tracking-wide">Konfirmasi Password <span class="text-[#A33215]">*</span></label>
                    <div class="relative mt-1">
                        <input type="password" id="m_password_conf" name="password_confirmation"
                            placeholder="Masukkan kembali password"
                            class="w-full px-4 py-2.5 pr-10 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]"
                            required>
                        <button type="button" onclick="togglePwd('m_password_conf', this)"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-[#C54716] transition-colors">
                            <svg class="w-5 h-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            <svg class="w-5 h-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                        </button>
                    </div>
                    <p id="m_err_password_conf" class="text-[#A33215] text-xs mt-1 hidden"></p>
                </div>

            </div>

            <div class="p-4 border-t flex justify-end gap-3 bg-gray-50/50">
                <button type="button"
                    onclick="closeModal('modalTambahPengguna')"
                    class="px-5 py-2 text-[#7F1911] font-bold hover:bg-gray-100 rounded-lg text-sm uppercase tracking-wide">
                    Batal
                </button>

                <button type="submit" class="bg-[#C54716] text-white px-8 py-2 rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 text-sm uppercase tracking-wide">
                    Simpan
                </button>
            </div>

        </form>

    </div>
</div>

<div id="modalDetail" class="fixed top-0 left-0 w-screen h-screen bg-black/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-2xl relative overflow-hidden animate-zoom-in">
        <div class="bg-[#A33215] p-6 text-white relative">
            <button onclick="closeModal('modalDetail')" class="absolute top-4 right-4 text-white/70 hover:text-white transition-all text-xl">✕</button>
            <div class="flex items-center gap-4">

                <div>
                    <h2 class="text-xl font-black uppercase tracking-tight" id="det_nama"></h2>
                    <p class="text-xs font-bold text-orange-200 uppercase tracking-[0.2em] mt-0.5" id="det_role"></p>
                    <p class="text-sm font-medium text-gray-200 hidden" id="det_padukuhan"></p>
                    <p class="text-sm font-medium text-gray-200" id="det_status"></p>
                </div>
            </div>
        </div>
        
        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 gap-5">
                <div class="flex items-start gap-4">
                    
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Kontak Telepon</p>
                        <p class="text-sm font-black text-[#A33215]" id="det_hp"></p>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">NIK</p>
                        <p class="text-sm font-black text-[#A33215]" id="det_nik"></p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat Email</p>
                        <p class="text-sm font-bold text-gray-800" id="det_email"></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-start gap-4">
                    
                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Gender</p>
                            <p class="text-sm font-bold text-gray-800" id="det_jk"></p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">

                        <div>
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tgl Lahir</p>
                            <p class="text-sm font-bold text-gray-800" id="det_tgl"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-4 border-t border-gray-50 pt-4">
                    
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat Domisili</p>
                        <p class="text-sm font-bold text-gray-800 leading-relaxed" id="det_alamat"></p>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <button onclick="closeModal('modalDetail')" 
                    class="w-full py-4 bg-gray-100 text-gray-500 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-gray-200 transition-all shadow-inner">
                    Tutup Detail
                </button>
            </div>
        </div>
    </div>
</div>

<div id="modalEdit" class="fixed top-0 left-0 w-screen h-screen bg-black/40 hidden z-[999] flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-2 sm:mx-4 rounded-xl shadow-lg max-h-[90vh] flex flex-col relative">
        <button onclick="closeModal('modalEdit')" class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center text-gray-400 hover:text-black rounded-full hover:bg-gray-100">✕</button>
        <div class="p-6 border-b bg-orange-50/20">
            <h2 class="text-xl font-bold text-[#A33215]">Ubah Data Pengguna</h2>
            <p class="text-sm text-[#E75C16] font-bold uppercase tracking-widest mt-1">Sesuaikan Informasi Akun</p>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
        </div>
        <form id="formEdit" method="POST" class="flex flex-col flex-1 overflow-hidden">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4 flex-1 overflow-y-auto">
                <div>
                    <label class="text-[10px] font-black text-gray-900 uppercase tracking-[0.2em] ml-1">Nama Lengkap <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="nama" id="edit_nama" class="w-full border p-2 rounded-lg mt-1" required>
                </div>
                <div>
                    <label class="text-[10px] font-black text-gray-900 uppercase tracking-[0.2em] ml-1">Username <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="username" id="edit_username" class="w-full border p-2 rounded-lg mt-1" required>
                </div>
                <div>
                    <label class="text-sm font-medium">NIK <span class="text-[#A33215]">*</span></label>
                    <input type="text" name="nik" id="edit_nik" class="w-full border p-2 rounded-lg mt-1" required>
                </div>
                <div>
                    <label class="text-sm font-medium">Nomor Telepon <span class="text-[#A33215]">*</span></label>
                    <input type="tel" name="nomor_telepon" id="edit_hp" class="w-full border p-2 rounded-lg mt-1" required>
                </div>
                <div>
                    <label class="text-sm font-medium">Email</label>
                    <input type="email" name="email" id="edit_email" class="w-full border p-2 rounded-lg mt-1">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium">Jenis Kelamin <span class="text-[#A33215]">*</span></label>
                        <select name="jenis_kelamin" id="edit_jk" class="w-full border p-2 rounded-lg mt-1 bg-white" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium">Tanggal Lahir <span class="text-[#A33215]">*</span></label>
                        <input type="date" name="tanggal_lahir" id="edit_tgl" max="{{ date('Y-m-d') }}" class="w-full border p-2 rounded-lg mt-1" required>
                    </div>
                </div>
                <div>
                    <label class="text-sm font-medium">Alamat</label>
                    <textarea name="alamat" id="edit_alamat" rows="2" class="w-full border p-2 rounded-lg mt-1"></textarea>
                </div>
                <div>
                    <label class="text-sm font-medium">Role <span class="text-[#A33215]">*</span></label>
                    <select name="id_role" id="edit_role" class="w-full border p-2 rounded-lg mt-1 bg-white" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->id_role }}">{{ ucwords(str_replace('_', ' ', $role->nama_role)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="bg-gray-50 p-3 rounded-lg border border-dashed">
                    <label class="text-sm font-medium">Ubah Password (Opsional)</label>
                    <input type="password" name="password" placeholder="Password baru" class="w-full border p-2 rounded-lg mt-1 mb-2">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru" class="w-full border p-2 rounded-lg">
                </div>
            </div>
            <div class="p-4 border-t flex justify-end gap-3 bg-gray-50/50">
                <button type="button" onclick="closeModal('modalEdit')" class="px-5 py-2 text-[#7F1911] font-bold hover:bg-gray-100 rounded-lg text-xs uppercase tracking-wide">Batal</button>
                <button type="submit" class="bg-[#C54716] text-white px-8 py-2 rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 text-xs uppercase tracking-wide">Perbarui Data</button>
            </div>
        </form>
    </div>
</div>

<div id="modalDelete" class="fixed top-0 left-0 w-screen h-screen bg-black/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl text-center w-full max-w-sm shadow-2xl animate-zoom-in border border-[#FA8145]">
        <h3 class="text-lg font-black text-gray-900 mb-2 uppercase tracking-tight">Konfirmasi Hapus</h3>
        <p class="text-[10px] text-gray-500 mb-6 font-bold leading-relaxed uppercase tracking-widest px-2">Apakah Anda yakin ingin menghapus akun <span id="del_nama" class="text-[#A33215]"></span>? Tindakan ini tidak dapat dibatalkan.</p>
        <form id="formDelete" method="POST" class="flex gap-3 justify-center">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModal('modalDelete')" class="flex-1 px-4 py-3 bg-gray-100 text-[#7F1911] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="flex-1 px-4 py-3 bg-[#7F1911] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#5A120C] transition-all shadow-lg shadow-orange-100">Hapus Akun</button>
        </form>
    </div>
</div>

<div id="modalTerima" class="fixed top-0 left-0 w-screen h-screen bg-black/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Terima</h3>
        <p class="text-sm text-gray-500 mb-6">Terima pendaftaran akun <span id="terima_nama" class="font-bold text-[#A33215]"></span>?</p>
        <form id="formTerima" method="POST" class="flex gap-3 justify-center">
            @csrf
            @method('PUT')
            <button type="button" onclick="closeModal('modalTerima')" class="flex-1 px-4 py-2.5 bg-gray-100 text-[#7F1911] rounded-xl font-bold text-sm hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="flex-1 px-4 py-2.5 bg-[#C54716] text-white rounded-xl font-bold text-sm hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100">Terima</button>
        </form>
    </div>
</div>

<div id="modalTolak" class="fixed top-0 left-0 w-screen h-screen bg-black/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-2xl text-center w-full max-w-sm shadow-2xl border border-[#FA8145]">
        <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Tolak</h3>
        <p class="text-sm text-gray-500 mb-6">Tolak dan hapus pendaftaran akun <span id="tolak_nama" class="font-bold text-[#A33215]"></span>? Tindakan ini tidak dapat dibatalkan.</p>
        <form id="formTolak" method="POST" class="flex gap-3 justify-center">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeModal('modalTolak')" class="flex-1 px-4 py-2.5 bg-gray-100 text-[#7F1911] rounded-xl font-bold text-sm hover:bg-gray-200 transition-all">Batal</button>
            <button type="submit" class="flex-1 px-4 py-2.5 bg-[#7F1911] text-white border border-[#7F1911] rounded-xl font-bold text-sm hover:bg-[#5A120C] hover:border-[#5A120C] transition-all shadow-md shadow-red-100">Tolak</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    setTimeout(() => {
        const alert = document.getElementById('alertSuccess');
        if (alert) {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);    

    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    function switchTab(tabId) {
        const tabPending = document.getElementById('tabPending');
        const tabAktif = document.getElementById('tabAktif');
        const btnPending = document.getElementById('btnTabPending');
        const btnAktif = document.getElementById('btnTabAktif');

        if (tabId === 'tabPending') {
            tabPending.classList.remove('hidden');
            tabAktif.classList.add('hidden');
            btnPending.classList.add('bg-white', 'text-[#C54716]', 'shadow-sm');
            btnPending.classList.remove('text-gray-500');
            btnAktif.classList.remove('bg-white', 'text-[#C54716]', 'shadow-sm');
            btnAktif.classList.add('text-gray-500');
        } else {
            tabPending.classList.add('hidden');
            tabAktif.classList.remove('hidden');
            btnAktif.classList.add('bg-white', 'text-[#C54716]', 'shadow-sm');
            btnAktif.classList.remove('text-gray-500');
            btnPending.classList.remove('bg-white', 'text-[#C54716]', 'shadow-sm');
            btnPending.classList.add('text-gray-500');
        }
    }
    
    // Auto-switch tab logic
    @if(request('search'))
        switchTab('tabAktif');
    @endif

    function showDetail(el) {
        const d = el.dataset;
        document.getElementById('det_nama').innerText = d.nama || '';
        document.getElementById('det_nik').innerText = d.nik || '';
        document.getElementById('det_hp').innerText = d.hp || '-';
        document.getElementById('det_email').innerText = d.email || '-';
        document.getElementById('det_jk').innerText = d.jk || '-';
        document.getElementById('det_tgl').innerText = d.tgl || '-';
        document.getElementById('det_alamat').innerText = d.alamat || '-';
        document.getElementById('det_status').innerText = d.status || '';
        document.getElementById('det_role').innerText = d.role || '';
        const padEl = document.getElementById('det_padukuhan');
        if (d.padukuhan && d.padukuhan !== '-') {
            padEl.innerText = d.padukuhan;
            padEl.classList.remove('hidden');
        } else {
            padEl.innerText = '';
            padEl.classList.add('hidden');
        }
        openModal('modalDetail');
    }

    function editPengguna(btn) {
        const d = btn.closest('tr').dataset;
        document.getElementById('edit_nama').value = d.nama;
        document.getElementById('edit_username').value = d.username;
        document.getElementById('edit_nik').value = d.nik;
        document.getElementById('edit_hp').value = d.hp;
        document.getElementById('edit_email').value = d.email;
        document.getElementById('edit_jk').value = d.jk;
        document.getElementById('edit_tgl').value = d.tgl_raw;
        document.getElementById('edit_alamat').value = d.alamat;
        document.getElementById('edit_role').value = d.role_id;
        
        document.getElementById('formEdit').action = `/pengguna/${d.id}`;
        openModal('modalEdit');
    }

    function confirmTerima(action, nama) {
        document.getElementById('terima_nama').innerText = nama;
        document.getElementById('formTerima').action = action;
        openModal('modalTerima');
    }

    function confirmTolak(action, nama) {
        document.getElementById('tolak_nama').innerText = nama;
        document.getElementById('formTolak').action = action;
        openModal('modalTolak');
    }

    function confirmDelete(id, nama) {
        document.getElementById('del_nama').innerText = nama;
        document.getElementById('formDelete').action = `/pengguna/${id}`;
        openModal('modalDelete');
    }

    function filterPengguna(inputId, tableBodyId, emptyStateId) {
        const query       = document.getElementById(inputId)?.value.toLowerCase() || '';
        const tableBody   = document.getElementById(tableBodyId);
        const emptyState  = document.getElementById(emptyStateId);

        if (!tableBody) return;

        let hasResult = false;
        tableBody.querySelectorAll('tr[data-search]').forEach(row => {
            const isVisible = row.getAttribute('data-search').includes(query);
            row.style.display = isVisible ? '' : 'none';
            if (isVisible) hasResult = true;
        });

        if (emptyState) {
            emptyState.classList.toggle('hidden', hasResult || query === '');
        }
    }

    // Buka modal kembali jika ada error validasi
    @if($errors->any())
        // Jika ada input 'nama', kemungkinan dari modal tambah atau edit
        // Untuk sederhananya buka yang terakhir diinteraksi (atau tambah jika baru)
        @if(old('_method') == 'PUT')
            // Cari ID dari URL action sebelumnya jika mungkin, atau buka saja modal edit
            // Karena kita tidak tahu ID mana yang error tanpa flash ID, kita buka modal tambah saja sebagai fallback 
            // Namun biasanya 'nik' atau 'nomor_telepon' yang error.
            openModal('modalTambahPengguna');
        @else
            openModal('modalTambahPengguna');
        @endif
    @endif

    // ===== Toggle Password Visibility =====
    function togglePwd(inputId, btn) {
        const input = document.getElementById(inputId);
        const eyeOpen   = btn.querySelector('.eye-open');
        const eyeClosed = btn.querySelector('.eye-closed');
        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }

    // ===== Modal Tambah – Inline Validation =====
    (function() {
        const fields = {
            m_nama:         { err: 'm_err_nama',         validate: v => v.trim() ? '' : 'Nama lengkap wajib diisi.' },
            m_username:     { err: 'm_err_username',     validate: v => {
                if (!v.trim()) return 'Username wajib diisi.';
                if (v.length < 6) return 'Username minimal 6 karakter.';
                if (!/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]+$/.test(v)) return 'Username harus mengandung huruf dan angka, tanpa spasi.';
                return '';
            }},
            m_nik:          { err: 'm_err_nik',          validate: v => {
                if (!v.trim()) return 'NIK wajib diisi.';
                if (!/^\d+$/.test(v)) return 'NIK harus berupa angka saja.';
                if (v.length !== 16) return 'NIK wajib tepat 16 digit.';
                return '';
            }},
            m_hp:           { err: 'm_err_hp',           validate: v => {
                if (!v.trim()) return 'Nomor telepon wajib diisi.';
                if (!/^\d+$/.test(v)) return 'Nomor telepon harus angka saja.';
                if (v.length < 10 || v.length > 13) return 'Nomor telepon harus 10–13 digit.';
                return '';
            }},
            m_email:        { err: 'm_err_email',        validate: v => {
                if (!v.trim()) return 'Email wajib diisi.';
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v) ? '' : 'Format email tidak valid.';
            }},
            m_jk:           { err: 'm_err_jk',           validate: v => v ? '' : 'Jenis kelamin wajib dipilih.' },
            m_tgl:          { err: 'm_err_tgl',          validate: v => v ? '' : 'Tanggal lahir wajib diisi.' },
            m_alamat:       { err: 'm_err_alamat',       validate: v => v.trim() ? '' : 'Alamat wajib diisi.' },
            m_password:     { err: 'm_err_password',     validate: v => {
                if (!v) return 'Password wajib diisi.';
                if (v.length < 8) return 'Password minimal 8 karakter.';
                if (!/\d/.test(v)) return 'Password harus mengandung minimal satu angka.';
                return '';
            }},
            m_password_conf:{ err: 'm_err_password_conf',validate: v => {
                const pw = document.getElementById('m_password')?.value || '';
                if (!v) return 'Konfirmasi password wajib diisi.';
                if (v !== pw) return 'Konfirmasi tidak cocok dengan password.';
                return '';
            }},
        };

        function setError(fieldId, msg) {
            const input = document.getElementById(fieldId);
            const errEl = document.getElementById(fields[fieldId].err);
            if (!input || !errEl) return;
            if (msg) {
                errEl.textContent = msg;
                errEl.classList.remove('hidden');
                input.classList.add('border-[#A33215]');
                input.classList.remove('border-gray-200');
            } else {
                errEl.textContent = '';
                errEl.classList.add('hidden');
                input.classList.remove('border-[#A33215]');
                input.classList.add('border-gray-200');
            }
            return !msg;
        }

        Object.keys(fields).forEach(id => {
            const el = document.getElementById(id);
            if (!el) return;
            const handler = () => {
                if (id === 'm_nik' || id === 'm_hp') el.value = el.value.replace(/\D/g, '');
                setError(id, fields[id].validate(el.value));
                if (id === 'm_password') setError('m_password_conf', fields['m_password_conf'].validate(document.getElementById('m_password_conf')?.value || ''));
            };
            el.addEventListener('input', handler);
            el.addEventListener('blur', handler);
            if (el.tagName === 'SELECT') el.addEventListener('change', handler);
        });

        const modalForm = document.querySelector('#modalTambahPengguna form');
        if (modalForm) {
            modalForm.addEventListener('submit', function(e) {
                let ok = true;
                Object.keys(fields).forEach(id => {
                    const el = document.getElementById(id);
                    if (el && !setError(id, fields[id].validate(el.value))) ok = false;
                });
                if (!ok) e.preventDefault();
            });
        }
    })();
</script>
@endpush
