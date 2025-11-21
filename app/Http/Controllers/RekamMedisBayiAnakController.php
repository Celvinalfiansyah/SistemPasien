<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedisBayiAnak;
use Illuminate\Http\Request;
use App\Jobs\SendFonnteMessageJob;
use Carbon\Carbon;

class RekamMedisBayiAnakController extends Controller
{
    // Tampilkan semua rekam medis untuk pasien tertentu
    public function index(Pasien $pasien)
    {
        // Ambil rekam medis bayi & anak dengan pasien
    $rekamMedis = RekamMedisBayiAnak::with('pasien')->latest()->paginate(10);

    // Loop untuk menghitung umur setiap rekam medis
    foreach ($rekamMedis as $rekam) {
        // Menghitung umur berdasarkan tanggal lahir pasien dan tanggal pemeriksaan
        $tanggalLahir = Carbon::parse($rekam->pasien->tanggal_lahir);
        $tanggalPemeriksaan = Carbon::parse($rekam->tanggal_pemeriksaan);
        $diff = $tanggalLahir->diff($tanggalPemeriksaan);

        // Menghitung umur dalam tahun, bulan, hari, jam
        $rekam->umurText = "{$diff->y} tahun {$diff->m} bulan {$diff->d} hari {$diff->h} jam";
    }

    return view('rekam_medis_bayi_anak.index', compact('rekamMedis'));
    }

    // Tampilkan form tambah rekam medis
    public function create(Pasien $pasien)
    {
        // Mengambil tanggal lahir pasien
    $tanggalLahir = Carbon::parse($pasien->tanggal_lahir);

    // Mendapatkan tanggal pemeriksaan saat ini atau tanggal yang di-input
    $tanggalPemeriksaan = Carbon::now(); // Default ke tanggal hari ini

    // Jika ada input tanggal pemeriksaan, gunakan tanggal tersebut
    if (request()->has('tanggal_pemeriksaan')) {
        $tanggalPemeriksaan = Carbon::parse(request('tanggal_pemeriksaan'));
    }

    // Menghitung perbedaan umur antara tanggal lahir dan tanggal pemeriksaan
    $umur = $tanggalLahir->diff($tanggalPemeriksaan);
    $umurText = "{$umur->y} tahun {$umur->m} bulan {$umur->d} hari";

    // Menampilkan form tambah rekam medis dengan data pasien dan umur otomatis
    return view('rekam_medis_bayi_anak.create', compact('pasien', 'umurText'));
    }

    // Simpan data rekam medis bayi & anak
    public function store(Request $request, Pasien $pasien)
{
    // Validasi input
    $validated = $request->validate([
        'tanggal_pemeriksaan' => 'required|date',
        'berat_badan' => 'required|numeric',
        'keluhan' => 'nullable|string',
        'tindakan' => 'nullable|string',
    ]);

    // Menghitung umur dalam bulan
    $tanggalLahir = Carbon::parse($pasien->tanggal_lahir);
    $tanggalPemeriksaan = Carbon::parse($validated['tanggal_pemeriksaan']);
    
    $diff = $tanggalLahir->diff($tanggalPemeriksaan);

    $umur = "{$diff->y} tahun {$diff->m} bulan {$diff->d} hari";
    // Menyimpan umur dalam bulan
    $validated['umur'] = $umur;
    $validated['pasien_id'] = $pasien->id;

    // Menyimpan rekam medis
    RekamMedisBayiAnak::create($validated);

    // Mengirimkan pesan WhatsApp
    $message = "Halo {$pasien->nama_pasien}, hasil pemeriksaan Anda di Bidan Yeni"
                . " pada {$validated['tanggal_pemeriksaan']} sudah dicatat. "
                . "Diagnosa/Keluhan: {$validated['keluhan']}."
                . "Jika ada keluhan lebih lanjut, silakan datang kembali.";

    SendFonnteMessageJob::dispatch($pasien->no_telepon, $message);

    return redirect()
        ->route('daftar-pasien.show', $pasien)
        ->with('success', 'Rekam medis bayi & anak berhasil ditambahkan.');
}
    // Tampilkan detail rekam medis bayi & anak
    public function show(Pasien $pasien, RekamMedisBayiAnak $rekam_medis_bayi_anak)
    {
        // Menghitung umur lengkap (tahun, bulan, hari)
    $tanggalLahir = Carbon::parse($pasien->tanggal_lahir);
    $tanggalPemeriksaan = Carbon::parse($rekam_medis_bayi_anak->tanggal_pemeriksaan);
    $diff = $tanggalLahir->diff($tanggalPemeriksaan);

    $umurText = "{$diff->y} tahun {$diff->m} bulan {$diff->d} hari";

    return view('rekam_medis_bayi_anak.show', compact('pasien', 'rekam_medis_bayi_anak', 'umurText'));
    }

    // Tampilkan form edit rekam medis bayi & anak
    public function edit(Pasien $pasien, RekamMedisBayiAnak $rekam_medis_bayi_anak)
    {
        return view('rekam_medis_bayi_anak.edit', compact('pasien', 'rekam_medis_bayi_anak'));
    }

    // Simpan perubahan rekam medis bayi & anak
    public function update(Request $request, Pasien $pasien, RekamMedisBayiAnak $rekam_medis_bayi_anak)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'umur' => 'required|numeric',
            'berat_badan' => 'required|numeric',
            'keluhan' => 'nullable|string',
            'tindakan' => 'nullable|string',
        ]);

        // Menghitung umur ulang saat update
        $tanggalLahir = Carbon::parse($pasien->tanggal_lahir);
        $tanggalPemeriksaan = Carbon::parse($validated['tanggal_pemeriksaan']);
        $diff = $tanggalLahir->diff($tanggalPemeriksaan);
        $umur = "{$diff->y} tahun {$diff->m} bulan {$diff->d} hari";

        $validated['umur'] = $umur;

        // Memperbarui data rekam medis bayi & anak
        $rekam_medis_bayi_anak->update($validated);

        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis bayi & anak berhasil diperbarui.');
    }

    // Hapus rekam medis bayi & anak
    public function destroy(Pasien $pasien, RekamMedisBayiAnak $rekam_medis_bayi_anak)
    {
        $rekam_medis_bayi_anak->delete();

        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis bayi & anak berhasil dihapus.');
    }
}
//