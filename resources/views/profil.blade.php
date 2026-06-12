@extends('layouts.app')

@section('title', 'Profil ' . ucfirst($pengguna->role->nama_role))

@section('content')

<div id="alertSuccess" class="bg-[#FA8145] text-white border border-[#E75C16] p-4 rounded-xl mb-3 text-sm font-bold uppercase tracking-wide hidden">
    Profil berhasil diperbarui
</div>

<div class="bg-white/90 backdrop-blur-sm rounded-[2.5rem] shadow-xl border border-[#FA8145] overflow-hidden max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-12">
        
        <div class="md:col-span-4 px-12 py-10 md:px-16 md:py-12 bg-gradient-to-br from-orange-50 to-white border-b md:border-b-0 md:border-r border-[#FA8145] flex flex-col items-center justify-center text-center">
            @php
                $foto = $pengguna->foto_profil 
                        ? $pengguna->foto_profil
                        : asset('images/user.jpg');
            @endphp

            <div class="relative group">
                <img id="fotoProfil" src="{{ $foto }}"
                    class="w-44 h-44 object-cover rounded-full border-4 border-white shadow-xl group-hover:opacity-90 transition-all">
                <div class="absolute bottom-2 right-2 w-9 h-9 bg-[#C54716] rounded-full border-4 border-white flex items-center justify-center text-white text-xs shadow-lg">
                    ✅
                </div>
            </div>

            <h2 class="mt-6 text-3xl font-bold text-[#A33215] tracking-tight uppercase leading-tight">
                {{ $pengguna->nama }}
            </h2>

            <div class="mt-3 flex items-center gap-2">
                <span class="px-4 py-1.5 bg-orange-50 text-[#C54716] border border-[#FA8145] rounded-full text-sm font-bold uppercase tracking-widest">
                    {{ $pengguna->role->nama_role }}
                </span>
                <span class="text-sm text-gray-400 font-bold uppercase tracking-widest">Padukuhan</span>
            </div>

            <div class="mt-10 flex flex-col gap-4 w-full max-w-[260px]">
                <button onclick="openEditProfil()"
                    class="w-full bg-[#C54716] text-white py-4 rounded-xl font-bold shadow-lg shadow-orange-100 hover:bg-[#A33215] transition-all uppercase tracking-widest text-xs">
                    Ubah Data Profil
                </button>
                <button onclick="openUbahPassword()"
                    class="w-full bg-[#A33215] text-white py-4 rounded-xl font-bold shadow-lg shadow-orange-100 hover:bg-[#69200F] transition-all uppercase tracking-widest text-xs">
                    Ubah Password
                </button>
            </div>
        </div>

        <div class="md:col-span-8 px-12 py-10 md:px-16 md:py-12 flex flex-col justify-center">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                
                <div class="py-4 px-5 rounded-2xl border border-[#FA8145] bg-gray-50/20">
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">NIK (Nomor Induk Kependudukan)</p>
                    <p class="text-lg font-bold text-gray-900 font-mono tracking-tighter">{{ $pengguna->nik ?? '-' }}</p>
                </div>

                <div class="py-4 px-5 rounded-2xl border border-[#FA8145] bg-gray-50/20">
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Nomor Telepon</p>
                    <p id="hpText" class="text-lg font-bold text-gray-900">{{ $pengguna->nomor_telepon_pengguna ?? '-' }}</p>
                </div>

                <div class="py-4 px-5 rounded-2xl border border-[#FA8145] bg-gray-50/20">
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Alamat Email</p>
                    <p id="emailText" class="text-lg font-bold text-gray-900 truncate">{{ $pengguna->email_pengguna }}</p>
                </div>

                <div class="py-4 px-5 rounded-2xl border border-[#FA8145] bg-gray-50/20">
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Jenis Kelamin</p>
                    <p class="text-lg font-bold text-gray-900">{{ $pengguna->jenis_kelamin_pengguna ?? '-' }}</p>
                </div>

                <div class="py-4 px-5 rounded-2xl border border-[#FA8145] bg-gray-50/20">
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Tanggal Lahir</p>
                    <p class="text-lg font-bold text-gray-900">
                        {{ $pengguna->tanggal_lahir_pengguna ? \Carbon\Carbon::parse($pengguna->tanggal_lahir_pengguna)->translatedFormat('d F Y') : '-' }}
                    </p>
                </div>

                <div class="sm:col-span-2 py-4 px-5 rounded-2xl border border-[#FA8145] bg-gray-50/20">
                    <p class="text-xs uppercase tracking-widest font-bold text-gray-400 mb-1">Alamat Lengkap Domisili</p>
                    <p id="alamatText" class="text-lg font-bold text-gray-800 leading-relaxed">
                        {{ $pengguna->alamat_pengguna ?? '-' }}
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>

