<?php

namespace App\Exports\Laporan;

use Illuminate\Support\Carbon;
use App\Enums\StatusPermohonanEnum;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class RekapPermohonanExport implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings, WithStyles, WithEvents
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    public function registerEvents(): array
    {
        return [
            // Handle by a closure.
            BeforeSheet::class => function (BeforeSheet $event) {
                $event->sheet
                    ->getPageSetup()->setPaperSize(9)
                    ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);
            },
        ];
    }

    public function headings(): array
    {
        return $this->getHeader();
    }

    public function styles($sheet)
    {
        $numColumns = count($this->getHeader());
        $lastColumnLetter = Coordinate::stringFromColumnIndex($numColumns);
        $cellRange = 'A1:' . $lastColumnLetter . $sheet->getHighestRow();
        $sheet->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function map($permohonan): array
    {
        return [
            $permohonan->user->name,
            $permohonan->jenisIzin->nama,
            $permohonan->nomor_registrasi,
            Carbon::parse($permohonan->pengajuan_at)->isoFormat('D MMMM Y'),
            $permohonan->user->email,
            $permohonan->memohon_untuk,
            $permohonan->user->telepon,
            $permohonan->user->nik,
            $permohonan->formPermohonan->where('kode_isian', 'NO_STR')->first()?->value,
            $permohonan->formPermohonan->where('kode_isian', 'ALAMAT')->first()?->value,
            $permohonan->formPermohonan->where('kode_isian', 'PRAKTIK_KE')->first()?->value,
            $permohonan->formPermohonan->where('kode_isian', 'LOKASI')->first()?->value,
            $permohonan->kelengkapanPermohonan->where('kode_isian', 'NO_SK')->first()?->value,
            $permohonan->kelengkapanPermohonan->where('kode_isian', 'TGL_SK')?->value ? Carbon::parse($permohonan->kelengkapanPermohonan->where('kode_isian', 'TGL_SK')?->value)->isoFormat('D MMMM Y') : null,
            $permohonan->kelengkapanPermohonan->where('kode_isian', 'TGL_BERLAKU_SK')?->value ? Carbon::parse($permohonan->kelengkapanPermohonan->where('kode_isian', 'TGL_BERLAKU_SK')?->value)->isoFormat('D MMMM Y') : null,
            $permohonan->kelengkapanPermohonan->where('kode_isian', 'NO_REKOMENDASI')->first()?->value,
            StatusPermohonanEnum::tryFrom($permohonan->status)->deskripsi()
        ];
    }

    private function getHeader()
    {
        return [
            "Nama Pemohon",
            "Jenis Izin",
            "Nomor Registrasi",
            "Tanggal Pengajuan",
            "Email Pemohon",
            "Memohon Untuk",
            "No Telepon",
            "NIK",
            "Nomor STR - NO_STR",
            "Alamat Pemohon/Pemilik - ALAMAT",
            "Praktik Ke - PRAKTIK_KE",
            "Alamat Praktik/Usaha/Penelitian - LOKASI",
            "Nomor Surat Keputusan - NO_SK",
            "Tanggal Ditetapkan Surat Keputusan - TGL_SK",
            "Tanggal Berlaku Surat Keputusan Sampai - TGL_BERLAKU_SK",
            "Nomor Surat Rekomendasi dari Dinas - NO_REKOMENDASI",
            "Status"
        ];
    }
}
