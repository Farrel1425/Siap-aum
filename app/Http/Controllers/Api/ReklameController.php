<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\FormJenisIzin;
use App\Models\RegistrasiReklame;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReklameResource;
use App\Http\Requests\FormReklameRequest;
use App\Http\Requests\RegistrasiReklameRequest;
use App\Http\Resources\RegistrasiReklameResource;
use App\Http\Resources\RegistrasiReklameCollection;

class ReklameController extends Controller
{
    public function index(Request $request)
    {
        try {
            $per_page = $request->input('per_page', 10);
            $reklame = RegistrasiReklame::orderBy('created_at', 'desc')
                ->paginate($per_page);

            return ResponseFormatter::successPaginate(
                new RegistrasiReklameCollection($reklame),
                'Data berhasil diambil'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return ResponseFormatter::error([
                'message' => $e->getMessage(),
            ], 'Something went wrong', 500);
        }
    }

    public function show($id)
    {
        try {
            $reklame = RegistrasiReklame::with('formReklame')->find($id);
            if (!$reklame) {
                return ResponseFormatter::error([
                    'message' => 'Data tidak ditemukan',
                ], 'Data tidak ditemukan', 404);
            }

            return ResponseFormatter::success(
                new ReklameResource($reklame),
                'Data berhasil diambil'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return ResponseFormatter::error([
                'message' => $e->getMessage(),
            ], 'Something went wrong', 500);
        }
    }

    public function initReklame(RegistrasiReklameRequest $request)
    {
        try {
            $reklame = RegistrasiReklame::create([
                'user_id' => auth()->id(),
                'nama' => $request->nama,
                'nik' => $request->nik,
                'npwp' => $request->npwp,
                'nama_perusahaan' => $request->nama_perusahaan,
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'nomor_telepon' => $request->nomor_telepon,
            ]);

            $reklame->update([
                'nomor_registrasi' => $nomor_registrasi = 'BLL/' . time() . '/' . auth()->id() . '/9/' . $reklame->id,
            ]);

            return ResponseFormatter::success(
                new RegistrasiReklameResource($reklame),
                'Data berhasil disimpan'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return ResponseFormatter::error([
                'message' => $e->getMessage(),
            ], 'Something went wrong', 500);
        }
    }

    public function storeReklame(FormReklameRequest $request, $id)
    {
        try {
            $registrasi_reklame = RegistrasiReklame::find($id);
            if (!$registrasi_reklame) {
                return ResponseFormatter::error([
                    'message' => 'Data tidak ditemukan',
                ], 'Data tidak ditemukan', 404);
            }

            $filepath = $request->file('image')->store('public/reklame-images');


            $reklame = $registrasi_reklame->reklame()->create([
                'image_filepath' => $filepath,
            ]);

            $jenis_izin = FormJenisIzin::where('jenis_izin_id', 9)
                ->get();

            foreach ($jenis_izin as $izin) {
                if ($izin->kode_isian == 'NAMA_PERUSAHAAN') {
                    $reklame->formReklame()->create([
                        'kode_isian' => $izin->kode_isian,
                        'tipe' => $izin->tipe,
                        'label' => $izin->label,
                        'value' => $registrasi_reklame->nama_perusahaan,
                        'urutan' => $izin->urutan,
                    ]);
                    continue;
                }

                if ($izin->kode_isian == 'HP/TELP') {
                    $reklame->formReklame()->create([
                        'kode_isian' => $izin->kode_isian,
                        'tipe' => $izin->tipe,
                        'label' => $izin->label,
                        'value' => $registrasi_reklame->nomor_telepon,
                        'urutan' => $izin->urutan,
                    ]);
                    continue;
                }

                if ($izin->kode_isian == 'ALAMAT') {
                    $reklame->formReklame()->create([
                        'kode_isian' => $izin->kode_isian,
                        'tipe' => $izin->tipe,
                        'label' => $izin->label,
                        'value' => $registrasi_reklame->alamat_perusahaan,
                        'urutan' => $izin->urutan,
                    ]);
                    continue;
                }

                $reklame->formReklame()->create([
                    'kode_isian' => $izin->kode_isian,
                    'tipe' => $izin->tipe,
                    'label' => $izin->label,
                    'value' => $request->input($izin->kode_isian),
                    'urutan' => $izin->urutan,
                ]);
            }

            return ResponseFormatter::success(
                new ReklameResource($registrasi_reklame),
                'Data berhasil disimpan'
            );
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return ResponseFormatter::error([
                'message' => $e->getMessage(),
            ], 'Something went wrong', 500);
        }
    }
}
