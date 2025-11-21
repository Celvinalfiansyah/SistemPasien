<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Daftar Rekam Medis Bayi & Anak</title>
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

        .btn-secondary {
            background-color: #ff3333;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

    <h3>Daftar Rekam Medis Bayi & Anak</h3>

    <a href="{{ route('rekam-medis-bayi-anak.create') }}" class="btn btn-info mb-3">Tambah Rekam Medis</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Umur</th> <!-- Tambahkan kolom umur -->
                <th>Berat Badan</th>
                <th>Keluhan</th>
                <th>Tindakan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rekamMedis as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->pasien->nama_pasien ?? '-' }}</td>
                    <td>{{ $data->tanggal_pemeriksaan }}</td>
                    <td>{{ $data->umurText ?? 'Tidak Diketahui' }}</td> <!-- Tampilkan umur lengkap -->
                    <td>{{ $data->berat_badan }}</td>
                    <td>{{ $data->keluhan }}</td>
                    <td>{{ $data->tindakan }}</td>
                    <td>
                        <a href="{{ route('rekam-medis-bayi-anak.show', $data->id) }}" class="btn btn-info btn-sm">Lihat</a>
                        <a href="{{ route('rekam-medis-bayi-anak.edit', $data->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('rekam-medis-bayi-anak.destroy', $data->id) }}" method="POST" class="d-inline">
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
{{--  --}}