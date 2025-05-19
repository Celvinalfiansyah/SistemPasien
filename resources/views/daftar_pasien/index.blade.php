<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100 min-h-screen flex">

    <aside class="w-60 bg-[#123456] text-white min-h-screen p-5 space-y-6">
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

    <main class="flex-1 p-10">

        <div class="mb-6">
            <form method="GET" action="{{ route('daftar-pasien.index') }}" class="flex">
                <input
                    type="text"
                    name="cari"
                    placeholder="Cari berdasarkan nama pasien..."
                    value="{{ request('cari') }}"
                    class="flex-grow px-4 py-2 rounded-l-full border border-gray-300 shadow focus:outline-none"
                >
                <button type="submit" class="bg-blue-600 text-white px-6 rounded-r-full hover:bg-blue-700">
                    🔍 Cari
                </button>
            </form>
        </div>

        <div class="mb-4">
            <a href="{{ route('daftar-pasien.create') }}">
                <button class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded">+ Tambah Pasien</button>
            </a>
        </div>

        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Alamat</th>
                        <th class="py-3 px-4">Tanggal Lahir</th>
                        <th class="py-3 px-4">No HP</th>
                        <th class="py-3 px-4">Jenis Kelamin</th>
                        <th class="py-3 px-4">Tanggal Daftar</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if($pasiens->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center py-4 text-gray-500">Tidak ada data ditemukan.</td>
                        </tr>
                    @endif

                    @foreach($pasiens as $p)
                    <tr class="border-t">
                        <td class="py-2 px-4">{{ $p->nama_pasien }}</td>
                        <td class="py-2 px-4">{{ $p->alamat }}</td>
                        <td class="py-2 px-4">{{ \Carbon\Carbon::parse($p->tanggal_lahir)->format('d-m-Y') }}</td>
                        <td class="py-2 px-4">{{ $p->no_telepon }}</td>
                        <td class="py-2 px-4">{{ $p->jenis_kelamin }}</td>
                        <td class="py-2 px-4">{{ $p->tanggal_daftar }}</td>
                        <td class="py-2 px-4 space-x-2 flex">
                            <a href="{{ route('daftar-pasien.edit', $p) }}">
                                <button class="bg-green-500 text-white px-3 py-1 rounded">✏️</button>
                            </a>
                            <form action="{{ route('daftar-pasien.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-end">
            @if ($pasiens->lastPage() > 1)
                <ul class="inline-flex items-center space-x-1">
                    {{-- Prev --}}
                    <li>
                        <a href="{{ $pasiens->previousPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                           class="px-3 py-1 bg-white border rounded-l hover:bg-gray-100">
                            ‹
                        </a>
                    </li>

                    {{-- Pages --}}
                    @for ($i = 1; $i <= $pasiens->lastPage(); $i++)
                        <li>
                            <a href="{{ $pasiens->url($i) }}&{{ http_build_query(request()->except('page')) }}"
                               class="px-3 py-1 border {{ $pasiens->currentPage() == $i ? 'bg-blue-600 text-white' : 'bg-white hover:bg-gray-100' }}">
                                {{ $i }}
                            </a>
                        </li>
                    @endfor

                    {{-- Next --}}
                    <li>
                        <a href="{{ $pasiens->nextPageUrl() }}&{{ http_build_query(request()->except('page')) }}"
                           class="px-3 py-1 bg-white border rounded-r hover:bg-gray-100">
                            ›
                        </a>
                    </li>
                </ul>
            @endif
        </div>
    </main>
</body>
</html>
