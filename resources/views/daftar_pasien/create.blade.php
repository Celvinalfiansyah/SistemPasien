<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Pasien</title>
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
        .radio-group, .checkbox-group {
            margin-bottom: 20px;
        }
        .radio-group label,
        .checkbox-group label {
            display: inline-block;
            margin-right: 30px;
            font-weight: normal;
            font-size: 14px;
        }
        .radio-group input[type="radio"],
        .checkbox-group input[type="checkbox"] {
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
            line-height: 2.1;
        }
    </style>
</head>
<body>
    <h1>Tambahkan Pasien</h1>

    <h1>Tambah Pasien Baru</h1>

    <form action="{{ route('daftar-pasien.store') }}" method="POST">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="nama_pasien" required><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat" required></textarea><br><br>

        <label>Tanggal Lahir</label><br>
        <input type="date" name="tanggal_lahir" required><br><br>

        <label>No Hp:</label><br>
        <input type="text" name="no_telepon" required><br><br>

        <div class="radio-group">
            <label>Jenis Kelamin</label><br />
            <label><input type="radio" name="jenis_kelamin" value="Laki-laki" required /> Laki laki</label>
            <label><input type="radio" name="jenis_kelamin" value="Perempuan" /> Perempuan</label>
        </div>
        
        <label>Tanggal Daftar</label><br>
        <input type="datetime-local" name="tanggal_daftar" required>

        <button type="submit">Simpan</button>
        
        <a href="{{ route('daftar-pasien.index') }}">Kembali ke Daftar Pasien</a>
    </form>
</body>
</html>
