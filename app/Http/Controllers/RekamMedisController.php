<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

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
            'umur' => 'required|integer|min:0',
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

        $validated['pasien_id'] = $pasien->id;

        RekamMedis::create($validated);

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
    public function edit($pasienId, $rekamMedisId)
{
    $pasien = Pasien::findOrFail($pasienId);
    $rekam_medis = RekamMedis::findOrFail($rekamMedisId);

    return view('rekam_medis.edit', compact('pasien', 'rekam_medis'));
}

    // Simpan perubahan rekam medis
    public function update(Request $request, Pasien $pasien, RekamMedis $rekam_medis)
    {
        
        $validated = $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'umur' => 'required|integer|min:0',
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

        $rekam_medis->update($validated);

        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis berhasil diperbarui.');
    }

    // Hapus rekam medis
    public function destroyRekamMedis($pasien_id, $rekam_medis_id)
{
    $rekam_medis = RekamMedis::findOrFail($rekam_medis_id);
    $rekam_medis->delete();

    return redirect()
        ->route('daftar-pasien.show', $pasien_id)
        ->with('success', 'Rekam medis berhasil dihapus.');
}
}
