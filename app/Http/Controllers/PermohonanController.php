<?php

namespace App\Http\Controllers;

use App\Models\JenisIzin;
use App\Models\permohonan;
use App\Services\PermohonanService;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $jenis_izins = JenisIzin::all();
        return view('pages.admin.permohonan.index', compact(
            'jenis_izins'
        ));
    }

    public function show(Request $request, $id, PermohonanService $permohonan_service,)
    {
        $permohonan = Permohonan::with([
            'jenisIzin',
            'user',
            'formPermohonan',
            'berkasPermohonan',
            'kelengkapanPermohonan'
        ])->findOrFail($id);

        $steps = $permohonan_service->getStepAlurPermohonan($permohonan);
        $form_permohonans = $permohonan_service->getListFormPermohonan($permohonan);
        $berkas_permohonans = $permohonan_service->getListBerkasPermohonan($permohonan);
        $kelengkapan_permohonans = $permohonan_service->getListKelengkapanPermohonan($permohonan);

        return view('pages.admin.permohonan.show', compact(
            'permohonan',
            'steps',
            'form_permohonans',
            'berkas_permohonans',
            'kelengkapan_permohonans'
        ));
    }

    public function permohonanTable(Request $request)
    {
        if ($request->ajax()) {
            $start = $request->input('start');
            $length = $request->input('length');
            $draw = $request->input('draw');
            $search = $request->input('search');

            // Query
            $query = Permohonan::with([
                // 'jenisIzin',
                // 'user'
            ]);

            // Total records
            $totalRecords = $query->count();

            // Filter records
            if ($search || $request->input('status') || $request->input('jenis_izin_id')) {
                if ($search) {
                    $query = $query->where('nomor_registrasi', 'like', '%' . $search . '%')
                        ->orWhere('nama', 'like', '%' . $search . '%');
                }
                if ($request->input('status')) {
                    $query = $query->where('status', $request->input('status'));
                }
                if ($request->input('jenis_izin_id')) {
                    $query = $query->where('jenis_izin_id', $request->input('jenis_izin_id'));
                }

                // filtered records count
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
            $records = $query
                ->get()
                ->map(function ($permohonan) {
                    // $action = '<a href="' . route('admin.jenis-izin.show', $permohonan->id) . '" class="btn btn-sm btn-primary"><i class="isax isax-trash"></i></a>';
                    $action = '<a href="' . route('admin.permohonan.show', $permohonan->id) . '"><i class="isax-bold isax-eye"></i></a>';
                    // $action .= '<a href="#"><i class="isax-bold isax-trash"></i></a>';
                    return [
                        'nama_jenis_izin' => $permohonan->nama_jenis_izin,
                        'nomor_registrasi' => $permohonan->nomor_registrasi,
                        'waktu_pengajuan' => $permohonan->created_at->setTimezone('GMT+8')->locale('id')->isoFormat('LL LTS'),
                        'nama_pemohon' => $permohonan->nama,
                        'surat_permohonan_rekomendasi' => $permohonan->surat_permohonan_rekomendasi_filepath,
                        'surat_rekomendasi' => $permohonan->surat_rekomendasi_filepath,
                        'status_badge' => $permohonan->status_badge,
                        'action' => $action,
                    ];
                });

            // JSON response
            return response()->json([
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $records,
            ]);
        }
    }
}
