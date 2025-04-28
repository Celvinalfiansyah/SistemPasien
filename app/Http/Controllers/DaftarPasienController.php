<?php

namespace App\Http\Controllers;
use app\Models\DaftarPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades;

class DaftarPasienController extends Controller
{
    public function index()
    {
        $pasien=DaftarPasien::all();
        return view('daftar_pasien.index', compact('pasien'));
    }
    public function create()
    {
        return view('daftar_pasien.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien'=>'required|string|max:25',
            'alamat'=>'required|string',
            'tanggal_lahir'=>'required|date',
            'no_hp'=>'required|string|max:15',
            'jenis_kelamin'=>'required|in:P\L,P',
            'tanggal_daftar'=>'required|date',
        ]);

        DaftarPasien::create($request->all());

        return redirect()->route('daftar-pasien.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pasien'=>'required|string|max:255',
            'alamat'=>'required|string',
            'tanggal_lahir'=>'required|date',
            'no_hp'=>'required|string|max:15',
            'jenis_kelamin'=>'required|in:L,P',
            'tanggal_daftar'=>'required|date',
        ]);

        $pasien=DaftarPasien::findOrFail($id);
        $pasien->update($request->all());
        return redirect()->route('daftar-pasien.index');
    }
    public function detory($id)
    {
        $pasien=DaftarPasien::findOrFail($id);
        $pasien->delete();
        return redirect()->route('daftar-pasien.index');
    }
}
