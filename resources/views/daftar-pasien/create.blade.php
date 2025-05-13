<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pasien</title>
</head>
<body>
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

        <label>Jenis Kelamin:</label><br>
        <select name="jenis_kelamin" required>
            <option value="Laki-laki">Laki-laki</option>
            <option value="Perempuan">Perempuan</option>
        </select><br><br>
        
        <label>Tanggal Daftar</label><br>
        <input type="datetime-local" name="tanggal_daftar" required>

        <button type="submit">Simpan</button>
        
        <a href="{{ route('daftar-pasien.index') }}">Kembali ke Daftar Pasien</a>
    </form>
</body>
</html>
