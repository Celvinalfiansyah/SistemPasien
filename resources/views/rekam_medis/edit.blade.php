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
        input[type="number"],
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

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .radio-options label {
            display: inline-block;
            margin-right: 20px;
            font-weight: normal;
        }

        .radio-options input[type="radio"] {
            margin-right: 6px;
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

    <form action="{{ route('pasien.rekam-medis.update', ['pasien' => $pasien->id, 'rekam_medis' => $rekam_medis->id]) }}" method="POST">
    @csrf
    @method('PUT')
    <!-- input fields -->

        <div class="form-group">
            <label>Tanggal Pemeriksaan:</label>
            <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan', $rekam_medis->tanggal_pemeriksaan->format('Y-m-d')) }}" required>
        </div>

        <div class="form-row">
            {{-- <div class="form-group">
                <label>Umur:</label>
                <input type="number" name="umur" value="{{ old('umur', $rekam_medis->umur) }}" min="0" required>
            </div> --}}
            <div class="form-group">
                <label>Berat Badan (kg):</label>
                <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan', $rekam_medis->berat_badan) }}" min="0" required>
            </div>
            <div class="form-group">
                <label>Tinggi Badan (cm):</label>
                <input type="number" step="0.1" name="tinggi_badan" value="{{ old('tinggi_badan', $rekam_medis->tinggi_badan) }}" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label>Klasifikasi:</label>
            <div class="radio-options">
                <label>
                    <input type="radio" name="klasifikasi" value="Ibu Hamil" {{ old('klasifikasi', $rekam_medis->klasifikasi) == 'Ibu Hamil' ? 'checked' : '' }}>
                    Ibu Hamil
                </label>
                <label>
                    <input type="radio" name="klasifikasi" value="Bayi/Anak" {{ old('klasifikasi', $rekam_medis->klasifikasi) == 'Bayi/Anak' ? 'checked' : '' }}>
                    Bayi / Anak
                </label>
                <label>
                    <input type="radio" name="klasifikasi" value="KB" {{ old('klasifikasi', $rekam_medis->klasifikasi) == 'KB' ? 'checked' : '' }}>
                    KB
                </label>
                <label>
                    <input type="radio" name="klasifikasi" value="Rawat Jalan" {{ old('klasifikasi', $rekam_medis->klasifikasi) == 'Rawat Jalan' ? 'checked' : '' }}>
                    Rawat Jalan
                </label>
            </div>
        </div>

        <div class="form-group">
            <label>TTV:</label>
            <input type="text" name="ttv" value="{{ old('ttv', $rekam_medis->ttv) }}">
        </div>

        <div class="form-group">
            <label>HPHT:</label>
            <input type="date" name="hpht" value="{{ old('hpht', optional($rekam_medis->hpht)->format('Y-m-d')) }}">
        </div>

        <div class="form-group">
            <label>Anamnesa:</label>
            <textarea name="anamnesa">{{ old('anamnesa', $rekam_medis->anamnesa) }}</textarea>
        </div>

        <div class="form-group">
            <label>Keluhan:</label>
            <textarea name="keluhan">{{ old('keluhan', $rekam_medis->keluhan) }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Komplikasi:</label>
                <textarea name="komplikasi">{{ old('komplikasi', $rekam_medis->komplikasi) }}</textarea>
            </div>
            <div class="form-group">
                <label>Kegagalan:</label>
                <textarea name="kegagalan">{{ old('kegagalan', $rekam_medis->kegagalan) }}</textarea>
            </div>
        </div>

        <div class="form-group">
            <label>Tindakan:</label>
            <textarea name="tindakan">{{ old('tindakan', $rekam_medis->tindakan) }}</textarea>
        </div>

        <div class="buttons">
        <a href="{{ route('daftar-pasien.show', $pasien->id) }}" class="btn-cancel">Batal</a>
            <button type="submit">Simpan</button>
        </div>
    </form>

</body>
</html>
