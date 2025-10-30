<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    protected $loginUrl = '/login';
    private $passwordDefault = 'password';
    

    // TCL-01: LOGIN BIDAN SUKSES
    #[Test]
    public function test_login_bidan_berhasil_dan_redirect_ke_dashboard()
    {
        // Persiapan: Buat user bidan menggunakan factory()->bidan()
        $userBidan = User::factory()->bidan()->create([
            'email' => 'bidan@klinik.com',
            'password' => bcrypt($this->passwordDefault),
        ]);

        // Eksekusi: Login
        $response = $this->post($this->loginUrl, [
            'email' => $userBidan->email,
            'password' => $this->passwordDefault,
        ]);

        // Verifikasi
        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($userBidan);
        $this->assertEquals('bidan', $userBidan->role); 
    }


    // TCL02: LOGIN ADMIN SUKSES
    public function test_login_admin_berhasil_dan_redirect_ke_dashboard()
    {
        // Persiapan: Buat user admin menggunakan factory()->admin()
        $userAdmin = User::factory()->admin()->create([
            'email' => 'admin@klinik.com',
            'password' => bcrypt($this->passwordDefault),
        ]);

        // Eksekusi: Login
        $response = $this->post($this->loginUrl, [
            'email' => $userAdmin->email,
            'password' => $this->passwordDefault,
        ]);

        // Verifikasi
        $response->assertStatus(302);
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($userAdmin);
        $this->assertEquals('admin', $userAdmin->role);
    }


    // TCL03 dan TCL04: LOGIN GAGAL (Password atau Email Salah)
    #[Test]
    public function test_login_gagal_dengan_kredensial_yang_salah()
    {
        // Persiapan: Buat user yang benar untuk dicoba login
        User::factory()->admin()->create([
            'email' => 'admin_test@klinik.com',
            'password' => bcrypt($this->passwordDefault),
        ]);

        // EKSEKUSI 1: Password salah (TCL-03)
        $responsePasswordSalah = $this->post($this->loginUrl, [
            'email' => 'admin_test@klinik.com',
            'password' => 'passwordsalah', 
        ]);
        
        // EKSEKUSI 2: Email salah (TCL-04)
        $responseEmailSalah = $this->post($this->loginUrl, [
            'email' => 'email_tidak_terdaftar@klinik.com',
            'password' => $this->passwordDefault, 
        ]);

        // Verifikasi keduanya harus gagal dengan pesan error spesifik
        $expectedErrorMessage = 'Email atau password salah.';
        
        // Verifikasi Password Salah
        $responsePasswordSalah->assertStatus(302);
        $responsePasswordSalah->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            $expectedErrorMessage,
            $responsePasswordSalah->getSession()->get('errors')->first('email')
        );
        $this->assertGuest();
        
        // Verifikasi Email Salah
        $responseEmailSalah->assertStatus(302);
        $responseEmailSalah->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            $expectedErrorMessage,
            $responseEmailSalah->getSession()->get('errors')->first('email')
        );
        $this->assertGuest();
    }

    // TCL05: Input Kosong
    #[Test]
    public function test_pengguna_gagal_login_jika_mengirim_data_kosong()
    {
        // 1. Eksekusi: Kirim permintaan tanpa data email dan password
        $response = $this->post($this->loginUrl, [
            'email' => '', // Validasi: required
            'password' => '', // Validasi: required
        ]);

        // 2. Verifikasi: Cek hasilnya
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['email', 'password']); // Memastikan error pada kedua field
        $this->assertGuest();
    }

    // TCL06: Logout Sukses
    #[Test]
    public function test_pengguna_dapat_logout_dan_dialihkan_ke_halaman_login()
    {
// Persiapan: Login sebagai user (role apapun)
        $user = User::factory()->admin()->create();
        $this->actingAs($user); 

        // Eksekusi: Logout
        $response = $this->post('/logout'); 

        // Verifikasi
        $response->assertStatus(302); 
        $response->assertRedirect('/login'); 
        $this->assertGuest();
    }
}
