<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPesan extends Model
{
    use HasFactory;

    protected $table = 'logs_pesan';

    protected $fillable = [
        'pasien_id',
        'tipe_pesan',
        'isi_pesan',
        'status',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }
}
