<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pasien;
use App\Models\RekamMedisKb;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RekamMedisKbTest extends TestCase
{
    use RefreshDatabase;

    protected $userBidan;
    protected $userAdmin;
    protected $pasien;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create user dengan role bidan
        $this->userBidan = User::factory()->create(['role' => 'bidan']);
        
        // Create user dengan role admin
        $this->userAdmin = User::factory()->create(['role' => 'admin']);
        
        // Create pasien untuk testing
        $this->pasien = Pasien::factory()->create();
    }

    #[Test]
    public function test_menyimpan_data_rekam_medis_kb_lengkap()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_datang' => '2025-10-31',
            'hpht' => '2025-08-16',
            'berat_badan' => 55.5,
            'tensi' => '120/80',
            'komplikasi' => 'Tidak ada',
            'kegagalan' => 'Tidak ada',
            'pemeriksaan_dan_tindakan' => 'Pemasangan IUD',
            'tanggal_kembali' => '2025-11-20',
        ];

        $response = $this->post(route('pasien.rekam-medis-kb.store', $this->pasien), $data);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success', 'Rekam medis kb berhasil ditambahkan.');
        
        $this->assertDatabaseHas('rekam_medis_kb', [
            'pasien_id' => $this->pasien->id,
            'tanggal_datang' => '2025-10-31',
            'hpht' => '2025-08-16',
            'berat_badan' => 55.5,
            'tensi' => '120/80',
            'komplikasi' => 'Tidak ada',
            'kegagalan' => 'Tidak ada',
            'pemeriksaan_dan_tindakan' => 'Pemasangan IUD',
            'tanggal_kembali' => '2025-11-20',
        ]);
    }

    #[Test]
    public function test_menyimpan_data_tanpa_field_optional()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_datang' => '2025-10-31',
            // Field optional dikosongkan
            'hpht' => null,
            'berat_badan' => null,
            'tensi' => null,
            'komplikasi' => null,
            'kegagalan' => null,
            'pemeriksaan_dan_tindakan' => null,
            'tanggal_kembali' => null,
        ];

        $response = $this->post(route('pasien.rekam-medis-kb.store', $this->pasien), $data);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('rekam_medis_kb', [
            'pasien_id' => $this->pasien->id,
            'tanggal_datang' => '2025-10-31',
            'hpht' => null,
            'berat_badan' => null,
            'tensi' => null,
            'komplikasi' => null,
            'kegagalan' => null,
            'pemeriksaan_dan_tindakan' => null,
            'tanggal_kembali' => null,
        ]);
    }

    #[Test]
    public function test_validasi_field_tanggal_datang_wajib_diisi()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_datang' => '', // Kosong - seharusnya error
            'berat_badan' => 60,
            'tensi' => '130/85',
            'pemeriksaan_dan_tindakan' => 'Kontrol rutin',
        ];

        $response = $this->post(route('pasien.rekam-medis-kb.store', $this->pasien), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tanggal_datang']);
        
        $this->assertDatabaseMissing('rekam_medis_kb', [
            'pasien_id' => $this->pasien->id,
            'tensi' => '130/85'
        ]);
    }

    #[Test]
    public function test_validasi_semua_field_wajib()
    {
        $this->actingAs($this->userBidan);

        $data = []; // Semua field kosong

        $response = $this->post(route('pasien.rekam-medis-kb.store', $this->pasien), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tanggal_datang']);
    }

    #[Test]
    public function test_admin_tidak_bisa_akses_rekam_medis_kb()
    {
        $this->actingAs($this->userAdmin);

        // Test akses create form
        $responseCreate = $this->get(route('pasien.rekam-medis-kb.create', $this->pasien));
        $responseCreate->assertStatus(403);

        // Test akses store
        $data = [
            'tanggal_datang' => '2025-10-31',
            'tensi' => '120/80',
        ];
        
        $responseStore = $this->post(route('pasien.rekam-medis-kb.store', $this->pasien), $data);
        $responseStore->assertStatus(403);

        // Buat rekam medis untuk testing show
        $rekamMedis = RekamMedisKb::factory()->create(['pasien_id' => $this->pasien->id]);

        // Test akses show
        $responseShow = $this->get(route('pasien.rekam-medis-kb.show', [$this->pasien, $rekamMedis]));
        $responseShow->assertStatus(403);

        // Test akses edit
        $responseEdit = $this->get(route('pasien.rekam-medis-kb.edit', [$this->pasien, $rekamMedis]));
        $responseEdit->assertStatus(403);
    }

    #[Test]
    public function test_bidan_bisa_akses_semua_fitur_rekam_medis_kb()
    {
        $this->actingAs($this->userBidan);

        // Test akses create form
        $responseCreate = $this->get(route('pasien.rekam-medis-kb.create', $this->pasien));
        $responseCreate->assertStatus(200);

        // Buat rekam medis untuk testing show dan edit
        $rekamMedis = RekamMedisKb::factory()->create(['pasien_id' => $this->pasien->id]);

        // Test akses show
        $responseShow = $this->get(route('pasien.rekam-medis-kb.show', [$this->pasien, $rekamMedis]));
        $responseShow->assertStatus(200);

        // Test akses edit
        $responseEdit = $this->get(route('pasien.rekam-medis-kb.edit', [$this->pasien, $rekamMedis]));
        $responseEdit->assertStatus(200);
    }

    #[Test]
    public function test_validasi_format_tanggal()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_datang' => 'invalid-date',
            'hpht' => 'invalid-date',
            'tanggal_kembali' => 'invalid-date',
        ];

        $response = $this->post(route('pasien.rekam-medis-kb.store', $this->pasien), $data);

        $response->assertSessionHasErrors(['tanggal_datang', 'hpht', 'tanggal_kembali']);
    }

    #[Test]
    public function test_validasi_tipe_data_berat_badan()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_datang' => '2025-10-31',
            'berat_badan' => 'bukan-angka',
        ];

        $response = $this->post(route('pasien.rekam-medis-kb.store', $this->pasien), $data);

        $response->assertSessionHasErrors(['berat_badan']);
    }

    #[Test]
    public function test_update_rekam_medis_kb_berhasil()
    {
        $this->actingAs($this->userBidan);

        $rekamMedis = RekamMedisKb::factory()->create(['pasien_id' => $this->pasien->id]);

        $dataUpdate = [
            'tanggal_datang' => '2025-11-01',
            'berat_badan' => 65.0,
            'tensi' => '130/85',
            'pemeriksaan_dan_tindakan' => 'Kontrol ulang',
        ];

        $response = $this->put(route('pasien.rekam-medis-kb.update', [$this->pasien, $rekamMedis]), $dataUpdate);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success', 'Rekam medis KB berhasil diperbarui.');
        
        $this->assertDatabaseHas('rekam_medis_kb', [
            'id' => $rekamMedis->id,
            'berat_badan' => 65.0,
            'tensi' => '130/85',
            'pemeriksaan_dan_tindakan' => 'Kontrol ulang',
        ]);
    }

    #[Test]
    public function test_hapus_rekam_medis_kb_berhasil()
    {
        $this->actingAs($this->userBidan);

        $rekamMedis = RekamMedisKb::factory()->create(['pasien_id' => $this->pasien->id]);

        $response = $this->delete(route('pasien.rekam-medis-kb.destroy', [$this->pasien, $rekamMedis]));

        $response->assertRedirect(route('rekam-medis-kb.index'));
        $response->assertSessionHas('success', 'Rekam medis KB berhasil dihapus!');
        
        $this->assertDatabaseMissing('rekam_medis_kb', [
            'id' => $rekamMedis->id,
        ]);
    }

    #[Test]
    public function test_index_rekam_medis_kb()
    {
        $this->actingAs($this->userBidan);

        RekamMedisKb::factory()->count(3)->create();

        $response = $this->get(route('rekam-medis-kb.index'));

        $response->assertStatus(200);
        $response->assertViewHas('rekamMedis');
    }

    #[Test]
    public function test_create_rekam_medis_kb_dengan_pasien_id()
    {
        $this->actingAs($this->userBidan);

        $response = $this->get(route('pasien.rekam-medis-kb.create', $this->pasien));

        $response->assertStatus(200);
        $response->assertViewHas('pasien');
    }
}