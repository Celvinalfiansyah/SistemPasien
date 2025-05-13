<?php

namespace App\Http\Controllers;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;

class DaftarPasienController extends Controller
{
    public function index()
    {
        $pasiens=Pasien::all();
        return view('daftar-pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('daftar-pasien.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien'=>'required|string|max:25',
            'alamat'=>'required|string',
            'tanggal_lahir'=>'required|date',
            'no_telepon'=>'required|string|max:15',
            'jenis_kelamin'=>'required|in:Laki-laki,Perempuan',
            'tanggal_daftar'=>'required|date',
        ]);

        Pasien::create($request->all());

        return redirect()->route('daftar-pasien.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit(Pasien $pasien) {
        return view('daftar-pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pasien'=>'required|string|max:255',
            'alamat'=>'required|string',
            'tanggal_lahir'=>'required|date',
            'no_telepon'=>'required|string|max:15',
            'jenis_kelamin'=>'required|in:Laki-laki,Perempuan',
            'tanggal_daftar'=>'required|date',
        ]);

        $pasien=Pasien::findOrFail($id);
        $pasien->update($request->all());
        return redirect()->route('daftar-pasien.index')->with('success', 'Data pasien berhasil diperbarui');
    }
    public function destroy($id)
    {
        $pasien=Pasien::findOrFail($id);
        $pasien->delete();
        return redirect()->route('daftar-pasien.index')->with('success', 'Pasien berhasil dihapus');
    }
}
