<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\Laporan\PermohonanBulananExport;
use Maatwebsite\Excel\Facades\Excel;

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

    public function surveyBulananIndex(Request $request)
    {
        return view('pages.admin.laporan.survey-bulanan.index');
    }

    public function surveyBulanan(Request $request)
    {
        return view('pages.admin.laporan.survey-bulanan.index');
    }
}
