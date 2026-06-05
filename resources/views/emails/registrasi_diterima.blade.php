<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Akun Diterima - Padukuhan</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #A33215; text-align: center;">Selamat, Akun Anda Telah Aktif!</h2>
        
        <p>Halo {{ $pengguna->nama }},</p>
        <p>Dengan gembira kami informasikan bahwa pendaftaran akun Anda untuk sistem informasi Padukuhan telah <strong>diterima dan diaktifkan</strong> oleh administrator.</p>
        
        <p>Sekarang Anda dapat masuk ke dalam sistem menggunakan email dan password yang telah Anda daftarkan sebelumnya untuk menikmati seluruh layanan informasi.</p>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/login') }}" style="background-color: #C54716; color: white; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 5px;">Masuk ke Sistem</a>
        </div>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #999; text-align: center;">Email ini dikirim otomatis oleh sistem informasi Padukuhan.</p>
    </div>
</body>
</html>
