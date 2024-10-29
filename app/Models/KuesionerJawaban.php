<?php

namespace App\Models;

use App\Models\Kuesioner;
use App\Models\KuesionerOpsi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KuesionerJawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'kuesioner_id',
        'kuesioner_opsi_id',
    ];

    public function kuesioner()
    {
        return $this->belongsTo(Kuesioner::class);
    }

    public function kuesionerOpsi()
    {
        return $this->belongsTo(KuesionerOpsi::class);
    }
}
