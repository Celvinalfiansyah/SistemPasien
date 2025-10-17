<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedisRawatJalan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Jobs\SendFonnteMessageJob;

class RekamMedisRawatJalanController extends Controller
{
    // Tampilkan semua rekam medis untuk pasien tertentu
    public function index(Pasien $pasien)
    {
        // Mengambil data rekam medis rawat jalan yang berhubungan dengan pasien
        $rekamMedis = $pasien->rekamMedisRawatJalan()->latest()->get();

        // Menampilkan view rekam medis rawat jalan untuk pasien tertentu
        return view('rekam_medis_rawat_jalan.index', compact('pasien', 'rekamMedis'));
    }

    // Tampilkan form tambah rekam medis
    public function create(Pasien $pasien)
    {
        // Menampilkan form untuk menambah rekam medis untuk pasien tertentu
        return view('rekam_medis_rawat_jalan.create', compact('pasien'));
    }

    // Simpan data rekam medis
    public function store(Request $request, Pasien $pasien)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'ttv' => 'nullable|string',
            'anamnesa' => 'nullable|string',
            'keluhan' => 'nullable|string',
            'tindakan' => 'nullable|string',
        ]);

        // Menghitung umur berdasarkan tanggal lahir pasien dan tanggal pemeriksaan
        $tanggalLahir = Carbon::parse($pasien->tanggal_lahir);
        $tanggalPemeriksaan = Carbon::parse($validated['tanggal_pemeriksaan']);
        $diff = $tanggalLahir->diff($tanggalPemeriksaan);
        $umur = "{$diff->y} tahun {$diff->m} bulan {$diff->d} hari";

        // Menambahkan umur dan pasien_id ke data rekam medis
        $validated['umur'] = $umur;
        $validated['pasien_id'] = $pasien->id;

        // Menyimpan data rekam medis rawat jalan
        RekamMedisRawatJalan::create($validated);

        // Menyusun pesan untuk dikirim via WhatsApp
        $message = "Halo {$pasien->nama_pasien}, hasil pemeriksaan Anda di Bidan Yeni"
                    . " pada {$validated['tanggal_pemeriksaan']} sudah dicatat. "
                    . "Diagnosa/Keluhan: {$validated['keluhan']}."
                    . "Jika ada keluhan lebih lanjut, silakan datang kembali.";

        // Mengirimkan pesan WhatsApp ke pasien
        SendFonnteMessageJob::dispatch($pasien->no_telepon, $message);

        // Redirect ke halaman pasien dengan pesan sukses
        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis rawat jalan berhasil ditambahkan.');
    }

    // Tampilkan detail rekam medis tertentu
    public function show(Pasien $pasien, RekamMedisRawatJalan $rekam_medis_rawat_jalan)
    {
        // Menampilkan view untuk detail rekam medis rawat jalan
        return view('rekam_medis_rawat_jalan.show', compact('pasien', 'rekam_medis_rawat_jalan'));
    }

    // Tampilkan form edit rekam medis
    public function edit(Pasien $pasien, RekamMedisRawatJalan $rekam_medis_rawat_jalan)
    {
        // Menampilkan form untuk mengedit rekam medis rawat jalan
        return view('rekam_medis_rawat_jalan.edit', compact('pasien', 'rekam_medis_rawat_jalan'));
    }

    // Simpan perubahan rekam medis
    public function update(Request $request, Pasien $pasien, RekamMedisRawatJalan $rekam_medis_rawat_jalan)
    {
        // Validasi input
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'ttv' => 'nullable|string',
            'anamnesa' => 'nullable|string',
            'keluhan' => 'nullable|string',
            'tindakan' => 'nullable|string',
        ]);

        // Menghitung umur ulang saat update
        $tanggalLahir = Carbon::parse($pasien->tanggal_lahir);
        $tanggalPemeriksaan = Carbon::parse($validated['tanggal_pemeriksaan']);
        $diff = $tanggalLahir->diff($tanggalPemeriksaan);
        $umur = "{$diff->y} tahun {$diff->m} bulan {$diff->d} hari";

        // Menambahkan umur ke data rekam medis yang diperbarui
        $validated['umur'] = $umur;

        // Memperbarui data rekam medis rawat jalan
        $rekam_medis_rawat_jalan->update($validated);

        // Redirect kembali ke halaman pasien dengan pesan sukses
        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis rawat jalan berhasil diperbarui.');
    }

    // Hapus rekam medis
    public function destroy(Pasien $pasien, RekamMedisRawatJalan $rekam_medis_rawat_jalan)
    {
        // Menghapus data rekam medis rawat jalan
        $rekam_medis_rawat_jalan->delete();

        // Redirect kembali ke halaman pasien dengan pesan sukses
        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis rawat jalan berhasil dihapus.');
    }
}
