<?php

namespace App\Models;

use App\Enums\JenisVerifikatorEnum;
use App\Models\Permohonan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlurPermohonan extends Model
{
    use HasFactory;

    protected $fillable = [
        'permohonan_id',
        'verifikator_id',
        'jenis_verifikator',
        'urutan',
        'is_done',
    ];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class);
    }

    public function getJenisVerifikatorNameAttribute()
    {
        return JenisVerifikatorEnum::from($this->jenis_verifikator)->deskripsi();
    }
}
