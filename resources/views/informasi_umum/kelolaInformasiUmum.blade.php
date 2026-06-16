@extends('layouts.app')

@section('title', 'Informasi Padukuhan')

@section('content')

<div class="relative overflow-hidden bg-white rounded-3xl p-5 md:p-8 shadow-sm border border-[#FA8145] mb-8">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="text-center md:text-left">
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#A33215] leading-tight uppercase tracking-tight">
                Informasi Padukuhan
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-2 font-medium max-w-md">
                Kelola profil dan kontak padukuhan dalam satu halaman.
            </p>
        </div>

        <div class="bg-gray-100/80 p-1.5 rounded-2xl flex gap-1 border border-gray-200 shadow-inner w-full md:w-auto overflow-x-auto no-scrollbar">
            <button onclick="switchTab('profil')" id="tab-profil" 
                class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all bg-white text-[#C54716] shadow-sm uppercase tracking-wide">
                Profil Padukuhan
            </button>
            <button onclick="switchTab('kontak')" id="tab-kontak" 
                class="tab-btn flex-1 md:flex-none px-6 py-2.5 rounded-xl text-sm sm:text-base font-semibold transition-all text-gray-500 hover:text-[#C54716] uppercase tracking-wide">
                Kontak Padukuhan
            </button>
        </div>
    </div>
</div>

@if(session('success'))
<div id="alertSuccess"
     class="bg-[#FA8145] text-white border border-[#E75C16] p-4 rounded-xl mb-4 font-bold text-sm uppercase tracking-wide">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div id="alertError"
     class="bg-[#A33215] text-white border border-[#69200F] p-4 rounded-xl mb-4 font-bold text-sm uppercase tracking-wide">
    <p class="font-bold">Gagal memperbarui profil:</p>
    <ul class="list-disc ml-5 text-xs mt-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div id="panel-profil" class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-[#FA8145] overflow-hidden">
        <div class="p-5 bg-white border-b border-[#FA8145] flex justify-between items-center">
            <div>
                <h2 class="font-bold text-[#A33215] text-xl flex items-center gap-2">
                    Profil Padukuhan
                </h2>
                <p class="text-sm text-[#E75C16] font-bold uppercase tracking-widest">Identitas Resmi Padukuhan</p>
            </div>
            <button onclick="openModal('modalEditProfil')" 
                class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#A33215] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-orange-100 whitespace-nowrap text-center">
                Ubah Profil
            </button>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl border border-gray-200 bg-white">
                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Nama Padukuhan</p>
                        <p class="text-lg font-bold text-gray-900">{{ $profil->nama_padukuhan ?? '-' }}</p>
                    </div>
                    <div class="p-4 rounded-xl border border-gray-200 bg-white">
                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Jam Operasional</p>
                        <p class="text-lg font-bold text-gray-900">{{ $profil->jam_operasional ?? '-' }}</p>
                    </div>
                    <div class="p-4 rounded-xl border border-gray-200 bg-white">
                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Kalurahan</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $profil->nama_kalurahan ?? '-' }}</p>
                    </div>
                    <div class="p-4 rounded-xl border border-gray-200 bg-white">
                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Kecamatan</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $profil->nama_kecamatan ?? '-' }}</p>
                    </div>
                    <div class="p-4 rounded-xl border border-gray-200 bg-white">
                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Kabupaten</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $profil->nama_kabupaten ?? '-' }}</p>
                    </div>
                    <div class="sm:col-span-2 p-4 rounded-xl border border-gray-200 bg-white">
                        <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Alamat Balai Padukuhan</p>
                        <p class="text-lg text-gray-700 leading-relaxed">{{ $profil->alamat_balai ?? '-' }}</p>
                        @if($profil && $profil->link_maps_balai)
                            <a href="{{ $profil->link_maps_balai }}" target="_blank" class="mt-2 inline-flex items-center gap-1 text-xs font-bold text-[#C54716] hover:underline uppercase tracking-widest">
                                Lihat di Google Maps
                            </a>
                        @else
                            <p class="mt-2 text-xs font-bold text-gray-400 italic uppercase tracking-widest">Link Google Maps Belum Tersedia</p>
                        @endif
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="p-4 rounded-xl border border-gray-200 bg-white">
                        <p class="text-xs uppercase tracking-widest font-bold text-[#E75C16] mb-1">Visi</p>
                        <p class="text-lg font-bold text-[#69200F] italic">"{{ $profil->visi ?? '-' }}"</p>
                    </div>
                    <div class="p-4 rounded-xl border border-gray-200 bg-white">
                        <p class="text-xs uppercase tracking-widest font-bold text-[#E75C16] mb-1">Misi</p>
                        <div class="text-base text-gray-700 whitespace-pre-line leading-relaxed font-medium">{{ $profil->misi ?? '-' }}</div>
                    </div>
                </div>

            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 p-5 rounded-2xl border border-gray-200 bg-white">
                     <h3 class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-8 h-[2px] bg-gray-200"></span> Sejarah Padukuhan
                     </h3>
                     <p class="text-base text-gray-700 leading-relaxed text-justify">
                        {{ $profil->sejarah ?? 'Belum ada sejarah yang dicatat.' }}
                     </p>
                </div>

                <div class="space-y-4">
                    <div class="p-3 rounded-2xl border border-gray-200 bg-white">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Foto Balai</p>
                        @if(($profil->foto_balai ?? null))
                            @if(Str::endsWith(strtolower($profil->foto_balai), ['.heic', '.heif']))
                                <div class="w-full h-32 bg-[#FA8145] text-white rounded-xl flex flex-col items-center justify-center p-4 text-center border border-[#E75C16]">
                                    <p class="text-[9px] font-bold uppercase tracking-tighter">Format HEIC Tidak Didukung Browser</p>
                                    <p class="text-[8px] text-orange-100 mt-1">Mohon ganti dengan format JPG/PNG</p>
                                </div>
                            @else
                                <img src="{{ $profil->foto_balai }}" class="w-full h-32 object-cover rounded-xl shadow-sm" onclick="openImageModal('{{ $profil->foto_balai }}')" style="cursor:pointer;">
                            @endif
                        @else
                            <div class="w-full h-32 bg-gray-50 rounded-xl flex items-center justify-center text-xs text-gray-400 border border-dashed">Belum ada foto balai</div>
                        @endif
                    </div>
                    <div class="p-3 rounded-2xl border border-gray-200 bg-white">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Foto Kebersamaan</p>
                        @if(($profil->foto_kebersamaan ?? null))
                            @if(Str::endsWith(strtolower($profil->foto_kebersamaan), ['.heic', '.heif']))
                                <div class="w-full h-32 bg-[#FA8145] text-white rounded-xl flex flex-col items-center justify-center p-4 text-center border border-[#E75C16]">
                                    <p class="text-[9px] font-bold uppercase tracking-tighter">Format HEIC Tidak Didukung Browser</p>
                                    <p class="text-[8px] text-orange-100 mt-1">Mohon ganti dengan format JPG/PNG</p>
                                </div>
                            @else
                                <img src="{{ $profil->foto_kebersamaan }}" class="w-full h-32 object-cover rounded-xl shadow-sm" onclick="openImageModal('{{ $profil->foto_kebersamaan }}')" style="cursor:pointer;">
                            @endif
                        @else
                            <div class="w-full h-32 bg-gray-50 rounded-xl flex items-center justify-center text-xs text-gray-400 border border-dashed">Belum ada foto kebersamaan</div>
                        @endif
                    </div>
                    <div class="p-3 rounded-2xl border border-gray-200 bg-white">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 px-1">Logo Resmi</p>
                        @if(($profil->logo_logo ?? null) || ($profil->logo_padukuhan ?? null))
                            @php $logoUrl = $profil->logo_padukuhan ?? $profil->logo_logo; @endphp
                            @if(Str::endsWith(strtolower($logoUrl), ['.heic', '.heif']))
                                <div class="w-full h-32 bg-[#FA8145] text-white rounded-xl flex flex-col items-center justify-center p-4 text-center border border-[#E75C16]">
                                    <p class="text-[9px] font-bold uppercase tracking-tighter">Format HEIC Tidak Didukung Browser</p>
                                    <p class="text-[8px] text-orange-100 mt-1">Mohon ganti dengan format JPG/PNG</p>
                                </div>
                            @else
                                <img src="{{ $logoUrl }}" class="w-full h-32 object-contain rounded-xl p-2" onclick="openImageModal('{{ $logoUrl }}')" style="cursor:pointer;">
                            @endif
                        @else
                            <div class="w-full h-32 bg-gray-50 rounded-xl flex items-center justify-center text-xs text-gray-400 border border-dashed">Belum ada logo</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="panel-kontak" class="hidden">
    <div class="bg-white rounded-xl shadow border border-[#FA8145] overflow-hidden">
        <div class="p-4 bg-white border-b border-[#FA8145] flex justify-between items-center">
            <h2 class="font-bold text-[#A33215] text-xl">
                Kontak Padukuhan
            </h2>
            <button onclick="openModal('modalEditKontak')" 
                class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl text-xs sm:text-sm font-bold uppercase tracking-wider hover:bg-[#A33215] transition-all hover:scale-105 active:scale-95 shadow-lg shadow-orange-100 whitespace-nowrap text-center">
                Ubah Kontak
            </button>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="p-4 rounded-xl border border-gray-200 bg-white">
                    <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Nomor Telepon</p>
                    <p class="text-lg font-bold text-gray-900">{{ $kontak->nomor_telepon ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl border border-gray-200 bg-white">
                    <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Email Resmi</p>
                    <p class="text-lg font-bold text-gray-900 text-ellipsis overflow-hidden">{{ $kontak->email ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl border border-gray-200 bg-white">
                    <p class="text-[10px] uppercase tracking-[0.2em] font-black text-gray-900 mb-1">Instagram</p>
                    <p class="text-lg font-bold text-gray-900">@ {{ $kontak->instagram ?? '-' }}</p>
                </div>
            </div>
            <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Status Publikasi Kontak</p>
                    <p class="text-xs text-gray-400">Menentukan apakah kontak ini dapat dilihat oleh warga/publik</p>
                </div>
                <div>
                    @if(($kontak->status_kontak ?? 'aktif') == 'aktif')
                        <span class="px-4 py-1.5 bg-[#FA8145]/10 text-[#C54716] border border-[#FA8145]/30 rounded-full text-xs font-bold uppercase tracking-wider inline-block">Aktif / Terlihat</span>
                    @else
                        <span class="px-4 py-1.5 bg-[#A33215]/10 text-[#A33215] border border-[#A33215]/30 rounded-full text-xs font-bold uppercase tracking-wider inline-block">Tidak Aktif / Disembunyikan</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalEditProfil" class="fixed top-0 left-0 w-screen h-screen bg-black/40 hidden z-[999] flex items-center justify-center">
    <div class="bg-white w-full max-w-4xl mx-2 rounded-xl shadow-lg max-h-[90vh] flex flex-col relative">
        <button onclick="closeModal('modalEditProfil')" class="absolute top-4 right-4 text-gray-400 hover:text-black text-xl">✕</button>
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-[#A33215] uppercase tracking-tight">Ubah Profil Padukuhan</h2>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
        </div>
        <form action="{{ route('informasiUmum.profil.update') }}" method="POST" enctype="multipart/form-data" class="flex-1 overflow-y-auto">
            @csrf
            @method('PUT')
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-base font-bold text-gray-700">Nama Padukuhan</label>
                        <input type="text" name="nama_padukuhan" value="{{ $profil->nama_padukuhan ?? '' }}" class="w-full mt-1 border-2 border-gray-200 p-3 rounded-lg text-base">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-base font-bold text-gray-700">Kalurahan</label>
                            <input type="text" name="nama_kalurahan" value="{{ $profil->nama_kalurahan ?? '' }}" class="w-full mt-1 border-2 border-gray-200 p-3 rounded-lg text-base">
                        </div>
                        <div>
                            <label class="text-base font-bold text-gray-700">Jam Operasional</label>
                            <input type="text" name="jam_operasional" value="{{ $profil->jam_operasional ?? '' }}" placeholder="Contoh: 08:00 - 16:00" class="w-full mt-1 border-2 border-gray-200 p-2 rounded-lg">
                        </div>
                        <div>
                            <label class="text-sm font-bold text-gray-700">Kecamatan</label>
                            <input type="text" name="nama_kecamatan" value="{{ $profil->nama_kecamatan ?? '' }}" class="w-full mt-1 border-2 border-gray-200 p-2 rounded-lg">
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700">Kabupaten</label>
                        <input type="text" name="nama_kabupaten" value="{{ $profil->nama_kabupaten ?? '' }}" class="w-full mt-1 border-2 border-gray-200 p-2 rounded-lg">
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700">Alamat Balai</label>
                        <textarea name="alamat_balai" rows="4" class="w-full mt-1 border-2 border-gray-200 p-2 rounded-lg">{{ $profil->alamat_balai ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700">Visi</label>
                        <textarea name="visi" rows="5" class="w-full mt-1 border-2 border-gray-200 p-2 rounded-lg">{{ $profil->visi ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700">Link Google Maps Balai</label>
                        <input type="text" name="link_maps_balai" value="{{ $profil->link_maps_balai ?? '' }}" placeholder="https://goo.gl/maps/..." class="w-full mt-1 border-2 border-gray-200 p-2 rounded-lg">
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-bold text-gray-700">Misi</label>
                        <textarea name="misi" rows="8" class="w-full mt-1 border-2 border-gray-200 p-2 rounded-lg">{{ $profil->misi ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700">Sejarah</label>
                        <textarea name="sejarah" rows="10" class="w-full mt-1 border-2 border-gray-200 p-2 rounded-lg">{{ $profil->sejarah ?? '' }}</textarea>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-gray-700">Media Padukuhan (Opsional)</label>
                        <div class="flex flex-col gap-4 mt-2">
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Foto Balai Padukuhan</label>
                                <input type="file" name="foto_balai" class="w-full text-xs border-2 border-gray-200 p-2 rounded-lg bg-gray-50">
                                <p class="text-[10px] text-gray-400 italic mt-1">* Pilih untuk ganti foto balai saat ini</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Foto Kebersamaan Warga</label>
                                <input type="file" name="foto_kebersamaan" class="w-full text-xs border-2 border-gray-200 p-2 rounded-lg bg-gray-50">
                                <p class="text-[10px] text-gray-400 italic mt-1">* Pilih untuk ganti foto kebersamaan saat ini</p>
                            </div>
                            <div>
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-1">Logo Padukuhan</label>
                                <input type="file" name="logo_padukuhan" class="w-full text-xs border-2 border-gray-200 p-2 rounded-lg bg-gray-50">
                                <p class="text-[10px] text-gray-400 italic mt-1">* Pilih untuk ganti logo resmi padukuhan</p>
                            </div>
                            <div class="bg-[#FA8145] p-3 rounded-lg border border-[#E75C16] text-white">
                                <p class="text-[10px] leading-relaxed font-medium">
                                    <strong>Catatan Format:</strong> Jika menggunakan iPhone (file .HEIC), sangat disarankan untuk mengonversinya ke .JPG atau .PNG terlebih dahulu agar gambar dapat muncul di semua browser.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t bg-gray-50 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalEditProfil')" class="px-5 py-2 text-[#7F1911] font-bold hover:bg-gray-100 rounded-lg text-sm uppercase tracking-wide">Batal</button>
                <button type="submit" class="px-8 py-2 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 text-sm uppercase tracking-wide">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<div id="modalEditKontak" class="fixed top-0 left-0 w-screen h-screen bg-black/40 hidden z-[999] flex items-center justify-center">
    <div class="bg-white w-full max-w-md mx-2 rounded-xl shadow-lg relative">
        <button onclick="closeModal('modalEditKontak')" class="absolute top-4 right-4 text-gray-400 hover:text-black text-xl">✕</button>
        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-[#A33215] uppercase tracking-tight">Ubah Kontak</h2>
            <p class="text-[10px] text-[#E75C16] mt-2 uppercase tracking-widest font-bold">
                <span class="text-[#A33215]">*</span> Wajib Diisi Lengkap
            </p>
        </div>
        <form action="{{ route('informasiUmum.kontak.update') }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="text-sm font-bold text-gray-700">Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ $kontak->nomor_telepon ?? '' }}" class="w-full mt-1 border-2 border-gray-300 p-2 rounded-lg">
            </div>
            <div>
                <label class="text-sm font-bold text-gray-700">Email</label>
                <input type="email" name="email" value="{{ $kontak->email ?? '' }}" class="w-full mt-1 border-2 border-gray-300 p-2 rounded-lg">
            </div>
            <div>
                <label class="text-sm font-bold text-gray-700">Instagram</label>
                <div class="flex mt-1">
                    <span class="inline-flex items-center px-3 rounded-l-lg border-2 border-r-0 border-gray-300 bg-gray-100 text-gray-500 text-sm">@</span>
                    <input type="text" name="instagram" value="{{ $kontak->instagram ?? '' }}" class="flex-1 border-2 border-gray-300 p-2 rounded-r-lg">
                </div>
            </div>
            <div>
                <label class="text-sm font-bold text-gray-700">Status Publikasi</label>
                <div class="flex gap-4 mt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status_kontak" value="aktif" {{ ($kontak->status_kontak ?? 'aktif') == 'aktif' ? 'checked' : '' }} class="accent-[#C54716]">
                        <span class="text-sm font-bold text-[#E75C16]">Aktif</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="status_kontak" value="tidak aktif" {{ ($kontak->status_kontak ?? '') == 'tidak aktif' ? 'checked' : '' }} class="accent-[#C54716]">
                        <span class="text-sm font-bold text-[#A33215]">Tidak Aktif</span>
                    </label>
                </div>
            </div>
            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="closeModal('modalEditKontak')" class="px-5 py-2 text-[#7F1911] font-bold hover:bg-gray-100 rounded-lg text-sm uppercase tracking-wide">Batal</button>
                <button type="submit" class="px-8 py-2 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 text-sm uppercase tracking-wide">Simpan Kontak</button>
            </div>
        </form>
    </div>
</div>

<div id="modalImage" class="fixed inset-0 bg-black/70 hidden z-[1000] flex items-center justify-center p-4 backdrop-blur-sm" onclick="if(event.target===this) closeModal('modalImage')">
    <div class="relative max-w-3xl w-full flex items-center justify-center">
        <button onclick="closeModal('modalImage')" class="absolute -top-3 -right-3 bg-white rounded-full w-8 h-8 flex items-center justify-center text-gray-600 hover:text-black shadow-lg z-10">✕</button>
        <img id="modalImg" src="" class="max-w-full max-h-[85vh] object-contain rounded-xl shadow-2xl" alt="Enlarged Image">
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
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);

function switchTab(tab) {
    const panels = ['profil', 'kontak'];
    panels.forEach(p => {
        const el = document.getElementById('panel-' + p);
        const btn = document.getElementById('tab-' + p);
        if(el) el.classList.add('hidden');
        if(btn) {
            btn.classList.remove('bg-white', 'text-[#C54716]', 'shadow-sm');
            btn.classList.add('text-gray-500', 'hover:text-[#C54716]');
        }
    });

    const activePanel = document.getElementById('panel-' + tab);
    const activeBtn = document.getElementById('tab-' + tab);
    if(activePanel) activePanel.classList.remove('hidden');
    if(activeBtn) {
        activeBtn.classList.add('bg-white', 'text-[#C54716]', 'shadow-sm');
        activeBtn.classList.remove('text-gray-500', 'hover:text-[#C54716]');
    }
}

// Open image modal
function openImageModal(src) {
    const img = document.getElementById('modalImg');
    img.src = src;
    openModal('modalImage');
}


// Buka modal kembali jika ada error validasi profil
@if($errors->hasAny(['visi', 'misi', 'alamat_balai', 'nama_padukuhan', 'nama_kalurahan', 'nama_kecamatan', 'nama_kabupaten', 'sejarah', 'jam_operasional', 'foto_balai', 'foto_kebersamaan', 'logo_padukuhan']))
    openModal('modalEditProfil');
@endif

// Buka modal kembali jika ada error validasi kontak
@if($errors->hasAny(['nomor_telepon', 'email', 'instagram', 'status_kontak']))
    openModal('modalEditKontak');
    switchTab('kontak');
@endif

// Jika setelah simpan kontak (cek URL hash atau session dari redirect back)
@if(session('success') && request()->is('kontakPadukuhan*'))
    switchTab('kontak');
@endif
</script>
@endpush
