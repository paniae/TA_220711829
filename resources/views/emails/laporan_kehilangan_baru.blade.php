<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kehilangan Baru - Padukuhan</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #A33215; text-align: center;">Laporan Kehilangan Baru!</h2>
        
        <p>Halo Bapak/Ibu,</p>
        <p>Terdapat laporan kehilangan barang baru dari warga Padukuhan. Berikut rincian barang yang hilang:</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p><strong>Nama Barang:</strong> {{ $laporan->barang_hilang }}</p>
            <p><strong>Tanggal Kehilangan:</strong> {{ \Carbon\Carbon::parse($laporan->tanggal_hilang)->translatedFormat('l, d F Y') }}</p>
            <p><strong>Lokasi Hilang / Terakhir:</strong> {{ $laporan->lokasi_hilang }}</p>
            <p><strong>Pelapor:</strong> {{ $laporan->pengguna->nama ?? 'Warga' }}</p>
            @if($laporan->deskripsi_laporan)
                <p><strong>Kronologi Kejadian:</strong></p>
                <p style="background: #fff; padding: 10px; border-left: 4px solid #C54716; font-style: italic;">
                    "{{ $laporan->deskripsi_laporan }}"
                </p>
            @endif
        </div>

        <p>Mari bantu pantau dan berikan informasi jika Anda mengetahui keberadaan barang tersebut pada forum diskusi kehilangan.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/kehilangan/'.$laporan->id_laporan) }}" style="background-color: #C54716; color: white; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 5px;">Buka Forum Diskusi</a>
        </div>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #999; text-align: center;">Email ini dikirim otomatis oleh sistem informasi Padukuhan.</p>
    </div>
</body>
</html>
