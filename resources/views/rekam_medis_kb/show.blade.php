<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Detail Rekam Medis KB - {{ $rekam->pasien->nama }}</title>
    <style>
        body {
            background-color: #cbe6f6;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 40px;
        }

        .card {
            background-color: #ffffff;
            padding: 30px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            margin-bottom: 20px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

    <h3>Detail Rekam Medis KB - {{ $rekam->pasien->nama }}</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Tanggal Datang:</strong> {{ $rekam->tanggal_datang }}</p>
            <p><strong>HPHT:</strong> {{ $rekam->hpht }}</p>
            <p><strong>Berat Badan:</strong> {{ $rekam->berat_badan }}</p>
            <p><strong>Tensi:</strong> {{ $rekam->tensi }}</p>
            <p><strong>Komplikasi:</strong> {{ $rekam->komplikasi }}</p>
            <p><strong>Kegagalan:</strong> {{ $rekam->kegagalan }}</p>
            <p><strong>Pemeriksaan & Tindakan:</strong> {{ $rekam->pemeriksaan_dan_tindakan }}</p>
            <p><strong>Tanggal Kembali:</strong> {{ $rekam->tanggal_kembali }}</p>
        </div>
    </div>

    <a href="{{ route('rekam-medis-kb.index', $rekam->pasien->id) }}" class="btn btn-secondary mt-3">Kembali</a>

</body>
</html>
{{--  --}}