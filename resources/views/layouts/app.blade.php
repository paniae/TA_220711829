<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <title>@yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html, body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
            width: 100%;
        }

        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background-image: url('/images/batikSemen.jpg');
            background-repeat: repeat;
            background-size: 300px;
            opacity: 0.08;
            z-index: -1;
        }
    </style>
</head>

<body class="bg-orange-50 min-h-screen">

@include('layouts.header')

<div id="overlay" class="fixed inset-0 bg-black/40 hidden z-30"></div>

<div class="pt-20 flex w-full max-w-full overflow-hidden">

    @auth
        @include('layouts.sidebar') 
    @endauth

    @guest
        @include('layouts.sidebar_guest')
    @endguest

    <main class="flex-1 w-full min-w-0 p-4 md:p-6 min-h-[calc(100vh-80px)] overflow-hidden">
        @yield('content')
    </main>
</div>

@if(request()->is('/') || request()->routeIs('beranda') || request()->is('beranda'))
    @include('layouts.footer')
@endif

<script>
document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    const toggleBtn = document.getElementById('toggleSidebar');

    let isOpen = false;

    function openSidebar() {
        sidebar?.classList.remove('-translate-x-full');
        overlay?.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar?.classList.add('-translate-x-full');
        overlay?.classList.add('hidden');
    }

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            isOpen ? closeSidebar() : openSidebar();
            isOpen = !isOpen;
        });
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // ================= MODAL =================
    window.openModal = function (id) {
        const modal = document.getElementById(id);
        modal?.classList.remove('hidden');
        modal?.classList.add('flex');
    }

    window.closeModal = function (id) {
        const modal = document.getElementById(id);
        modal?.classList.add('hidden');
        modal?.classList.remove('flex');
    }

    window.addEventListener('click', function(e) {
        document.querySelectorAll('[id^="modal"]').forEach(modal => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });
    });

});
</script>

@stack('scripts')
</body>
</html>
