<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\UnitModel;
use App\Models\FasilitasModel;
use App\Models\TempatModel;
use App\Models\BarangLokasiModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UnitController extends Controller
{
    public function index()
    {
        $activeMenu = 'unit';
        $fasilitas = FasilitasModel::all(); // Untuk filter dropdown
        return view('unit.index', [
            'title' => 'Manajemen Unit',
            'activeMenu' => $activeMenu,
            'fasilitas' => $fasilitas,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Manajemen Unit', 'url' => '/unit']
            ]
        ]);
    }

    public function list(Request $request)
    {
        $unit = UnitModel::select('unit_id', 'nama_unit', 'fasilitas_id', 'created_at', 'updated_at')
            ->with('fasilitas');

        if ($request->fasilitas_id) {
            $unit->where('fasilitas_id', $request->fasilitas_id);
        }

        return DataTables::of($unit)
            ->addIndexColumn()
            ->addColumn('action', function ($unit) {
            if ($unit->fasilitas_id != 2) {
                // Untuk Fasilitas Gedung (Tersedia button edit)
                $detailBtn = '<button onclick="modalAction(\'' . url('/unit/' . $unit->unit_id . '/show') . '\')" class="btn btn-sm btn-primary flex-fill">Detail</button>';
                $editBtn = '<button onclick="modalAction(\'' . url('/unit/' . $unit->unit_id . '/edit') . '\')" class="btn btn-sm btn-warning flex-fill">Edit</button>';
                $deleteBtn = '<button onclick="modalAction(\'' . url('/unit/' . $unit->unit_id . '/delete') . '\')" class="btn btn-sm btn-danger flex-fill">Hapus</button>';
                return '<div class="d-flex gap-1 justify-content-center" style="min-width:180px;">' . $detailBtn . $editBtn . $deleteBtn . '</div>';
            } else {
                // Untuk Fasum (Button edit tidak tersedia)
                $detailBtn = '<button onclick="modalAction(\'' . url('/unit/' . $unit->unit_id . '/show') . '\')" class="btn btn-sm btn-primary w-50">Detail</button>';
                $deleteBtn = '<button onclick="modalAction(\'' . url('/unit/' . $unit->unit_id . '/delete') . '\')" class="btn btn-sm btn-danger w-50">Hapus</button>';
                return '<div class="d-flex gap-1 justify-content-center" style="min-width:180px;">' . $detailBtn . '</div>';
    }
            })
            ->addColumn('tempat', function ($unit) {
                return '<button onclick="modalAction(\'' . url('/tempat/' . $unit->unit_id . '/popup') . '\')" class="btn btn-sm btn-success">Kelola Ruang</button>';
            })
            ->rawColumns(['action', 'tempat'])
            ->make(true);
    }

    public function create()
    {
        $fasilitas = FasilitasModel::all();
        $fasumExist = UnitModel::where('fasilitas_id', 2)->exists();
        return view('unit.create', compact('fasilitas', 'fasumExist'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_unit' => 'required|unique:m_unit,nama_unit',
            'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        // Cek apakah Fasilitas Umum ada di database
        if ($request->fasilitas_id == 2) {
            $exist = UnitModel::where('fasilitas_id', 2)->exists();
            if ($exist) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unit dengan Fasilitas Umum sudah ada, tidak bisa menambah lagi.',
                    'msgField' => ['fasilitas_id' => ['Unit Fasilitas Umum sudah ada.']]
                ]);
            }
        }

        $unit = new UnitModel();
        $unit->nama_unit = $request->nama_unit;
        $unit->fasilitas_id = $request->fasilitas_id;
        $unit->save();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Unit berhasil dibuat.',
                'data' => $unit
            ]);
        }
        return redirect()->route('unit.index')->with('success', 'Unit berhasil dibuat.');
    }

    public function show($id)
    {
        $unit = UnitModel::with('fasilitas')->findOrFail($id);
        return view('unit.show', compact('unit'));
    }

    public function edit($id)
    {
        $unit = UnitModel::findOrFail($id);
        $fasilitas = FasilitasModel::all();
        return view('unit.edit', compact('unit', 'fasilitas'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_unit' => 'required|unique:m_unit,nama_unit,' . $id . ',unit_id',
            'fasilitas_id' => 'required|exists:m_fasilitas,fasilitas_id|not_in:2',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $unit = UnitModel::findOrFail($id);
        $unit->nama_unit = $request->nama_unit;
        $unit->fasilitas_id = $request->fasilitas_id;
        $unit->save();
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Unit berhasil diperbarui.',
                'data' => $unit
            ]);
        }
        return redirect()->route('unit.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        $unit = UnitModel::findOrFail($id);
        return view('unit.confirm_delete', compact('unit'));
    }

    public function destroy($id)
    {
        // Hapus tempat yang ada di dalam unit yang akan dihapus
        $tempat = TempatModel::where('unit_id', $id);
        $tempat->delete();

        // Hapus unit
        $unit = UnitModel::findOrFail($id);
        $unit->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Unit berhasil dihapus.'
            ]);
        }
        return redirect()->route('unit.index')->with('success', 'Unit berhasil dihapus.');
    }
}