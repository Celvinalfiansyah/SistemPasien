<?php

namespace App\Http\Controllers;

use App\Models\JadwalKontrol;
use Illuminate\Http\Request;

class JadwalKontrolController extends Controller
{
    public function index()
    {
        return response()->json(JadwalKontrol::with('pasien')->get(), 200);
    }

    public function show($id)
    {
        $jadwal = JadwalKontrol::with('pasien')->find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal kontrol not found'], 404);
        }
        return response()->json($jadwal, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id',
            'tanggal_kontrol' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $jadwal = JadwalKontrol::create($request->all());

        return response()->json($jadwal, 201);
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalKontrol::find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal kontrol not found'], 404);
        }

        $request->validate([
            'id_pasien' => 'sometimes|exists:pasien,id',
            'tanggal_kontrol' => 'sometimes|date',
            'keterangan' => 'sometimes|string',
        ]);

        $jadwal->update($request->all());

        return response()->json($jadwal, 200);
    }

    public function destroy($id)
    {
        $jadwal = JadwalKontrol::find($id);
        if (!$jadwal) {
            return response()->json(['message' => 'Jadwal kontrol not found'], 404);
        }

        $jadwal->delete();
        return response()->json(['message' => 'Jadwal kontrol deleted successfully'], 200);
    }
}
