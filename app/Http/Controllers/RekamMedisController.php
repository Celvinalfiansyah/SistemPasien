<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index()
    {
        return response()->json(RekamMedis::with('pasien')->get(), 200);
    }

    public function show($id)
    {
        $rekamMedis = RekamMedis::with('pasien')->find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis not found'], 404);
        }
        return response()->json($rekamMedis, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pasien' => 'required|exists:pasien,id',
            'tanggal_periksa' => 'required|date',
            'diagnosa' => 'required|string',
            'tindakan' => 'nullable|string',
            'resep' => 'nullable|string',
        ]);

        $rekamMedis = RekamMedis::create($request->all());

        return response()->json($rekamMedis, 201);
    }

    public function update(Request $request, $id)
    {
        $rekamMedis = RekamMedis::find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis not found'], 404);
        }

        $request->validate([
            'id_pasien' => 'sometimes|exists:pasien,id',
            'tanggal_periksa' => 'sometimes|date',
            'diagnosa' => 'sometimes|string',
            'tindakan' => 'sometimes|string',
            'resep' => 'sometimes|string',
        ]);

        $rekamMedis->update($request->all());

        return response()->json($rekamMedis, 200);
    }

    public function destroy($id)
    {
        $rekamMedis = RekamMedis::find($id);
        if (!$rekamMedis) {
            return response()->json(['message' => 'Rekam medis not found'], 404);
        }

        $rekamMedis->delete();
        return response()->json(['message' => 'Rekam medis deleted successfully'], 200);
    }
}
