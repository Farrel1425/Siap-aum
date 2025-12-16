<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PermohonanReklameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'permohonan_id' => $this->permohonan_id,
            'nomor_registrasi' => $this->registrasiReklame->nomor_registrasi,
            'jenis_reklame' => $this->permohonan?->formPermohonan?->where('kode_isian', 'JENIS_REKLAME')->first()?->value,
            'tanggal_akhir_izin' => $this->permohonan?->formPermohonan?->where('kode_isian', 'TGL_AKHIR')->first()?->value ? Carbon::parse($this->permohonan?->formPermohonan?->where('kode_isian', 'TGL_AKHIR')->first()?->value)->format('Y-m-d') : null,
            'tempat_pemasangan' => $this->permohonan?->formPermohonan?->where('kode_isian', 'LOKASI')->first()?->value,
            'nama_wajib_pajak' => $this->permohonan?->formPermohonan?->where('kode_isian', 'NAMA_PERUSAHAAN')->first()?->value,
            'is_bongkar' => $this->is_bongkar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
