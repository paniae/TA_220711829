@extends('layouts.app')

@section('title', 'Data Penduduk')

@section('content')

<div class="bg-white/90 backdrop-blur rounded-2xl p-4 md:p-6 shadow border border-[#FA8145] mb-6">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6 pb-6 border-b border-gray-200">
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-[#A33215] mb-1">
                Data Penduduk
            </h1>
            <p class="text-base text-gray-500 font-medium">
                Kelola data warga RT/RW secara terpusat.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <form action="{{ route('penduduk.index') }}" method="GET" class="relative w-full sm:w-64">
                @if(!empty($filter))
                    <input type="hidden" name="filter" value="{{ $filter }}">
                @endif
                <input type="text" name="search" id="searchInput" value="{{ $search ?? '' }}" placeholder="Cari NIK/Nama/Nomor KK..." 
                    class="w-full pl-10 pr-4 py-2.5 border border-orange-200 rounded-xl text-sm focus:outline-none focus:border-[#C54716] focus:ring-1 focus:ring-[#C54716] transition-all" autocomplete="off">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </form>

            <button onclick="openModal('modalPenduduk')"
                class="bg-[#C54716] text-white px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 active:scale-95 whitespace-nowrap">
                + Tambah Penduduk
            </button>
        </div>
    </div>

    <div>
        <p class="text-xs text-gray-500 font-bold mb-3 uppercase tracking-wider">
            Demografi & Statistik Penduduk
        </p>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => '', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ empty($filter) ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total Penduduk</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['total_penduduk'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => '', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md bg-orange-50/40 border-orange-100 shadow-sm">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Total KK</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['total_kk'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => 'laki_aktif', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $filter === 'laki_aktif' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Laki-Laki (Aktif)</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['laki_aktif'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => 'perempuan', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $filter === 'perempuan' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Perempuan</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['perempuan'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => 'lansia', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $filter === 'lansia' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Lansia (60+)</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['lansia'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => 'dewasa', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $filter === 'dewasa' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Dewasa (19-59)</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['dewasa'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => 'remaja', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $filter === 'remaja' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Remaja (12-18)</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['remaja'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => 'anak', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $filter === 'anak' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Anak-Anak (&lt;12)</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['anak'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => 'pindah', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $filter === 'pindah' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Pindah ({{ date('Y') }})</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['pindah_tahun_ini'] ?? 0 }}</p>
            </div>

            <div onclick="window.location.href='{{ route('penduduk.index', ['filter' => 'meninggal', 'search' => $search]) }}'" 
                 class="p-4 rounded-xl border transition-all cursor-pointer active:scale-95 hover:shadow-md {{ $filter === 'meninggal' ? 'bg-orange-100/60 border-[#FA8145] ring-2 ring-[#C54716]' : 'bg-orange-50/40 border-orange-100 shadow-sm' }}">
                <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Meninggal ({{ date('Y') }})</h3>
                <p class="text-2xl font-bold text-[#A33215]">{{ $stats['meninggal_tahun_ini'] ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<div id="tableContainer" class="bg-white/90 p-4 md:p-6 rounded-xl shadow border border-[#FA8145] overflow-x-auto">

    <table class="w-full text-base whitespace-nowrap">
        <thead>
            <tr class="text-left border-b border-gray-200 text-gray-900 font-black text-base uppercase tracking-wider">
                <th class="py-3 pr-4 border-r border-gray-200 text-center w-12">No</th>
                <th class="hidden md:table-cell px-4 border-r border-gray-200">NIK</th>
                <th class="whitespace-normal min-w-[150px] px-4 border-r border-gray-200">Nama</th>
                <th class="hidden md:table-cell px-4 border-r border-gray-200">Jenis Kelamin</th>
                <th class="hidden md:table-cell px-4 border-r border-gray-200">Alamat</th>
                <th class="hidden md:table-cell px-4 border-r border-gray-200">RT/RW</th>
                <th class="pl-4">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($data as $i => $d)
            <tr class="border-b border-gray-100 hover:bg-orange-50/50 transition-colors text-base">
                <td class="py-3 pr-4 border-r border-gray-200 text-center">{{ $data->firstItem() + $i }}</td>
                <td class="hidden md:table-cell px-4 border-r border-gray-200">{{ $d->nomor_induk_kependudukan }}</td>
                <td class="font-bold text-gray-800 whitespace-normal break-words leading-tight min-w-[150px] px-4 border-r border-gray-200">{{ $d->nama_lengkap }}</td>
                <td class="hidden md:table-cell px-4 border-r border-gray-200">{{ $d->jenis_kelamin }}</td>
                <td class="hidden md:table-cell px-4 border-r border-gray-200">{{ $d->alamat }}</td>
                <td class="hidden md:table-cell px-4 border-r border-gray-200">{{ $d->rt }}/{{ $d->rw }}</td>
                <td class="py-3 pl-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <button onclick="openDetailModal(
                        '{{ $d->nomor_induk_kependudukan }}',
                        '{{ $d->nomor_kk }}',
                        '{{ addslashes($d->nama_lengkap) }}',
                        '{{ $d->jenis_kelamin }}',
                        '{{ addslashes($d->tempat_lahir) }}',
                        '{{ $d->tanggal_lahir }}',
                        '{{ addslashes($d->agama) }}',
                        '{{ addslashes($d->pendidikan) }}',
                        '{{ addslashes($d->jenis_pekerjaan) }}',
                        '{{ $d->status_perkawinan }}',
                        '{{ $d->rt }}',
                        '{{ $d->rw }}',
                        '{{ addslashes($d->desa_kelurahan) }}',
                        '{{ addslashes($d->kecamatan) }}',
                        '{{ addslashes($d->kabupaten_kota) }}',
                        '{{ addslashes($d->provinsi) }}',
                        '{{ addslashes($d->alamat) }}',
                        '{{ $d->status_penduduk }}',
                        '{{ $d->foto_penduduk ? asset($d->foto_penduduk) : '' }}'
                        )" class="bg-gray-50 text-gray-700 px-4 py-2 rounded-xl text-xs font-bold hover:bg-gray-100 transition-all border border-gray-200 shadow-sm uppercase tracking-wider min-w-[75px] text-center">
                        Detail
                    </button>
                    <button onclick="openEditModal(
                        '{{ $d->nomor_induk_kependudukan }}',
                        '{{ $d->nomor_induk_kependudukan }}',
                        '{{ $d->nomor_kk }}',
                        '{{ addslashes($d->nama_lengkap) }}',
                        '{{ $d->jenis_kelamin }}',
                        '{{ addslashes($d->tempat_lahir) }}',
                        '{{ $d->tanggal_lahir }}',
                        '{{ addslashes($d->agama) }}',
                        '{{ addslashes($d->pendidikan) }}',
                        '{{ addslashes($d->jenis_pekerjaan) }}',
                        '{{ $d->status_perkawinan }}',
                        '{{ $d->rt }}',
                        '{{ $d->rw }}',
                        '{{ addslashes($d->desa_kelurahan) }}',
                        '{{ addslashes($d->kecamatan) }}',
                        '{{ addslashes($d->kabupaten_kota) }}',
                        '{{ addslashes($d->provinsi) }}',
                        '{{ addslashes($d->alamat) }}',
                        '{{ $d->status_penduduk }}'
                        )" class="bg-orange-50 text-[#C54716] px-4 py-2 rounded-xl text-xs font-bold hover:bg-[#C54716] hover:text-white transition-all border border-orange-100 shadow-sm uppercase tracking-wider min-w-[75px] text-center">
                        Ubah
                    </button>

                    <button onclick="openDeleteModal('{{ $d->nomor_induk_kependudukan }}', '{{ addslashes($d->nama_lengkap) }}')" 
                        class="bg-orange-50 text-[#69200F] px-4 py-2 rounded-xl text-xs font-bold hover:bg-[#69200F] hover:text-white transition-all border border-orange-200 shadow-sm uppercase tracking-wider min-w-[75px] text-center">
                        Hapus
                    </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center py-4 text-gray-500">
                    Belum ada data penduduk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $data->links('components.pagination') }}
    </div>

</div>

<div id="modalPenduduk" class="fixed inset-0 bg-[#69200F]/40 hidden items-center justify-center z-50 p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col max-h-[90vh] relative">

        <div class="p-6 border-b flex justify-between items-center bg-gray-50/50">
            <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight">
                Tambah Penduduk
                <p class="text-xs text-[#E75C16] mt-1 uppercase tracking-widest font-bold">
                    <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
                </p>
            </h2>
            <button onclick="closeModal('modalPenduduk')"
                class="absolute top-3 right-3 w-10 h-10 flex items-center justify-center
                    text-gray-400 hover:text-black text-2xl rounded-full 
                    hover:bg-gray-100 transition">
                ✕
            </button>
        </div>

        <div class="p-6 overflow-y-auto">

            <form action="{{ route('penduduk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-base font-medium">NIK <span class="text-[#A33215]">*</span></label>
                        <input type="text" id="create_nik_input" name="nik" required minlength="16" maxlength="16" pattern="[0-9]{16}" title="NIK harus berupa 16 digit angka" class="border p-2 rounded-lg w-full @error('nik') border-[#A33215] @enderror" value="{{ old('nik') }}">
                        <p id="create_nik_warning" class="text-xs text-gray-500 mt-1 font-semibold"></p>
                        @error('nik')
                            <p class="text-[#A33215] text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-base font-medium">Nomor KK <span class="text-[#A33215]">*</span></label>
                        <input type="text" id="create_kk_input" name="nomor_kk" required minlength="16" maxlength="16" pattern="[0-9]{16}" title="Nomor KK harus berupa 16 digit angka" class="border p-2 rounded-lg w-full @error('nomor_kk') border-[#A33215] @enderror" value="{{ old('nomor_kk') }}">
                        <p id="create_kk_warning" class="text-xs text-gray-500 mt-1 font-semibold"></p>
                        @error('nomor_kk')
                            <p class="text-[#A33215] text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-base font-medium">Nama Lengkap <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="nama_lengkap" required class="border p-2 rounded-lg w-full" value="{{ old('nama_lengkap') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Jenis Kelamin <span class="text-[#A33215]">*</span></label>
                        <select name="jenis_kelamin" required class="border p-2 rounded-lg w-full">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-base font-medium">Tempat Lahir <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="tempat_lahir" required class="border p-2 rounded-lg w-full" value="{{ old('tempat_lahir') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Tanggal Lahir <span class="text-[#A33215]">*</span></label>
                        <input type="date" name="tanggal_lahir" max="{{ date('Y-m-d') }}" required class="border p-2 rounded-lg w-full" value="{{ old('tanggal_lahir') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Agama <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="agama" required class="border p-2 rounded-lg w-full" value="{{ old('agama') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Pendidikan <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="pendidikan" required class="border p-2 rounded-lg w-full" value="{{ old('pendidikan') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Jenis Pekerjaan <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="jenis_pekerjaan" required class="border p-2 rounded-lg w-full" value="{{ old('jenis_pekerjaan') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Status Perkawinan <span class="text-[#A33215]">*</span></label>
                        <select name="status_perkawinan" required class="border p-2 rounded-lg w-full">
                            <option value="">-- Pilih --</option>
                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                    </div>


                    <div>
                        <label class="text-base font-medium">RT <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="rt" required class="border p-2 rounded-lg w-full" value="{{ old('rt') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">RW <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="rw" required class="border p-2 rounded-lg w-full" value="{{ old('rw') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Desa/Kelurahan <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="desa_kelurahan" required class="border p-2 rounded-lg w-full" value="{{ old('desa_kelurahan', 'Ngestirejo') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Kecamatan <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="kecamatan" required class="border p-2 rounded-lg w-full" value="{{ old('kecamatan', 'Tanjungsari') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Kabupaten <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="kabupaten" required class="border p-2 rounded-lg w-full" value="{{ old('kabupaten', 'Gunungkidul') }}">
                    </div>

                    <div>
                        <label class="text-base font-medium">Provinsi <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="provinsi" required class="border p-2 rounded-lg w-full" value="{{ old('provinsi', 'Daerah Istimewa Yogyakarta') }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-base font-medium">Alamat <span class="text-[#A33215]">*</span></label>
                        <textarea name="alamat" required class="border p-2 rounded-lg w-full">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-base font-medium">Foto</label>
                        <input type="file" name="foto" class="border p-2 rounded-lg w-full">
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3 pt-4 border-t">
                    <button type="button" onclick="closeModal('modalPenduduk')"
                        class="px-5 py-2 text-gray-500 font-bold hover:bg-gray-100 rounded-lg text-xs uppercase tracking-wide">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-8 py-2 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 text-xs uppercase tracking-wide">
                        Simpan Data
                    </button>
                </div>

            </form>

        </div>

    </div>
     
</div>

<div id="modalDetail" class="fixed inset-0 bg-[#69200F]/40 hidden items-center justify-center z-50 p-4 backdrop-blur-sm">
    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col max-h-[90vh] relative">

        <button onclick="closeModal('modalDetail')"
            class="absolute top-4 right-4 text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold">
            ✕
        </button>

        <div class="p-6 border-b flex justify-between items-center bg-gray-50/50">
            <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight">Detail Penduduk</h2>
        </div>

        <div class="p-6 overflow-y-auto">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label class="text-[10px] font-black text-gray-900 uppercase tracking-[0.2em] ml-1">NIK</label>
                    <input type="text" id="detail_nik" readonly class="border p-2.5 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-[10px] font-black text-gray-900 uppercase tracking-[0.2em] ml-1">Nomor KK</label>
                    <input type="text" id="detail_kk" readonly class="border p-2.5 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Nama Lengkap</label>
                    <input type="text" id="detail_nama" readonly class="border p-2.5 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Jenis Kelamin</label>
                    <input type="text" id="detail_jk" readonly class="border p-2.5 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Tempat Lahir</label>
                    <input type="text" id="detail_tempat" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Tanggal Lahir</label>
                    <input type="date" id="detail_tgl" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Agama</label>
                    <input type="text" id="detail_agama" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Pendidikan</label>
                    <input type="text" id="detail_pendidikan" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Jenis Pekerjaan</label>
                    <input type="text" id="detail_pekerjaan" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Status Perkawinan</label>
                    <input type="text" id="detail_status_kawin" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">RT</label>
                    <input type="text" id="detail_rt" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">RW</label>
                    <input type="text" id="detail_rw" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Desa/Kelurahan</label>
                    <input type="text" id="detail_desa" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Kecamatan</label>
                    <input type="text" id="detail_kecamatan" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Kabupaten</label>
                    <input type="text" id="detail_kabupaten" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div>
                    <label class="text-base font-medium">Provinsi</label>
                    <input type="text" id="detail_provinsi" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="text-base font-medium">Status Penduduk</label>
                    <input type="text" id="detail_status" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none">
                </div>

                <div class="md:col-span-2">
                    <label class="text-base font-medium">Alamat</label>
                    <textarea id="detail_alamat" readonly class="border p-2 rounded-xl w-full bg-gray-50 text-gray-600 outline-none"></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="text-base font-medium mb-2 block">Foto</label>
                    <img id="detail_foto" src="" class="w-32 h-32 object-cover rounded-xl shadow border hidden cursor-pointer hover:opacity-90 active:scale-95 transition-all" alt="Foto Penduduk" onclick="openPhotoPreview(this.src)" title="Klik untuk memperbesar">
                    <p id="detail_foto_kosong" class="text-sm text-gray-500 italic hidden">Tidak ada foto</p>
                </div>

            </div>

        </div>

    </div>
</div>

<div id="modalEdit" class="fixed inset-0 bg-[#69200F]/40 hidden items-center justify-center z-50 p-4 backdrop-blur-sm">

    <div class="bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl border border-[#FA8145] flex flex-col max-h-[90vh] relative">

        <button onclick="closeModal('modalEdit')"
            class="absolute top-4 right-4 text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold">
            ✕
        </button>

        <div class="p-6 border-b flex justify-between items-center bg-gray-50/50">
            <h2 class="text-xl font-bold text-[#69200F] uppercase tracking-tight">Ubah Data Penduduk</h2>
        </div>

        <div class="p-6 overflow-y-auto">

            <form id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-base font-medium">NIK <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="nik" id="edit_nik" required minlength="16" maxlength="16" pattern="[0-9]{16}" title="NIK harus berupa 16 digit angka" class="border p-2.5 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                        <p id="edit_nik_warning" class="text-xs text-gray-500 mt-1 font-semibold"></p>
                    </div>

                    <div>
                        <label class="text-base font-medium">Nomor KK <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="nomor_kk" id="edit_kk" required minlength="16" maxlength="16" pattern="[0-9]{16}" title="Nomor KK harus berupa 16 digit angka" class="border p-2.5 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                        <p id="edit_kk_warning" class="text-xs text-gray-500 mt-1 font-semibold"></p>
                    </div>

                    <div>
                        <label class="text-base font-medium">Nama Lengkap <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="nama_lengkap" id="edit_nama" required class="border p-2.5 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Jenis Kelamin <span class="text-[#A33215]">*</span></label>
                        <select name="jenis_kelamin" id="edit_jk" required class="border p-2.5 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-base font-medium">Tempat Lahir <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="tempat_lahir" id="edit_tempat" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Tanggal Lahir <span class="text-[#A33215]">*</span></label>
                        <input type="date" name="tanggal_lahir" id="edit_tgl" max="{{ date('Y-m-d') }}" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Agama <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="agama" id="edit_agama" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Pendidikan <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="pendidikan" id="edit_pendidikan" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Jenis Pekerjaan <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="jenis_pekerjaan" id="edit_pekerjaan" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Status Perkawinan <span class="text-[#A33215]">*</span></label>
                        <select name="status_perkawinan" id="edit_status_kawin" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-base font-medium">RT <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="rt" id="edit_rt" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">RW <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="rw" id="edit_rw" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Desa/Kelurahan <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="desa_kelurahan" id="edit_desa" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Kecamatan <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="kecamatan" id="edit_kecamatan" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Kabupaten <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="kabupaten" id="edit_kabupaten" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div>
                        <label class="text-base font-medium">Provinsi <span class="text-[#A33215]">*</span></label>
                        <input type="text" name="provinsi" id="edit_provinsi" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-base font-medium">Status Penduduk <span class="text-[#A33215]">*</span></label>
                        <select name="status_penduduk" id="edit_status" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                            <option value="Aktif">Aktif</option>
                            <option value="Pindah">Pindah</option>
                            <option value="Meninggal">Meninggal</option>
                            <option value="Pendatang">Pendatang</option>
                            <option value="Tidak Diketahui">Tidak Diketahui</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-base font-medium">Alamat <span class="text-[#A33215]">*</span></label>
                        <textarea name="alamat" id="edit_alamat" required class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-base font-medium">Foto</label>
                        <input type="file" name="foto" class="border p-2 rounded-xl w-full focus:border-[#C54716] outline-none transition-all">
                    </div>

                </div>

                <div class="mt-6 text-right pt-4 border-t">
                    <button type="submit" class="bg-[#C54716] text-white px-8 py-2 rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 text-xs uppercase tracking-wide">
                        Ubah Data
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

<div id="modalDelete" class="fixed inset-0 bg-[#69200F]/40 hidden z-[999] flex items-center justify-center p-4 backdrop-blur-sm">

    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-[#FA8145] relative">

        <button onclick="closeModal('modalDelete')"
            class="absolute top-4 right-4 text-gray-400 hover:text-[#A33215] text-2xl transition-colors font-bold">✕</button>

        <h3 class="text-xl font-bold text-[#69200F] mb-3 uppercase tracking-tight">Hapus Penduduk?</h3>
        <p class="text-sm text-gray-500 mb-8 font-medium">Yakin ingin menghapus data <strong id="delete_nama_teks" class="text-[#A33215]"></strong>?</p>

        <form id="formDelete" method="POST" class="flex flex-col gap-3">
            @csrf
            @method('DELETE')

            <button type="submit" class="w-full py-4 bg-[#A33215] text-white rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider hover:bg-[#69200F] shadow-xl shadow-orange-100 transition-all">
                Ya, Hapus Sekarang
            </button>
            <button type="button" onclick="closeModal('modalDelete')" class="w-full py-4 text-xs sm:text-sm font-bold text-gray-500 uppercase tracking-wider hover:text-gray-600 transition-all">
                Batal
            </button>
        </form>

    </div>
</div>

<div id="modalFotoPreview" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-[9999] p-4 backdrop-blur-sm">
    <div class="relative max-w-3xl max-h-[90vh]">
        <button onclick="closeModal('modalFotoPreview')"
            class="absolute -top-12 right-0 text-white text-3xl font-bold hover:text-gray-300 focus:outline-none">
            ✕
        </button>
        <img id="preview_foto_img" src="" class="max-w-full max-h-[80vh] rounded-lg shadow-2xl object-contain border border-white/20">
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    function validate16DigitInput(inputEl, warningEl, label) {
        if (!inputEl || !warningEl) return;
        const value = inputEl.value;
        const numbersOnly = /^[0-9]*$/;
        
        if (value.length === 0) {
            warningEl.innerText = 'Wajib 16 digit angka.';
            warningEl.className = 'text-xs text-gray-500 mt-1 font-semibold';
        } else if (!numbersOnly.test(value)) {
            warningEl.innerText = 'Hanya boleh berisi angka!';
            warningEl.className = 'text-xs text-[#A33215] mt-1 font-bold';
        } else if (value.length < 16) {
            warningEl.innerText = `Harus 16 digit (Saat ini: ${value.length} digit)`;
            warningEl.className = 'text-xs text-[#C54716] mt-1 font-semibold';
        } else if (value.length === 16) {
            warningEl.innerText = `${label} Lengkap (16 digit)`;
            warningEl.className = 'text-xs text-[#C54716] mt-1 font-bold';
        }
    }

    // Attach listeners for NIK dynamic helper warnings
    const createNikInput = document.getElementById('create_nik_input');
    const createNikWarning = document.getElementById('create_nik_warning');
    if (createNikInput && createNikWarning) {
        validate16DigitInput(createNikInput, createNikWarning, 'NIK');
        createNikInput.addEventListener('input', function() {
            validate16DigitInput(createNikInput, createNikWarning, 'NIK');
        });
    }

    const editNikInput = document.getElementById('edit_nik');
    const editNikWarning = document.getElementById('edit_nik_warning');
    if (editNikInput && editNikWarning) {
        editNikInput.addEventListener('input', function() {
            validate16DigitInput(editNikInput, editNikWarning, 'NIK');
        });
    }

    // Attach listeners for KK dynamic helper warnings
    const createKkInput = document.getElementById('create_kk_input');
    const createKkWarning = document.getElementById('create_kk_warning');
    if (createKkInput && createKkWarning) {
        validate16DigitInput(createKkInput, createKkWarning, 'No KK');
        createKkInput.addEventListener('input', function() {
            validate16DigitInput(createKkInput, createKkWarning, 'No KK');
        });
    }

    const editKkInput = document.getElementById('edit_kk');
    const editKkWarning = document.getElementById('edit_kk_warning');
    if (editKkInput && editKkWarning) {
        editKkInput.addEventListener('input', function() {
            validate16DigitInput(editKkInput, editKkWarning, 'No KK');
        });
    }

    window.openEditModal = function (
        id, nik, kk, nama, jk, tempat, tgl, agama, pendidikan, pekerjaan,
        statusKawin, rt, rw, desa, kec, kab, prov, alamat, statusPenduduk
    ) {
        const modal = document.getElementById('modalEdit');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.getElementById('formEdit').action = '/penduduk/' + id;

        document.getElementById('edit_nik').value = nik;
        document.getElementById('edit_kk').value = kk;
        document.getElementById('edit_nama').value = nama;
        document.getElementById('edit_jk').value = jk;
        document.getElementById('edit_tempat').value = tempat;
        document.getElementById('edit_tgl').value = tgl;
        document.getElementById('edit_agama').value = agama;
        document.getElementById('edit_pendidikan').value = pendidikan;
        document.getElementById('edit_pekerjaan').value = pekerjaan;
        document.getElementById('edit_status_kawin').value = statusKawin;
        document.getElementById('edit_rt').value = rt;
        document.getElementById('edit_rw').value = rw;
        document.getElementById('edit_desa').value = desa;
        document.getElementById('edit_kecamatan').value = kec;
        document.getElementById('edit_kabupaten').value = kab;
        document.getElementById('edit_provinsi').value = prov;
        document.getElementById('edit_alamat').value = alamat;
        document.getElementById('edit_status').value = statusPenduduk;

        // Perform instant validation of loaded NIK & KK
        validate16DigitInput(editNikInput, editNikWarning, 'NIK');
        validate16DigitInput(editKkInput, editKkWarning, 'No KK');
    }

    window.openDetailModal = function (
        nik, kk, nama, jk, tempat, tgl, agama, pendidikan, pekerjaan,
        statusKawin, rt, rw, desa, kec, kab, prov, alamat, statusPenduduk, foto
    ) {
        const modal = document.getElementById('modalDetail');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.getElementById('detail_nik').value = nik || '';
        document.getElementById('detail_kk').value = kk || '';
        document.getElementById('detail_nama').value = nama || '';
        document.getElementById('detail_jk').value = jk === 'L' ? 'Laki-laki' : 'Perempuan';
        document.getElementById('detail_tempat').value = tempat || '';
        document.getElementById('detail_tgl').value = tgl || '';
        document.getElementById('detail_agama').value = agama || '';
        document.getElementById('detail_pendidikan').value = pendidikan || '';
        document.getElementById('detail_pekerjaan').value = pekerjaan || '';
        document.getElementById('detail_status_kawin').value = statusKawin || '';
        document.getElementById('detail_rt').value = rt || '';
        document.getElementById('detail_rw').value = rw || '';
        document.getElementById('detail_desa').value = desa || '';
        document.getElementById('detail_kecamatan').value = kec || '';
        document.getElementById('detail_kabupaten').value = kab || '';
        document.getElementById('detail_provinsi').value = prov || '';
        document.getElementById('detail_status').value = statusPenduduk || '';
        document.getElementById('detail_alamat').value = alamat || '';
        
        const fotoEl = document.getElementById('detail_foto');
        const fotoKosong = document.getElementById('detail_foto_kosong');
        if(foto && foto.trim() !== '') {
            fotoEl.src = foto;
            fotoEl.classList.remove('hidden');
            fotoKosong.classList.add('hidden');
        } else {
            fotoEl.classList.add('hidden');
            fotoKosong.classList.remove('hidden');
        }
    }

    window.openPhotoPreview = function(src) {
        document.getElementById('preview_foto_img').src = src;
        openModal('modalFotoPreview');
    }

    window.openDeleteModal = function(id, nama) {
        const modal = document.getElementById('modalDelete');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.getElementById('delete_nama_teks').innerText = nama;
        document.getElementById('formDelete').action = `/penduduk/${id}`;
    }

    @if ($errors->any() && old('_method') != 'PUT')
        const modalPenduduk = document.getElementById('modalPenduduk');
        if(modalPenduduk) {
            modalPenduduk.classList.remove('hidden');
            modalPenduduk.classList.add('flex');
        }
    @endif

    // Live Search Script
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        // Posisikan kursor di akhir teks saat pertama kali di-load
        const len = searchInput.value.length;
        if (len > 0) {
            searchInput.focus();
            searchInput.setSelectionRange(len, len);
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                const query = searchInput.value;
                const url = new URL(window.location.href);
                
                if (query) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.delete('search');
                }
                url.searchParams.delete('page'); // Reset ke halaman 1

                fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newTableContent = doc.getElementById('tableContainer').innerHTML;
                        document.getElementById('tableContainer').innerHTML = newTableContent;
                        window.history.pushState({}, '', url);
                    })
                    .catch(err => console.error("Search fetch error:", err));
            }, 400); // 400ms debounce
        });
    }

});
</script>
@endpush