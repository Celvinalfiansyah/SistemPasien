<?php

namespace App\Http\Controllers;
use App\Models\Pasien;
use Illuminate\Http\Request;

class DaftarPasienController extends Controller
{
    /**
     * Tampilkan daftar pasien, dengan fitur search, sort A–Z, dan pagination.
     */
    public function index(Request $request)
    {
        // Ambil keyword pencarian jika ada
        $search = $request->input('cari');

        // Bangun query: filter nama, sort A–Z, paginate 10 per halaman
        $pasiens = Pasien::when($search, function ($q) use ($search) {
                $q->where('nama_pasien', 'like', '%' . $search . '%');
            })
            ->orderBy('nama_pasien', 'asc')
            ->paginate(10);

        // Agar query string (cari=...) ikut ke link pagination
        $pasiens->appends(['cari' => $search]);

        return view('daftar_pasien.index', compact('pasiens'));
    }

    /**
     * Tampilkan form tambah pasien.
     */
    public function create()
    {
        return view('daftar-pasien.create');
    }

    /**
     * Simpan data pasien baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien'    => 'required|string|max:25',
            'alamat'         => 'required|string',
            'tanggal_lahir'  => 'required|date',
            'no_telepon'     => 'required|string|max:15',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_daftar' => 'required|date',
        ]);

        Pasien::create($request->all());

        return redirect()
            ->route('daftar-pasien.index')
            ->with('success', 'Pasien berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit data pasien.
     */
    public function edit(Pasien $pasien)
    {
        return view('daftar_pasien.edit', compact('pasien'));
    }

    /**
     * Update data pasien.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pasien'    => 'required|string|max:255',
            'alamat'         => 'required|string',
            'tanggal_lahir'  => 'required|date',
            'no_telepon'     => 'required|string|max:15',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_daftar' => 'required|date',
        ]);

        $pasien = Pasien::findOrFail($id);
        $pasien->update($request->all());

        return redirect()
            ->route('daftar-pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui');
    }

    /**
     * Hapus data pasien.
     */
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()
            ->route('daftar-pasien.index')
            ->with('success', 'Pasien berhasil dihapus');
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
