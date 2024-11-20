<?php

namespace App\Http\Controllers;

use App\Models\JenisIzin;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\GroupLayananSkm;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Laporan\IzinTerbitExport;
use App\Exports\SurveyLayanan\LaporanExport;
use App\Exports\Laporan\RekapPermohonanExport;

class LaporanController extends Controller
{
    public function ijinTerbitBulananIndex(Request $request)
    {
        return view('pages.admin.laporan.ijin-terbit-bulanan.index');
    }

    public function ijinTerbitBulananExport(Request $request)
    {
        $request->validate([
            'tahun' => 'required|numeric',
        ]);
        $tahun = $request->tahun;
        return Excel::download(new IzinTerbitExport($tahun), 'laporan_ijin_terbit_bulanan_' . $tahun . '.xlsx');
    }

    public function rekapPermohonanIndex(Request $request)
    {
        $jenis_izins = JenisIzin::all();
        return view('pages.admin.laporan.rekap-permohonan.index', compact('jenis_izins'));
    }

    public function rekapPermohonanExport(Request $request)
    {
        $request->validate([
            'jenis_izin_id' => 'nullable|numeric|exists:jenis_izins,id',
            'periode' => 'required',
            'status' => 'nullable',
        ]);


        $jenis_izin_id = $request->jenis_izin_id;
        $periode = explode(' - ', $request->periode);
        $start = Carbon::createFromFormat('d/m/Y', $periode[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', $periode[1])->format('Y-m-d');

        $filename = 'laporan_rekap_permohonan_' . $start . '_' . $end . '.xlsx';

        $permohonans = Permohonan::with([
            'user',
            'kelengkapanPermohonan',
            'formPermohonan'
        ]);

        if ($jenis_izin_id) {
            $permohonans = $permohonans->where('jenis_izin_id', $jenis_izin_id);
        }

        if ($request->status) {
            $permohonans = $permohonans->where('status', $request->status);
        }

        $permohonans = $permohonans->whereBetween('created_at', [$start, $end])->get();

        return Excel::download(new RekapPermohonanExport($permohonans), $filename);
    }

    public function surveyLayananIndex(Request $request)
    {
        $groupLayananSkm = GroupLayananSkm::all();
        return view('pages.admin.laporan.survey-layanan.index', compact('groupLayananSkm'));
    }

    public function surveyLayananExport(Request $request)
    {
        $request->validate([
            'group_layanan_skm_id' => 'required|numeric',
            'periode' => 'required',
        ]);

        $groupLayananSkm = GroupLayananSkm::find($request->group_layanan_skm_id);
        $periode = explode(' - ', $request->periode);
        $start = Carbon::createFromFormat('d/m/Y', $periode[0])->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', $periode[1])->format('Y-m-d');

        $namaLayanan =  $groupLayananSkm?->nama ?? 'Siajaib';
        $filename = 'laporan_survey_layanan_' . $namaLayanan . '_' . $start . '_' . $end . '.xlsx';
        return Excel::download(new LaporanExport($groupLayananSkm, $start, $end), $filename);
    }
}
