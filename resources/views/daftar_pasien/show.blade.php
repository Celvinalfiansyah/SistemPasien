<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Detail Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-60 bg-[#123456] text-white min-h-screen p-5 space-y-6 flex-shrink-0">
        <div class="text-white text-lg font-bold mb-6">Menu</div>
        <div class="space-y-4">
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:text-gray-300">
                <span>🏠</span><span>Home</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:text-gray-300 font-bold">
                <span>📊</span><span>Data & Laporan</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:text-gray-300">
                <span>📖</span><span>Sumber Daya</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:text-gray-300">
                <span>❓</span><span>Bantuan Saya</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:text-gray-300">
                <span>👤</span><span>Manajemen Akun</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:text-gray-300">
                <span>⚙️</span><span>Settings</span>
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8">
        <div class="mb-6">
            <a href="{{ route('daftar-pasien.index') }}" class="text-blue-600 hover:underline">← Kembali ke daftar pasien</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-2xl font-bold mb-4">Detail Pasien</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Nama:</strong> {{ $pasien->nama_pasien }}</div>
                <div><strong>Tanggal Lahir:</strong> {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d-m-Y') }}</div>
                <div><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin }}</div>
                <div><strong>No Telepon:</strong> {{ $pasien->no_telepon }}</div>
                <div><strong>Alamat:</strong> {{ $pasien->alamat }}</div>
                <div><strong>Tanggal Daftar:</strong> {{ $pasien->tanggal_daftar }}</div>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Riwayat Rekam Medis</h2>
            <a href="{{ route('pasien.rekam-medis.create', $pasien) }}">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Rekam Medis</button>
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4">Tanggal</th>
                        <th class="py-2 px-4">Umur</th>
                        <th class="py-2 px-4">BB</th>
                        <th class="py-2 px-4">TB</th>
                        <th class="py-2 px-4">Klasifikasi</th>
                        <th class="py-2 px-4">TTV</th>
                        <th class="py-2 px-4">Anamnesa</th>
                        <th class="py-2 px-4">Keluhan</th>
                        <th class="py-2 px-4">Tindakan</th>
                        <th class="py-2 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasien->rekamMedis as $rm)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ \Carbon\Carbon::parse($rm->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                            <td class="py-2 px-4">{{ $rm->umur }}</td>
                            <td class="py-2 px-4">{{ $rm->berat_badan }} kg</td>
                            <td class="py-2 px-4">{{ $rm->tinggi_badan }} cm</td>
                            <td class="py-2 px-4">{{ $rm->klasifikasi }}</td>
                            <td class="py-2 px-4">{{ $rm->ttv }}</td>
                            <td class="py-2 px-4">{{ $rm->anamnesa }}</td>
                            <td class="py-2 px-4">{{ $rm->keluhan }}</td>
                            <td class="py-2 px-4">{{ $rm->tindakan }}</td>
                            <td class="py-2 px-4 space-x-2">
                                
                                <a href="{{ route('pasien.rekam-medis.edit', ['pasien' => $pasien->id, 'rekam_medis' => $rm->id]) }}">Edit</a>

                                    
                                    <form action="{{ route('pasien.rekam-medis.destroy', [$pasien->id, $rm->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                    </form>
                                
                                </td>
                             </tr>
                             @empty
                             
                             <tr>
                                <td colspan="10" class="text-center py-4 text-gray-500">Belum ada rekam medis.</td>
                            </tr>
                            
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        
        </body>
</html>
