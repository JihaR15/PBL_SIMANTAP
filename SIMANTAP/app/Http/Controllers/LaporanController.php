<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\UnitModel;
use App\Models\UserModel;
use App\Models\TempatModel;
use App\Models\LaporanModel;
use App\Models\PeriodeModel;
use Illuminate\Http\Request;
use App\Models\FasilitasModel;
use App\Models\NotifikasiModel;
use App\Models\BarangLokasiModel;
use App\Models\KategoriKerusakanModel;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index()
    {
        $activeMenu = 'laporan';
        $fasilitas = FasilitasModel::all();
        $unit = UnitModel::all();
        $tempat = TempatModel::all();
        $barangLokasi = BarangLokasiModel::all();
        return view('laporan.index', [
            'title' => 'Form Laporan Kerusakan',
            'activeMenu' => $activeMenu,
            'fasilitas' => $fasilitas,
            'unit' => $unit,
            'tempat' => $tempat,
            'barangLokasi' => $barangLokasi,
            'periode' => PeriodeModel::all(),
            'kategoriKerusakan' => KategoriKerusakanModel::all(),
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Buat Laporan', 'url' => '/public/laporan']
            ]

        ]);
    }


    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'fasilitas_id' => 'required',
            'unit_id' => 'required',
            'tempat_id' => 'required',
            'barang_lokasi_id' => 'required',
            'periode_id' => 'required',
            'kategori_kerusakan_id' => 'required',
            'deskripsi' => 'required',
            'file' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi file gambar
        ]);

        try {
            // Simpan data laporan ke database
            $laporanData = [
                'user_id' => auth()->id(),
                'fasilitas_id' => $validated['fasilitas_id'],
                'unit_id' => $validated['unit_id'],
                'tempat_id' => $validated['tempat_id'],
                'barang_lokasi_id' => $validated['barang_lokasi_id'],
                'kategori_kerusakan_id' => $validated['kategori_kerusakan_id'],
                'periode_id' => $validated['periode_id'],
                'deskripsi' => $validated['deskripsi'],
                'status_verif' => 'belum diverifikasi',
            ];

            // Simpan file jika ada
            if ($request->hasFile('foto_laporan')) {
                $file = $request->file('foto_laporan');
                $path = $file->store('uploads', 'public'); // Simpan file di folder 'uploads'
                $laporanData['foto_laporan'] = $path; // Tambahkan path file ke data laporan
            }

            // Buat laporan dan simpan
            $laporan = LaporanModel::create($laporanData);

            $usersToNotify = UserModel::whereHas('role', function ($query) {
                $query->whereIn('kode_role', ['ADM', 'SRN']);
            })->get();

            foreach ($usersToNotify as $user) {
                NotifikasiModel::create([
                    'user_id' => $user->user_id,
                    'laporan_id' => $laporan->laporan_id,
                    'isi_notifikasi' => "Laporan baru dengan ID #{$laporan->laporan_id} telah dibuat dan menunggu verifikasi.",
                    'is_read' => false,
                ]);
            }

            // Kembalikan respons sukses
            return redirect()->back()->with('success', 'Laporan berhasil dibuat.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menyimpan data
            return redirect()->back()->with('error', 'Laporan gagal dibuat. Silakan coba lagi.');
        }
    }

    public function list()
    {
        $laporan = LaporanModel::with(['fasilitas', 'unit', 'tempat', 'barangLokasi.jenisBarang'])
            ->select('laporan_id', 'fasilitas_id', 'unit_id', 'tempat_id', 'barang_lokasi_id', 'status_verif', 'created_at')
            ->where('user_id', auth()->id())
            ->get();

        return datatables()->of($laporan)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<button onclick="modalAction(\'' . route('laporan.show', $row->laporan_id) . '\')" class="btn btn-sm btn-primary">Detail</button>' .
                    ($row->status_verif === 'belum diverifikasi'
                        ? '<button onclick="modalAction(\'' . route('laporan.confirmDelete', $row->laporan_id) . '\')" class="btn btn-sm btn-danger ms-1">Delete</button>'
                        : '');
            })
            ->addColumn('nama_barang', function ($row) {
                return optional($row->barangLokasi->jenisBarang)->nama_barang ?? '-';
            })
            ->addColumn('status_verif', function ($row) {
                if ($row->status_verif === 'belum diverifikasi') {
                    return '<span class="badge bg-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                } elseif ($row->status_verif === 'diverifikasi') {
                    return '<span class="badge bg-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                } else {
                    return '<span class="badge bg-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
                }
            })
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d M Y'); // Format tanggal
            })
            ->rawColumns(['action', 'status_verif'])
            ->make(true);
    }

    public function riwayatLaporan()
    {
        $activeMenu = 'riwayatlaporan';
        // Ambil semua laporan milik pengguna yang sedang login
        $laporan = LaporanModel::with(['fasilitas', 'unit', 'tempat', 'barangLokasi'])
            ->where('user_id', auth()->id())
            ->get();

        return view('laporan.riwayatlaporan', [
            'title' => 'Riwayat Laporan',
            'activeMenu' => $activeMenu,
            'laporan' => $laporan,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Riwayat Laporan', 'url' => '/public/laporan/riwayat']
            ]
        ]);
    }
    public function show($id)
    {
        $laporan = LaporanModel::findOrFail($id);
        $laporan->formatted_created_at = Carbon::parse($laporan->created_at)->translatedFormat('d F Y, H:i'); // contoh: 14 Mei 2025, 13:45
        return view('laporan.show', compact('laporan'));
    }

    public function confirmDelete($id)
    {
        $laporan = LaporanModel::findOrFail($id);
        $laporan->formatted_created_at = Carbon::parse($laporan->created_at)->translatedFormat('d F Y, H:i'); // contoh: 14 Mei 2025, 13:45
        return view('laporan.confirm_delete', compact('laporan'));
    }
    public function destroy($id)
    {
        try {
        $laporan = LaporanModel::findOrFail($id);

        // Hapus file jika ada
        if ($laporan->foto_laporan && Storage::exists('public/' . $laporan->foto_laporan)) {
            Storage::delete('public/' . $laporan->foto_laporan);
        }

        // Hapus laporan
        $laporan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Laporan berhasil dihapus.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan saat menghapus laporan.'
        ]);
    }
    }
}
