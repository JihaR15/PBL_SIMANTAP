<?php

namespace App\Http\Controllers;

use App\Models\LaporanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\NotifikasiModel;
use Yajra\DataTables\Facades\DataTables;

class VerifikasiController extends Controller
{
    public function index()
    {
        $activeMenu = 'verifikasi';

        $laporans = LaporanModel::with(['fasilitas', 'unit', 'tempat', 'barangLokasi'])
        ->where('status_verif', 'belum diverifikasi')
        ->get();

        return view('verifikasi.index', [
            'title' => 'Laporan Kerusakan',
            'laporans' => $laporans,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Laporan Kerusakan', 'url' => '/public/verifikasi']
            ]
        ]);
    }

    public function list(Request $request)
    {
        $laporans = LaporanModel::with(['fasilitas', 'unit', 'tempat', 'barangLokasi.jenisBarang'])
            ->select('laporan_id', 'fasilitas_id', 'unit_id', 'tempat_id', 'barang_lokasi_id', 'status_verif', 'created_at')
            ->where('status_verif', 'belum diverifikasi')
            ->get();

        return DataTables::of($laporans)
            ->addIndexColumn()
            ->addColumn('action', function ($laporan) {
                return '<button onclick="modalAction(\'' . url('/verifikasi/' . $laporan->laporan_id . '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>';
            })
            ->addColumn('nama_barang', function ($laporan) {
                return optional($laporan->barangLokasi->jenisBarang)->nama_barang ?? '-';
            })
            ->addColumn('status_verif', function ($laporan) {
                if ($laporan->status_verif === 'belum diverifikasi') {
                    return '<span class="badge bg-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                } elseif ($laporan->status_verif === 'diverifikasi') {
                    return '<span class="badge bg-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                } else {
                    return '<span class="badge bg-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
                }
            })
            ->addColumn('created_at', function ($laporan) {
                return Carbon::parse($laporan->created_at)->format('d M Y');
            })
            ->rawColumns(['action', 'status_verif'])
            ->make(true);
    }

    public function show($laporan_id)
    {
        $laporan = LaporanModel::with([
            'fasilitas', 'unit', 'tempat', 'barangLokasi.jenisBarang',
            'kategoriKerusakan', 'periode'
        ])->findOrFail($laporan_id);

        return view('verifikasi.show', compact('laporan'));
    }

    public function verify($laporan_id)
    {
        $laporan = LaporanModel::findOrFail($laporan_id);
        $laporan->status_verif = 'diverifikasi';
        $laporan->save();

        NotifikasiModel::create([
            'user_id' => $laporan->user_id,
            'laporan_id' => $laporan->laporan_id,
            'isi_notifikasi' => 'Laporan Anda dengan ID #' . $laporan->laporan_id . ' telah diverifikasi.',
            'is_read' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil diverifikasi']);
    }

    public function reject($laporan_id)
    {
        $laporan = LaporanModel::findOrFail($laporan_id);
        $laporan->status_verif = 'ditolak';
        $laporan->save();

        // Buat notifikasi ke user pelapor
        NotifikasiModel::create([
            'user_id' => $laporan->user_id,
            'laporan_id' => $laporan->laporan_id,
            'isi_notifikasi' => 'Laporan Anda dengan ID #' . $laporan->laporan_id . ' telah ditolak.',
            'is_read' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil ditolak']);
    }

    public function riwayatVerifikasi(Request $request)
    {
        if ($request->ajax()) {
            $laporans = LaporanModel::with(['fasilitas', 'unit', 'tempat', 'barangLokasi.jenisBarang'])
                ->select('laporan_id', 'fasilitas_id', 'unit_id', 'tempat_id', 'barang_lokasi_id', 'status_verif', 'created_at')
                ->whereIn('status_verif', ['diverifikasi', 'ditolak'])
                ->orderBy('created_at', 'desc')
                ->get();

            return DataTables::of($laporans)
                ->addIndexColumn()
                ->addColumn('action', function ($laporan) {
                    return '<button onclick="modalAction(\'' . url('/riwayatverifikasi/' . $laporan->laporan_id . '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>';
                })
                ->addColumn('nama_barang', function ($laporan) {
                    return optional($laporan->barangLokasi->jenisBarang)->nama_barang ?? '-';
                })
                ->addColumn('status_verif', function ($laporan) {
                    if ($laporan->status_verif === 'belum diverifikasi') {
                        return '<span class="badge bg-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                    } elseif ($laporan->status_verif === 'diverifikasi') {
                        return '<span class="badge bg-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                    } else {
                        return '<span class="badge bg-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
                    }
                })
                ->addColumn('created_at', function ($laporan) {
                    return \Carbon\Carbon::parse($laporan->created_at)->format('d M Y');
                })
                ->rawColumns(['action', 'status_verif'])
                ->make(true);
        }

        return view('verifikasi.riwayatVerif', [
            'title' => 'Riwayat Verifikasi Laporan',
            'activeMenu' => 'riwayatverifikasi',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Riwayat Verifikasi', 'url' => '/riwayatverifikasi']
            ],
        ]);
    }
}
