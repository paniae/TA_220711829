<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>Login - Padukuhan</title>

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

<body class="bg-orange-50 min-h-screen pt-20 flex items-center justify-center px-4">

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

<div class="w-full max-w-md bg-white/90 backdrop-blur rounded-2xl shadow-xl p-6 sm:p-8">

    <h2 class="text-xl sm:text-2xl font-semibold text-center text-[#69200F] mb-2">
        Masuk ke Sistem
    </h2>

    <p class="text-center text-gray-500 text-sm mb-6">
        Silakan login menggunakan nomor telepon
    </p>

    <form action="/login" method="POST" class="space-y-4">
        @csrf

        @if(session('success'))
            <div id="alertSuccess" class="bg-orange-50 border-l-4 border-[#C54716] text-[#A33215] p-4 mb-4 rounded-xl shadow-sm flex items-start justify-between gap-2 transition-all duration-300">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-bold flex items-center gap-1.5 text-[#A33215]">
                        <span class="text-sm">🎉</span> Berhasil!
                    </p>
                    <p class="text-[10px] sm:text-xs text-orange-950 font-medium mt-1 leading-relaxed">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="document.getElementById('alertSuccess').remove()" class="text-[#C54716] hover:text-[#A33215] font-bold text-sm px-1.5 focus:outline-none transition-colors">
                    ✕
                </button>
            </div>
        @endif

        @if(session('error'))
            <div id="alertError" class="bg-orange-50 border-l-4 border-[#A33215] text-[#A33215] p-4 mb-4 rounded-xl shadow-sm flex items-start justify-between gap-2 transition-all duration-300">
                <div class="flex-1">
                    <p class="text-xs sm:text-sm font-bold flex items-center gap-1.5 text-[#A33215]">
                        <span class="text-sm">❌</span> Gagal!
                    </p>
                    <p class="text-[10px] sm:text-xs text-red-950 font-medium mt-1 leading-relaxed">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="document.getElementById('alertError').remove()" class="text-[#A33215] hover:text-[#A33215] font-bold text-sm px-1.5 focus:outline-none transition-colors">
                    ✕
                </button>
            </div>
        @endif

        <div>
            <label class="text-sm sm:text-base font-semibold text-gray-700">
                Nomor Telepon <span class="text-[#A33215]">*</span>
            </label>
            <input type="tel" name="nomor_telepon"
                value="{{ old('nomor_telepon') }}"
                placeholder="08xxxxxxxxxx"
                class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]
                @error('nomor_telepon') border-[#A33215] @enderror"
                required>

            @error('nomor_telepon')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <div class="flex justify-between items-center">
                <label class="text-sm sm:text-base font-semibold text-gray-700">
                    Password <span class="text-[#A33215]">*</span>
                </label>
                <button type="button" onclick="openForgotModal()" class="text-xs sm:text-sm text-[#C54716] font-bold hover:underline focus:outline-none">
                    Lupa Password?
                </button>
            </div>
            <div class="relative mt-1">
                <input type="password" name="password" id="password"
                    placeholder="Masukkan password"
                    class="w-full px-4 py-2.5 pr-10 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]
                    @error('password') border-[#A33215] @enderror"
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

            @error('password')
                <p class="text-[#A33215] text-xs sm:text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        @error('login')
            <div class="bg-orange-50 text-[#A33215] text-sm sm:text-base p-2.5 rounded-xl text-center">
                {{ $message }}
            </div>
        @enderror

        <button type="submit"
            class="w-full bg-[#C54716] text-white py-3 rounded-xl font-bold hover:bg-[#A33215] transition-all shadow-lg shadow-orange-100 uppercase tracking-widest text-sm sm:text-base mt-4">
            Masuk
        </button>

        <p class="text-center text-sm sm:text-base text-gray-600 mt-4">
            Belum punya akun? <a href="/register" class="text-[#C54716] font-bold hover:underline">Daftar</a>
        </p>

    </form>

    <p class="text-xs text-center text-gray-400 mt-6">
        © {{ date('Y') }} Padukuhan Bruno II
    </p>

</div>

<div id="modalLupaPassword" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50 p-4">
    <div class="bg-white w-full max-w-md rounded-2xl shadow-lg relative p-6">
        <button type="button" onclick="closeForgotModal()"
            class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center text-gray-500 hover:text-black rounded-full hover:bg-gray-100 text-lg">
            ✕
        </button>

        <h2 class="text-xl sm:text-2xl font-bold text-[#A33215] mb-2">Lupa Password?</h2>
        <p class="text-xs sm:text-sm text-gray-500 mb-6 leading-relaxed">
            Masukkan Nomor Telepon dan Tanggal Lahir Anda yang terdaftar. Jika data sesuai, password Anda akan diatur ulang menjadi tanggal lahir Anda (Format: <strong>ddmmyyyy</strong>, contoh: 01012001).
        </p>

        <form action="{{ route('forgot-password.reset') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="text-sm sm:text-base font-semibold text-gray-700">Nomor Telepon <span class="text-[#A33215]">*</span></label>
                <input type="tel" name="reset_nomor_telepon" placeholder="08xxxxxxxxxx" class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]" required>
            </div>

            <div>
                <label class="text-sm sm:text-base font-semibold text-gray-700">Tanggal Lahir <span class="text-[#A33215]">*</span></label>
                <input type="date" name="reset_tanggal_lahir" max="{{ date('Y-m-d') }}" class="w-full mt-1 px-4 py-2.5 text-sm sm:text-base border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#C54716] focus:border-[#C54716]" required>
            </div>

            <div class="pt-2 flex justify-end gap-2">
                <button type="button" onclick="closeForgotModal()" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded-xl font-bold text-sm sm:text-base">
                    Batal
                </button>
                <button type="submit" class="bg-[#C54716] text-white px-5 py-2.5 rounded-xl font-bold hover:bg-[#A33215] transition-all text-sm sm:text-base">
                    Atur Ulang Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
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

function openForgotModal() {
    const modal = document.getElementById('modalLupaPassword');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeForgotModal() {
    const modal = document.getElementById('modalLupaPassword');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>

</body>
</html>
