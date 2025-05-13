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

        </select><br><br>

        <button type="submit">Update</button>
    </form>

    <a href="{{ route('daftar-pasien.index') }}">Kembali ke Daftar Pasien</a>
</body>
</html>
