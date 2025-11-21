<?php

namespace App\Http\Controllers;

use App\Models\RekamMedisKb;
use App\Models\Pasien;
use Illuminate\Http\Request;

class RekamMedisKbController extends Controller
{
    public function index()
    {
        $rekamMedis = RekamMedisKb::with('pasien')->latest()->paginate(10);
        return view('rekam_medis_kb.index', compact('rekamMedis'));
    }

    public function create($pasien_id = null)
    {
        $pasien = $pasien_id ? Pasien::findOrFail($pasien_id) : null;
        return view('rekam_medis_kb.create', compact('pasien'));
    }

    public function store(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'tanggal_datang' => 'required|date',
            'hpht' => 'nullable|date',
            'berat_badan' => 'nullable|numeric',
            'tensi' => 'nullable|string',
            'komplikasi' => 'nullable|string',
            'kegagalan' => 'nullable|string',
            'pemeriksaan_dan_tindakan' => 'nullable|string',
            'tanggal_kembali' => 'nullable|date',
        ]);

        $validated['pasien_id'] = $pasien->id;
        RekamMedisKb::create($validated);
    
        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis kb berhasil ditambahkan.');

        
    }

    public function show($id)
    {
        $rekam = RekamMedisKb::with('pasien')->findOrFail($id);
        return view('rekam_medis_kb.show', compact('rekam'));
    }

    public function edit($id)
    {
        $rekam = RekamMedisKb::findOrFail($id);
        $pasien = Pasien::find($rekam->pasien_id);
        return view('rekam_medis_kb.edit', compact('rekam', 'pasien'));
    }

    public function update(Request $request, Pasien $pasien, RekamMedisKb $rekam_medis_kb)
    {
        $validated = $request->validate([
            'tanggal_datang' => 'required|date',
            'hpht' => 'nullable|date',
            'berat_badan' => 'nullable|numeric',
            'tensi' => 'nullable|string',
            'komplikasi' => 'nullable|string',
            'kegagalan' => 'nullable|string',
            'pemeriksaan_dan_tindakan' => 'nullable|string',
            'tanggal_kembali' => 'nullable|date',
        ]);

        $rekam_medis_kb->update($validated);
        return redirect()
            ->route('daftar-pasien.show', $pasien)
            ->with('success', 'Rekam medis KB berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $rekam = RekamMedisKb::findOrFail($id);
        $rekam->delete();
        return redirect()->route('rekam-medis-kb.index')->with('success', 'Rekam medis KB berhasil dihapus!');
    }
}

//