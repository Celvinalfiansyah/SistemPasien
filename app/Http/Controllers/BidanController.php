<?php

namespace App\Http\Controllers;

use App\Models\Bidan;
use Illuminate\Http\Request;

class BidanController extends Controller
{
    public function index()
    {
        return response()->json(Bidan::all(), 200);
    }

    public function show($id)
    {
        $bidan = Bidan::find($id);
        if (!$bidan) {
            return response()->json(['message' => 'Bidan not found'], 404);
        }
        return response()->json($bidan, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telepon' => 'required|string|max:15|unique:bidan,no_telepon',
            'email' => 'required|email|unique:bidan,email',
        ]);

        $bidan = Bidan::create($request->all());

        return response()->json($bidan, 201);
    }

    public function update(Request $request, $id)
    {
        $bidan = Bidan::find($id);
        if (!$bidan) {
            return response()->json(['message' => 'Bidan not found'], 404);
        }

        $request->validate([
            'nama' => 'sometimes|string|max:255',
            'no_telepon' => 'sometimes|string|max:15|unique:bidan,no_telepon,' . $id,
            'email' => 'sometimes|email|unique:bidan,email,' . $id,
        ]);

        $bidan->update($request->all());

        return response()->json($bidan, 200);
    }

    public function destroy($id)
    {
        $bidan = Bidan::find($id);
        if (!$bidan) {
            return response()->json(['message' => 'Bidan not found'], 404);
        }

        $bidan->delete();
        return response()->json(['message' => 'Bidan deleted successfully'], 200);
    }
}
