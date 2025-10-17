<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Detail Rekam Medis Rawat Jalan</title>
    <style>
        /* CSS yang sama seperti di daftar */
    </style>
</head>
<body>

    <h1>Detail Rekam Medis Rawat Jalan</h1>

    <div>
        <strong>Nama Pasien:</strong> {{ $rekam->pasien->nama_pasien }}<br>
        <strong>Tanggal Pemeriksaan:</strong> {{ $rekam->tanggal_pemeriksaan }}<br>
        <strong>TTV:</strong> {{ $rekam->ttv }}<br>
        <strong>Anamnesa:</strong> {{ $rekam->anamnesa }}<br>
        <strong>Keluhan:</strong> {{ $rekam->keluhan }}<br>
        <strong>Tindakan:</strong> {{ $rekam->tindakan }}<br>
    </div>

    <br>
    <a href="{{ route('rekam-medis-rawat-jalan.index') }}"><button>Kembali</button></a>

</body>
</html>
