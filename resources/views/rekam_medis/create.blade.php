<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Tambah Rekam Medis - {{ $pasien->nama_pasien }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <h1 class="text-2xl font-bold mb-4">Tambah Rekam Medis - {{ $pasien->nama_pasien }}</h1>

    <form action="{{ route('pasien.rekam-medis.store', $pasien->id) }}" method="POST" class="bg-white p-6 rounded shadow max-w-lg">
        @csrf

        <label class="block mb-2">
            Tanggal Pemeriksaan:
            <input type="date" name="tanggal_pemeriksaan" value="{{ old('tanggal_pemeriksaan') }}" class="w-full border rounded px-3 py-2" required>
        </label>

        <label class="block mb-2">
            Umur:
            <input type="number" name="umur" value="{{ old('umur') }}" class="w-full border rounded px-3 py-2" min="0" required>
        </label>

        <label class="block mb-2">
            Berat Badan (kg):
            <input type="number" step="0.1" name="berat_badan" value="{{ old('berat_badan') }}" class="w-full border rounded px-3 py-2" min="0" required>
        </label>

        <label class="block mb-2">
            Tinggi Badan (cm):
            <input type="number" step="0.1" name="tinggi_badan" value="{{ old('tinggi_badan') }}" class="w-full border rounded px-3 py-2" min="0" required>
        </label>

        <label class="block mb-2">
            Klasifikasi:
            <input type="text" name="klasifikasi" value="{{ old('klasifikasi') }}" class="w-full border rounded px-3 py-2">
        </label>

        <label class="block mb-2">
            TTV:
            <input type="text" name="ttv" value="{{ old('ttv') }}" class="w-full border rounded px-3 py-2">
        </label>

        <label class="block mb-2">
            HPHT:
            <input type="date" name="hpht" value="{{ old('hpht') }}" class="w-full border rounded px-3 py-2">
        </label>

        <label class="block mb-2">
            Anamnesa:
            <textarea name="anamnesa" class="w-full border rounded px-3 py-2">{{ old('anamnesa') }}</textarea>
        </label>

        <label class="block mb-2">
            Keluhan:
            <textarea name="keluhan" class="w-full border rounded px-3 py-2">{{ old('keluhan') }}</textarea>
        </label>

        <label class="block mb-2">
            Komplikasi:
            <textarea name="komplikasi" class="w-full border rounded px-3 py-2">{{ old('komplikasi') }}</textarea>
        </label>

        <label class="block mb-2">
            Kegagalan:
            <textarea name="kegagalan" class="w-full border rounded px-3 py-2">{{ old('kegagalan') }}</textarea>
        </label>

        <label class="block mb-4">
            Tindakan:
            <textarea name="tindakan" class="w-full border rounded px-3 py-2">{{ old('tindakan') }}</textarea>
        </label>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        <a href="{{ route('pasien.rekam-medis.index', $pasien->id) }}" class="ml-4 text-gray-600 hover:underline">Batal</a>
    </form>

</body>
</html>
