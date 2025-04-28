<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DaftarPasien extends Model
{
    use HasFactory;
    protected $table='daftar_pasien';
    protected $fillable=[
        'nama_pasien',
        'alamat',
        'tanggal_lahir',
        'no_hp',
        'jenis_kelamin',
        'tanggal_daftar',
    ];
}
