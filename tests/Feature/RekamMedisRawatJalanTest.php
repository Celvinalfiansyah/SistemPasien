<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Pasien;
use App\Models\RekamMedisRawatJalan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RekamMedisRawatJalanTest extends TestCase
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
    public function test_menyimpan_data_rekam_medis_rawat_jalan_lengkap()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'ttv' => 'TD: 120/80, N: 80x/menit, S: 36.5°C',
            'anamnesa' => 'Keluhan sakit kepala dan demam sejak 2 hari yang lalu',
            'tindakan' => 'Pemberian paracetamol 500mg',
        ];

        $response = $this->post(route('pasien.rekam-medis-rawat-jalan.store', $this->pasien), $data);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success', 'Rekam medis rawat jalan berhasil ditambahkan.');
        
        $this->assertDatabaseHas('rekam_medis_rawat_jalan', [
            'pasien_id' => $this->pasien->id,
            'tanggal_pemeriksaan' => '2025-10-31',
            'ttv' => 'TD: 120/80, N: 80x/menit, S: 36.5°C',
            'anamnesa' => 'Keluhan sakit kepala dan demam sejak 2 hari yang lalu',
            'tindakan' => 'Pemberian paracetamol 500mg',
        ]);
    }

    #[Test]
    public function test_menyimpan_data_tanpa_field_optional()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'anamnesa' => 'Keluhan sakit kepala',
            // Field optional dikosongkan
            'ttv' => null,
            'tindakan' => null,
        ];

        $response = $this->post(route('pasien.rekam-medis-rawat-jalan.store', $this->pasien), $data);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('rekam_medis_rawat_jalan', [
            'pasien_id' => $this->pasien->id,
            'tanggal_pemeriksaan' => '2025-10-31',
            'anamnesa' => 'Keluhan sakit kepala',
            'ttv' => null,
            'tindakan' => null,
        ]);
    }

    #[Test]
    public function test_validasi_field_tanggal_pemeriksaan_wajib_diisi()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '', // Kosong - seharusnya error
            'anamnesa' => 'Keluhan sakit kepala',
            'ttv' => 'TD: 120/80',
        ];

        $response = $this->post(route('pasien.rekam-medis-rawat-jalan.store', $this->pasien), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tanggal_pemeriksaan']);
        
        $this->assertDatabaseMissing('rekam_medis_rawat_jalan', [
            'pasien_id' => $this->pasien->id,
            'anamnesa' => 'Keluhan sakit kepala'
        ]);
    }

    #[Test]
    public function test_validasi_field_anamnesa_wajib_diisi()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'anamnesa' => '', // Kosong - seharusnya error
            'ttv' => 'TD: 120/80',
        ];

        $response = $this->post(route('pasien.rekam-medis-rawat-jalan.store', $this->pasien), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['anamnesa']);
    }

    #[Test]
    public function test_validasi_semua_field_wajib()
    {
        $this->actingAs($this->userBidan);

        $data = []; // Semua field kosong

        $response = $this->post(route('pasien.rekam-medis-rawat-jalan.store', $this->pasien), $data);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['tanggal_pemeriksaan', 'anamnesa']);
    }

    #[Test]
    public function test_admin_tidak_bisa_akses_rekam_medis_rawat_jalan()
    {
        $this->actingAs($this->userAdmin);

        // Test akses create form
        $responseCreate = $this->get(route('pasien.rekam-medis-rawat-jalan.create', $this->pasien));
        $responseCreate->assertStatus(403);

        // Test akses store
        $data = [
            'tanggal_pemeriksaan' => '2025-10-31',
            'anamnesa' => 'Keluhan sakit kepala',
        ];
        
        $responseStore = $this->post(route('pasien.rekam-medis-rawat-jalan.store', $this->pasien), $data);
        $responseStore->assertStatus(403);

        // Buat rekam medis untuk testing show
        $rekamMedis = RekamMedisRawatJalan::factory()->create(['pasien_id' => $this->pasien->id]);

        // Test akses show
        $responseShow = $this->get(route('pasien.rekam-medis-rawat-jalan.show', [$this->pasien, $rekamMedis]));
        $responseShow->assertStatus(403);

        // Test akses edit
        $responseEdit = $this->get(route('pasien.rekam-medis-rawat-jalan.edit', [$this->pasien, $rekamMedis]));
        $responseEdit->assertStatus(403);
    }

    #[Test]
    public function test_bidan_bisa_akses_semua_fitur_rekam_medis_rawat_jalan()
    {
        $this->actingAs($this->userBidan);

        // Test akses create form
        $responseCreate = $this->get(route('pasien.rekam-medis-rawat-jalan.create', $this->pasien));
        $responseCreate->assertStatus(200);

        // Buat rekam medis untuk testing show dan edit
        $rekamMedis = RekamMedisRawatJalan::factory()->create(['pasien_id' => $this->pasien->id]);

        // Test akses show
        $responseShow = $this->get(route('pasien.rekam-medis-rawat-jalan.show', [$this->pasien, $rekamMedis]));
        $responseShow->assertStatus(200);

        // Test akses edit
        $responseEdit = $this->get(route('pasien.rekam-medis-rawat-jalan.edit', [$this->pasien, $rekamMedis]));
        $responseEdit->assertStatus(200);
    }

    #[Test]
    public function test_validasi_format_tanggal()
    {
        $this->actingAs($this->userBidan);

        $data = [
            'tanggal_pemeriksaan' => 'invalid-date',
            'anamnesa' => 'Keluhan sakit kepala',
        ];

        $response = $this->post(route('pasien.rekam-medis-rawat-jalan.store', $this->pasien), $data);

        $response->assertSessionHasErrors(['tanggal_pemeriksaan']);
    }

    #[Test]
    public function test_update_rekam_medis_rawat_jalan_berhasil()
    {
        $this->actingAs($this->userBidan);

        $rekamMedis = RekamMedisRawatJalan::factory()->create(['pasien_id' => $this->pasien->id]);

        $dataUpdate = [
            'tanggal_pemeriksaan' => '2025-11-01',
            'ttv' => 'TD: 130/85, N: 75x/menit, S: 36.8°C',
            'anamnesa' => 'Keluhan sudah membaik',
            'tindakan' => 'Kontrol ulang 1 minggu',
        ];

        $response = $this->put(route('pasien.rekam-medis-rawat-jalan.update', [$this->pasien, $rekamMedis]), $dataUpdate);

        $response->assertRedirect(route('daftar-pasien.show', $this->pasien));
        $response->assertSessionHas('success', 'Rekam medis rawat jalan berhasil diperbarui.');
        
        $this->assertDatabaseHas('rekam_medis_rawat_jalan', [
            'id' => $rekamMedis->id,
            'ttv' => 'TD: 130/85, N: 75x/menit, S: 36.8°C',
            'anamnesa' => 'Keluhan sudah membaik',
            'tindakan' => 'Kontrol ulang 1 minggu',
        ]);
    }

    #[Test]
    public function test_hapus_rekam_medis_rawat_jalan_berhasil()
    {
        $this->actingAs($this->userBidan);

        $rekamMedis = RekamMedisRawatJalan::factory()->create(['pasien_id' => $this->pasien->id]);

        $response = $this->delete(route('pasien.rekam-medis-rawat-jalan.destroy', [$this->pasien, $rekamMedis]));

        $response->assertRedirect(route('rekam-medis-rawat-jalan.index'));
        $response->assertSessionHas('success', 'Rekam medis rawat jalan berhasil dihapus!');
        
        $this->assertDatabaseMissing('rekam_medis_rawat_jalan', [
            'id' => $rekamMedis->id,
        ]);
    }

    #[Test]
    public function test_index_rekam_medis_rawat_jalan()
    {
        $this->actingAs($this->userBidan);

        // Create beberapa rekam medis
        RekamMedisRawatJalan::factory()->count(3)->create();

        $response = $this->get(route('rekam-medis-rawat-jalan.index'));

        $response->assertStatus(200);
        $response->assertViewHas('rekamMedis');
    }

    #[Test]
    public function test_create_rekam_medis_rawat_jalan_dengan_pasien_id()
    {
        $this->actingAs($this->userBidan);

        $response = $this->get(route('pasien.rekam-medis-rawat-jalan.create', $this->pasien));

        $response->assertStatus(200);
        $response->assertViewHas('pasien');
    }
}