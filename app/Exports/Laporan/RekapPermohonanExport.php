<?php

namespace App\Exports\Laporan;

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

    public function map($data): array
    {
        return [
            $data->user->name,
            $data->nama_jenis_izin,
            $data->nomor_registrasi,
            $data->nama,
            $data->nik,
            $data->npwp,
            $data->tempat_lahir,
            $data->pengajuan_at,
            StatusPermohonanEnum::tryFrom($data->status)->deskripsi(),
            $data->is_ttd ? 'Sudah' : 'Belum',
        ];
    }

    private function getHeader()
    {
        return [
            'Nama Pemohon',
            'Jenis Izin',
            'Nomor Registrasi',
            'Nama',
            'NIK',
            'NPWP',
            'Tempat Lahir',
            'Tanggal Pengajuan',
            'Status',
            'TTD',
        ];
    }
}
