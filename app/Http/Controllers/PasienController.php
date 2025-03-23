<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        return response()->json(Pasien::all(), 200);
    }

    public function show($id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json(['message' => 'Pasien not found'], 404);
        }
        return response()->json($pasien, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15|unique:pasien,no_telepon',
            'tanggal_daftar' => 'nullable|date',
        ]);

        $pasien = Pasien::create($request->all());

        return response()->json($pasien, 201);
    }

    public function update(Request $request, $id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json(['message' => 'Pasien not found'], 404);
        }

        $request->validate([
            'nama_pasien' => 'sometimes|string|max:255',
            'tanggal_lahir' => 'sometimes|date',
            'jenis_kelamin' => 'sometimes|in:Laki-laki,Perempuan',
            'alamat' => 'sometimes|string',
            'no_telepon' => 'sometimes|string|max:15|unique:pasien,no_telepon,' . $id,
            'tanggal_daftar' => 'sometimes|date',
        ]);

        $pasien->update($request->all());

        return response()->json($pasien, 200);
    }

    public function destroy($id)
    {
        $pasien = Pasien::find($id);
        if (!$pasien) {
            return response()->json(['message' => 'Pasien not found'], 404);
        }

        $pasien->delete();
        return response()->json(['message' => 'Pasien deleted successfully'], 200);
    }
}
