<?php

namespace App\Http\Controllers;

use App\Enums\StatusPermohonanEnum;
use App\Models\JenisIzin;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\PermohonanService;
use Illuminate\Support\Facades\Log;

class UserPermohonanController extends Controller
{
    public function create(Request $request, JenisIzin $jenis_izin)
    {
        return view('pages.public.permohonan.create');
    }

    public function createPermohonan(Request $request, JenisIzin $jenis_izin)
    {
        return view('pages.public.permohonan.submit-form', compact('jenis_izin'));
    }

    public function show(Permohonan $permohonan)
    {
        $permohonan->load([
            'jenisIzin',
            'formPermohonan',
            'alurPermohonan',
            'berkasPermohonan',
            'kelengkapanPermohonan',
        ]);

        if (!$permohonan->pengajuan_at) {
            // upload berkas
            $is_all_uploaded = $permohonan
                ->berkasPermohonan
                ->where('is_required', 1)
                ->whereNull('filepath')
                ->count() == 0;
            return view('pages.public.permohonan.submit-berkas', compact(
                'permohonan',
                'is_all_uploaded'
            ));
        }

        return view('pages.public.permohonan.show', compact('permohonan'));
    }

    public function submitForm(Request $request, JenisIzin $jenis_izin, PermohonanService $permohonan_service)
    {
        $jenis_izin->load([
            'formJenisIzin',
            'alurJenisIzin',
            'berkasJenisIzin',
            'kelengkapanJenisIzin',
        ]);

        // validasi input form
        $request->validate([
            'memohon_untuk' => 'required|in:0,1',
            'nama' => 'required',
            'nomor_telepon' => 'required',
            'nik' => 'required',
            'npwp' => 'required',
            'tempat_lahir' => 'required',
        ]);

        // validasi surat kuasa
        if ($request->memohon_untuk == 1) {
            $request->validate([
                'surat_kuasa' => 'required|file|mimes:pdf|max:2048',
            ]);
        }

        // validasi tiap field form jenis izin
        $form_jenis_izin = $jenis_izin->formJenisIzin;
        foreach ($form_jenis_izin as $form) {
            $request->validate([
                $form->kode_isian => 'required',
            ]);
        }

        DB::beginTransaction();
        try {
            // store permohonan
            $permohonan = Permohonan::create([
                'user_id' => auth()->id(),
                'jenis_izin_id' => $jenis_izin->id,
                'nama_jenis_izin' => $jenis_izin->nama,
                'deskripsi_jenis_izin' => $jenis_izin->deskripsi,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'tempat_lahir' => $request->tempat_lahir,
            ]);

            // nomor registrasi
            $nomor_registrasi = 'BLL/' . time() . '/' . auth()->id() . '/' . $jenis_izin->id . '/' . $permohonan->id;
            $permohonan->update([
                'nomor_registrasi' => $nomor_registrasi,
            ]);

            // store surat kuasa
            if ($request->memohon_untuk == 1) {
                $surat_kuasa = $request->file('surat_kuasa');
                $surat_kuasa_path = $surat_kuasa->store('public/surat_kuasa');
                $permohonan->update([
                    'surat_kuasa_filepath' => $surat_kuasa_path,
                ]);
            }

            // copy all form jenis izin to form permohonan
            foreach ($form_jenis_izin as $form) {
                $permohonan->formPermohonan()->create([
                    'label' => $form->label,
                    'tipe' => $form->tipe,
                    'kode_isian' => $form->kode_isian,
                    'value' => $request->{$form->kode_isian},
                    'urutan' => $form->urutan,
                ]);
            }

            // copy all alurJenisIzin to alurPermohonan
            $alur_jenis_izin = $jenis_izin->alurJenisIzin;
            foreach ($alur_jenis_izin as $alur) {
                $permohonan->alurPermohonan()->create([
                    'verifikator_id' => $alur->verifikator_id,
                    'jenis_verifikator' => $alur->jenis_verifikator,
                    'urutan' => $alur->urutan,
                    'is_done' => 0
                ]);
            }

            // copy berkasJenisIzin to berkasPermohonan
            $berkas_jenis_izin = $jenis_izin->berkasJenisIzin;
            foreach ($berkas_jenis_izin as $berkas) {
                $permohonan->berkasPermohonan()->create([
                    'nama' => $berkas->nama,
                    'is_required' => $berkas->is_required,
                    'urutan' => $berkas->urutan,
                    'is_valid' => 0,
                ]);
            }

            // copy kelengkapanJenisIzin to kelengkapanPermohonan
            $kelengkapan_jenis_izin = $jenis_izin->kelengkapanJenisIzin;
            foreach ($kelengkapan_jenis_izin as $kelengkapan) {
                $permohonan->kelengkapanPermohonan()->create([
                    'label' => $kelengkapan->label,
                    'tipe' => $kelengkapan->tipe,
                    'kode_isian' => $kelengkapan->kode_isian,
                    'urutan' => $kelengkapan->urutan,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error')->error($e->getFile() . $e->getLine() . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kegagalan sistem, silahkan hubungi administrator')->withInput();
        }

        return redirect()->route('dashboard')->with('success', 'Permohonan berhasil diajukan');
    }

    public function submitBerkas(Request $request, Permohonan $permohonan)
    {
        $permohonan->load([
            'berkasPermohonan'
        ]);

        $is_all_uploaded = $permohonan
            ->berkasPermohonan
            ->where('is_required', 1)
            ->whereNull('filepath')
            ->count() == 0;

        if (!$is_all_uploaded) {
            return redirect()->back()->with('error', 'Berkas wajib belum lengkap');
        }

        DB::beginTransaction();
        try {
            $permohonan->update([
                'pengajuan_at' => now(),
                'status' => StatusPermohonanEnum::PERMOHONAN_BARU->value,
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error')->error($e->getFile() . $e->getLine() . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kegagalan sistem, silahkan hubungi administrator');
        }

        return redirect()->route('dashboard')->with('success', 'Permohonan berhasil diajukan');
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
                ->where('user_id', auth()->id());

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
                    $steps = $permohonan_service->getStepAlurPermohonan($permohonan,true);
                    return [
                        'id' => $permohonan->id,
                        'url' => route('public.permohonan.show', $permohonan->id),
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

    public function jenisIzinTable(Request $request)
    {
        if ($request->ajax()) {
            $start = $request->input('start');
            $length = $request->input('length');
            $draw = $request->input('draw');
            $search = $request->input('search');

            // Query
            $query = JenisIzin::query();

            // Total records
            $totalRecords = $query->count();

            // Filter records
            if ($search) {
                $query = $query->where('nama', 'like', '%' . $search . '%');
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
            $jenis_izins = $query->get()
                ->map(function ($jenis_izin) {
                    return [
                        'id' => $jenis_izin->id,
                        'nama' => $jenis_izin->nama,
                        'deskripsi' => $jenis_izin->deskripsi,
                    ];
                });

            return response()->json([
                'draw' => $draw,
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalFiltered,
                'data' => $jenis_izins
            ]);
        }
    }

    // ajax
    public function storeBerkas(Request $request)
    {
        $request->validate([
            'berkas' => 'required|file|mimes:pdf,docx|max:2048',
            'berkas_key' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $permohonan = Permohonan::find($request->permohonan);
            $berkas_permohonan = $permohonan->berkasPermohonan()->find($request->berkas_key);
            if (!$berkas_permohonan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode berkas yang anda upload tidak ditemukan'
                ]);
            }
            $berkas = $request->file('berkas');
            $berkas_path = $berkas->store('public/berkas_permohonan');
            $berkas_permohonan->update([
                'filepath' => $berkas_path
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::channel('error')->error($e->getFile() . $e->getLine() . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kegagalan sistem, silahkan hubungi administrator'
            ]);
        }
        return response()->json([
            'success' => true,
            'message' => 'Berkas berhasil diunggah'
        ]);
    }
}
