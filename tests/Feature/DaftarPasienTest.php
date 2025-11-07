<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pasien;
use App\Models\User; // Tambahkan ini
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use App\Services\FonnteService;
use App\Models\LogPesan;

class DaftarPasienTest extends TestCase
{
    use RefreshDatabase;

    protected $validData;
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Buat user untuk auth
        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin' // atau 'bidan'
        ]);

        // Data pasien valid untuk base test
        $this->validData = [
            'nama_pasien'    => 'Anggara Pratama',
            'alamat'         => 'Jl. Soekarno No.12',
            'tanggal_lahir'  => '2000-05-12',
            'no_telepon'     => '081234567890',
            'jenis_kelamin'  => 'Laki-laki',
            'tanggal_daftar' => '2025-10-30 08:00:00',
            'jenis_pasien'   => 'rawat_jalan',
        ];
    }

    /** TC-001: Tambah pasien baru dengan data valid */
    public function test_tambah_pasien_valid()
    {
        // Mock FonnteService agar tidak kirim pesan WA sungguhan
        $mock = Mockery::mock(FonnteService::class);
        $mock->shouldReceive('sendMessage')->once()->andReturn(['status' => 'success']);
        $this->app->instance(FonnteService::class, $mock);

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $this->validData);

        $response->assertRedirect(route('daftar-pasien.index'));
        $this->assertDatabaseHas('pasien', ['nama_pasien' => 'Anggara Pratama']);
        $this->assertDatabaseHas('logs_pesan', ['tipe_pesan' => 'registrasi']);
    }

    /** TC-002: Gagal simpan jika nama kosong */
    public function test_gagal_tambah_tanpa_nama()
    {
        $data = $this->validData;
        $data['nama_pasien'] = '';

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('nama_pasien');
        $this->assertDatabaseCount('pasien', 0);
    }

    /** TC-003: Gagal jika nama lebih dari 25 karakter */
    public function test_gagal_tambah_nama_lebih_25_karakter()
    {
        $data = $this->validData;
        $data['nama_pasien'] = str_repeat('A', 26);

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('nama_pasien');
    }

    /** TC-004: Gagal jika alamat kosong */
    public function test_gagal_tambah_tanpa_alamat()
    {
        $data = $this->validData;
        $data['alamat'] = '';

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('alamat');
    }

    /** TC-005: Gagal jika tanggal lahir kosong */
    public function test_gagal_tambah_tanpa_tanggal_lahir()
    {
        $data = $this->validData;
        unset($data['tanggal_lahir']);

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('tanggal_lahir');
    }

    /** TC-006: Validasi tanggal lahir valid */
    public function test_validasi_tanggal_lahir_format_benar()
    {
        $data = $this->validData;
        $data['tanggal_lahir'] = '12 Mei 2000'; // format salah

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('tanggal_lahir');
    }

    /** TC-007: Gagal jika no HP kosong */
    public function test_gagal_tambah_tanpa_no_hp()
    {
        $data = $this->validData;
        unset($data['no_telepon']);

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('no_telepon');
    }

    /** TC-008: Gagal jika no HP lebih dari 15 karakter */
    public function test_gagal_tambah_no_hp_lebih_15_karakter()
    {
        $data = $this->validData;
        $data['no_telepon'] = str_repeat('8', 16);

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('no_telepon');
    }

    /** TC-009: Gagal jika jenis kelamin kosong */
    public function test_gagal_tambah_tanpa_jenis_kelamin()
    {
        $data = $this->validData;
        unset($data['jenis_kelamin']);

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('jenis_kelamin');
    }

    /** TC-010: Gagal jika tanggal daftar kosong */
    public function test_gagal_tambah_tanpa_tanggal_daftar()
    {
        $data = $this->validData;
        unset($data['tanggal_daftar']);

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('tanggal_daftar');
    }

    /** TC-011: Gagal jika jenis pasien invalid */
    public function test_gagal_tambah_jenis_pasien_invalid()
    {
        $data = $this->validData;
        $data['jenis_pasien'] = 'tidak_valid';

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('jenis_pasien');
    }

    /** TC-012: Tambah pasien bayi/anak */
    public function test_tambah_pasien_bayi_anak()
    {
        $mock = Mockery::mock(FonnteService::class);
        $mock->shouldReceive('sendMessage')->once()->andReturn(['status' => 'success']);
        $this->app->instance(FonnteService::class, $mock);

        $data = $this->validData;
        $data['jenis_pasien'] = 'bayi_anak';

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertRedirect(route('daftar-pasien.index'));
        $this->assertDatabaseHas('pasien', ['jenis_pasien' => 'bayi_anak']);
    }

    /** TC-013: Tambah pasien KB */
    public function test_tambah_pasien_kb()
    {
        $mock = Mockery::mock(FonnteService::class);
        $mock->shouldReceive('sendMessage')->once()->andReturn(['status' => 'success']);
        $this->app->instance(FonnteService::class, $mock);

        $data = $this->validData;
        $data['jenis_pasien'] = 'kb';

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertRedirect(route('daftar-pasien.index'));
        $this->assertDatabaseHas('pasien', ['jenis_pasien' => 'kb']);
    }

    /** TC-014: Gagal tambah pasien jika nomor HP duplikat */
    public function test_gagal_tambah_duplikat_no_hp()
    {
        // Buat pasien pertama dengan user auth
        $this->actingAs($this->user)
             ->post(route('daftar-pasien.store'), $this->validData);

        // Coba buat pasien kedua dengan nomor yang sama
        $data = $this->validData;
        $data['nama_pasien'] = 'Lainnya';

        $response = $this->actingAs($this->user)
                         ->post(route('daftar-pasien.store'), $data);

        $response->assertSessionHasErrors('no_telepon');
    }
}