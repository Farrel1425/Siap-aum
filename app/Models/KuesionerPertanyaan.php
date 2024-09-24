<?php

namespace App\Models;

use App\Models\KuesionerOpsi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KuesionerPertanyaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pertanyaan',
    ];

    public function kuesionerOpsi()
    {
        return $this->hasMany(KuesionerOpsi::class);
    }
}
