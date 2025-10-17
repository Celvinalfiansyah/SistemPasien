<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Rekam Medis Rawat Jalan</title>
    <style>
        /* CSS sederhana */
        body {
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        button {
            background-color: #0066ff;
            color: white;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #0052cc;
        }
    </style>
</head>
<body>

    <h1>Daftar Rekam Medis Rawat Jalan</h1>

    <a href="{{ route('rekam-medis-rawat-jalan.create') }}"><button>Tambah Rekam Medis</button></a>

    @if(session('success'))
        <div style="background-color: #28a745; color: white; padding: 10px; margin: 10px 0;">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekamMedis as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->pasien->nama_pasien }}</td>
                    <td>{{ $data->tanggal_pemeriksaan }}</td>
                    <td>{{ $data->ttv }}</td>
                    <td>{{ $data->tindakan }}</td>
                    <td>
                        <a href="{{ route('rekam-medis-rawat-jalan.show', $data->id) }}"><button>Lihat</button></a>
                        <a href="{{ route('rekam-medis-rawat-jalan.edit', $data->id) }}"><button>Edit</button></a>
                        <form action="{{ route('rekam-medis-rawat-jalan.destroy', $data->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
