<?php

namespace App\Http\Controllers;

use App\Models\LaporanModel;
use Illuminate\Http\Request;
use App\Models\JenisBarangModel;
use App\Models\BarangLokasiModel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JenisBarangController extends Controller
{
    public function index()
    {
        $activeMenu = 'jenisbarang';
        $jenisbarang = JenisBarangModel::all();
        return view('jenisbarang.index', [
            'title' => 'Manajemen Barang',
            'jenisbarang' => $jenisbarang,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Manajemen Fasilitas', 'url' => '/public/barang']
            ]

        ]);
    }

    public function list(Request $request)
    {
        $jenisbarang = JenisBarangModel::select('jenis_barang_id', 'nama_barang', 'created_at', 'updated_at');

        return DataTables::of($jenisbarang)
            ->addIndexColumn()
            ->addColumn('action', function ($jenisbarang) {
                return '<button onclick="modalAction(\'' . url('/jenisbarang/' . $jenisbarang->jenis_barang_id . '/show') . '\')"class="btn btn-sm btn-primary">Detail</button>
                <button onclick="modalAction(\'' . url('/jenisbarang/' . $jenisbarang->jenis_barang_id . '/edit') . '\')"class="btn btn-sm btn-warning">Edit</button>
                <button onclick="modalAction(\'' . url('/jenisbarang/' . $jenisbarang->jenis_barang_id . '/delete') .  '\')"class="btn btn-sm btn-danger">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $jenisbarang = JenisBarangModel::all();
        return view('jenisbarang.create', compact('jenisbarang'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_barang' => 'required|unique:m_jenis_barang,nama_barang',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $jenisbarang = new JenisBarangModel();
        $jenisbarang->nama_barang = $request->nama_barang;
        $jenisbarang->save();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Jenis Barang Berhasil dibuat.',
                'data' => $jenisbarang
            ]);
        }
        return redirect()->route('jenisbarang.index')->with('success', 'Jenis Barang Berhasil dibuat.');
    }

    public function show($id)
    {
        $jenisbarang = JenisBarangModel::findOrFail($id);
        return view('jenisbarang.show', compact('jenisbarang'));
    }

    public function edit($id)
    {
        $jenisbarang = JenisBarangModel::findOrFail($id);
        return view('jenisbarang.edit', compact('jenisbarang'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_barang' => 'required|unique:m_jenis_barang,nama_barang,' . $id . ',jenis_barang_id',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $jenisbarang = JenisBarangModel::findOrFail($id);
        $jenisbarang->nama_barang = $request->nama_barang;
        $jenisbarang->save();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Jenis Barang Berhasil diperbarui.',
                'data' => $jenisbarang
            ]);
        }
        return redirect()->route('jenisbarang.index')->with('success', 'Jenis Barang Berhasil diperbarui.');
    }

    public function confirmDelete($id)
    {
        $jenisbarang = JenisBarangModel::findOrFail($id);
        return view('jenisbarang.confirmDelete', compact('jenisbarang'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $jenisbarang = JenisBarangModel::findOrFail($id);
            $barangLokasi = BarangLokasiModel::where('jenis_barang_id', $id)->get();
            $laporans = LaporanModel::whereIn('barang_lokasi_id', $barangLokasi->pluck('barang_lokasi_id'))->get();

            // hapus semua notifikasi
            foreach ($laporans as $laporan) {
                $laporan->notifikasi()->delete();
            }

            // hapus perbaikan
            foreach ($laporans as $laporan) {
                $laporan->perbaikan()->delete();
            }

            // hapus prioritas
            foreach ($laporans as $laporan) {
                $laporan->prioritas()->delete();
            }

            // hapus laporan & feedback
            foreach ($laporans as $laporan) {
                $laporan->feedback()->delete();
                $laporan->delete();
            }

            // hapus di barang lokasi
            foreach ($barangLokasi as $barang) {
                $barang->delete();
            }


            // hapus jenis barang
            $jenisbarang->delete();

            DB::commit();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Jenis Barang Berhasil dihapus.'
                ]);
            }

            return redirect()->route('jenisbarang.index')->with('success', 'Jenis Barang Berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('jenisbarang.index')->with('error', 'Terjadi kesalahan saat menghapus jenis barang: ' . $e->getMessage());
        }
    }

}
