<!DOCTYPE html>
<html>
<head>
    <title>Pengaduan Baru dari Warga</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #A33215; text-align: center;">Ada Pengaduan Baru!</h2>
        
        <p>Halo Bapak/Ibu Dukuh,</p>
        <p>Terdapat pengaduan baru dari warga yang masuk ke sistem. Berikut adalah rinciannya:</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p><strong>Pengirim:</strong> {{ $pengaduan->pengguna->nama ?? 'Warga' }}</p>
            <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($pengaduan->tgl_waktu_pengaduan)->translatedFormat('l, d F Y H:i') }}</p>
            <p><strong>Isi Pengaduan:</strong></p>
            <p style="background: #fff; padding: 10px; border-left: 4px solid #C54716;">
                {{ $pengaduan->isi_pengaduan }}
            </p>
        </div>

        <p>Silakan login ke aplikasi Padukuhan untuk menindaklanjuti pengaduan tersebut.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/pengaduan/kelola') }}" style="background-color: #C54716; color: white; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 5px;">Buka Aplikasi</a>
        </div>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #999; text-align: center;">Email ini dikirim otomatis oleh sistem informasi Padukuhan.</p>
    </div>
</body>
</html>
