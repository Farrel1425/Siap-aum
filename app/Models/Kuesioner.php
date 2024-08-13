<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kuesioner extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'jenis_kelamin',
        'pendidikan',
        'pekerjaan',
        'jenis_layanan',
    ];
}