<div id="editProfilModal" class="fixed inset-0 bg-black/40 hidden flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded-xl w-full max-w-md">

        <h2 class="mb-3 font-semibold">Ubah Profil</h2>

        <form id="formEditProfil" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Ganti Foto Profil</label>
                <input type="file" name="foto_profil" class="text-sm w-full mb-2">
                
                <button type="button" id="btnHapusFoto" onclick="hapusFotoProfil()" 
                    class="text-xs text-[#7F1911] font-bold hover:underline uppercase tracking-wider flex items-center gap-1 {{ !$pengguna->foto_profil ? 'hidden' : '' }}">
                    Hapus Foto Saat Ini
                </button>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Nomor Telepon</label>
                <input type="tel" name="nomor_telepon_pengguna" id="m_nomor_telepon_pengguna" value="{{ $pengguna->nomor_telepon_pengguna }}" class="w-full border p-2 rounded-lg text-sm focus:border-[#C54716] focus:ring-[#C54716]">
                <p id="err_nomor_telepon_pengguna" class="text-[#A33215] text-xs font-bold mt-1 hidden"></p>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Email</label>
                <input type="email" name="email_pengguna" id="m_email_pengguna" value="{{ $pengguna->email_pengguna }}" class="w-full border p-2 rounded-lg text-sm focus:border-[#C54716] focus:ring-[#C54716]">
                <p id="err_email_pengguna" class="text-[#A33215] text-xs font-bold mt-1 hidden"></p>
            </div>

            <label class="block text-xs font-bold text-gray-600 uppercase tracking-wide mb-1">Alamat</label>
            <textarea name="alamat_pengguna" class="w-full border p-2 mb-3 rounded-lg text-sm focus:border-[#C54716] focus:ring-[#C54716]"
                rows="3">{{ $pengguna->alamat_pengguna }}</textarea>

            <div class="flex justify-end gap-3 pt-4 border-t">
                <button type="button" onclick="closeEditProfil()" 
                    class="px-5 py-2 text-[#7F1911] font-bold hover:bg-gray-100 rounded-lg text-xs uppercase tracking-wide">
                    Batal
                </button>

                <button class="px-8 py-2 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 text-xs uppercase tracking-wide">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

</div>

