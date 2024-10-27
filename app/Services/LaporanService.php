<?php

namespace App\Services;

use App\Models\KategoriIzin;
use Illuminate\Support\Facades\Cache;

class LaporanService
{
    public function laporanPermohonanBulanan($tahun)
    {
        $data = Cache::remember('laporan_permohonan_bulanan_' . $tahun, 5, function () use ($tahun) {
            return $this->queryLaporanPermohonanBulanan($tahun);
        });

        return $data;
    }

    private function queryLaporanPermohonanBulanan($tahun)
    {
        // Query data laporan permohonan bulanan
        return KategoriIzin::with(['sektorIzin.jenisIzin.permohonan' => function ($query) use ($tahun) {
                $query->whereYear('created_at', $tahun);
            }])
            ->whereHas('sektorIzin.jenisIzin')
            ->get()
            ->map(function ($kategori) {
                $kategori_collect = collect();
                $kategori_collect->put('nama_kategori', $kategori->nama);
                $sektorIzin =  $kategori->sektorIzin
                    ->filter(function ($sektor) {
                        return $sektor->jenisIzin->count() > 0;
                    })
                    ->map(function ($sektor) {
                        $sektor->jenisIzin->map(function ($jenisIzin) {
                            $jenisIzin->statistik = $this->generateStatistikBulanan($jenisIzin->permohonan);
                            $jenisIzin->statistik_total = $jenisIzin->statistik->sum();
                            unset($jenisIzin->deskripsi);
                            unset($jenisIzin->permohonan);
                        });

                        $sektor->statistik_total = $sektor->jenisIzin->map(function ($jenisIzin) {
                            return $jenisIzin->statistik_total;
                        })->sum();

                        $sektor->statistik = $sektor->jenisIzin->map(function ($jenisIzin) {
                            return $jenisIzin->statistik;
                        })->reduce(
                            function ($carry, $item) {
                                foreach ($item as $month => $value) {
                                    if (isset($carry[$month])) {
                                        $carry[$month] += $value;
                                    } else {
                                        $carry[$month] = $value;
                                    }
                                }
                                return $carry;
                            },
                            collect([
                                'Januari' => 0,
                                'Februari' => 0,
                                'Maret' => 0,
                                'April' => 0,
                                'Mei' => 0,
                                'Juni' => 0,
                                'Juli' => 0,
                                'Agustus' => 0,
                                'September' => 0,
                                'Oktober' => 0,
                                'November' => 0,
                                'Desember' => 0,
                            ])
                        );

                        return $sektor;
                    });

                $kategori_collect->put('sektorIzin', $sektorIzin);
                return $kategori_collect;
            })
            ->filter(function ($sektor) {
                return $sektor->count() > 0;
            });
    }

    private function generateStatistikBulanan($permohonan)
    {
        $statistik = collect([
            'Januari' => 0,
            'Februari' => 0,
            'Maret' => 0,
            'April' => 0,
            'Mei' => 0,
            'Juni' => 0,
            'Juli' => 0,
            'Agustus' => 0,
            'September' => 0,
            'Oktober' => 0,
            'November' => 0,
            'Desember' => 0,
        ]);
        $permohonan->each(function ($item) use ($statistik) {
            $bulan = $item->created_at->locale('id')->monthName;
            $statistik[$bulan] += 1;
        });

        return $statistik;
    }
}
