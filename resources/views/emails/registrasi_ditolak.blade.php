<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Akun Ditolak - Padukuhan</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #A33215; text-align: center;">Pendaftaran Akun Belum Disetujui</h2>
        
        <p>Halo {{ $pengguna->nama }},</p>
        <p>Kami menginformasikan bahwa pendaftaran akun Anda untuk sistem informasi Padukuhan <strong>tidak dapat didaftarkan / ditolak</strong> oleh administrator.</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #A33215;">
            <p style="margin: 0; font-weight: bold; color: #A33215;">Keterangan / Alasan:</p>
            <p style="margin: 5px 0 0 0; color: #555;">
                Mungkin NIK yang Anda masukkan tidak terdaftar di Padukuhan Bruno II, atau terdapat ketidaksesuaian data kependudukan lainnya.
            </p>
        </div>

        <p>Anda dapat mendaftarkan kembali akun Anda atau menghubungi Kepala Dukuh setempat untuk memastikan data kependudukan Anda sudah terdaftar dengan benar di Padukuhan Bruno II.</p>
        
        <div style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
            <a href="{{ url('/register') }}" style="background-color: #C54716; color: white; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 5px;">Daftar Akun Kembali</a>
        </div>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #999; text-align: center;">Email ini dikirim otomatis oleh sistem informasi Padukuhan.</p>
    </div>
</body>
</html>
