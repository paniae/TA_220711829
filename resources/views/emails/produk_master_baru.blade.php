<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Produk Master Baru</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <div style="background-color: #69200F; padding: 20px; text-align: center; border-radius: 10px 10px 0 0;">
        <h2 style="color: #fff; margin: 0; text-transform: uppercase; letter-spacing: 2px;">Notifikasi Sistem</h2>
    </div>

    <div style="background-color: #fff; padding: 30px; border: 1px solid #ddd; border-top: none; border-radius: 0 0 10px 10px;">
        <h3 style="color: #A33215; margin-top: 0;">Halo Admin,</h3>
        
        <p>Terdapat pengajuan penambahan <strong>Produk Master Baru</strong> dari warga pengelola UMKM yang membutuhkan konfirmasi Anda.</p>
        
        <div style="background-color: #FA814520; border-left: 4px solid #FA8145; padding: 15px; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>Nama Pengaju:</strong> {{ $pengaju->nama ?? 'Warga' }}</p>
            <p style="margin: 5px 0;"><strong>Nama Produk Master:</strong> {{ $produkMaster->nama_produk_master }}</p>
            <p style="margin: 5px 0;"><strong>Status:</strong> <span style="color: #A33215; font-weight: bold;">Menunggu Konfirmasi</span></p>
        </div>

        <p>Silakan login ke sistem untuk melakukan pengecekan dan konfirmasi (Terima/Tolak) agar produk warga dapat segera digunakan.</p>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/umkm/konfirmasi') }}" style="background-color: #C54716; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">Kelola Produk Master</a>
        </div>
    </div>

    <div style="text-align: center; margin-top: 20px; font-size: 12px; color: #777;">
        <p>Email ini dibuat otomatis oleh Sistem Informasi Padukuhan.<br>Mohon tidak membalas email ini.</p>
    </div>

</body>
</html>
