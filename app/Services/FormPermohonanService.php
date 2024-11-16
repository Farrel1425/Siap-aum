<?php

namespace App\Services;

use App\Enums\StatusValidasiEnum;
use App\Models\AlurPermohonan;
use App\Models\Permohonan;
use App\Models\ValidasiForm;

class FormPermohonanService
{
    public function isFormValidFromVerifikator(AlurPermohonan $alurPermohonan)
    {
        $alurPermohonan->relationLoaded('permohonan') || $alurPermohonan->load('permohonan');
        if ($alurPermohonan->is_done) {
            return true;
        }

        if (!$alurPermohonan->validasiForm()->exists()) {
            return false;
        }

        return $alurPermohonan->validasiForm->first()->status == StatusValidasiEnum::VALID->value;
    }

    public function isFormNeedValidationFromVerifikator(AlurPermohonan $alurPermohonan)
    {
        $alurPermohonan->relationLoaded('permohonan') || $alurPermohonan->load('permohonan');
        if ($alurPermohonan->is_done) {
            return false;
        }

        return !$alurPermohonan->validasiForm()->exists();
    }

    public function getLastValidationFormByVerifikator(AlurPermohonan $alurPermohonan): ?ValidasiForm
    {
        $alurPermohonan->relationLoaded('permohonan') || $alurPermohonan->load('permohonan');

        if (!$alurPermohonan->validasiForm()->exists()) {
            return null;
        }

        return $alurPermohonan->validasiForm->first();
    }

    public function getLastValidationFormByPermohonan(Permohonan $permohonan): ?ValidasiForm
    {
        $permohonan->relationLoaded('alurPermohonan') || $permohonan->load('alurPermohonan');
        if ($permohonan->alurPermohonan->isNotEmpty() && !$permohonan->alurPermohonan->first()->relationLoaded('validasiForm')) {
            $permohonan->alurPermohonan->first()->load('validasiForm');
        }

        if ($permohonan->alurPermohonan->isEmpty()) {
            return null;
        }

        return $permohonan->alurPermohonan->first()->validasiForm->sortByDesc('created_at')->first();
    }

    public function isFormValidatedByVerifikator(AlurPermohonan $alurPermohonan)
    {
        $alurPermohonan->relationLoaded('permohonan') || $alurPermohonan->load('permohonan');

        return $alurPermohonan->validasiForm()->exists();
    }

    public function revisiFormByVerifikator(AlurPermohonan $alurPermohonan, $catatan): Permohonan
    {
        $alurPermohonan->relationLoaded('permohonan') || $alurPermohonan->load('permohonan');

        $alurPermohonan->validasiForm()->delete();
        $alurPermohonan->validasiForm()->create([
            'status' => StatusValidasiEnum::REVISI->value,
            'catatan' => $catatan
        ]);

        return $alurPermohonan->permohonan;
    }

    public function validFormByVerifikator(AlurPermohonan $alurPermohonan): Permohonan
    {
        $alurPermohonan->relationLoaded('permohonan') || $alurPermohonan->load('permohonan');

        $alurPermohonan->validasiForm()->delete();
        $alurPermohonan->validasiForm()->create([
            'status' => StatusValidasiEnum::VALID->value,
            'catatan' => null
        ]);

        return $alurPermohonan->permohonan;
    }

    public function isFormOnRevisi(Permohonan $permohonan)
    {
        $permohonan->relationLoaded('alurPermohonan') || $permohonan->load('alurPermohonan');
        if ($permohonan->alurPermohonan->isNotEmpty() && !$permohonan->alurPermohonan->first()->relationLoaded('validasiForm')) {
            $permohonan->alurPermohonan->first()->load('validasiForm');
        }

        // check every alurPermohonan on validasi form is revisi exist
        return $permohonan->alurPermohonan->filter(function ($alurPermohonan) {
            return $alurPermohonan->validasiForm->where('status', StatusValidasiEnum::REVISI->value)->isNotEmpty();
        })->isNotEmpty();
    }
}
