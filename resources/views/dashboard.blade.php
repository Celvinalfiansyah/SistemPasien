<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-100 min-h-screen flex">

    <aside class="w-60 bg-[#123456] text-white min-h-screen p-5 space-y-6">
        <div class="text-white text-lg font-bold">Menu</div>
        <div class="space-y-4">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:text-gray-300">
                <span>🏠</span><span>Home</span>
            </a>
            <a href="{{ route('daftar-pasien.index') }}" class="flex items-center space-x-3 hover:text-gray-300">
                <span>📊</span><span>Data & laporan</span>
            </a>
            <a href="#" class="flex items-center space-x-3 hover:text-gray-300">
                <span>📖</span><span>Sumber daya</span>
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

    <main class="flex-1 p-8">

     <div class="mt-16 text-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="mx-auto h-10">
        </div>
        <div class="text-center text-2xl font-semibold text-gray-600 mb-10">
            Selamat datang kembali, dokter
        </div>

        <div class="grid grid-cols-2 gap-6 px-20">

            <div class="bg-white p-6 rounded-lg shadow text-center">
                <div class="text-4xl mb-3">🔍</div>
                <div class="text-lg font-bold">Search</div>
                <p class="text-sm text-gray-500 mt-2">Apa yang Anda cari hari ini? Ketik kata kunci Anda di sini...</p>
            </div>

            <a href="{{ route('daftar-pasien.index') }}">
                <div class="bg-white p-6 rounded-lg shadow text-center hover:bg-blue-50 transition duration-300">
                    <div class="text-4xl mb-3">📊</div>
                    <div class="text-lg font-bold">Data & Laporan</div>
                    <p class="text-sm text-gray-500 mt-2">Ingin memeriksa laporan terbaru? Pilih kategori data yang ingin Anda akses.</p>
                </div>
            </a>

            <div class="bg-white p-6 rounded-lg shadow text-center">
                <div class="text-4xl mb-3">📘</div>
                <div class="text-lg font-bold">Sumber daya</div>
                <p class="text-sm text-gray-500 mt-2">Butuh panduan atau referensi? Jelajahi berbagai sumber daya yang tersedia.</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow text-center">
                <div class="text-4xl mb-3">❓</div>
                <div class="text-lg font-bold">Bantuan Saya</div>
                <p class="text-sm text-gray-500 mt-2">Mengalami masalah atau butuh bantuan? Temukan jawabannya di pusat bantuan kami.</p>
            </div>
        </div>

       
    </main>

</body>
</html>
