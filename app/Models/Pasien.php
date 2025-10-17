<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'tanggal_daftar',
        'jenis_pasien',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'datetime',
    ];

    public function rekamMedis() 
    {
        return $this->hasMany(RekamMedis::class);
    }
    
    public function rekamMedisRawatJalan()
    {
        return $this->hasMany(RekamMedisRawatJalan::class);
    }
    
    public function rekamMedisBayiAnak()
    {
        return $this->hasMany(RekamMedisBayiAnak::class);
    }
    
    public function rekamMedisKb()
    {
        return $this->hasMany(RekamMedisKb::class);
    }
}
