<?php

namespace App\Models;

use App\Models\KuesionerJawaban;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function kuesionerJawaban()
    {
        return $this->hasMany(KuesionerJawaban::class);
    }
}
