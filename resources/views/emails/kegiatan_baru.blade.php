<!DOCTYPE html>
<html>
<head>
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
            <h1>{{ $kegiatan->jenis_kegiatan === 'proker' ? 'Program Kerja Baru' : 'Kegiatan Baru' }}</h1>
        </div>
        <div class="content">
            <p>Halo Warga Padukuhan Bruno II,</p>
            <p>Ada kabar terbaru mengenai {{ $kegiatan->jenis_kegiatan === 'proker' ? 'program kerja' : 'kegiatan' }} yang akan dilaksanakan di padukuhan kita. Berikut detailnya:</p>
            
            <div class="activity-card">
                <div class="info-row">
                    <span class="label">Nama {{ $kegiatan->jenis_kegiatan === 'proker' ? 'Program Kerja' : 'Kegiatan' }}</span>
                    <span class="value">{{ $kegiatan->nama_kegiatan }}</span>
                </div>
                <div class="info-row">
                    <span class="label">Waktu Pelaksanaan</span>
                    <span class="value">
                        {{ \Carbon\Carbon::parse($kegiatan->tgl_waktu_pelaksanaan)->translatedFormat('l, d F Y') }} <br>
                        Pukul {{ \Carbon\Carbon::parse($kegiatan->tgl_waktu_pelaksanaan)->format('H:i') }} WIB
                    </span>
                </div>
                <div class="info-row">
                    <span class="label">Lokasi</span>
                    <span class="value">{{ $kegiatan->lokasi }}</span>
                </div>
                @if($kegiatan->deskripsi_kegiatan)
                <div class="info-row">
                    <span class="label">Deskripsi</span>
                    <span class="value" style="font-weight: normal; font-size: 14px; font-style: italic;">
                        "{{ $kegiatan->deskripsi_kegiatan }}"
                    </span>
                </div>
                @endif
            </div>

            <p style="text-align: center;">
                <a href="{{ url('/') }}" class="button">Lihat Detail di Website</a>
            </p>
        </div>
        <div class="footer">
            Email ini dikirim otomatis oleh website Padukuhan Bruno II. <br>
            © {{ date('Y') }} - Kebersamaan Untuk Kemajuan
        </div>
    </div>
</body>
</html>
