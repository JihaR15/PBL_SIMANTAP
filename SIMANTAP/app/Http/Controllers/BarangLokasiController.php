<?php

namespace App\Http\Controllers;

use App\Models\UnitModel;
use App\Models\TempatModel;
use App\Models\LaporanModel;
use Illuminate\Http\Request;
use App\Models\JenisBarangModel;
use App\Models\BarangLokasiModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class BarangLokasiController extends Controller
{
    public function index()
    {
        $activeMenu = 'lokasibarang';

        $tempat = TempatModel::all();
        $unit = UnitModel::all();
        return view('lokasibarang.index', [
            'title' => 'Manajemen Fasilitas',
            'tempat' => $tempat,
            'unit' => $unit,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Manajemen Fasilitas', 'url' => '/public/fasilitas']
            ]

        ]);
    }

    public function list(Request $request)
    {
        $lokasibarang = TempatModel::select('tempat_id', 'unit_id', 'nama_tempat', 'created_at', 'updated_at')->with('unit');

        // filter berdasarkan unit_id
        if ($request->unit_id) {
            $lokasibarang->where('unit_id', $request->unit_id);
        }

        return DataTables::of($lokasibarang)
            ->addIndexColumn()
            ->addColumn('action', function ($lokasibarang) {
                // return '<a href="' . url('/lokasibarang/' . $lokasibarang->tempat_id . '/show') . '" class="btn btn-sm btn-primary">Kelola Fasilitas</a>';
                return '<button onclick="modalAction(\'' . url('/lokasibarang/' . $lokasibarang->tempat_id . '/show') . '\')"class="btn btn-sm btn-primary">Kelola Fasilitas</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function show($tempat_id)
    {
        $tempat = TempatModel::findOrFail($tempat_id);
        $barangLokasi = BarangLokasiModel::with('jenisBarang')
                        ->where('tempat_id', $tempat_id)
                        ->get();

        $semuaJenisBarang = JenisBarangModel::all();

        return view('lokasibarang.show', [
            'tempat_id' => $tempat_id,
            'tempat' => $tempat,
            'barangLokasi' => $barangLokasi,
            'semuaJenisBarang' => $semuaJenisBarang,
        ]);
    }

    public function create($tempat_id)
    {
        $tempat = TempatModel::findOrFail($tempat_id);
        $semuaJenisBarang = JenisBarangModel::all();

        return view('lokasibarang.create', [
            'tempat' => $tempat,
            'semuaJenisBarang' => $semuaJenisBarang,
            'tempat_id' => $tempat_id
        ]);
    }

    public function store(Request $request, $tempat_id)
    {
        $validator = Validator::make($request->all(), [
            'jenis_barang_id' => 'required|array',
            'jenis_barang_id.*' => 'exists:m_jenis_barang,jenis_barang_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $tempat = TempatModel::findOrFail($tempat_id);

        foreach ($request->jenis_barang_id as $jenis_barang_id) {
            $barang = JenisBarangModel::findOrFail($jenis_barang_id);

            $barangLokasi = new BarangLokasiModel();
            $barangLokasi->tempat_id = $tempat_id;
            $barangLokasi->jenis_barang_id = $jenis_barang_id;
            $barangLokasi->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Fasilitas berhasil ditambahkan di Lokasi ' . $tempat->nama_tempat,
            'redirect' => route('lokasibarang.index')
        ]);
    }

    public function updateJumlah(Request $request, $barang_lokasi_id)
    {
        $request->validate([
            'jumlah_barang' => 'required|integer|min:0',
        ]);

        $barangLokasi = BarangLokasiModel::findOrFail($barang_lokasi_id);

        // Update jumlah barang
        $barangLokasi->jumlah_barang = $request->jumlah_barang;
        $barangLokasi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Jumlah barang berhasil diperbarui'
        ]);
    }

    public function confirmDelete($tempat_id, $jenis_barang_id)
    {
        $tempat = TempatModel::findOrFail($tempat_id);
        $barang = BarangLokasiModel::where('tempat_id', $tempat_id)
                                    ->where('jenis_barang_id', $jenis_barang_id)
                                    ->first();

        if ($barang) {
            return view('lokasibarang.confirmDelete', [
                'tempat' => $tempat,
                'barang' => $barang
            ]);
        }

        return redirect()->route('lokasibarang.index');
    }

    // menghapus barang
    public function delete(Request $request, $tempat_id, $jenis_barang_id)
    {
        $tempat = TempatModel::findOrFail($tempat_id);
        $namabrg = JenisBarangModel::findOrFail($jenis_barang_id);
        $barang = BarangLokasiModel::where('tempat_id', $tempat_id)
                                    ->where('jenis_barang_id', $jenis_barang_id)
                                    ->first();

        if ($barang) {
            // hapus semua relasi yang terkait
            $laporans = LaporanModel::where('barang_lokasi_id', $barang->barang_lokasi_id)->get();
            foreach ($laporans as $laporan) {
                $laporan->notifikasi()->delete();
                $laporan->perbaikan()->delete();
                $laporan->prioritas()->delete();
                $laporan->feedback()->delete();
                $laporan->delete();
            }
            $barang->delete();

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Fasilitas ' . $namabrg->nama_barang . ' berhasil dihapus dari Lokasi ' . $tempat->nama_tempat,
                ]);
            }

            return redirect()->route('lokasibarang.index')->with('success', 'Fasilitas berhasil dihapus');
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Fasilitas ' . $namabrg->nama_barang . ' tidak ditemukan di Lokasi ' . $tempat->nama_tempat,
            ], 404);
        }

        return redirect()->route('lokasibarang.index');
    }
}
