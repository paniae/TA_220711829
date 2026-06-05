<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Akun Baru Perlu Konfirmasi - Padukuhan</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #A33215; text-align: center;">Konfirmasi Pendaftaran Akun Baru!</h2>
        
        <p>Halo Bapak/Ibu Admin,</p>
        <p>Terdapat pendaftar warga baru yang memerlukan konfirmasi dan persetujuan akun agar dapat mengakses sistem informasi Padukuhan. Berikut rincian data pendaftar:</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <p><strong>Nama Lengkap:</strong> {{ $pendaftar->nama }}</p>
            <p><strong>NIK:</strong> {{ $pendaftar->nik }}</p>
            <p><strong>Nomor Telepon:</strong> {{ $pendaftar->nomor_telepon_pengguna }}</p>
            <p><strong>Email:</strong> {{ $pendaftar->email_pengguna }}</p>
            <p><strong>Alamat:</strong> {{ $pendaftar->alamat_pengguna }}</p>
        </div>

        <p>Silakan masuk ke sistem untuk menyetujui atau menolak pendaftaran akun tersebut.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/pengguna/kelola') }}" style="background-color: #C54716; color: white; padding: 10px 20px; text-decoration: none; font-weight: bold; border-radius: 5px;">Kelola Pendaftar Baru</a>
        </div>
        
        <hr style="margin-top: 30px; border: 0; border-top: 1px solid #eee;">
        <p style="font-size: 12px; color: #999; text-align: center;">Email ini dikirim otomatis oleh sistem informasi Padukuhan.</p>
    </div>
</body>
</html>
