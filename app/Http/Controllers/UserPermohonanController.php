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
        if ($jenis_izin->id == 9) {
            return redirect()->route('public.reklame.index');
        }else{
            return view('pages.public.permohonan.submit-form', compact('jenis_izin'));
        }
    }

    public function show(Permohonan $permohonan, PermohonanService $permohonan_service)
    {
        $permohonan->load([
            'jenisIzin',
            'formPermohonan',
            'alurPermohonan',
            'berkasPermohonan',
            'kelengkapanPermohonan',
            'kuesioner',
        ]);

        $steps = $permohonan_service->getStepAlurPermohonan($permohonan, true);

        $need_kuesioner = $permohonan->status == StatusPermohonanEnum::SELESAI->value && !$permohonan->kuesioner ? true : false;

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
        } else if ($permohonan->status == StatusPermohonanEnum::REVISI->value) {
            return view('pages.public.permohonan.revisi', compact(
                'permohonan',
                'steps'
            ));
        } else {
            return view('pages.public.permohonan.show', compact(
                'permohonan',
                'steps',
                'need_kuesioner'
            ));
        }
    }

    public function submitForm(Request $request, JenisIzin $jenis_izin, PermohonanService $permohonan_service)
    {
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

        if($jenis_izin->is_pas_foto_required){
            $request->validate([
                'pas_foto' => 'required|file|mimes:jpeg,jpg,png|max:2048',
            ]);
        }

        $jenis_izin->load([
            'formJenisIzin',
            'alurJenisIzin',
            'berkasJenisIzin',
            'kelengkapanJenisIzin',
        ]);

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

            // store pas foto
            if($jenis_izin->is_pas_foto_required){
                $pas_foto = $request->file('pas_foto');
                $pas_foto_path = $pas_foto->store('public/pas_foto');
                $permohonan->update([
                    'is_pas_foto_required' => 1,
                    'pas_foto_filepath' => $pas_foto_path,
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

        return redirect()->route('public.permohonan.show', $permohonan->id)->with('success', 'Data berhasil disimpan. Silahkan lengkapi berkas permohonan');
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

    public function destroy(Request $request, Permohonan $permohonan)
    {
        if ($permohonan->user_id != auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses'
            ]);
        }

        if($permohonan->status != StatusPermohonanEnum::PENDING->value){
            return response()->json([
                'success' => false,
                'message' => 'Hanya permohonan dengan status pending yang dapat dihapus'
            ]);
        }

        DB::beginTransaction();
        try {
            $permohonan->formPermohonan()->delete();
            $permohonan->alurPermohonan()->delete();
            $permohonan->berkasPermohonan()->delete();
            $permohonan->kelengkapanPermohonan()->delete();
            $permohonan->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getFile() . $e->getLine() . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kegagalan sistem, silahkan hubungi administrator');
        }

        return redirect()->back()->with('success', 'Permohonan berhasil dihapus');
    }

    public function revisi(Request $request, Permohonan $permohonan)
    {
        $permohonan->load([
            'berkasPermohonan' => function ($query) {
                $query->with([
                    'validasiBerkas' => function ($query) {
                        $query->where('status', 'revisi');
                    }
                ]);
            },
            'alurPermohonan' => function ($query) {
                $query->with([
                    'validasiBerkas' => function ($query) {
                        $query->where('status', 'revisi');
                    }
                ])
                    ->where('is_done', 0);
            }
        ]);

        if ($permohonan->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $is_all_uploaded = $permohonan
            ->berkasPermohonan
            ->where('is_required', 1)
            ->whereNull('filepath')
            ->count() == 0;

        if (!$is_all_uploaded) {
            return redirect()->back()->with('error', 'Berkas wajib belum lengkap');
        }

        // if validasi berkas revisi exist
        $validasi_berkas_revisi = $permohonan->alurPermohonan->map(function ($alur) {
            return $alur->validasiBerkas->count();
        })->sum();

        if ($validasi_berkas_revisi > 0) {
            return redirect()->back()->with('error', 'Mohon melakukan upload ulang ke seluruh berkas yang memilik status revisi');
        }


        DB::beginTransaction();
        try {
            $permohonan->update([
                'pengajuan_at' => now(),
                'status' => StatusPermohonanEnum::VERIFIKASI_ULANG->value,
            ]);
            // $permohonan->alurPermohonan->map(function ($alur) {
            //     $alur->validasiBerkas()->where('status', 'revisi')->delete();
            // });
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

            $query = $query->orderBy('created_at', 'desc');

            // Get data
            $permohonans = $query->get()
                ->map(function ($permohonan) use ($permohonan_service) {
                    $steps = $permohonan_service->getStepAlurPermohonan($permohonan, true);
                    return [
                        'id' => $permohonan->id,
                        'url' => route('public.permohonan.show', $permohonan->id),
                        'nomor_registrasi' => $permohonan->nomor_registrasi,
                        'nama' => $permohonan->nama,
                        'status_badge' => $permohonan->status_badge,
                        'nama_jenis_izin' => $permohonan->jenisIzin->nama,
                        'tanggal_masuk' => $permohonan->created_at->format('d-m-Y'),
                        'steps' => $steps,
                        'status' => $permohonan->status,
                        'delete_url' => route('public.permohonan.destroy', $permohonan->id),
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
            'berkas' => 'required|file|mimes:pdf|max:5120',
            'berkas_key' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $permohonan = Permohonan::find($request->permohonan);
            $berkas_permohonan = $permohonan->berkasPermohonan()->with('validasiBerkas')->find($request->berkas_key);
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
            $berkas_permohonan->validasiBerkas()->where('status', 'revisi')->delete();
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
