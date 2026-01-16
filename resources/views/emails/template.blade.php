<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #007bff;
        }
        .content {
            margin: 20px 0;
            line-height: 1.8;
        }
        .footer {
            border-top: 1px solid #ddd;
            margin-top: 30px;
            padding-top: 20px;
            font-size: 12px;
            color: #666;
        }
        .signature {
            margin-top: 30px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ $riwayatEmail->subjek }}</h2>
        </div>

        <div class="content">
            {!! nl2br(e($riwayatEmail->isi_pesan)) !!}
        </div>

        <div class="signature">
            <p>Regards,<br>{{ $pengirim->name }}</p>
        </div>

        <div class="footer">
            <p>
                <strong>Note:</strong> Email ini dikirimkan secara otomatis dari sistem CRM.<br>
                Waktu Pengiriman: {{ $riwayatEmail->waktu_kirim->format('d F Y H:i') }} WIB<br>
                <em>Jangan balas email ini. Hubungi kami melalui kontak yang tersedia.</em>
            </p>
        </div>
    </div>
</body>
</html>
