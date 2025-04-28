<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pasien</title>
</head>
<body>
    <h1>Edit Data Pasien</h1>

    <form action="{{ route('daftar-pasien.update', $pasien->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama:</label><br>
        <input type="text" name="nama_pasien" value="{{ $pasien->nama_pasien }}" required><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat_pasien" required>{{ $pasien->alamat_pasien }}</textarea><br><br>

        <label>Tanggal Lahir:</label><br>
        <textarea name="tanggal_lahir_pasien" required>{{$pasien->tanggal_lahir_pasien}}</textarea><br><br>

        <label>No Hp:</label><br>
        <input type="text" name="no_hp_pasien" value="{{ $pasien->no_hp_pasien }}" required><br><br>

        <label>Jenis Kelamin:</label><br>
        <select name="jenis_kelamin" required>
            <option value="L" {{ $pasien->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
            <option value="P" {{ $pasien->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
        
        <label>Tanggal Daftar:</label><br>
        <textarea name="tanggal_daftar" required>{{$pasien->tanggal_daftar}}</textarea><br><br>

        </select><br><br>

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('daftar-pasien.index') }}">Kembali ke Daftar Pasien</a>
</body>
</html>
