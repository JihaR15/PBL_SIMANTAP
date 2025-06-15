<?php

namespace App\Http\Controllers;

use App\Models\PeriodeModel;
use App\Models\LaporanModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PeriodeController extends Controller
{

    public function index()
    {
        $activeMenu = 'periode';
        return view('periode.index', [
            'title' => 'Manajemen Periode',
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Manajemen Periode', 'url' => '/periode']
            ]
        ]);
    }

    public function list()
    {
        $periode = PeriodeModel::select(['periode_id', 'nama_periode']);
        return DataTables::of($periode)
            ->addIndexColumn()
            ->addColumn('action', function ($periode) {
                return '<button onclick="modalAction(\'' . url('/periode/' . $periode->periode_id. '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>
                <button onclick="modalAction(\'' . url('/periode/' . $periode->periode_id . '/edit') . '\')" class="btn btn-sm btn-warning">Edit</button>
                <button onclick="modalAction(\'' . url('/periode/' . $periode->periode_id . '/delete') . '\')" class="btn btn-sm btn-danger">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('periode.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_periode' => 'required|min:3|max:10',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $periode = new PeriodeModel();
        $periode->nama_periode = $request->nama_periode;
        $periode->save();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Periode berhasil dibuat.',
                'data' => $periode
            ]);
        }
        return redirect()->route('periode.index')->with('success', 'Periode berhasil dibuat.');
    }

    public function show($id)
    {
        $periode = PeriodeModel::find($id);
        return view('periode.show', compact('periode'));
    }

    public function edit($id)
    {
        $periode = PeriodeModel::findOrFail($id);
        return view('periode.edit', compact('periode'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_periode' => 'required|min:3|max:10',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $periode = PeriodeModel::findOrFail($id);
        $periode->nama_periode = $request->nama_periode;
        $periode->save();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Periode berhasil diperbarui.',
                'data' => $periode
            ]);
        }
        return redirect()->route('periode.index')->with('success', 'Periode berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        $periode = PeriodeModel::findOrFail($id);
        return view('periode.confirm_delete', compact('periode'));
    }

    public function destroy($id)
    {
        $periode = PeriodeModel::findOrFail($id);

        $laporans = LaporanModel::where('periode_id', $id)->get();
        foreach ($laporans as $laporan) {
            $laporan->notifikasi()->delete();
            $laporan->perbaikan()->delete();
            $laporan->prioritas()->delete();
            $laporan->feedback()->delete();

            $laporan->delete();
        }

        $periode->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Periode berhasil dihapus'
            ]);
        }

        return redirect()->route('periode.index')->with('success', 'Periode berhasil dihapus');
    }
}