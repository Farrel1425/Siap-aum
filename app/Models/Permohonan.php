<?php

namespace App\Models;

use App\Models\User;
use App\Models\JenisIzin;
use App\Models\AlurPermohonan;
use App\Enums\StatusPermohonanEnum;
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
        'is_legacy_data',
        'pengajuan_at',
    ];

    public function jenisIzin()
    {
        return $this->belongsTo(JenisIzin::class);
    }

    public function alurPermohonan()
    {
        return $this->hasMany(AlurPermohonan::class)->orderBy('urutan');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case StatusPermohonanEnum::PENDING->value:
                return '<span class="badge bg-warning">Pending</span>';
            case StatusPermohonanEnum::PERMOHONAN_BARU->value:
                return '<span class="badge bg-primary">Permohonan Baru</span>';
            case StatusPermohonanEnum::SELESAI->value:
                return '<span class="badge bg-success">Selesai</span>';
            case StatusPermohonanEnum::REVISI->value:
                return '<span class="badge bg-danger">Revisi</span>';
            case StatusPermohonanEnum::VERIFIKASI_ULANG->value:
                return '<span class="badge bg-info">Verifikasi Ulang</span>';
            case StatusPermohonanEnum::EXPIRED->value:
                return '<span class="badge bg-secondary">Expired</span>';
            case StatusPermohonanEnum::VERIFIKASI->value:
                return '<span class="badge bg-info">Verifikasi</span>';
            default:
                return '<span class="badge bg-secondary">Undefined</span>';
        }
    }
}
