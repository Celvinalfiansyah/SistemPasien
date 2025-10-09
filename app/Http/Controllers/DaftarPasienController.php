<?php

namespace App\Http\Controllers;
use App\Models\Pasien;
use Illuminate\Http\Request;
// use App\Jobs\SendFonnteMessageJob;
use App\Services\FonnteService;
use App\Models\LogPesan;

class DaftarPasienController extends Controller
{
    /**
     * Tampilkan daftar pasien, dengan fitur search, sort A–Z, dan pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('cari');

        $pasiens = Pasien::when($search, function ($q) use ($search) {
                $q->where('nama_pasien', 'like', '%' . $search . '%');
            })
            ->orderBy('nama_pasien', 'asc')
            ->paginate(10);

        $pasiens->appends(['cari' => $search]);

        return view('daftar_pasien.index', compact('pasiens'));
    }

    /**
     * Tampilkan form tambah pasien.
     */
    public function create()
    {
        return view('daftar_pasien.create');
    }

    /**
     * Simpan data pasien baru.
     */
    public function store(Request $request, FonnteService $fonnte)
    {
        $request->validate([
            'nama_pasien'    => 'required|string|max:25',
            'alamat'         => 'required|string',
            'tanggal_lahir'  => 'required|date',
            'no_telepon'     => 'required|string|max:15',
            'jenis_kelamin'  => 'required|in:Laki-laki,Perempuan',
            'tanggal_daftar' => 'required|date',
        ]);

        $pasien = Pasien::create($request->all());

        // Pesan WA
        $message = "Halo {$pasien->nama_pasien}, Anda berhasil terdaftar di Bidan Yeni" 
                    . "pada {$pasien->tanggal_daftar}. Harap simpan nomor ini untuk informasi berikutnya";

        // SendFonnteMessageJob::dispatch($pasien->no_telepon, $message);

        $response = $fonnte->sendMessage($pasien->no_telepon, $message);
         
        // Simpan log
        LogPesan::create([
            'pasien_id' => $pasien->id,
            'tipe_pesan' => 'registrasi',
            'isi_pesan' => $message,
            'status' => $response['status'] ?? 'failed'
        ]);

        return redirect()
            ->route('daftar-pasien.index')
            ->with('success', 'Pasien berhasil ditambahkan & notifikasi WA dikirim.');
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
    * Tampilkan detail data pasien.
    */
    public function show(Pasien $pasien)
    {
        // Memuat relasi rekam medis jika ada
        $pasien->load('rekamMedis');

        return view('daftar_pasien.show', compact('pasien'));
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
    }
}
