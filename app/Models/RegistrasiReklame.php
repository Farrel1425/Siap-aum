<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiReklame extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_registrasi',
        'nama',
        'nik',
        'npwp',
        'nama_perusahaan',
        'alamat_perusahaan',
        'nomor_telepon',
    ];
}
