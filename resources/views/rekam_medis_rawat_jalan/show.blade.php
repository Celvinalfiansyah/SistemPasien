<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Detail Rekam Medis Rawat Jalan</title>
</head>
<body>

    <h1>Detail Rekam Medis Rawat Jalan</h1>

    <p>ID Rekam Medis: {{ $rekam_medis_rawat_jalan->id }}</p> 

    <div>
        <strong>Nama Pasien:</strong> {{ $pasien->nama_pasien }}<br>
        <strong>Tanggal Pemeriksaan:</strong> {{ $rekam_medis_rawat_jalan->tanggal_pemeriksaan }}<br>
        <strong>TTV:</strong> {{ $rekam_medis_rawat_jalan->ttv }}<br>
        <strong>Anamnesa:</strong> {{ $rekam_medis_rawat_jalan->anamnesa }}<br>
        <strong>Keluhan:</strong> {{ $rekam_medis_rawat_jalan->keluhan }}<br>
        <strong>Tindakan:</strong> {{ $rekam_medis_rawat_jalan->tindakan }}<br>
    </div>

    <br>
    <a href="{{ route('daftar-pasien.show', $pasien->id) }}"><button>Kembali</button></a>

</body>
</html>

showrawat jalan
{{--  --}}