<div id="ubahPasswordModal" class="fixed inset-0 bg-[#69200F]/40 hidden flex items-center justify-center z-50 backdrop-blur-sm">
    <div class="bg-white p-8 rounded-[2.5rem] w-full max-w-md shadow-2xl border border-orange-50 animate-in zoom-in duration-300">
        <h2 class="mb-6 font-bold text-2xl text-[#A33215] uppercase tracking-tight">Ubah Password</h2>
        <div id="passwordError" class="text-sm text-white mb-4 hidden bg-[#A33215] p-4 rounded-2xl border border-[#69200F] font-bold whitespace-pre-line"></div>
        <form id="formUbahPassword">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-600 uppercase tracking-wide mb-1.5">Password Lama</label>
                <input type="password" name="old_password" class="w-full border-2 border-gray-100 focus:border-[#C54716] p-3 rounded-xl transition-all text-base" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-600 uppercase tracking-wide mb-1.5">Password Baru</label>
                <input type="password" name="password" id="new_password" class="w-full border-2 border-gray-100 focus:border-[#C54716] p-3 rounded-xl transition-all mb-1 text-base" required>
                <p class="text-xs text-gray-400 font-semibold italic">*Wajib minimal 8 karakter dan mengandung minimal 1 angka</p>
                <p id="error-new_password" class="text-[#A33215] text-xs font-bold mt-1 hidden"></p>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-600 uppercase tracking-wide mb-1.5">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="new_password_confirmation" class="w-full border-2 border-gray-100 focus:border-[#C54716] p-3 rounded-xl transition-all mb-1 text-base" required>
                <p id="error-new_password_confirmation" class="text-[#A33215] text-xs font-bold mt-1 hidden"></p>
            </div>
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeUbahPassword()" 
                    class="px-5 py-2.5 text-[#7F1911] font-bold hover:bg-gray-100 rounded-xl text-sm uppercase tracking-wide transition-all">
                    Batal
                </button>
                <button type="submit" class="px-8 py-2.5 bg-[#C54716] text-white rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 text-sm uppercase tracking-wide">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<div id="modalKonfirmasiHapus" class="fixed inset-0 bg-[#69200F]/40 hidden flex items-center justify-center z-[60] backdrop-blur-sm">
    <div class="bg-white p-10 rounded-[2.5rem] text-center w-full max-w-sm shadow-2xl border border-orange-50 animate-in fade-in zoom-in duration-300">
        <h3 class="text-xl font-bold text-[#69200F] uppercase tracking-tight mb-3">Hapus Foto?</h3>
        <p class="text-sm text-gray-500 mb-8 leading-relaxed font-medium">Foto profil Anda akan dihapus secara permanen dan dikembalikan ke gambar standar.</p>
        <div class="flex gap-3 justify-center">
            <button type="button" onclick="closeModalKonfirmasi()" class="flex-1 px-4 py-3 bg-gray-100 text-[#7F1911] rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-gray-200 transition-all">Batal</button>
            <button type="button" onclick="performHapusFoto()" class="flex-1 px-4 py-3 bg-[#7F1911] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#5A120C] transition-all shadow-lg shadow-orange-100">Ya, Hapus</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

function openEditProfil() {
    document.getElementById('editProfilModal').classList.remove('hidden');
    document.getElementById('err_nomor_telepon_pengguna').classList.add('hidden');
    document.getElementById('err_email_pengguna').classList.add('hidden');
    document.getElementById('m_nomor_telepon_pengguna').classList.remove('border-[#A33215]');
    document.getElementById('m_email_pengguna').classList.remove('border-[#A33215]');
}

function closeEditProfil() {
    document.getElementById('editProfilModal').classList.add('hidden');
}

document.getElementById('formEditProfil').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("{{ route('pengguna.profil.update') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        if (!res.ok) {
            if (res.status === 422) {
                let data = await res.json();
                
                document.getElementById('err_nomor_telepon_pengguna').classList.add('hidden');
                document.getElementById('err_email_pengguna').classList.add('hidden');
                document.getElementById('m_nomor_telepon_pengguna').classList.remove('border-[#A33215]');
                document.getElementById('m_email_pengguna').classList.remove('border-[#A33215]');

                if (data.errors.nomor_telepon_pengguna) {
                    let p = document.getElementById('err_nomor_telepon_pengguna');
                    p.innerText = data.errors.nomor_telepon_pengguna[0];
                    p.classList.remove('hidden');
                    document.getElementById('m_nomor_telepon_pengguna').classList.add('border-[#A33215]');
                }
                
                if (data.errors.email_pengguna) {
                    let p = document.getElementById('err_email_pengguna');
                    p.innerText = data.errors.email_pengguna[0];
                    p.classList.remove('hidden');
                    document.getElementById('m_email_pengguna').classList.add('border-[#A33215]');
                }
                
                throw new Error("Validation failed");
            }
        }
        return res.json();
    })
    .then(data => {

        document.getElementById('alamatText').innerText = data.alamat_pengguna || '-';
        document.getElementById('hpText').innerText = data.nomor_telepon_pengguna || '-';
        document.getElementById('emailText').innerText = data.email_pengguna || '-';

        const btnHapus = document.getElementById('btnHapusFoto');
        if (data.foto) {
            document.getElementById('fotoProfil').src = data.foto;
            if (btnHapus) btnHapus.classList.remove('hidden');
        } else {
            document.getElementById('fotoProfil').src = "/images/user.jpg";
            if (btnHapus) btnHapus.classList.add('hidden');
        }

        closeEditProfil();
        showAlert();
    })
    .catch(error => {
        console.error(error);
    });
});

function hapusFotoProfil() {
    document.getElementById('modalKonfirmasiHapus').classList.remove('hidden');
}

function closeModalKonfirmasi() {
    document.getElementById('modalKonfirmasiHapus').classList.add('hidden');
}

