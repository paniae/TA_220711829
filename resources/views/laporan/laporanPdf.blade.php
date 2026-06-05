<!DOCTYPE html>
<html>
<head>
    <title>Laporan {{ ucfirst($tab) }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        h2 { text-align: center; margin-bottom: 5px; }
        p { text-align: center; margin-top: 0; color: #666; }
    </style>
</head>
<body>
    <h2>Laporan Rekapitulasi: {{ strtoupper($tab) }}</h2>
    <p>
        @if($month && $year)
            Periode: {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
        @elseif($year)
            Periode: Tahun {{ $year }}
        @elseif($month)
            Periode: Bulan {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}
        @else
            Semua Periode
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                @if($tab == 'umkm')
                    <th>Nama Produk</th>
                    <th>Pemilik (UMKM)</th>
                    <th>Harga</th>
                    <th>Status</th>
                @elseif($tab == 'kegiatan' || $tab == 'proker')
                    <th>Nama Kegiatan</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Lokasi</th>
                    <th>Kategori</th>
                    <th>Dana (Rp)</th>
                    <th>Status</th>
                @elseif($tab == 'pengaduan')
                    <th>Tgl Pengaduan</th>
                    <th>Isi Pengaduan</th>
                    <th>Status</th>
                @elseif($tab == 'kehilangan')
                    <th>Tgl Laporan</th>
                    <th>Barang Hilang</th>
                    <th>Lokasi</th>
                    <th>Status</th>
                @elseif($tab == 'penduduk')
                    <th>NIK</th>
                    <th>No. KK</th>
                    <th>Nama Lengkap</th>
                    <th>TTL</th>
                    <th>J. Kelamin</th>
                    <th>Agama</th>
                    <th>Pekerjaan</th>
                    <th>Alamat (RT/RW)</th>
                    <th>Status</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    @if($tab == 'umkm')
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->umkm->nama_umkm ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td>{{ strtoupper($item->status_produk) }}</td>
                    @elseif($tab == 'kegiatan' || $tab == 'proker')
                        <td>{{ $item->nama_kegiatan }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tgl_waktu_pelaksanaan)->format('d M Y H:i') }}</td>
                        <td>{{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->format('d M Y H:i') : '-' }}</td>
                        <td>{{ $item->lokasi }}</td>
                        <td>{{ strtoupper($item->kategori) }}</td>
                        <td>{{ number_format($item->dana_dikeluarkan, 0, ',', '.') }}</td>
                        <td>{{ strtoupper($item->status_kegiatan) }}</td>
                    @elseif($tab == 'pengaduan')
                        <td>{{ \Carbon\Carbon::parse($item->tgl_waktu_pengaduan)->format('d M Y') }}</td>
                        <td>{{ $item->isi_pengaduan }}</td>
                        <td>{{ strtoupper($item->status_pengaduan) }}</td>
                    @elseif($tab == 'kehilangan')
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_laporan)->format('d M Y') }}</td>
                        <td>{{ $item->barang_hilang }}</td>
                        <td>{{ $item->lokasi_hilang }}</td>
                        <td>{{ strtoupper($item->status_kehilangan) }}</td>
                    @elseif($tab == 'penduduk')
                        <td>{{ $item->nomor_induk_kependudukan }}</td>
                        <td>{{ $item->nomor_kk }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->tempat_lahir }}, {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ $item->agama }}</td>
                        <td>{{ $item->jenis_pekerjaan }}</td>
                        <td>RT {{ $item->rt }}/RW {{ $item->rw }}</td>
                        <td>{{ $item->status_penduduk }}</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada data untuk kategori ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
