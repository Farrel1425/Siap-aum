<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permohonan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'jenis_izin_id',
        'nama_jenis_izin',
        'deskripsi_jenis_izin',
        'nomor_registrasi',
        'surat_kuasa_filepath',
        'nama',
        'nik',
        'npwp',
        'tempat_lahir',
        'surat_permohonan_rekomendasi_filepath',
        'surat_rekomendasi_filepath',
        'template_surat_filepath',
        'status',
        'is_expired',
    ];
}
