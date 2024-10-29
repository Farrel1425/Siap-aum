<?php

namespace App\Services;

use App\Models\Kuesioner;
use App\Models\KategoriIzin;
use Illuminate\Support\Carbon;
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

    public function laporanSurveyBulanan($filter)
    {
        // generate hash cache key based on filter
        $hash = md5(json_encode($filter));

        $data = Cache::remember('laporan_survey_bulanan_' . $hash, 5, function () use ($filter) {
            return $this->queryLaporanSurveyBulanan($filter);
        });

        return $data;
    }

    // Laporan Survey Bulanan For Public with long cache ttl
    public function laporanSurveyBulananPublic()
    {
        $data = Cache::remember('laporan_survey_bulanan_public', 3600, function () {
            // last 3 month
            $tanggal_awal = Carbon::now()->subMonths(10)->startOfMonth();
            $tanggal_akhir = Carbon::now()->endOfMonth();
            $data = $this->queryLaporanSurveyBulanan([
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
            ]);

            // total kuesioner
            $data['totalKuesioner'] = $data['kuesioners']->count();

            // Group by layanan and count
            $groupedKuesioners = $data['kuesioners']->groupBy(function ($item) {
                return $item->layanan;
            })->map(function ($group) {
                return $group->count();
            });

            // Calculate total count of all kuesioners
            $totalKuesioners = $groupedKuesioners->sum();

            // Sort by total kuesioner per group, take top 5, and calculate percentage
            $top5Kuesioners = $groupedKuesioners->sortDesc()->take(5)->map(function ($count) use ($totalKuesioners) {
                return [
                    'count' => $count,
                    'percentage' => ($count / $totalKuesioners) * 100,
                ];
            });

            $data['topKuesioners'] = $top5Kuesioners;

            // nrrTertbgUnsur to percentage
            $data['nrrTertbgUnsurPercentage'] = array_map(function ($nrr) {
                return $nrr * 100;
            }, $data['nrrTertbgUnsur']);

            $array = [
                'Persyaratan',
                'Prosedur',
                'Kecepatan',
                'Biaya/Tarif',
                'Produk/Layanan',
                'Kompetensi Pelaksana',
                'Perilaku Pelaksana',
                'Penanganan Pengaduan',
                'Sarana dan Prasarana',
            ];

            $data['nrrTertbgUnsurPercentage'] = array_combine($array, $data['nrrTertbgUnsurPercentage']);

            unset($data['kuesioners']);

            return $data;
        });

        return $data;
    }

    public function queryLaporanSurveyBulanan($filter = [])
    {
        // Query data laporan survey bulanan
        $kuesioners = Kuesioner::with(['kuesionerJawaban.kuesionerOpsi.kuesionerPertanyaan', 'layananSkm', 'jenisIzin']);

        if (isset($filter['tanggal_awal'])) {
            $tanggal_awal = Carbon::parse($filter['tanggal_awal']);
            $kuesioners->where('created_at', '>=', $tanggal_awal);
        }

        if (isset($filter['tanggal_akhir'])) {
            $tanggal_akhir = Carbon::parse($filter['tanggal_akhir']);
            $kuesioners->where('created_at', '<=', $tanggal_akhir);
        }

        $kuesioners = $kuesioners->get()
            ->map(function ($kuesioner) {
                $kuesioner->layanan = $kuesioner->layananSkm?->nama ?? $kuesioner->jenisIzin?->nama ?? '-';
                $kuesioner->kuesioner_point = $kuesioner
                    ->kuesionerJawaban
                    ->sortBy('kuesioner_pertanyaan_id')
                    ->map(function ($jawaban) {
                        return $jawaban->kuesionerOpsi->point;
                    });
                unset($kuesioner->kuesionerJawaban);
                unset($kuesioner->layananSkm);
                unset($kuesioner->jenisIzin);
                return $kuesioner;
            });

        // Calculate "JML Nilai / Unsur"
        $jmlNilaiUnsur = [];
        foreach ($kuesioners as $kuesioner) {
            foreach ($kuesioner->kuesioner_point as $index => $point) {
                if (!isset($jmlNilaiUnsur[$index])) {
                    $jmlNilaiUnsur[$index] = 0;
                }
                $jmlNilaiUnsur[$index] += $point;
            }
        }

        // Calculate "NRR / Unsur"
        $totalKuesioner = $kuesioners->count();
        $nrrUnsur = array_map(function ($nilai) use ($totalKuesioner) {
            return $nilai / $totalKuesioner;
        }, $jmlNilaiUnsur);

        // Calculate "NRR Tertbg / Unsur"
        $nrrTertbgUnsur = array_map(function ($nrr) {
            return $nrr / 4;
        }, $nrrUnsur);

        // Calculate "Persentase Nilai IKM"
        $sumJmlNilaiUnsur = array_sum($jmlNilaiUnsur);
        if ($totalKuesioner === 0) {
            $persentaseNilaiIKM = 0;
        } else {
            $persentaseNilaiIKM = ($sumJmlNilaiUnsur / ($totalKuesioner * 9 * 4)) * 100;
        }

        return [
            'kuesioners' => $kuesioners,
            'jmlNilaiUnsur' => $jmlNilaiUnsur,
            'nrrUnsur' => $nrrUnsur,
            'nrrTertbgUnsur' => $nrrTertbgUnsur,
            'persentaseNilaiIKM' => $persentaseNilaiIKM,
        ];
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
