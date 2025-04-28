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
        <textarea name="alamat_pasien" required></textarea><br><br>

        <label>Tanggal Lahir</label><br>
        <textarea name="tanggal_lahir_pasien" required></textarea><br><br>

        <label>No Hp:</label><br>
        <input type="text" name="no_hp_pasien" required><br><br>

        <label>Jenis Kelamin:</label><br>
        <select name="jenis_kelamin" required>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        
        <label>Tanggal Daftar</label><br>
        <textarea name="tanggal_daftar" required></textarea><br><br>
        </select><br><br>

        <button type="submit">Simpan</button>
    </form>

    <a href="{{ route('daftar-pasien.index') }}">Kembali ke Daftar Pasien</a>
</body>
</html>
