<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LaporanModel;
use App\Models\PerbaikanModel;
use App\Models\UnitModel;
use App\Models\TempatModel;
use App\Models\FasilitasModel;
use App\Models\JenisBarangModel;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{

    public function landing()
    {
        $activeMenu = 'landing';
        $userCount = UserModel::count();
        $laporanCount = LaporanModel::count();
        $perbaikanCount = PerbaikanModel::count();
        return view('landing', [
            'title' => 'Selamat Datang di SIMANTAP',
            'activeMenu' => $activeMenu,
            'userCount' => $userCount,
            'laporanCount' => $laporanCount,
            'perbaikanCount' => $perbaikanCount,
            'breadcrumbs' => [
                ['label' => 'Landing']
            ]
        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        $activeMenu = 'dashboard';

        $teknisiCount = UserModel::whereHas('role', function ($q) {
            $q->where('kode_role', 'TKS');
        })->count();



        $periodeTahun = LaporanModel::with('periode')
            ->get()
            ->pluck('periode.nama_periode')
            ->unique()
            ->sort()
            ->values();

        // Tahun terpilih (default: tahun sekarang)
        $tahunDipilih = request('tahun', now()->year);

        // Hitung data sesuai tahun terpilih
        $laporanCount = LaporanModel::whereHas('periode', function ($q) use ($tahunDipilih) {
            $q->where('nama_periode', $tahunDipilih);
        })->count();

        $laporanBelumDiverifikasiCount = LaporanModel::where('status_verif', 'belum diverifikasi')
            ->whereHas('periode', function ($q) use ($tahunDipilih) {
                $q->where('nama_periode', $tahunDipilih);
            })->count();

        $laporanDiverifikasiCount = LaporanModel::where('status_verif', 'diverifikasi')
            ->whereHas('periode', function ($q) use ($tahunDipilih) {
                $q->where('nama_periode', $tahunDipilih);
            })->count();

        $laporanDitolakCount = LaporanModel::where('status_verif', 'ditolak')
            ->whereHas('periode', function ($q) use ($tahunDipilih) {
                $q->where('nama_periode', $tahunDipilih);
            })->count();

        $perbaikanCount = PerbaikanModel::whereHas('laporan.periode', function ($q) use ($tahunDipilih) {
            $q->where('nama_periode', $tahunDipilih);
        })->count();

        $perbaikanBelumCount = PerbaikanModel::where('status_perbaikan', 'belum')
            ->whereHas('laporan.periode', function ($q) use ($tahunDipilih) {
            $q->where('nama_periode', $tahunDipilih);
            })->count();

        $perbaikanSelesaiCount = PerbaikanModel::where('status_perbaikan', 'selesai')
            ->whereHas('laporan.periode', function ($q) use ($tahunDipilih) {
            $q->where('nama_periode', $tahunDipilih);
            })->count();

        $perbaikanBerjalanCount = PerbaikanModel::where('status_perbaikan', 'sedang diperbaiki')
            ->whereHas('laporan.periode', function ($q) use ($tahunDipilih) {
            $q->where('nama_periode', $tahunDipilih);
            })->count();


        $topBarang = JenisBarangModel::select(
            'm_jenis_barang.nama_barang',
            DB::raw('COUNT(t_laporan.laporan_id) as jumlah_laporan')
        )
            ->join('m_barang_lokasi', 'm_barang_lokasi.jenis_barang_id', '=', 'm_jenis_barang.jenis_barang_id')
            ->join('t_laporan', 't_laporan.barang_lokasi_id', '=', 'm_barang_lokasi.barang_lokasi_id')
            ->groupBy('m_jenis_barang.jenis_barang_id', 'm_jenis_barang.nama_barang')
            ->orderByDesc('jumlah_laporan')
            ->take(3)
            ->get();

        $topTempat =  LaporanModel::select('unit_id', 'tempat_id', DB::raw('COUNT(*) as jumlah_laporan'))
            ->with(['unit', 'tempat'])
            ->groupBy('unit_id', 'tempat_id')
            ->orderByDesc('jumlah_laporan')
            ->limit(3)
            ->get();

        return view('welcome', [
            'user' => $user,
            'teknisiCount' => $teknisiCount,
            'teknisiTerbaru' => UserModel::whereHas('role', function ($q) {
                $q->where('kode_role', 'TKS');
            })->latest('created_at')->first(),
            'userCount' => UserModel::count(),
            'laporan' => LaporanModel::count(),
            'laporanTerbaru' => LaporanModel::latest('created_at')->first(),
            'laporanDiverifikasiCount' => $laporanDiverifikasiCount,
            'laporanBelumDiverifikasiCount' => $laporanBelumDiverifikasiCount,
            'laporanDitolakCount' => $laporanDitolakCount,
            'perbaikanTerbaru' => PerbaikanModel::latest('created_at')->first(),
            'laporanCount' => $laporanCount,
            'perbaikan' => PerbaikanModel::count(),
            'perbaikanCount' => $perbaikanCount,
            'perbaikanBelumCount' => $perbaikanBelumCount,
            'perbaikanSelesaiCount' => $perbaikanSelesaiCount,
            'perbaikanBerjalanCount' => $perbaikanBerjalanCount,
            'periodeTahun' => $periodeTahun,
            'tahunDipilih' => $tahunDipilih,
            'unitTerbaru' => UnitModel::latest('created_at')->first(),
            'unitCount' => UnitModel::count(),
            'tempatTerbaru' => TempatModel::latest('created_at')->first(),
            'tempatCount' => TempatModel::count(),
            'topBarang' => $topBarang,
            'topTempat' => $topTempat,
            'title' => 'Dashboard',
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                // ['label' => 'SIMANTAP'],
                // ['label' => 'Dashboard']
                ['label' => 'Simantap', 'url' => '/dashboard'],
                ['label' => 'Dashboard']
            ]
        ]);
    }


    public function chartData(Request $request)
    {

        $tahun = $request->get('tahun', now()->year);

        $query = LaporanModel::query();

        if ($tahun !== 'all') {
            $query->whereHas('periode', function ($q) use ($tahun) {
                $q->where('nama_periode', $tahun);
            });
        }

        $laporanCount = (clone $query)->count();
        $laporanBelumDiverifikasiCount = (clone $query)->where('status_verif', 'belum diverifikasi')->count();
        $laporanDiverifikasiCount = (clone $query)->where('status_verif', 'diverifikasi')->count();
        $laporanDitolakCount = (clone $query)->where('status_verif', 'ditolak')->count();

        return response()->json([
            'laporanCount' => $laporanCount,
            'laporanDiverifikasiCount' => $laporanDiverifikasiCount,
            'laporanBelumDiverifikasiCount' => $laporanBelumDiverifikasiCount,
            'laporanDitolakCount' => $laporanDitolakCount,
        ]);
    }

    public function chartData2(Request $request)
    {

        $tahun = $request->get('tahun', now()->year);

        $query = PerbaikanModel::query();

        if ($tahun !== 'all') {
            $query->whereHas('laporan.periode', function ($q) use ($tahun) {
            $q->where('nama_periode', $tahun);
            });
        }

        $perbaikanCount = (clone $query)->count();
        $perbaikanBelumCount = (clone $query)->where('status_perbaikan', 'belum')->count();
        $perbaikanSelesaiCount = (clone $query)->where('status_perbaikan', 'selesai')->count();
        $perbaikanBerjalanCount = (clone $query)->where('status_perbaikan', 'sedang diperbaiki')->count();

        return response()->json([
            'perbaikanCount' => $perbaikanCount,
            'perbaikanBelumCount' => $perbaikanBelumCount,
            'perbaikanSelesaiCount' => $perbaikanSelesaiCount,
            'perbaikanBerjalanCount' => $perbaikanBerjalanCount,
        ]);
    }
}
