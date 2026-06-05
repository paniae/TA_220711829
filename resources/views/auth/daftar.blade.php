<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>Daftar Akun - Padukuhan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image: url('/images/batikSemen.jpg');
            background-repeat: repeat;
            background-size: 300px;
            opacity: 0.05;
            z-index: -1;
        }
    </style>
</head>

<body class="bg-orange-50 min-h-screen pt-20 pb-10 flex items-center justify-center px-4">

@php
    $profil = \App\Models\ProfilPadukuhan::first();
@endphp

<header class="w-full bg-[#A33215] text-white shadow-md fixed top-0 left-0 z-50 border-b-2 border-[#C54716]">
    <div class="w-full flex items-center justify-between px-4 md:px-10 py-3">

        <div class="flex items-center gap-3">
            <img src="{{ $profil->logo_padukuhan ? $profil->logo_padukuhan : asset('images/logo.png') }}" class="w-10 h-10 rounded object-contain">

            <div class="leading-tight">
                <p class="text-sm sm:text-base font-bold uppercase tracking-wide">
                    Padukuhan {{ $profil->nama_padukuhan ?? 'Bruno II' }}
                </p>
                <p class="text-[10px] text-orange-200 font-medium uppercase tracking-widest">
                    Kalurahan {{ $profil->nama_kalurahan ?? 'Ngestirejo' }}
                </p>
            </div>
        </div>

        <a href="/"
           class="text-xs px-5 py-2 rounded-xl bg-[#C54716] text-white font-bold hover:bg-[#E75C16] transition-all shadow-md shadow-orange-900/20 uppercase tracking-widest">
            ← Kembali
        </a>

    </div>
</header>

