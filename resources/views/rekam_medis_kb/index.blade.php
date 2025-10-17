<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Rekam Medis KB</title>
    <style>
        body {
            background-color: #cbe6f6;
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h3 {
            text-align: center;
            margin-bottom: 40px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-warning {
            background-color: #ffc107;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <h3>Daftar Rekam Medis KB</h3>

    <a href="{{ route('rekam-medis-kb.create') }}" class="btn btn-info mb-3">Tambah Rekam Medis</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Tanggal Datang</th>
                <th>HPHT</th>
                <th>Berat Badan</th>
                <th>Tensi</th>
                <th>Komplikasi</th>
                <th>Kegagalan</th>
                <th>Pemeriksaan & Tindakan</th>
                <th>Tanggal Kembali</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekamMedis as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->pasien->nama_pasien ?? '-' }}</td>
                    <td>{{ $data->tanggal_datang }}</td>
                    <td>{{ $data->hpht }}</td>
                    <td>{{ $data->berat_badan }}</td>
                    <td>{{ $data->tensi }}</td>
                    <td>{{ $data->komplikasi }}</td>
                    <td>{{ $data->kegagalan }}</td>
                    <td>{{ $data->pemeriksaan_dan_tindakan }}</td>
                    <td>{{ $data->tanggal_kembali }}</td>
                    <td>
                        <a href="{{ route('rekam-medis-kb.show', $data->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('rekam-medis-kb.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('rekam-medis-kb.destroy', $data->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus data ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
