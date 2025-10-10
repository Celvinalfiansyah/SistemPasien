<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Pasien</title>
    <style>
        body {
            background-color: #cbe6f6; /* Warna biru muda sesuai gambar */
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 40px;
        }
        form {
            max-width: 700px;
            margin: 0 auto;
            background-color: #cbe6f6;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }
        input[type="text"],
        input[type="date"],
        input[type="datetime-local"],
        textarea {
            width: 80%;
            padding: 10px;
            border-radius: 10px;
            border: none;
            margin-bottom: 20px;
            font-size: 14px;
        }
        textarea {
            height: 60px;
            resize: vertical;
        }
        .radio-group {
            margin-bottom: 20px;
        }
        .radio-group label {
            display: inline-block;
            margin-right: 30px;
            font-weight: normal;
            font-size: 14px;
        }
        .radio-group input[type="radio"] {
            margin-right: 6px;
        }
        .buttons {
            text-align: right;
            max-width: 700px;
            margin: 20px auto 0 auto;
        }
        button, .btn-cancel {
            padding: 10px 24px;
            border-radius: 10px;
            border: none;
            font-size: 14px;
            cursor: pointer;
            margin-left: 15px;
        }
        button {
            background-color: #0066ff;
            color: white;
        }
        .btn-cancel {
            background-color: #ff3333;
            color: white;
            text-decoration: none;
            line-height: 1.1;
        }
    </style>
</head>
<body>
    <h1>Edit Pasien</h1>

    <form action="{{ route('daftar-pasien.update', $pasien->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama:</label>
        <input type="text" name="nama_pasien" value="{{ $pasien->nama_pasien }}" required>

<<<<<<< HEAD:resources/views/daftar_pasien/edit.blade.php
        <label>Alamat:</label>
        <textarea name="alamat" required>{{ $pasien->alamat }}</textarea>

        <label>Tanggal Lahir:</label>
        <input type="date" name="tanggal_lahir" value="{{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') }}" required>

        <label>No Hp:</label>
        <input type="text" name="no_telepon" value="{{ $pasien->no_telepon }}" required>

        <div class="radio-group">
            <label>Jenis Kelamin</label><br />
            <label><input type="radio" name="jenis_kelamin" value="Laki-laki" {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}> Laki laki</label>
            <label><input type="radio" name="jenis_kelamin" value="Perempuan" {{ $pasien->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}> Perempuan</label>
        </div>
=======
        <label>Alamat:</label><br>
        <textarea name="alamat" required>{{ $pasien->alamat }}</textarea><br><br>

        <label>Tanggal Lahir:</label><br>
        <textarea name="tanggal_lahir" required>{{$pasien->tanggal_lahir}}</textarea><br><br>

        <label>No Hp:</label><br>
        <input type="text" name="no_telepon" value="{{ $pasien->no_telepon }}" required><br><br>

        <label>Jenis Kelamin:</label><br>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki" {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ $pasien->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        
        <label>Tanggal Daftar:</label><br>
        <input type="datetime-local" name="tanggal_daftar" value="{{ $pasien->tanggal_daftar->format('Y-m-d\TH:i') }}"><br><br>
>>>>>>> 29dc27401831505d064869d585036dd4f7005191:resources/views/daftar-pasien/edit.blade.php

        <label>Tanggal Daftar:</label>
        <input type="datetime-local" name="tanggal_daftar" value="{{ $pasien->tanggal_daftar->format('Y-m-d\TH:i') }}" required>

        <div class="buttons">
        <a href="{{ route('daftar-pasien.index') }}" class="btn-cancel">Batalkan</a>
            <button type="submit">Update</button>
        </div>
    </form>
</body>
</html>
