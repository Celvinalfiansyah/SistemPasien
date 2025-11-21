<!DOCTYPE html>
<html lang="id">
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
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 text-white hover:text-gray-300 w-full mt-4">
                    <span>🚪</span><span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-8">
        <div class="mb-6">
            <a href="{{ route('daftar-pasien.index') }}" class="text-blue-600 hover:underline">← Kembali ke daftar pasien</a>
        </div>

        <!-- Detail Pasien -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-2xl font-bold mb-4">Detail Pasien</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div><strong>Nama:</strong> {{ $pasien->nama_pasien }}</div>
                <div><strong>Tanggal Lahir:</strong> {{ $pasien->tanggal_lahir->format('d-m-Y') }}</div>
                <div><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin }}</div>
                <div><strong>No Telepon:</strong> {{ $pasien->no_telepon }}</div>
                <div><strong>Alamat:</strong> {{ $pasien->alamat }}</div>
                <div><strong>Tanggal Daftar:</strong> {{ $pasien->tanggal_daftar->format('d-m-Y') }}</div>
                <div><strong>Jenis Pasien:</strong> {{ ucfirst(str_replace('_', ' ', $pasien->jenis_pasien ?? '-')) }}</div>
            </div>
        </div>

        @php
            $jenis = $pasien->jenis_pasien;
            $dataRekamMedis = collect();
            $urlTambah = null;

            switch($jenis) {
                case 'rawat_jalan':
                    $dataRekamMedis = $pasien->rekamMedisRawatJalan;
                    $urlTambah = route('pasien.rekam-medis-rawat-jalan.create', $pasien->id);
                    break;
                case 'bayi_anak':
                    $dataRekamMedis = $pasien->rekamMedisBayiAnak;
                    $urlTambah = route('pasien.rekam-medis-bayi-anak.create', $pasien->id);
                    break;
                case 'kb':
                    $dataRekamMedis = $pasien->rekamMedisKb;
                    $urlTambah = route('pasien.rekam-medis-kb.create', $pasien->id);
                    break;
            }
        @endphp

        <!-- Tombol Aksi -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Riwayat Rekam Medis</h2>
            <div class="flex gap-2">
                @if ($urlTambah)
                    <a href="{{ $urlTambah }}">
                        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">+ Tambah Rekam Medis</button>
                    </a>
                @else
                    <span class="text-red-500 font-semibold">Jenis pasien belum ditentukan</span>
                @endif

                <a href="{{ route('rekam-medis.cetak', $pasien->id) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Cetak Rekam Medis
                </a>
            </div>
        </div>

        <!-- Tabel Rekam Medis -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-gray-200">
                    <tr>
                        @if($jenis === 'rawat_jalan')
                            <th class="py-2 px-4">Tanggal Pemeriksaan</th>
                            <th class="py-2 px-4">TTV</th>
                            <th class="py-2 px-4">Anamnesa</th>
                            <th class="py-2 px-4">Tindakan</th>
                        @elseif($jenis === 'bayi_anak')
                            <th class="py-2 px-4">Tanggal Pemeriksaan</th>
                            <th class="py-2 px-4">Umur</th>
                            <th class="py-2 px-4">Berat Badan</th>
                            <th class="py-2 px-4">Keluhan</th>
                            <th class="py-2 px-4">Tindakan</th>
                        @elseif($jenis === 'kb')
                            <th class="py-2 px-4">Tanggal Datang</th>
                            <th class="py-2 px-4">HPHT</th>
                            <th class="py-2 px-4">Berat Badan</th>
                            <th class="py-2 px-4">Tensi</th>
                            <th class="py-2 px-4">Komplikasi</th>
                            <th class="py-2 px-4">Kegagalan</th>
                            <th class="py-2 px-4">Pemeriksaan & Tindakan</th>
                            <th class="py-2 px-4">Tanggal Kembali</th>
                        @endif
                        <th class="py-2 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dataRekamMedis as $rm)
                        <tr class="border-t hover:bg-gray-50">
                            @if($jenis === 'rawat_jalan')
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($rm->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                                <td class="py-2 px-4">{{ $rm->ttv }}</td>
                                <td class="py-2 px-4">{{ $rm->anamnesa }}</td>
                                <td class="py-2 px-4">{{ $rm->tindakan }}</td>
                            @elseif($jenis === 'bayi_anak')
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($rm->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                                <td class="py-2 px-4">{{ $rm->umur }}</td>
                                <td class="py-2 px-4">{{ $rm->berat_badan }} kg</td>
                                <td class="py-2 px-4">{{ $rm->keluhan }}</td>
                                <td class="py-2 px-4">{{ $rm->tindakan }}</td>
                            @elseif($jenis === 'kb')
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($rm->tanggal_datang)->format('d-m-Y') }}</td>
                                <td class="py-2 px-4">{{ $rm->hpht }}</td>
                                <td class="py-2 px-4">{{ $rm->berat_badan }}</td>
                                <td class="py-2 px-4">{{ $rm->tensi }}</td>
                                <td class="py-2 px-4">{{ $rm->komplikasi }}</td>
                                <td class="py-2 px-4">{{ $rm->kegagalan }}</td>
                                <td class="py-2 px-4">{{ $rm->pemeriksaan_dan_tindakan }}</td>
                                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($rm->tanggal_kembali)->format('d-m-Y') }}</td>
                            @endif

                            <td class="py-2 px-4 space-x-2">
                                @php
                                    $routeEdit = match($jenis) {
                                        'rawat_jalan' => route('pasien.rekam-medis-rawat-jalan.edit', [$pasien->id, $rm->id]),
                                        'bayi_anak' => route('pasien.rekam-medis-bayi-anak.edit', [$pasien->id, $rm->id]),
                                        'kb' => route('pasien.rekam-medis-kb.edit', [$pasien->id, $rm->id]),
                                        default => '#',
                                    };
                                    $routeDelete = match($jenis) {
                                        'rawat_jalan' => route('pasien.rekam-medis-rawat-jalan.destroy', [$pasien->id, $rm->id]),
                                        'bayi_anak' => route('pasien.rekam-medis-bayi-anak.destroy', [$pasien->id, $rm->id]),
                                        'kb' => route('pasien.rekam-medis-kb.destroy', [$pasien->id, $rm->id]),
                                        default => '#',
                                    };
                                @endphp
                                <a href="{{ $routeEdit }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ $routeDelete }}"
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
{{--  --}}