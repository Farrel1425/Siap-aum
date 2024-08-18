<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JenisIzin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JenisIzinController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.master-data.jenis-izin.index');
    }

    public function create(Request $request)
    {
        return view('pages.admin.master-data.jenis-izin.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
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
                $query = $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', '%' . $search . '%');
                });

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
                ->map(function ($jenisIzin) {
                    // $action = '<a href="' . route('admin.jenis-izin.show', $jenisIzin->id) . '" class="btn btn-sm btn-primary"><i class="isax isax-trash"></i></a>';
                    $action = '<a href="#"><i class="isax-bold isax-brush-1"></i></a>';
                    $action .= '<a href="#"><i class="isax-bold isax-trash"></i></a>';
                    return [
                        'id' => $jenisIzin->id,
                        'nama' => $jenisIzin->nama,
                        'created_at' => $jenisIzin->created_at->setTimezone('GMT+8')->locale('id')->isoFormat('LL LTS'),
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
