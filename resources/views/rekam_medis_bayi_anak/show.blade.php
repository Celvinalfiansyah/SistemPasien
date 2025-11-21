<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Detail Rekam Medis Bayi & Anak - {{ $pasien->nama }}</title>
    <style>
        body {
            background-color: #cbe6f6;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 40px;
        }

        .card {
            background-color: #ffffff;
            padding: 30px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 700px;
        }

        .card-body {
            padding: 20px;
        }

        .card-body p {
            font-size: 16px;
        }

        .buttons {
            text-align: right;
            margin-top: 30px;
        }

        .btn-secondary {
            background-color: #ff3333;
            color: white;
            padding: 10px 24px;
            border-radius: 10px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

    <h1>Detail Rekam Medis Bayi & Anak - {{ $pasien->nama_pasien }}</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Nama Pasien:</strong> {{ $pasien->nama_pasien }}</p>
            <p><strong>Tanggal Pemeriksaan:</strong> {{ $rekam_medis_bayi_anak->tanggal_pemeriksaan }}</p>
            <p><strong>Umur Pasien:</strong> {{ $umurText }}</p>
            <p><strong>Berat Badan:</strong> {{ $rekam_medis_bayi_anak->berat_badan }} kg</p>
            <p><strong>Keluhan:</strong> {{ $rekam_medis_bayi_anak->keluhan }}</p>
            <p><strong>Tindakan:</strong> {{ $rekam_medis_bayi_anak->tindakan }}</p>
        </div>
    </div>

    <div class="buttons">
        <a href="{{ route('pasien.rekam-medis-bayi-anak.index', $pasien->id) }}" class="btn-secondary">Kembali</a>
    </div>

</body>
</html>
{{--  --}}