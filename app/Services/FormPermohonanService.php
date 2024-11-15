<?php

namespace App\Services;

use App\Models\AlurPermohonan;
use App\Models\Permohonan;

class FormPermohonanService
{
    public function isFormValidFromVerifikator(AlurPermohonan $alurPermohonan)
    {
        $alurPermohonan->relationLoaded('permohonan') || $alurPermohonan->load('permohonan');
        if ($alurPermohonan->is_done) {
            return true;
        }
    }
}
