<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\Permohonan;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Collection;
use App\Enums\StatusPermohonanEnum;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\TemplateProcessor;

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
        if (!$permohonan->relationLoaded('kelengkapanPermohonan')) {
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

    public function getStepAlurPermohonan(Permohonan $permohonan, $is_include_pemohon = false): Collection
    {
        // check if permohonan load alur permohonan relation
        if (!$permohonan->relationLoaded('alurPermohonan')) {
            $permohonan->load('alurPermohonan');
        }

        // check if alur permohonan not empty, check load relation verifikator
        if ($permohonan->alurPermohonan->isNotEmpty() && !$permohonan->alurPermohonan->first()->relationLoaded('verifikator')) {
            $permohonan->alurPermohonan->load('verifikator');
        }



        $alur_verifikator =  $permohonan->alurPermohonan->map(function ($alurPermohonan) {
            return collect([
                'id' => $alurPermohonan->id,
                'nama' => $alurPermohonan->verifikator->name,
                'urutan' => $alurPermohonan->urutan,
                'is_done' => $alurPermohonan->is_done,
                'done_at' => $alurPermohonan->is_done ? $alurPermohonan->updated_at->format('d-m-Y H:i:s') : '-',
            ]);
        });

        if (!$is_include_pemohon) {
            return $alur_verifikator;
        } else {
            // add pemohon to first step
            $pemohon = collect([
                'id' => 0,
                'nama' => 'Pemohon',
                'urutan' => 0,
                'is_done' => $permohonan->pengajuan_at ? true : false,
                'done_at' => $permohonan->pengajuan_at ? $permohonan->pengajuan_at->format('d-m-Y H:i:s') : '-',
            ]);

            return $alur_verifikator->prepend($pemohon);
        }
    }

    public function isPermohonanCanVerified(Permohonan $permohonan): bool
    {
        return in_array($permohonan->status, [
            StatusPermohonanEnum::PERMOHONAN_BARU->value,
            StatusPermohonanEnum::VERIFIKASI->value,
            StatusPermohonanEnum::VERIFIKASI_ULANG->value
        ]);
    }

    public function generateIzinTerbit(Permohonan $permohonan)
    {
        $permohonan->load([
            'jenisIzin',
            'formPermohonan',
            'kelengkapanPermohonan',
        ]);
        try {
            // Convert $permohonan->jenisIzin->template_surat and assign template processing using PHPWord
            $templateProcessor = new TemplateProcessor(storage_path('app/' . $permohonan->jenisIzin->template_surat));

            $array_kode = array(
                'NAMA' => $permohonan->nama,
                'NIK' => $permohonan->nik,
                'NPWP' => $permohonan->npwp,
                'TEMPAT_LAHIR' => $permohonan->tempat_lahir,
                'NAMA_JNS_IZIN' => $permohonan->nama_jenis_izin,
                'DESKRIPSI_JNS_IZIN' => $permohonan->deskripsi_jenis_izin,
                'NO_REGISTRASI' => $permohonan->no_registrasi
            );

            foreach ($permohonan->formPermohonan as $formPermohonan) {
                $array_kode[$formPermohonan->kode_isian] = $formPermohonan->value;
            }

            foreach ($permohonan->kelengkapanPermohonan as $kelengkapanPermohonan) {
                $array_kode[$kelengkapanPermohonan->kode_isian] = $kelengkapanPermohonan->value;
            }

            foreach ($array_kode as $key => $value) {
                $templateProcessor->setValue($key, $value);
            }

            // Replace all variables in the template with values from $permohonan
            $templateProcessor->setValue('NO_SK', 123);

            // Save the Word document to a temporary file
            $filename_encrypt = Str::random(32);
            $tempWordPath = storage_path('app/temp/' . $filename_encrypt . '.docx');
            $templateProcessor->saveAs($tempWordPath);

            $pdfPath = 'public/izin_terbit/' . $filename_encrypt . '.pdf';
            $pdfPathStorage = storage_path('app/' . $pdfPath);

            // Path to LibreOffice soffice executable
            if (config('app.env') == 'local') {
                $sofficePath = '"C:\\Program Files\\LibreOffice\\program\\soffice.exe"';
            } else {
                $sofficePath = '/usr/bin/soffice';
            }

            // Convert the Word document to PDF using LibreOffice
            $command = $sofficePath . ' --headless --convert-to pdf --outdir ' . escapeshellarg(dirname($pdfPathStorage)) . ' ' . escapeshellarg($tempWordPath);

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                throw new \Exception('Error converting document to PDF: ' . implode("\n", $output));
            }

            // Clean up temporary files
            unlink($tempWordPath);

            return $pdfPath;
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error generating Izin Terbit: ' . $e->getMessage());
            throw $e;
        }
    }
}
