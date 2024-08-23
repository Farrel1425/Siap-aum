<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuesionerOpsi extends Model
{
    use HasFactory;

    protected $fillable = [
        'kuesioner_pertanyaan_id',
        'opsi',
        'point',
    ];
}
