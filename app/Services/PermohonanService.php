<?php

namespace App\Services;

use App\Models\Permohonan;
use Illuminate\Support\Collection;

class PermohonanService
{
    public function getListFormPermohonan(Permohonan $permohonan): Collection
    {
        // check if permohonan load form permohonan relation
        if (!$permohonan->relationLoaded('formPermohonan')) {
            $permohonan->load('formPermohonan');
        }

        return $permohonan->formPermohonan->map(function ($formPermohonan) {
            return collect([
                'id' => $formPermohonan->id,
                'label' => $formPermohonan->label,
                'tipe' => $formPermohonan->tipe,
                'kode_isian' => $formPermohonan->kode_isian,
                'value' => $formPermohonan->value,
            ]);
        });
    }

    public function getListBerkasPermohonan(Permohonan $permohonan): Collection
    {
        // check if permohonan load berkas permohonan relation
        if (!$permohonan->relationLoaded('berkasPermohonan')) {
            $permohonan->load('berkasPermohonan');
        }

        return $permohonan->berkasPermohonan->map(function ($berkasPermohonan) {
            return collect([
                'id' => $berkasPermohonan->id,
                'nama' => $berkasPermohonan->nama,
                'is_required' => $berkasPermohonan->is_required,
                'urutan' => $berkasPermohonan->urutan,
                'filepath' => $berkasPermohonan->filepath,
                'is_valid' => $berkasPermohonan->is_valid,
            ]);
        });
    }

    public function getListKelengkapanPermohonan(Permohonan $permohonan): Collection
    {
        if(!$permohonan->relationLoaded('kelengkapanPermohonan')) {
            $permohonan->load('kelengkapanPermohonan');
        }

        return $permohonan->kelengkapanPermohonan->map(function ($kelengkapanPermohonan) {
            return collect([
                'id' => $kelengkapanPermohonan->id,
                'label' => $kelengkapanPermohonan->label,
                'tipe' => $kelengkapanPermohonan->tipe,
                'kode_isian' => $kelengkapanPermohonan->kode_isian,
                'value' => $kelengkapanPermohonan->value,
            ]);
        });
    }

    public function getStepAlurPermohonan(Permohonan $permohonan): Collection
    {
        // check if permohonan load alur permohonan relation
        if (!$permohonan->relationLoaded('alurPermohonan')) {
            $permohonan->load('alurPermohonan');
        }

        // check if alur permohonan not empty, check load relation verifikator
        if ($permohonan->alurPermohonan->isNotEmpty() && !$permohonan->alurPermohonan->first()->relationLoaded('verifikator')) {
            $permohonan->alurPermohonan->load('verifikator');
        }


        return $permohonan->alurPermohonan->map(function ($alurPermohonan) {
            return collect([
                'id' => $alurPermohonan->id,
                'nama' => $alurPermohonan->verifikator->name,
                'urutan' => $alurPermohonan->urutan,
                'is_done' => $alurPermohonan->is_done,
                'done_at' => $alurPermohonan->is_done ? $alurPermohonan->updated_at->format('d-m-Y H:i:s') : null,
            ]);
        });
    }
}
