<?php

namespace App\Http\Controllers;

use App\Models\LayananSkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LayananSkmController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.master-data.layanan-skm.index');
    }

    public function create(Request $request)
    {
        return view('pages.admin.master-data.layanan-skm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
        ]);

        try {
            $layananSkm = new LayananSkm();
            $layananSkm->nama = $request->nama;
            $layananSkm->save();

            return redirect()->route('admin.master-data.layanan-skm.index')->with('success', 'Berhasil menambahkan layanan skm');
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->back()->with('error', 'Gagal menambahkan layanan skm');
        }
    }

    public function show(Request $request, $id)
    {
        $layanan_skm = LayananSkm::findOrFail($id);
        return view('pages.admin.master-data.layanan-skm.show', compact('layanan_skm'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string',
        ]);

        try {
            $layananSkm = LayananSkm::findOrFail($id);
            $layananSkm->nama = $request->nama;
            $layananSkm->save();

            return redirect()->route('admin.master-data.layanan-skm.index')->with('success', 'Berhasil mengubah layanan skm');
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->back()->with('error', 'Gagal mengubah layanan skm');
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $layananSkm = LayananSkm::findOrFail($id);
            $layananSkm->delete();

            return redirect()->route('admin.master-data.layanan-skm.index')->with('success', 'Berhasil menghapus layanan skm');
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' | ' . $e->getFile() . ':' . $e->getLine());
            return redirect()->back()->with('error', 'Gagal menghapus layanan skm');
        }
    }

    public function layananSkmTable(Request $request)
    {
        if ($request->ajax()) {
            $start = $request->input('start');
            $length = $request->input('length');
            $draw = $request->input('draw');
            $search = $request->input('search');

            // Query
            $query = LayananSkm::query();

            // Total records
            $totalRecords = $query->count();

            // Search
            if($search){
                $query = $query->where('nama', 'like', '%' . $search . '%');
                $totalFiltered = $query->count();
            }else{
                $totalFiltered = $query->count();
            }

            // Offset and limit
            if ($start != 0 || $length != -1) {
                $query = $query->offset($start)
                    ->limit($length);
            }

            // Get data
            $records = $query
                ->get()
                ->map(function ($layanan_skm) {
                    // $action = '<a href="' . route('admin.jenis-izin.show', $layanan_skm->id) . '" class="btn btn-sm btn-primary"><i class="isax isax-trash"></i></a>';
                    $action = '<a href="' . route('admin.master-data.layanan-skm.show', $layanan_skm->id) . '"><i class="isax-bold isax-brush-1"></i></a>';
                    // $action .= '<a href="#"><i class="isax-bold isax-trash"></i></a>';
                    return [
                        'id' => $layanan_skm->id,
                        'nama' => $layanan_skm->nama,
                        'created_at' => $layanan_skm->created_at->setTimezone('GMT+8')->locale('id')->isoFormat('LL LTS'),
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
