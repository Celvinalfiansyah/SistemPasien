<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Rekam Medis - {{ $pasien->nama_pasien }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <h1 class="text-2xl font-bold mb-4">Rekam Medis - {{ $pasien->nama_pasien }}</h1>

    <a href="{{ route('pasien.rekam-medis.create', $pasien->id) }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah Rekam Medis</a>

    <div class="mt-6 bg-white shadow rounded">
        <table class="w-full text-left">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Umur</th>
                    <th class="px-4 py-2">BB / TB</th>
                    <th class="px-4 py-2">Klasifikasi</th>
                    <th class="px-4 py-2">Tindakan</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekamMedis as $rekam)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $rekam->tanggal_pemeriksaan->format('d-m-Y') }}</td>
                    <td class="px-4 py-2">{{ $rekam->umur }}</td>
                    <td class="px-4 py-2">{{ $rekam->berat_badan }} kg / {{ $rekam->tinggi_badan }} cm</td>
                    <td class="px-4 py-2">{{ $rekam->klasifikasi }}</td>
                    <td class="px-4 py-2">{{ $rekam->tindakan }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('pasien.rekam-medis.show', [$pasien->id, $rekam->id]) }}" class="text-blue-600">🔍</a>
                        <a href="{{ route('pasien.rekam-medis.edit', [$pasien->id, $rekam->id]) }}" class="text-green-600">✏️</a>
                        <form action="{{ route('pasien.rekam-medis.destroy', [$pasien->id, $rekam->id]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600">🗑️</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
