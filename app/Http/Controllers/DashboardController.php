<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Enums\StatusPermohonanEnum;
use App\Http\Controllers\DashboardUserController;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->is_admin) {
            $total_permohonan = Permohonan::whereNotIn('status', [
                StatusPermohonanEnum::PENDING->value,
                StatusPermohonanEnum::EXPIRED->value
            ])->count();

            $permohonan_diproses = Permohonan::whereNotIn('status', [
                StatusPermohonanEnum::PENDING->value,
                StatusPermohonanEnum::EXPIRED->value,
                StatusPermohonanEnum::SELESAI->value,
            ])->count();

            $permohonan_selesai = Permohonan::where('status', StatusPermohonanEnum::SELESAI->value)
                ->count();
            return view('pages.admin.dashboard.index', compact(
                'total_permohonan',
                'permohonan_diproses',
                'permohonan_selesai'
            ));
        } else if (auth()->user()->is_public) {
            $dashboardUserController = new DashboardUserController();
            return $dashboardUserController->index($request);
        } else if (auth()->user()->is_verifikator) {
            $total_permohonan = Permohonan::whereNotIn('status', [
                StatusPermohonanEnum::PENDING->value,
                StatusPermohonanEnum::EXPIRED->value
            ])->whereHas('alurPermohonan', function ($q) {
                $q->where('verifikator_id', auth()->user()->id);
            })->count();

            $permohonan_diproses = Permohonan::whereNotIn('status', [
                StatusPermohonanEnum::PENDING->value,
                StatusPermohonanEnum::EXPIRED->value,
                StatusPermohonanEnum::SELESAI->value,
            ])->whereHas('alurPermohonan', function ($q) {
                $q->where('verifikator_id', auth()->user()->id);
            })->count();

            $permohonan_selesai = Permohonan::where('status', StatusPermohonanEnum::SELESAI->value)
                ->whereHas('alurPermohonan', function ($q) {
                    $q->where('verifikator_id', auth()->user()->id);
                })->count();

            return view('pages.verifikator.dashboard.index', compact(
                'total_permohonan',
                'permohonan_diproses',
                'permohonan_selesai'
            ));
        } else {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses, silahkan login kembali');
        }
    }
}
