<?php

namespace App\Models;

use App\Models\FormReklame;
use App\Models\RegistrasiReklame;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reklame extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'registrasi_reklame_id',
        'image_filepath',
        'is_from_sireko',
    ];

    public function registrasiReklame()
    {
        return $this->belongsTo(RegistrasiReklame::class);
    }

    public function formReklame()
    {
        return $this->hasMany(FormReklame::class);
    }
}
