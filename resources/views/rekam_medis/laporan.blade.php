<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekam Medis</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Rekam Medis</h2>
    <p><strong>Nama Pasien:</strong> {{ $pasien->nama_pasien }}</p>
    <p><strong>Tanggal Lahir:</strong> {{ $pasien->tanggal_lahir }}</p>
    <p><strong>Alamat:</strong> {{ $pasien->alamat }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tgl Pemeriksaan</th>
                <th>Umur</th>
                <th>BB</th>
                <th>TB</th>
                <th>Klasifikasi</th>
                <th>TTV</th>
                <th>HPHT</th>
                <th>Anamnesa</th>
                <th>Keluhan</th>
                <th>Komplikasi</th>
                <th>Kegagalan</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasien->rekamMedis as $i => $rm)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $rm->tanggal_pemeriksaan }}</td>
                <td>{{ $rm->umur }}</td>
                <td>{{ $rm->berat_badan }}</td>
                <td>{{ $rm->tinggi_badan }}</td>
                <td>{{ $rm->klasifikasi }}</td>
                <td>{{ $rm->ttv }}</td>
                <td>{{ $rm->hpht }}</td>
                <td>{{ $rm->anamnesa }}</td>
                <td>{{ $rm->keluhan }}</td>
                <td>{{ $rm->komplikasi }}</td>
                <td>{{ $rm->kegagalan }}</td>
                <td>{{ $rm->tindakan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>