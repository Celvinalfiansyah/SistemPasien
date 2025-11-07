<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pasien;
use App\Models\RekamMedisBayiAnak;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RekamMedisBayiAnakTest extends TestCase
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
        $this->pasien = Pasien::factory()->create([
            'tanggal_lahir' => '2020-01-01' // Tambahkan tanggal lahir untuk testing umur
        ]);
    }

    #[Test]
    public function test_menyimpan_data_rekam_medis_bayi_anak_lengkap()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'berat_badan' => 12.5,
            'keluhan' => 'Demam dan batuk ringan',
            'tindakan' => 'Diberi obat penurun panas',
        ];

        $response = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success', 'Rekam medis bayi & anak berhasil ditambahkan.');
        
        $this->assertDatabaseHas('rekam_medis_bayi_anak', [
            'pasien_id' => $this->pasien->id,
            'tanggal_pemeriksaan' => '2025-10-31',
            'berat_badan' => 12.5,
            'keluhan' => 'Demam dan batuk ringan',
            'tindakan' => 'Diberi obat penurun panas',
        ]);
    }

    #[Test]
    public function test_menyimpan_data_tanpa_field_optional()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'berat_badan' => 12.5,
            // Field optional dikosongkan
            'keluhan' => null,
            'tindakan' => null,
        ];

        $response = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('rekam_medis_bayi_anak', [
            'pasien_id' => $this->pasien->id,
            'tanggal_pemeriksaan' => '2025-10-31',
            'berat_badan' => 12.5,
            'keluhan' => null,
            'tindakan' => null,
        ]);
    }

    #[Test]
    public function test_validasi_field_tanggal_pemeriksaan_wajib_diisi()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '', // Kosong - seharusnya error
            'berat_badan' => 12.5,
            'keluhan' => 'Demam',
        ];

        $response = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tanggal_pemeriksaan']);
        
        $this->assertDatabaseMissing('rekam_medis_bayi_anak', [
            'pasien_id' => $this->pasien->id,
            'keluhan' => 'Demam'
        ]);
    }

    #[Test]
    public function test_validasi_field_berat_badan_wajib_diisi()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'berat_badan' => '', // Kosong - seharusnya error
            'keluhan' => 'Demam',
        ];

        $response = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['berat_badan']);
    }

    #[Test]
    public function test_validasi_semua_field_wajib()
    {
        $this->actingAs($this->userBidan);

        $data = []; // Semua field kosong

        $response = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tanggal_pemeriksaan', 'berat_badan']);
    }

    #[Test]
    public function test_admin_tidak_bisa_akses_rekam_medis_bayi_anak()
    {
        $this->actingAs($this->userAdmin);

        // Test akses create form
        $responseCreate = $this->get(route('pasien.rekam-medis-bayi-anak.create', $this->pasien));
        $responseCreate->assertStatus(403);

        // Test akses store
        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'berat_badan' => 12.5,
        ];
        
        $responseStore = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);
        $responseStore->assertStatus(403);

        // Buat rekam medis untuk testing show
        $rekamMedis = RekamMedisBayiAnak::factory()->create(['pasien_id' => $this->pasien->id]);

        // Test akses show
        $responseShow = $this->get(route('pasien.rekam-medis-bayi-anak.show', [$this->pasien, $rekamMedis]));
        $responseShow->assertStatus(403);

        // Test akses edit
        $responseEdit = $this->get(route('pasien.rekam-medis-bayi-anak.edit', [$this->pasien, $rekamMedis]));
        $responseEdit->assertStatus(403);

        // Test akses update
        $dataUpdate = [
            'tanggal_pemeriksaan' => '2025-11-01',
            'berat_badan' => 13.0,
        ];
        $responseUpdate = $this->put(route('pasien.rekam-medis-bayi-anak.update', [$this->pasien, $rekamMedis]), $dataUpdate);
        $responseUpdate->assertStatus(403);

        // Test akses destroy
        $responseDestroy = $this->delete(route('pasien.rekam-medis-bayi-anak.destroy', [$this->pasien, $rekamMedis]));
        $responseDestroy->assertStatus(403);
    }

    #[Test]
    public function test_bidan_bisa_akses_semua_fitur_rekam_medis_bayi_anak()
    {
        $this->actingAs($this->userBidan);

        // Test akses create form
        $responseCreate = $this->get(route('pasien.rekam-medis-bayi-anak.create', $this->pasien));
        $responseCreate->assertStatus(200);

        // Buat rekam medis untuk testing show dan edit
        $rekamMedis = RekamMedisBayiAnak::factory()->create(['pasien_id' => $this->pasien->id]);

        // Test akses show
        $responseShow = $this->get(route('pasien.rekam-medis-bayi-anak.show', [$this->pasien, $rekamMedis]));
        $responseShow->assertStatus(200);

        // Test akses edit
        $responseEdit = $this->get(route('pasien.rekam-medis-bayi-anak.edit', [$this->pasien, $rekamMedis]));
        $responseEdit->assertStatus(200);
    }

    #[Test]
    public function test_validasi_format_tanggal()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => 'invalid-date', // Format tanggal tidak valid
            'berat_badan' => 12.5,
        ];

        $response = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);

        $response->assertSessionHasErrors(['tanggal_pemeriksaan']);
    }

    #[Test]
    public function test_validasi_tipe_data_berat_badan()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'berat_badan' => 'bukan-angka', // Bukan numerik
        ];

        $response = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);

        $response->assertSessionHasErrors(['berat_badan']);
    }

    #[Test]
    public function test_validasi_berat_badan_tidak_boleh_negatif()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'berat_badan' => -5, // Tidak boleh negatif
        ];

        $response = $this->post(route('pasien.rekam-medis-bayi-anak.store', $this->pasien), $data);

        $response->assertSessionHasErrors(['berat_badan']);
    }

    #[Test]
    public function test_update_rekam_medis_bayi_anak_berhasil()
    {
        $this->actingAs($this->userBidan);

        $rekamMedis = RekamMedisBayiAnak::factory()->create(['pasien_id' => $this->pasien->id]);

        $dataUpdate = [
            'tanggal_pemeriksaan' => '2025-11-01',
            'umur' => 24, // Diperlukan untuk update
            'berat_badan' => 13.0,
            'keluhan' => 'Batuk sudah membaik',
            'tindakan' => 'Kontrol rutin',
        ];

        $response = $this->put(route('pasien.rekam-medis-bayi-anak.update', [$this->pasien, $rekamMedis]), $dataUpdate);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success', 'Rekam medis bayi & anak berhasil diperbarui.');
        
        $this->assertDatabaseHas('rekam_medis_bayi_anak', [
            'id' => $rekamMedis->id,
            'berat_badan' => 13.0,
            'keluhan' => 'Batuk sudah membaik',
            'tindakan' => 'Kontrol rutin',
        ]);
    }

    #[Test]
    public function test_hapus_rekam_medis_bayi_anak_berhasil()
    {
        $this->actingAs($this->userBidan);

        $rekamMedis = RekamMedisBayiAnak::factory()->create(['pasien_id' => $this->pasien->id]);

        $response = $this->delete(route('pasien.rekam-medis-bayi-anak.destroy', [$this->pasien, $rekamMedis]));

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success', 'Rekam medis bayi & anak berhasil dihapus.');
        
        $this->assertDatabaseMissing('rekam_medis_bayi_anak', [
            'id' => $rekamMedis->id,
        ]);
    }

    #[Test]
    public function test_index_rekam_medis_bayi_anak()
    {
        $this->actingAs($this->userBidan);

        // Create beberapa rekam medis
        RekamMedisBayiAnak::factory()->count(3)->create();

        $response = $this->get(route('pasien.rekam-medis-bayi-anak.index', $this->pasien));

        $response->assertStatus(200);
        $response->assertViewHas('rekamMedis');
    }

    #[Test]
    public function test_create_rekam_medis_bayi_anak_dengan_pasien_id()
    {
        $this->actingAs($this->userBidan);

        $response = $this->get(route('pasien.rekam-medis-bayi-anak.create', $this->pasien));

        $response->assertStatus(200);
        $response->assertViewHas('pasien');
    }

    #[Test]
    public function test_show_rekam_medis_bayi_anak()
    {
        $this->actingAs($this->userBidan);

        $rekamMedis = RekamMedisBayiAnak::factory()->create(['pasien_id' => $this->pasien->id]);

        $response = $this->get(route('pasien.rekam-medis-bayi-anak.show', [$this->pasien, $rekamMedis]));

        $response->assertStatus(200);
        $response->assertViewHas(['pasien', 'rekam_medis_bayi_anak', 'umurText']);
    }
}