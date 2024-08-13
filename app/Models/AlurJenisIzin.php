<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlurJenisIzin extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis_izin_id',
        'verifikator_id',
        'jenis_verifikator',
        'urutan',
    ];
}
