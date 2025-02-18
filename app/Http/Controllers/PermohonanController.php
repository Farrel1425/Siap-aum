<?php

namespace App\Http\Controllers;

use App\Enums\StatusPermohonanEnum;
use App\Models\JenisIzin;
use App\Models\Permohonan;
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

        $steps = $permohonan_service->getStepAlurPermohonan($permohonan, true);
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

    public function edit(Request $request, $id, PermohonanService $permohonan_service)
    {
        $permohonan = Permohonan::with([
            'formPermohonan',
            'kelengkapanPermohonan'
        ])->findOrFail($id);

        if (!in_array($permohonan->status, [
            StatusPermohonanEnum::PERMOHONAN_BARU->value,
            StatusPermohonanEnum::VERIFIKASI->value,
            StatusPermohonanEnum::VERIFIKASI_ULANG->value,
        ])) {
            return back()->with('error', 'Permohonan tidak dapat diubah');
        }

        $steps = $permohonan_service->getStepAlurPermohonan($permohonan, true);

        return view('pages.admin.permohonan.edit', compact(
            'permohonan',
            'steps'
        ));
    }

    public function update(Request $request, $id, PermohonanService $permohonan_service)
    {
        $permohonan = Permohonan::findOrFail($id);

        if (!in_array($permohonan->status, [
            StatusPermohonanEnum::PERMOHONAN_BARU->value,
            StatusPermohonanEnum::VERIFIKASI->value,
            StatusPermohonanEnum::VERIFIKASI_ULANG->value,
        ])) {
            return back()->with('error', 'Permohonan tidak dapat diubah');
        }

        $request->validate([
            'nama' => 'required|string',
            'nik' => 'required|string',
            'npwp' => 'nullable|string',
            'tempat_lahir' => 'required|string',
        ]);

        foreach ($permohonan->formPermohonan as $form) {
            $request->validate([
                $form->kode_isian => 'required',
            ]);
        }

        try {
            $permohonan->update([
                'nama' => $request->nama,
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'tempat_lahir' => $request->tempat_lahir,
            ]);

            foreach ($permohonan->formPermohonan as $form) {
                $form->update([
                    'value' => $request->{$form->kode_isian},
                ]);
            }

            foreach ($permohonan->kelengkapanPermohonan as $kelengkapan) {
                $kelengkapan->update([
                    'value' => $request->{$kelengkapan->kode_isian},
                ]);
            }

            return redirect()->back()->with('success', 'Permohonan berhasil diubah');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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

            // order table
            if ($request->input('order.0.name') == 'waktu_pengajuan') {
                $query = $query->orderBy('created_at', $request->input('order.0.dir'));
            }

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
                    $action = '';

                    if (in_array($permohonan->status, [
                        StatusPermohonanEnum::PERMOHONAN_BARU->value,
                        StatusPermohonanEnum::VERIFIKASI->value,
                        StatusPermohonanEnum::VERIFIKASI_ULANG->value,
                    ])) {
                        $action .= '<a href="' . route('admin.permohonan.edit', $permohonan->id) . '"><i class="isax-bold isax-edit me-2"></i></a>';
                    }
                    // $action = '<a href="' . route('admin.jenis-izin.show', $permohonan->id) . '" class="btn btn-sm btn-primary"><i class="isax isax-trash"></i></a>';
                    $action .= '<a href="' . route('admin.permohonan.show', $permohonan->id) . '"><i class="isax-bold isax-eye"></i></a>';
                    // $action .= '<a href="#"><i class="isax-bold isax-trash"></i></a>';
                    return [
                        'nama_jenis_izin' => $permohonan->nama_jenis_izin,
                        'nomor_registrasi' => $permohonan->nomor_registrasi,
                        'waktu_pengajuan' => $permohonan->created_at->setTimezone('GMT+8')->locale('id')->isoFormat('LL LTS'),
                        'nama_pemohon' => $permohonan->nama,
                        // 'surat_permohonan_rekomendasi' => $permohonan->surat_permohonan_rekomendasi_filepath,
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

    public function downloadIzinTerbit(Request $request, $permohonan, $filepath, PermohonanService $permohonan_service)
    {
        try {
            $permohonan = Permohonan::findOrFail($permohonan);
            return $permohonan_service->downloadIzinTerbit($permohonan, auth()->user());
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
