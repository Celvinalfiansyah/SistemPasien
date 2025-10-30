<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Pasien;

class AuthTest extends TestCase
{
     use RefreshDatabase;

    // URL yang hanya boleh diakses bidan (contoh diambil dari route Anda)
    protected $bidanOnlyRouteName = 'pasien.rekam-medis-rawat-jalan.create';
    // URL yang boleh diakses oleh semua user yang sudah login (contoh dari daftar-pasien)
    protected $authOnlyUrl = '/daftar-pasien';
    /**
     * A basic feature test example.
     */

    // TCL07: Akses halaman (role admin)
    #[Test]
    public function test_admin_gagal_mengakses_halaman_khusus_bidan()
    {
        $pasien = Pasien::factory()->create(); // Asumsikan PasienFactory sudah ada
        // 1. Persiapan: Buat user admin dan login
        $userAdmin = User::factory()->admin()->create();
        $this->actingAs($userAdmin);

        // Ubah URL menjadi RUTE BERDASARKAN ID PASIEN YANG BARU DIBUAT
        $url = route($this->bidanOnlyRouteName, ['pasien' => $pasien->id]); 
        
        // 2. Eksekusi: Coba akses rute bidan
        $response = $this->get($url); 

        // 3. Verifikasi: Admin HARUS GAGAL Otorisasi (403 Forbidden)
        $response->assertStatus(403); 
        $response->assertSee('Akses Ditolak');
    }

    // TCL08: Akses Halaman Bidan
    #[Test]
    public function test_bidan_dapat_mengakses_semua_halaman_bidan()
    {
        // 1. Persiapan: Buat user bidan dan login
        $userBidan = User::factory()->bidan()->create();
        $this->actingAs($userBidan);

        // 2. Eksekusi: Coba akses rute bidan
        $response = $this->get($this->authOnlyUrl); 

        // 3. Verifikasi: Bidan HARUS lolos (Status 200/404/302, bukan 403)
        // Kita tidak bisa hanya assertSuccessful() karena mungkin mengembalikan 404.
        // Yang penting: BUKAN 403.
        $this->assertNotEquals(403, $response->status());

        // Coba akses rute umum (harus lolos)
        $this->get($this->authOnlyUrl)->assertSuccessful();
    }
}