function performHapusFoto() {
    fetch("{{ route('pengguna.profil.hapusFoto') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('fotoProfil').src = "{{ asset('images/user.jpg') }}";
            const btnHapus = document.getElementById('btnHapusFoto');
            if (btnHapus) btnHapus.classList.add('hidden');
            
            closeModalKonfirmasi();
            closeEditProfil();
            
            const alert = document.getElementById('alertSuccess');
            alert.innerText = "Foto profil berhasil dihapus";
            showAlert();
            setTimeout(() => { alert.innerText = "Profil berhasil diperbarui"; }, 3000);
        }
    });
}

function openUbahPassword() {
    document.getElementById('ubahPasswordModal').classList.remove('hidden');
    document.getElementById('formUbahPassword').reset();
    document.getElementById('passwordError').classList.add('hidden');
    
    document.getElementById('error-new_password').classList.add('hidden');
    document.getElementById('new_password').classList.remove('border-[#A33215]');
    document.getElementById('error-new_password_confirmation').classList.add('hidden');
    document.getElementById('new_password_confirmation').classList.remove('border-[#A33215]');
}

function closeUbahPassword() {
    document.getElementById('ubahPasswordModal').classList.add('hidden');
}

const passwordInput = document.getElementById('new_password');
const passwordError = document.getElementById('error-new_password');
const confirmInput = document.getElementById('new_password_confirmation');
const confirmError = document.getElementById('error-new_password_confirmation');

function validateNewPassword() {
    const val = passwordInput.value;
    if (!val) {
        passwordError.textContent = "Password baru wajib diisi.";
        passwordError.classList.remove('hidden');
        passwordInput.classList.add('border-[#A33215]');
        return false;
    }
    if (val.length < 8) {
        passwordError.textContent = "Password baru minimal harus 8 karakter.";
        passwordError.classList.remove('hidden');
        passwordInput.classList.add('border-[#A33215]');
        return false;
    }
    if (!/\d/.test(val)) {
        passwordError.textContent = "Password baru harus mengandung minimal satu angka.";
        passwordError.classList.remove('hidden');
        passwordInput.classList.add('border-[#A33215]');
        return false;
    }
    passwordError.textContent = "";
    passwordError.classList.add('hidden');
    passwordInput.classList.remove('border-[#A33215]');
    return true;
}

function validateConfirmPassword() {
    const val = confirmInput.value;
    const passVal = passwordInput.value;
    if (!val) {
        confirmError.textContent = "Konfirmasi password baru wajib diisi.";
        confirmError.classList.remove('hidden');
        confirmInput.classList.add('border-[#A33215]');
        return false;
    }
    if (val !== passVal) {
        confirmError.textContent = "Konfirmasi password tidak cocok dengan password baru.";
        confirmError.classList.remove('hidden');
        confirmInput.classList.add('border-[#A33215]');
        return false;
    }
    confirmError.textContent = "";
    confirmError.classList.add('hidden');
    confirmInput.classList.remove('border-[#A33215]');
    return true;
}

passwordInput.addEventListener('input', () => {
    validateNewPassword();
    if (confirmInput.value) {
        validateConfirmPassword();
    }
});

confirmInput.addEventListener('input', validateConfirmPassword);

document.getElementById('formUbahPassword').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const isNewPasswordValid = validateNewPassword();
    const isConfirmValid = validateConfirmPassword();
    
    if (!isNewPasswordValid || !isConfirmValid) {
        return;
    }

    let formData = new FormData(this);
    let errorDiv = document.getElementById('passwordError');
    errorDiv.classList.add('hidden');

    fetch("{{ route('pengguna.profil.updatePassword') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        let data = await res.json();
        if (!res.ok) {
            errorDiv.classList.remove('hidden');
            if(data.errors) {
               errorDiv.innerText = Object.values(data.errors).flat().join("\n");
            } else {
               errorDiv.innerText = data.message || "Terjadi kesalahan.";
            }
        } else {
            closeUbahPassword();
            const alert = document.getElementById('alertSuccess');
            alert.innerText = "Password berhasil diperbarui";
            showAlert();
            setTimeout(() => { alert.innerText = "Profil berhasil diperbarui"; }, 3000);
        }
    });
});

function showAlert() {
    const alert = document.getElementById('alertSuccess');

    alert.classList.remove('hidden');

    setTimeout(() => {
        alert.classList.add('hidden');
    }, 3000);
}

</script>
@endpush
