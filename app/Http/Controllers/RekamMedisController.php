<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Jobs\SendFonnteMessageJob;

class RekamMedisController extends Controller
{
    // Tampilkan semua rekam medis untuk pasien tertentu
    public function index(Pasien $pasien)
    {
        $rekamMedis = $pasien->rekamMedis()->latest()->get();
        return view('rekam_medis.index', compact('pasien', 'rekamMedis'));
    }

    // Tampilkan form tambah rekam medis
    public function create(Pasien $pasien)
    {
        return view('rekam_medis.create', compact('pasien'));
    }

    // Simpan data rekam medis
    public function store(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'klasifikasi' => 'nullable|string',
            'ttv' => 'nullable|string',
            'hpht' => 'nullable|date',
            'anamnesa' => 'nullable|string',
            'keluhan' => 'nullable|string',
            'komplikasi' => 'nullable|string',
            'kegagalan' => 'nullable|string',
            'tindakan' => 'nullable|string',
        ]);

        // Hitung umur otomatis
        $tanggalLahir = Carbon::parse($pasien->tanggal_lahir);
        $tanggalPemeriksaan = Carbon::parse($validated['tanggal_pemeriksaan']);
        $diff = $tanggalLahir->diff($tanggalPemeriksaan);
        $umur = "{$diff->y} tahun {$diff->m} bulan {$diff->d} hari";

        $validated['umur'] = $umur;
        $validated['pasien_id'] = $pasien->id;

        $rekamMedis = RekamMedis::create($validated);

        $message = "Halo {$pasien->nama_pasien}, hasil pemeriksaan Anda di Bidan Yeni"
                    . "pada {$rekamMedis->tanggal_pemeriksaan->format('d-m-Y')} sudah dicatat. "
                    . "Diagnosa/Keluhan: {$rekamMedis->keluhan}."
                    . "Jika ada keluhan lebih lanjut, silakan datang kembali.";

        SendFonnteMessageJob::dispatch($pasien->no_telepon, $message);

        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis berhasil ditambahkan.');
    }

    // Tampilkan detail rekam medis tertentu (opsional)
    public function show(Pasien $pasien, RekamMedis $rekam_medis)
    {
        return view('rekam_medis.show', compact('pasien', 'rekam_medis'));
    }

    // Tampilkan form edit
    public function edit(Pasien $pasien, RekamMedis $rekam_medis)
    {
        return view('rekam_medis.edit', compact('pasien', 'rekam_medis'));
    }

    // Simpan perubahan rekam medis
    public function update(Request $request, Pasien $pasien, RekamMedis $rekam_medis)
    {
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'berat_badan' => 'required|numeric|min:0',
            'tinggi_badan' => 'required|numeric|min:0',
            'klasifikasi' => 'nullable|string',
            'ttv' => 'nullable|string',
            'hpht' => 'nullable|date',
            'anamnesa' => 'nullable|string',
            'keluhan' => 'nullable|string',
            'komplikasi' => 'nullable|string',
            'kegagalan' => 'nullable|string',
            'tindakan' => 'nullable|string',
        ]);

        // Hitung umur ulang saat update
        $tanggalLahir = Carbon::parse($pasien->tanggal_lahir);
        $tanggalPemeriksaan = Carbon::parse($validated['tanggal_pemeriksaan']);
        $diff = $tanggalLahir->diff($tanggalPemeriksaan);
        $umur = "{$diff->y} tahun {$diff->m} bulan {$diff->d} hari";

        $validated['umur'] = $umur;

        $rekam_medis->update($validated);

        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    // Hapus rekam medis
    public function destroy(Pasien $pasien, RekamMedis $rekam_medis)
    {
        $rekam_medis->delete();

        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis berhasil dihapus.');
    }
    
    public function cetak($id)
    {
        $pasien = Pasien::with('rekamMedis')->findOrFail($id);

        $pdf = Pdf::loadView('rekam_medis.laporan', compact('pasien'))->setPaper('A4', 'landscape');

        return $pdf->stream('laporan_rekam_medis_' . $pasien->nama . '.pdf');
    }
}

