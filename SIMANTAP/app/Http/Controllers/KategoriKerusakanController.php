<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriKerusakanModel;
use App\Models\LaporanModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class KategoriKerusakanController extends Controller
{
    public function index()
    {
        $activeMenu = 'kategoriKerusakan';
        return view('kategoriKerusakan.index', [
            'title' => 'Manajemen Kategori Kerusakan',
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Manajemen Kategori Kerusakan', 'url' => '/kategoriKerusakan']
            ]
        ]);
    }

    public function list()
    {
        $kategoriKerusakan = KategoriKerusakanModel::select(['kategori_kerusakan_id', 'nama_kategori']);
        return DataTables::of($kategoriKerusakan)
            ->addIndexColumn()
            ->addColumn('action', function ($kategoriKerusakan) {
                return '<button onclick="modalAction(\'' . url('/kategoriKerusakan/' . $kategoriKerusakan->kategori_kerusakan_id. '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>
                <button onclick="modalAction(\'' . url('/kategoriKerusakan/' . $kategoriKerusakan->kategori_kerusakan_id . '/edit') . '\')" class="btn btn-sm btn-warning">Edit</button>
                <button onclick="modalAction(\'' . url('/kategoriKerusakan/' . $kategoriKerusakan->kategori_kerusakan_id . '/delete') . '\')" class="btn btn-sm btn-danger">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('kategoriKerusakan.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_kategori' => 'required|min:12|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $kategoriKerusakan = new KategoriKerusakanModel();
        $kategoriKerusakan->nama_kategori = $request->nama_kategori;
        $kategoriKerusakan->save();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Kategori Kerusakan berhasil dibuat.',
                'data' => $kategoriKerusakan
            ]);
        }
        return redirect()->route('kategoriKerusakan.index')->with('success', 'Kategori Kerusakan berhasil dibuat.');
    }

    public function show($id)
    {
        $kategoriKerusakan = KategoriKerusakanModel::find($id);
        return view('kategoriKerusakan.show', compact('kategoriKerusakan'));
    }


    public function edit($id)
    {
        $kategoriKerusakan = KategoriKerusakanModel::findOrFail($id);
        return view('kategoriKerusakan.edit', compact('kategoriKerusakan'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_kategori' => 'required|min:12|max:100',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $kategoriKerusakan = KategoriKerusakanModel::findOrFail($id);
        $kategoriKerusakan->nama_kategori = $request->nama_kategori;
        $kategoriKerusakan->save();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Kategori Kerusakan berhasil diperbarui.',
                'data' => $kategoriKerusakan
            ]);
        }
        return redirect()->route('kategoriKerusakan.index')->with('success', 'Kategori Kerusakan berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        $kategoriKerusakan = KategoriKerusakanModel::findOrFail($id);
        return view('kategoriKerusakan.confirm_delete', compact('kategoriKerusakan'));
    }

    public function destroy($id)
    {
        $kategoriKerusakan = KategoriKerusakanModel::findOrFail($id);

        $laporans = LaporanModel::where('kategori_kerusakan_id', $id)->get();
        foreach ($laporans as $laporan) {
            $laporan->notifikasi()->delete();
            $laporan->perbaikan()->delete();
            $laporan->prioritas()->delete();
            $laporan->feedback()->delete();

            $laporan->delete();
        }

        $kategoriKerusakan->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Kategori Kerusakan berhasil dihapus'
            ]);
        }

        return redirect()->route('kategoriKerusakan.index')->with('success', 'Kategori Kerusakan berhasil dihapus');
    }
}
