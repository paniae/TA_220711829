@extends('layouts.app')

@section('title', 'Laporan Padukuhan')

@section('content')
<div class="relative overflow-hidden bg-white rounded-3xl p-8 shadow-sm border border-[#FA8145] mb-8">
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <h1 class="text-2xl md:text-3xl font-black text-[#A33215] leading-tight uppercase tracking-tight">
                Laporan & Statistik
            </h1>
            <p class="text-base text-gray-400 mt-2 font-medium">
                Pantau data penduduk, kegiatan, dan pengaduan secara real-time.
            </p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Data</span>
        </div>
        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Penduduk</h3>
        <p class="text-3xl font-black text-gray-800">{{ $totalPenduduk }}</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Data</span>
        </div>
        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Kegiatan</h3>
        <p class="text-3xl font-black text-gray-800">{{ $totalKegiatan }}</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-gray-200 shadow-sm hover:shadow-md transition-all group">
        <div class="flex justify-between items-start mb-4">
            <span class="text-xs font-black text-gray-400 uppercase tracking-widest">Total Data</span>
        </div>
        <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Pengaduan</h3>
        <p class="text-3xl font-black text-gray-800">{{ $totalPengaduan }}</p>
    </div>
</div>

<div class="bg-white rounded-3xl p-8 border border-dashed border-gray-200 text-center">
    <h2 class="text-lg font-black text-gray-800 uppercase tracking-tight">Detail Laporan Segera Hadir</h2>
    <p class="text-sm text-gray-400 font-medium max-w-sm mx-auto mt-2 uppercase tracking-wide">
        Fitur ekspor data (PDF/Excel) dan grafik statistik mendalam sedang dalam tahap pengembangan.
    </p>
</div>

@endsection
