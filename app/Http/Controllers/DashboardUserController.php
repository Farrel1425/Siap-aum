<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Services\PermohonanService;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    public function index(Request $request)
    {
        $permohonans = Permohonan::where('user_id', '1006')->get();
        return view('pages.public.dashboard.index', compact(
            'permohonans'
        ));
    }

    public function permohonanTable(Request $request, PermohonanService $permohonan_service)
    {
        if ($request->ajax()) {
            $start = $request->input('start');
            $length = $request->input('length');
            $draw = $request->input('draw');
            $search = $request->input('search');

            // Query
            $query = Permohonan::with(['jenisIzin', 'alurPermohonan'])
                ->where('user_id', '1006');

            // Total records
            $totalRecords = $query->count();

            // Filter records
            if ($search) {
                $query = $query->where(function ($query) use ($search) {
                    $query->where('nomor_registrasi', 'like', '%' . $search . '%')
                    ->orWhereHas('jenisIzin', function ($query) use ($search) {
                        $query->where('nama', 'like', '%' . $search . '%');
                    });
                });
                $totalFiltered = $query->count();
            } else {
                $totalFiltered = $totalRecords;
            }

            // Offset and limit
            if ($start != 0 || $length != -1) {
                $query = $query->offset($start)
                    ->limit($length);
            }

            // Get data
            $permohonans = $query->get()
                ->map(function ($permohonan) use ($permohonan_service) {
                    $steps = $permohonan_service->getStepAlurPermohonan($permohonan);
                    return [
                        'id' => $permohonan->id,
                        'url' => '#',
                        'nomor_registrasi' => $permohonan->nomor_registrasi,
                        'nama' => $permohonan->nama,
                        'status_badge' => $permohonan->status_badge,
                        'nama_jenis_izin' => $permohonan->jenisIzin->nama,
                        'tanggal_masuk' => $permohonan->created_at->format('d-m-Y'),
                        'steps' => $steps
                    ];
                });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $permohonans
            ]);
        }
    }
}
