<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kehilangan Baru</title>
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
            <h1>Laporan Kehilangan</h1>
        </div>
        <div class="content">
            <p>Halo Warga Padukuhan Bruno II,</p>
            <p>Terdapat laporan kehilangan baru dari warga. Berikut rinciannya:</p>
            
            <div class="activity-card">
                <div class="info-row">
                    <span class="label">Pelapor</span>
                    <span class="value">{{ $laporan->pengguna->nama ?? 'Warga' }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Waktu Kehilangan</span>
                    <span class="value">{{ \Carbon\Carbon::parse($laporan->tgl_waktu_kehilangan)->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Lokasi Terakhir</span>
                    <span class="value">{{ $laporan->lokasi_terakhir }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Deskripsi Barang</span>
                    <span class="value" style="font-weight: normal; font-size: 14px;">{{ $laporan->deskripsi_barang }}</span>
                </div>
            </div>

            <p>Mari bantu pantau dan berikan informasi jika Anda mengetahui keberadaan barang tersebut pada forum diskusi kehilangan.</p>
            
            <p style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Buka Forum Diskusi</a>
            </p>
        </div>
        <div class="footer">
            Email ini dikirim otomatis oleh website Padukuhan Bruno II. <br>
            © {{ date('Y') }} - Kebersamaan Untuk Kemajuan
        </div>
    </div>
</body>
</html>
