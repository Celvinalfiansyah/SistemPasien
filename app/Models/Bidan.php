<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidan extends Model
{
    use HasFactory;

    protected $table = 'bidans';

    protected $fillable = [
        'nama',
        'no_telepon',
        'email',
    ];
}
