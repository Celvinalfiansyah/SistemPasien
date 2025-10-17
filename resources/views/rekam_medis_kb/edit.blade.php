<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Edit Rekam Medis KB - {{ $pasien->nama }}</title>
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

        form {
            max-width: 700px;
            background-color: #ffffff;
            padding: 30px;
            margin: 0 auto;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            font-size: 14px;
        }

        textarea {
            height: 60px;
            resize: vertical;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .buttons {
            text-align: right;
            margin-top: 30px;
        }

        button, .btn-cancel {
            padding: 10px 24px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            margin-left: 10px;
        }

        button {
            background-color: #0066ff;
            color: white;
        }

        .btn-cancel {
            background-color: #ff3333;
            color: white;
            text-decoration: none;
        }

        .btn-cancel:hover {
            background-color: #cc0000;
        }

        button:hover {
            background-color: #0052cc;
        }
    </style>
</head>
<body>

    <h1>Edit Rekam Medis KB - {{ $pasien->nama }}</h1>

    <form action="{{ route('pasien.rekam-medis-kb.update', ['pasien' => $pasien->id, 'rekam_medis_kb' => $rekam->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Tanggal Datang:</label>
            <input type="date" name="tanggal_datang" value="{{ old('tanggal_datang', $rekam->tanggal_datang) }}" required>
        </div>

        <div class="form-group">
            <label>HPHT:</label>
            <input type="date" name="hpht" value="{{ old('hpht', $rekam->hpht) }}">
        </div>

        <div class="form-group">
            <label>Berat Badan (kg):</label>
            <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan', $rekam->berat_badan) }}">
        </div>

        <div class="form-group">
            <label>Tensi:</label>
            <input type="text" name="tensi" value="{{ old('tensi', $rekam->tensi) }}">
        </div>

        <div class="form-group">
            <label>Komplikasi:</label>
            <textarea name="komplikasi">{{ old('komplikasi', $rekam->komplikasi) }}</textarea>
        </div>

        <div class="form-group">
            <label>Kegagalan:</label>
            <textarea name="kegagalan">{{ old('kegagalan', $rekam->kegagalan) }}</textarea>
        </div>

        <div class="form-group">
            <label>Pemeriksaan & Tindakan:</label>
            <textarea name="pemeriksaan_dan_tindakan">{{ old('pemeriksaan_dan_tindakan', $rekam->pemeriksaan_dan_tindakan) }}</textarea>
        </div>

        <div class="form-group">
            <label>Tanggal Kembali:</label>
            <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali', $rekam->tanggal_kembali) }}">
        </div>

        <div class="buttons">
            <a href="{{ route('pasien.rekam-medis-kb.index', $pasien->id) }}" class="btn-cancel">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>

</body>
</html>
