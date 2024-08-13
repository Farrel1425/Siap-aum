<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuesionerJawaban extends Model
{
    use HasFactory;

    protected $fillable = [
        'kuesioner_id',
        'kuesioner_opsi_id',
    ];
}
