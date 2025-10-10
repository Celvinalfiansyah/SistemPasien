<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';
<<<<<<< HEAD
<<<<<<< HEAD

=======
    
>>>>>>> 29dc27401831505d064869d585036dd4f7005191
=======

>>>>>>> 79b4b19c5a7c91e4699dc0a34cfcca96b8bb1cda
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
}
