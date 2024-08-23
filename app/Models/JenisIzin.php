<?php

namespace App\Models;

use App\Models\AlurJenisIzin;
use App\Models\FormJenisIzin;
use App\Models\BerkasJenisIzin;
use App\Models\KelengkapanJenisIzin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisIzin extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'template_surat',
    ];

    public function alurJenisIzin()
    {
        return $this->hasMany(AlurJenisIzin::class);
    }

    public function formJenisIzin()
    {
        return $this->hasMany(FormJenisIzin::class);
    }

    public function berkasJenisIzin()
    {
        return $this->hasMany(BerkasJenisIzin::class);
    }

    public function kelengkapanJenisIzin()
    {
        return $this->hasMany(KelengkapanJenisIzin::class);
    }
}
