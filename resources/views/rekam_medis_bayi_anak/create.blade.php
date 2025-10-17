<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Rekam Medis Bayi & Anak</title>
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

    <h1>Tambah Rekam Medis Bayi & Anak - {{ $pasien->nama_pasien }}</h1>

    <form action="{{ route('pasien.rekam-medis-bayi-anak.store', $pasien->id) }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Tanggal Pemeriksaan:</label>
            <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan') }}" required>
        </div>

        <div class="form-group">
            <label>Berat Badan (kg):</label>
            <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan') }}">
        </div>

        <div class="form-group">
            <label>Keluhan:</label>
            <textarea name="keluhan">{{ old('keluhan') }}</textarea>
        </div>

        <div class="form-group">
            <label>Tindakan:</label>
            <textarea name="tindakan">{{ old('tindakan') }}</textarea>
        </div>

        <div class="buttons">
            <a href="{{ route('daftar-pasien.show', $pasien->id) }}" class="btn-cancel">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>

</body>
</html>
