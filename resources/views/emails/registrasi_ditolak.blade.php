<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Akun Ditolak</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #fffaf5;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #ffeada;
        }
        .header {
            background-color: #A33215;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .content {
            padding: 30px;
        }
        .activity-card {
            background-color: #fff9f4;
            border-left: 5px solid #C54716;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 10px 10px 0;
        }
        .info-row {
            margin-bottom: 15px;
        }
        .label {
            font-size: 10px;
            font-weight: bold;
            color: #E75C16;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
            letter-spacing: 1px;
        }
        .value {
            font-size: 16px;
            color: #69200F;
            font-weight: 600;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px solid #eee;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background-color: #C54716;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Pendaftaran Ditolak</h1>
        </div>
        <div class="content">
            <p>Halo {{ $pengguna->nama }},</p>
            <p>Kami menginformasikan bahwa pendaftaran akun Anda untuk sistem informasi Padukuhan <strong>tidak dapat didaftarkan / ditolak</strong> oleh administrator.</p>
            
            <div class="activity-card">
                <div class="info-row">
                    <span class="label">Keterangan / Alasan</span>
                    <span class="value" style="font-size: 14px; font-weight: normal;">Mungkin NIK yang Anda masukkan tidak terdaftar di Padukuhan Bruno II, atau terdapat ketidaksesuaian data kependudukan lainnya.</span>
                </div>
            </div>

            <p>Anda dapat mendaftarkan kembali akun Anda atau menghubungi Kepala Dukuh setempat untuk memastikan data kependudukan Anda sudah terdaftar dengan benar di Padukuhan Bruno II.</p>
            
            <p style="text-align: center;">
                <a href="{{ route('register') }}" style="display: inline-block; padding: 12px 25px; background-color: #C54716; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px;">Daftar Akun Kembali</a>
            </p>
        </div>
        <div class="footer">
            Email ini dikirim otomatis oleh website Padukuhan Bruno II. <br>
            © {{ date('Y') }} - Kebersamaan Untuk Kemajuan
        </div>
    </div>
</body>
</html>
