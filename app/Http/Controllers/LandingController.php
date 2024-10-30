<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Enums\StatusPermohonanEnum;
use App\Services\PermohonanService;
use App\Http\Controllers\Controller;
use App\Services\LaporanService;

class LandingController extends Controller
{
    public function index(Request $request, LaporanService $laporan_srvice)
    {
        $user_count = User::whereIn('role_id', [
            RoleEnum::PUBLIC->value,
        ])->count();
        $permohonan_count = Permohonan::count();
        $permohonan_proses_count = Permohonan::whereNotIn(
            'status',
            [
                StatusPermohonanEnum::SELESAI->value
            ]
        )->count();
        $permohonan_selesai_count = $permohonan_count - $permohonan_proses_count;

        $laporan_survey = $laporan_srvice->laporanSurveyBulananPublic();
        return view('pages.landing.index', compact(
            'user_count',
            'permohonan_count',
            'permohonan_proses_count',
            'permohonan_selesai_count',
            'laporan_survey'
        ));
    }

    public function userGuideIndex(Request $request)
    {
        return view('pages.landing.user-guide');
    }

    public function cekPermohonanIndex(Request $request)
    {
        return view('pages.landing.cek-permohonan');
    }
    public function cekPermohonanStore(Request $request, PermohonanService $permohonanService)
    {
        $request->validate([
            'nomor_registrasi' => 'required',
        ]);
        $permohonan = Permohonan::where('nomor_registrasi', $request->nomor_registrasi)->first();
        if ($permohonan) {
            $steps = $permohonanService->getStepAlurPermohonan($permohonan, true);
            return view('pages.landing.cek-permohonan', [
                'is_found' => true,
                'permohonan' => $permohonan,
                'nomor_registrasi' => $request->nomor_registrasi,
                'steps' => $steps
            ]);
        } else {
            return view('pages.landing.cek-permohonan', [
                'is_found' => false,
                'nomor_registrasi' => $request->nomor_registrasi
            ]);
        }
    }

    public function berkasNotFound(Request $request)
    {
        return view('pages.berkas-not-found');
    }
}
