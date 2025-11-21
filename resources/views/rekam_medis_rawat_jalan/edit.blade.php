<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Rekam Medis - {{ $pasien->nama_pasien }}</title>
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
        textarea {
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

    <h1>Edit Rekam Medis - {{ $pasien->nama_pasien }}</h1>

    <form action="{{ route('pasien.rekam-medis-rawat-jalan.update', [$pasien->id, $rekam_medis_rawat_jalan->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label>Tanggal Pemeriksaan:</label>
        <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', $rekam_medis_rawat_jalan->tanggal_pemeriksaan) }}" required>
    </div>

    <div class="form-group">
        <label>TTV:</label>
        <input type="text" name="ttv" value="{{ old('ttv', $rekam_medis_rawat_jalan->ttv) }}">
    </div>

    <div class="form-group">
        <label>Anamnesa:</label>
        <textarea name="anamnesa">{{ old('anamnesa', $rekam_medis_rawat_jalan->anamnesa) }}</textarea>
    </div>

    <div class="form-group">
        <label>Keluhan:</label>
        <textarea name="keluhan">{{ old('keluhan', $rekam_medis_rawat_jalan->keluhan) }}</textarea>
    </div>

    <div class="form-group">
        <label>Tindakan:</label>
        <textarea name="tindakan">{{ old('tindakan', $rekam_medis_rawat_jalan->tindakan) }}</textarea>
    </div>

    <div class="buttons">
        <a href="{{ route('pasien.rekam-medis.index', $pasien->id) }}" class="btn-cancel">Batal</a>
        <button type="submit">Perbarui</button>
    </div>
</form>



</body>
</html>
{{--  --}}