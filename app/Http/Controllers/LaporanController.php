<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\GroupLayananSkm;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Laporan\PermohonanBulananExport;
use App\Exports\SurveyLayanan\LaporanExport;

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
        return Excel::download(new PermohonanBulananExport($tahun), 'laporan_ijin_terbit_bulanan_' . $tahun . '.xlsx');
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
