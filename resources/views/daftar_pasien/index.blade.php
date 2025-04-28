<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pasien</title>
</head>
<body>
    <h1>Daftar Pasien</h1>

    <a href="{{ route('daftar-pasien.create') }}">Tambah Pasien Baru</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Tanggal Lahir</th>
                <th>No Hp</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pasien as $p)
            <tr>
                <td>{{ $p->nama_pasien }}</td>
                <td>{{ $p->alamat_pasien }}</td>
                <td>{{ $p->tanggal_lahir_pasien}}</td>
                <td>{{ $p->no_hp_pasien }}</td>
                <td>{{ $p->jenis_kelamin }}</td>
                <td>{{ $p->tanggal_daftar}}</td>
                <td>
                    <a href="{{ route('daftar-pasien.edit', $p->id) }}">Edit</a>
                    <form action="{{ route('daftar-pasien.destroy', $p->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