<div class="w-full max-w-lg bg-white/90 backdrop-blur rounded-2xl shadow-xl p-6 sm:p-8 my-8">

    <h2 class="text-xl sm:text-2xl font-semibold text-center text-[#69200F] mb-2">
        Daftar Akun Baru
    </h2>

    <div class="bg-orange-50 border-l-4 border-[#FA8145] p-4 mb-6">
        <p class="text-xs text-[#A33215] font-medium">
            <strong>Perhatian:</strong> Hanya warga asli <strong>Padukuhan Bruno II</strong> yang diperbolehkan mendaftar untuk memiliki akun sistem.
        </p>
    </div>

    <form action="/register" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Nama Lengkap <span class="text-[#A33215]">*</span>
            </label>
            <input type="text" name="nama" id="nama"
                value="{{ old('nama') }}"
                placeholder="Masukkan nama lengkap"
                class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]
                @error('nama') border-[#A33215] @enderror"
                required>
            <p id="error-nama" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
            @error('nama')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1 server-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                NIK <span class="text-[#A33215]">*</span>
            </label>
            <input type="text" name="nik" id="nik"
                value="{{ old('nik') }}"
                placeholder="Masukkan NIK (16 digit)"
                maxlength="16"
                class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]
                @error('nik') border-[#A33215] @enderror"
                required>
            <p id="error-nik" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
            @error('nik')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1 server-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Nomor Telepon <span class="text-[#A33215]">*</span>
            </label>
            <input type="tel" name="nomor_telepon" id="nomor_telepon"
                value="{{ old('nomor_telepon') }}"
                placeholder="08xxxxxxxxxx"
                class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]
                @error('nomor_telepon') border-[#A33215] @enderror"
                required>
            <p id="error-nomor_telepon" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
            @error('nomor_telepon')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1 server-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Email <span class="text-[#A33215]">*</span>
            </label>
            <input type="email" name="email" id="email"
                value="{{ old('email') }}"
                placeholder="masukkan email aktif"
                class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]
                @error('email') border-[#A33215] @enderror"
                required>
            <p id="error-email" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
            @error('email')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1 server-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Jenis Kelamin <span class="text-[#A33215]">*</span>
            </label>
            <select name="jenis_kelamin" id="jenis_kelamin"
                class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716] bg-white
                @error('jenis_kelamin') border-[#A33215] @enderror" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
            </select>
            <p id="error-jenis_kelamin" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
            @error('jenis_kelamin')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1 server-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Tanggal Lahir <span class="text-[#A33215]">*</span>
            </label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                value="{{ old('tanggal_lahir') }}"
                max="{{ date('Y-m-d') }}"
                class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]
                @error('tanggal_lahir') border-[#A33215] @enderror" required>
            <p id="error-tanggal_lahir" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
            @error('tanggal_lahir')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1 server-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Alamat <span class="text-[#A33215]">*</span>
            </label>
            <textarea name="alamat" id="alamat"
                placeholder="Masukkan alamat lengkap"
                class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]
                @error('alamat') border-[#A33215] @enderror"
                rows="2" required>{{ old('alamat') }}</textarea>
            <p id="error-alamat" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
            @error('alamat')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1 server-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Password <span class="text-[#A33215]">*</span>
            </label>
            <div class="relative mt-1">
                <input type="password" name="password" id="password"
                    placeholder="Masukkan password (min. 8 karakter & angka)"
                    class="w-full px-4 py-2.5 pr-10 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]"
                    required>
                <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 focus:outline-none hover:text-[#C54716] transition-colors">
                    <svg class="w-5 h-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg class="w-5 h-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <p id="error-password" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
            @error('password')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1 server-error">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Konfirmasi Password <span class="text-[#A33215]">*</span>
            </label>
            <div class="relative mt-1">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    placeholder="Masukkan kembali password"
                    class="w-full px-4 py-2.5 pr-10 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]"
                    required>
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 focus:outline-none hover:text-[#C54716] transition-colors">
                    <svg class="w-5 h-5 eye-open" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <svg class="w-5 h-5 eye-closed hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <p id="error-password_confirmation" class="text-[#A33215] text-xs sm:text-sm mt-1 hidden"></p>
        </div>

        <div class="bg-orange-50 text-[#A33215] border border-orange-200 text-xs sm:text-sm p-3 rounded-lg text-center mt-2">
            Akun yang didaftarkan <span class="font-semibold">menunggu persetujuan</span> admin.
        </div>

        @if(session('error'))
            <div class="bg-orange-50 text-[#A33215] text-sm p-2 rounded text-center">
                {{ session('error') }}
            </div>
        @endif

        <button type="submit"
            class="w-full bg-[#C54716] text-white py-3 rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 uppercase tracking-widest text-sm sm:text-base mt-4">
            Daftar
        </button>

        <p class="text-center text-sm sm:text-base text-gray-600 mt-4">
            Sudah punya akun? <a href="/login" class="text-[#C54716] font-bold hover:underline">Masuk</a>
        </p>

    </form>

    <p class="text-xs text-center text-gray-400 mt-6">
        © {{ date('Y') }} Padukuhan Bruno II
    </p>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    
    // Unique status checking configurations
    const uniqueStates = {
        nik: true,
        nomor_telepon: true,
        email: true
    };
    const checkTimeouts = {
        nik: null,
        nomor_telepon: null,
        email: null
    };
    
    const inputs = {
        nama: {
            el: document.getElementById("nama"),
            errorEl: document.getElementById("error-nama"),
            validate: (val) => {
                if (!val.trim()) return "Nama lengkap wajib diisi.";
                return "";
            }
        },
        nik: {
            el: document.getElementById("nik"),
            errorEl: document.getElementById("error-nik"),
            validate: (val) => {
                uniqueStates.nik = true; // Reset uniqueness status when NIK changes
                if (!val.trim()) return "NIK wajib diisi.";
                if (!/^\d+$/.test(val)) return "NIK harus berupa angka saja.";
                if (val.length !== 16) return "NIK wajib tepat 16 digit.";
                return "";
            }
        },
        nomor_telepon: {
            el: document.getElementById("nomor_telepon"),
            errorEl: document.getElementById("error-nomor_telepon"),
            validate: (val) => {
                uniqueStates.nomor_telepon = true; // Reset uniqueness status when phone changes
                if (!val.trim()) return "Nomor telepon wajib diisi.";
                if (!/^\d+$/.test(val)) return "Nomor telepon harus berupa angka saja.";
                if (val.length < 10 || val.length > 13) return "Nomor telepon harus terdiri dari 10 - 13 digit.";
                return "";
            }
        },
        email: {
            el: document.getElementById("email"),
            errorEl: document.getElementById("error-email"),
            validate: (val) => {
                uniqueStates.email = true; // Reset uniqueness status when email changes
                if (!val.trim()) return "Email wajib diisi.";
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(val)) return "Format email tidak valid.";
                return "";
            }
        },
        jenis_kelamin: {
            el: document.getElementById("jenis_kelamin"),
            errorEl: document.getElementById("error-jenis_kelamin"),
            validate: (val) => {
                if (!val) return "Jenis kelamin wajib dipilih.";
                return "";
            }
        },
        tanggal_lahir: {
            el: document.getElementById("tanggal_lahir"),
            errorEl: document.getElementById("error-tanggal_lahir"),
            validate: (val) => {
                if (!val) return "Tanggal lahir wajib diisi.";
                
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const todayStr = `${year}-${month}-${day}`;
                
                if (val > todayStr) return "Tanggal lahir tidak boleh setelah hari ini.";
                return "";
            }
        },
        alamat: {
            el: document.getElementById("alamat"),
            errorEl: document.getElementById("error-alamat"),
            validate: (val) => {
                if (!val.trim()) return "Alamat wajib diisi.";
                return "";
            }
        },
        password: {
            el: document.getElementById("password"),
            errorEl: document.getElementById("error-password"),
            validate: (val) => {
                if (!val) return "Password wajib diisi.";
                if (val.length < 8) return "Password minimal harus 8 karakter.";
                if (!/\d/.test(val)) return "Password harus mengandung minimal satu angka.";
                return "";
            }
        },
        password_confirmation: {
            el: document.getElementById("password_confirmation"),
            errorEl: document.getElementById("error-password_confirmation"),
            validate: (val) => {
                const passVal = document.getElementById("password").value;
                if (!val) return "Konfirmasi password wajib diisi.";
                if (val !== passVal) return "Konfirmasi password tidak cocok dengan password utama.";
                return "";
            }
        }
    };

    function validateField(key) {
        const field = inputs[key];
        if (!field || !field.el) return true;
        
        const value = field.el.value;
        const errorMessage = field.validate(value);
        
        // Hide server error message when client interaction starts
        const parent = field.el.parentElement;
        const serverError = parent.querySelector(".server-error");
        if (serverError) {
            serverError.style.display = 'none';
        }

        if (errorMessage) {
            field.errorEl.textContent = errorMessage;
            field.errorEl.classList.remove("hidden");
            field.el.classList.remove("border-gray-200");
            field.el.classList.add("border-[#A33215]", "focus:ring-[#A33215]", "focus:border-[#A33215]");
            return false;
        } else {
            field.errorEl.textContent = "";
            field.errorEl.classList.add("hidden");
            field.el.classList.remove("border-[#A33215]", "focus:ring-[#A33215]", "focus:border-[#A33215]");
            field.el.classList.add("border-gray-200");

            // Perform uniqueness checks if local format validation passes
            if (key === 'nik' && value.length === 16) {
                checkFieldUniqueness('nik', value);
            } else if (key === 'nomor_telepon' && value.length >= 10 && value.length <= 13) {
                checkFieldUniqueness('nomor_telepon', value);
            } else if (key === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailRegex.test(value)) {
                    checkFieldUniqueness('email', value);
                }
            }
            return true;
        }
    }

    function checkFieldUniqueness(fieldKey, value) {
        clearTimeout(checkTimeouts[fieldKey]);
        
        // Debounce to avoid multiple API calls during rapid typing
        checkTimeouts[fieldKey] = setTimeout(() => {
            fetch(`/check-uniqueness?field=${fieldKey}&value=${encodeURIComponent(value)}`)
                .then(response => response.json())
                .then(data => {
                    const field = inputs[fieldKey];
                    const labelNames = {
                        nik: "NIK",
                        nomor_telepon: "Nomor telepon",
                        email: "Email"
                    };
                    if (data.exists) {
                        uniqueStates[fieldKey] = false;
                        field.errorEl.textContent = `${labelNames[fieldKey]} ini sudah terdaftar.`;
                        field.errorEl.classList.remove("hidden");
                        field.el.classList.remove("border-gray-200");
                        field.el.classList.add("border-[#A33215]", "focus:ring-[#A33215]", "focus:border-[#A33215]");
                    } else {
                        uniqueStates[fieldKey] = true;
                        if (field.errorEl.textContent === `${labelNames[fieldKey]} ini sudah terdaftar.`) {
                            field.errorEl.textContent = "";
                            field.errorEl.classList.add("hidden");
                            field.el.classList.remove("border-[#A33215]", "focus:ring-[#A33215]", "focus:border-[#A33215]");
                            field.el.classList.add("border-gray-200");
                        }
                    }
                })
                .catch(err => console.error(`Error checking ${fieldKey} uniqueness:`, err));
        }, 300);
    }

    // Attach listeners
    Object.keys(inputs).forEach(key => {
        const inputObj = inputs[key];
        if (inputObj.el) {
            // Validate on input
            inputObj.el.addEventListener("input", function() {
                if (key === 'nik' || key === 'nomor_telepon') {
                    this.value = this.value.replace(/\D/g, '');
                }
                validateField(key);
                if (key === 'password') {
                    // Revalidate confirmation field if password changes
                    validateField('password_confirmation');
                }
            });
            // Validate on blur
            inputObj.el.addEventListener("blur", function() {
                if (key === 'nik' || key === 'nomor_telepon') {
                    this.value = this.value.replace(/\D/g, '');
                }
                validateField(key);
            });
            // Handle select specifically on change
            if (inputObj.el.tagName === "SELECT") {
                inputObj.el.addEventListener("change", function() {
                    validateField(key);
                });
            }
        }
    });

    // Form submit validation
    form.addEventListener("submit", function(e) {
        let isFormValid = true;
        let firstInvalidField = null;

        Object.keys(inputs).forEach(key => {
            const isValid = validateField(key);
            if (!isValid) {
                isFormValid = false;
                if (!firstInvalidField) {
                    firstInvalidField = inputs[key].el;
                }
            }
        });

        // Block submit if any unique field is already registered
        const uniqueKeys = ['nik', 'nomor_telepon', 'email'];
        const labelNames = {
            nik: "NIK",
            nomor_telepon: "Nomor telepon",
            email: "Email"
        };

        uniqueKeys.forEach(key => {
            if (isFormValid && !uniqueStates[key]) {
                isFormValid = false;
                firstInvalidField = inputs[key].el;
                inputs[key].errorEl.textContent = `${labelNames[key]} ini sudah terdaftar.`;
                inputs[key].errorEl.classList.remove("hidden");
                inputs[key].el.classList.remove("border-gray-200");
                inputs[key].el.classList.add("border-[#A33215]", "focus:ring-[#A33215]", "focus:border-[#A33215]");
            }
        });

        if (!isFormValid) {
            e.preventDefault();
            if (firstInvalidField) {
                firstInvalidField.focus();
                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    });
});

function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const eyeOpen = btn.querySelector('.eye-open');
    const eyeClosed = btn.querySelector('.eye-closed');
    
    if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        input.type = "password";
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
}
</script>

</body>
</html>
