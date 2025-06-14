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
use Barryvdh\DomPDF\Facade\Pdf;


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
        $messages = [
            'fasilitas_id.required' => 'Silakan pilih fasilitas terlebih dahulu.',
            'unit_id.required' => 'Silakan pilih unit terlebih dahulu.',
            'tempat_id.required' => 'Silakan pilih tempat terlebih dahulu.',
            'barang_lokasi_id.required' => 'Silakan pilih barang terlebih dahulu.',
            'periode_id.required' => 'Silakan pilih periode terlebih dahulu.',
            'kategori_kerusakan_id.required' => 'Silakan pilih kategori kerusakan terlebih dahulu.',
            'deskripsi.required' => 'Silakan isi deskripsi kerusakan terlebih dahulu.',
            'foto_laporan.image' => 'File harus berupa gambar.',
            'foto_laporan.mimes' => 'Format gambar harus jpeg, png, atau jpg.',
            'foto_laporan.max' => 'Ukuran gambar maksimal 2MB.',
            'jumlah_barang_rusak.required' => 'Silakan masukkan jumlah fasilitas yang rusak.',
            'jumlah_barang_rusak.min' => 'Jumlah fasilitas yang rusak harus lebih dari 0.',
            'jumlah_barang_rusak.max' => 'Jumlah fasilitas yang rusak tidak boleh melebihi jumlah fasilitas yang tersedia.',
        ];

        // Validasi input
        $validated = $request->validate([
            'fasilitas_id' => 'required',
            'unit_id' => 'required',
            'tempat_id' => 'required',
            'barang_lokasi_id' => 'required',
            'jumlah_barang_rusak' => 'required|integer|min:1|max:' . $this->getMaxBarangRusak($request->barang_lokasi_id),
            'periode_id' => 'required',
            'kategori_kerusakan_id' => 'required',
            'deskripsi' => 'required',
            'foto_laporan' => 'image|mimes:jpeg,png,jpg|max:2048',
        ], $messages);

        try {
            $existing = LaporanModel::where('barang_lokasi_id', $validated['barang_lokasi_id'])
                ->where(function ($query) {
                    $query->where('status_verif', 'belum diverifikasi')
                        ->orWhereHas('perbaikan', function ($subQuery) {
                            $subQuery->where('status_perbaikan', '!=', 'selesai');
                        });
                })
                ->exists();

            if ($existing) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Fasilitas ini sudah dilaporkan dan sedang dalam proses verifikasi atau perbaikan.'
                ], 422);
            }

            $laporanData = [
                'user_id' => auth()->id(),
                'fasilitas_id' => $validated['fasilitas_id'],
                'unit_id' => $validated['unit_id'],
                'tempat_id' => $validated['tempat_id'],
                'barang_lokasi_id' => $validated['barang_lokasi_id'],
                'jumlah_barang_rusak' => $validated['jumlah_barang_rusak'],
                'kategori_kerusakan_id' => $validated['kategori_kerusakan_id'],
                'periode_id' => $validated['periode_id'],
                'deskripsi' => $validated['deskripsi'],
                'status_verif' => 'belum diverifikasi',
                'foto_laporan' => null,
            ];

            if ($request->hasFile('foto_laporan')) {
                $file = $request->file('foto_laporan');
                $path = $file->store('uploads', 'public');
                $laporanData['foto_laporan'] = $path;
            }
            $laporan = LaporanModel::create($laporanData);

            $sender_id = auth()->id();
            $usersToNotify = UserModel::whereHas('role', function ($query) {
                $query->whereIn('kode_role', ['ADM', 'SRN']);
            })->get();

            foreach ($usersToNotify as $user) {
                NotifikasiModel::create([
                    'user_id' => $user->user_id,
                    'sender_id' => $sender_id,
                    'laporan_id' => $laporan->laporan_id,
                    'isi_notifikasi' => "Terdapat laporan kerusakan baru dengan ID #{$laporan->laporan_id} dan menunggu verifikasi.",
                    'is_read' => false,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Laporan berhasil dikirim!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan gagal dibuat. Silakan coba lagi.'
            ], 500);
        }
    }

    // untuk mendapatkan jumlah barang yang tersedia
    protected function getMaxBarangRusak($barang_lokasi_id)
    {
        $barangLokasi = BarangLokasiModel::find($barang_lokasi_id);
        return $barangLokasi ? $barangLokasi->jumlah_barang : 0;
    }

    public function list()
    {
        $laporan = LaporanModel::with(['fasilitas', 'unit', 'tempat', 'barangLokasi.jenisBarang'])
            ->select('laporan_id', 'fasilitas_id', 'unit_id', 'tempat_id', 'barang_lokasi_id', 'jumlah_barang_rusak', 'status_verif', 'created_at')
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
                    // return '<span class="badge bg-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                    return '<span class="badge rounded-pill bg-opacity-25 bg-warning text-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                } elseif ($row->status_verif === 'diverifikasi') {
                    // return '<span class="badge bg-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                    return '<span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                } else {
                    // return '<span class="badge bg-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
                    return '<span class="badge rounded-pill bg-opacity-25 bg-danger text-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
                }
            })
            ->addColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('d M Y');
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
        $laporan->formatted_created_at = Carbon::parse($laporan->created_at)->format('d M Y');
        return view('laporan.show', compact('laporan'));
    }

    public function confirmDelete($id)
    {
        $laporan = LaporanModel::findOrFail($id);
        $laporan->formatted_created_at = Carbon::parse($laporan->created_at)->format('d M Y');
        return view('laporan.confirm_delete', compact('laporan'));
    }
    public function destroy($id)
    {
        try {
            $laporan = LaporanModel::findOrFail($id);

            $laporan->notifikasi()->delete();

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
                'message' => 'Terjadi kesalahan saat menghapus laporan.',
                'error' => $e->getMessage()
            ]);
        }
    }

    public function statusPerbaikan(Request $request)
    {
        if ($request->ajax()) {
            $laporans = LaporanModel::with(['fasilitas', 'unit', 'tempat', 'barangLokasi.jenisBarang', 'perbaikan'])
                ->select('laporan_id', 'fasilitas_id', 'unit_id', 'tempat_id', 'barang_lokasi_id', 'created_at', 'jumlah_barang_rusak')
                ->whereHas('perbaikan')
                ->where('user_id', auth()->id())
                ->where('status_verif', 'diverifikasi')
                ->orderBy('created_at', 'asc')
                ->get();

            return DataTables::of($laporans)
                ->addIndexColumn()
                ->addColumn('barang', function ($laporan) {
                    return optional($laporan->barangLokasi->jenisBarang)->nama_barang ?? '-';
                })
                ->addColumn('tempat', function ($laporan) {
                    return optional($laporan->tempat)->nama_tempat ?? '-';
                })
                ->addColumn('unit', function ($laporan) {
                    return optional($laporan->unit)->nama_unit ?? '-';
                })
                ->addColumn('status_perbaikan', function ($laporan) {
                    return $laporan->perbaikan ? $laporan->perbaikan->status_perbaikan : '-';
                })
                ->addColumn('status_perbaikan', function ($laporan) {
                    $status = $laporan->perbaikan->status_perbaikan ?? null;

                    if ($status === 'belum') {
                        // return '<span class="badge bg-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum dikerjakan</span>';
                        return '<span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum dikerjakan</span>';
                    } elseif ($status === 'sedang diperbaiki') {
                        // return '<span class="badge bg-info" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Sedang dikerjakan</span>';
                        return '<span class="badge rounded-pill bg-opacity-25 bg-info text-info" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Sedang dikerjakan</span>';
                    } elseif ($status === 'selesai') {
                        // return '<span class="badge bg-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Selesai</span>';
                        return '<span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Selesai</span>';
                    } else {
                        // return '<span class="badge bg-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">-</span>';
                        return '<span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">-</span>';
                    }
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d M Y');
                })
                ->addColumn('action', function ($laporan) {
                    return '<button onclick="modalAction(\'' . url('/statusperbaikan/' . $laporan->laporan_id . '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>';
                })
                ->rawColumns(['status_perbaikan', 'action'])
                ->make(true);
        }

        return view('laporan.statusPerbaikan', [
            'title' => 'Status Perbaikan',
            'activeMenu' => 'statusperbaikan',
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Status Perbaikan', 'url' => '/statusperbaikan']
            ],
        ]);
    }

    public function showStatusPerbaikan($laporan_id)
    {
        $laporan = LaporanModel::with([
            'fasilitas',
            'unit',
            'tempat',
            'barangLokasi.jenisBarang',
            // 'jumlah_barang_rusak',
            'kategoriKerusakan',
            'periode',
            'perbaikan'
        ])->findOrFail($laporan_id);

        $laporan->formatted_created_at = Carbon::parse($laporan->created_at)->format('d M Y');
        if ($laporan->perbaikan && $laporan->perbaikan->ditugaskan_pada) {
            $laporan->perbaikan->formatted_tanggal_ditugaskan = Carbon::parse($laporan->perbaikan->ditugaskan_pada)->format('d M Y');
        } else {
            $laporan->perbaikan->formatted_tanggal_ditugaskan = null;
        }

        return view('laporan.showStatusPerbaikan', compact('laporan'));
    }

    public function laporanadmin(Request $request)
    {
        ini_set('max_execution_time', 36000);
        // Ambil hanya tahun-tahun dari periode yang punya laporan
        $periodeTahun = PeriodeModel::whereHas('laporan')
            ->pluck('nama_periode')
            ->unique()
            ->sort()
            ->values();

        // Query dasar laporan
        $query = LaporanModel::with([
            'fasilitas',
            'unit',
            'tempat',
            'barangLokasi.jenisBarang',
            'perbaikan.teknisi.user',
            'periode',
            'feedback',
            'verifikator'
        ]);

        // Filter berdasarkan tahun (periode)
        if ($request->filled('tahun')) {
            $query->whereHas('periode', function ($q) use ($request) {
                $q->where('nama_periode', $request->tahun);
            });
        }

        if ($request->status === 'diverifikasi' && $request->filled('status_perbaikan')) {
            $query->whereHas('perbaikan', function ($q) use ($request) {
                $q->where('status_perbaikan', $request->status_perbaikan);
            });
        }

        // Filter berdasarkan status verifikasi
        if ($request->filled('status')) {
            $query->where('status_verif', $request->status);
        }

        // Urutan default
        if ($request->sort_by === 'tempat_asc') {
            $query->orderBy('tempat_id', 'asc');
        } elseif ($request->sort_by === 'tanggal_desc') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort_by === 'tanggal_asc') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('tempat_id', 'asc'); // default
        }

        $laporan = $query->get();

        // Ambil info periode terpilih (optional, untuk ditampilkan di PDF)
        $periode_terpilih = PeriodeModel::where('nama_periode', $request->tahun)->first();


        // ---------- PERHITUNGAN STATISTIK ----------

        $totalLaporan = $laporan->count();

        $jumlahVerif = $laporan->where('status_verif', 'diverifikasi')->count();
        $jumlahTolak = $laporan->where('status_verif', 'ditolak')->count();
        $jumlahBelum = $laporan->where('status_verif', 'belum diverifikasi')->count();

        // Fasilitas yang paling sering dilaporkan
        $fasilitasTerbanyak = $laporan
            ->groupBy(fn($l) => optional($l->barangLokasi->jenisBarang)->nama_barang)
            ->sortByDesc(fn($group) => $group->count())
            ->keys()
            ->first() ?? '-';

        // Tempat yang paling sering dilaporkan
        $tempatTerbanyak = $laporan
            ->groupBy(fn($l) => optional($l->tempat)->nama_tempat)
            ->sortByDesc(fn($group) => $group->count())
            ->keys()
            ->first() ?? '-';

        // Jumlah perbaikan yang selesai
        $jumlahPerbaikanSelesai = $laporan->filter(function ($l) {
            return $l->perbaikan && $l->perbaikan->status_perbaikan === 'selesai';
        })->count();

        // Total biaya perbaikan
        $totalBiaya = $laporan->sum(fn($l) => $l->perbaikan->biaya ?? 0);

        $teknisiStats = $laporan->filter(fn($l) => $l->perbaikan && $l->perbaikan->teknisi)
            ->groupBy(fn($l) => optional($l->perbaikan->teknisi->user)->name)
            ->map(function ($group) {
            $jumlahPerbaikan = $group->count();
            $totalBiayaTeknisi = $group->sum(fn($l) => $l->perbaikan->biaya ?? 0);

            // Ambil semua rating dari feedback
            $allRatings = $group
                ->flatMap(fn($l) => optional($l->feedback)->pluck('rating_id') ?? collect())
                ->filter();

            $avgRating = $allRatings->count() > 0
                ? round($allRatings->avg(), 2)
                : null;

            // Hitung jumlah perbaikan yang selesai
            $jumlahSelesai = $group->filter(function ($l) {
                return $l->perbaikan && $l->perbaikan->status_perbaikan === 'selesai';
            })->count();

            return [
                'jumlah_perbaikan' => $jumlahPerbaikan,
                'total_biaya' => $totalBiayaTeknisi,
                'rata_rata_rating' => $avgRating ?? '-',
                'jumlah_selesai' => $jumlahSelesai,
            ];
            })->sortByDesc('jumlah_perbaikan');

        // Hitung total fasilitas yang ada (dari semua BarangLokasi)
        $totalFasilitasTersedia = BarangLokasiModel::sum('jumlah_barang');

        // Hitung total fasilitas yang rusak (dari laporan sesuai periode yang dipilih, exclude status_verif 'ditolak')
        if ($request->filled('tahun')) {
            $totalFasilitasRusak = LaporanModel::whereHas('periode', function ($q) use ($request) {
                $q->where('nama_periode', $request->tahun);
            })
            ->where('status_verif', '!=', 'ditolak')
            ->sum('jumlah_barang_rusak');
        } else {
            $totalFasilitasRusak = LaporanModel::where('status_verif', '!=', 'ditolak')
            ->sum('jumlah_barang_rusak');
        }

        // Hitung total fasilitas yang sudah diperbaiki (status_perbaikan = 'selesai')
        if ($request->filled('tahun')) {
            $totalFasilitasSudahDiperbaiki = LaporanModel::whereHas('periode', function ($q) use ($request) {
                $q->where('nama_periode', $request->tahun);
            })
            ->where('status_verif', '!=', 'ditolak')
            ->whereHas('perbaikan', function ($q) {
                $q->where('status_perbaikan', 'selesai');
            })
            ->sum('jumlah_barang_rusak');
        } else {
            $totalFasilitasSudahDiperbaiki = LaporanModel::where('status_verif', '!=', 'ditolak')
            ->whereHas('perbaikan', function ($q) {
                $q->where('status_perbaikan', 'selesai');
            })
            ->sum('jumlah_barang_rusak');
        }

        // Hitung total fasilitas yang belum diperbaiki (status_perbaikan != 'selesai')
        if ($request->filled('tahun')) {
            $totalFasilitasBelumDiperbaiki = LaporanModel::whereHas('periode', function ($q) use ($request) {
                $q->where('nama_periode', $request->tahun);
            })
            ->where('status_verif', '!=', 'ditolak')
            ->whereHas('perbaikan', function ($q) {
                $q->where('status_perbaikan', '!=', 'selesai');
            })
            ->sum('jumlah_barang_rusak');
        } else {
            $totalFasilitasBelumDiperbaiki = LaporanModel::where('status_verif', '!=', 'ditolak')
            ->whereHas('perbaikan', function ($q) {
                $q->where('status_perbaikan', '!=', 'selesai');
            })
            ->sum('jumlah_barang_rusak');
        }

        $verifikatorStats = $laporan
            ->whereNotNull('verifikator_id')
            ->groupBy(fn($l) => optional($l->verifikator)->name)
            ->map(function ($group) {
                return [
                    'total_dilaporkan' => $group->count(),
                    'jumlah_diverifikasi' => $group->where('status_verif', 'diverifikasi')->count(),
                    'jumlah_ditolak' => $group->where('status_verif', 'ditolak')->count(),
                ];
            });


        // Kirim ke blade
        $pdf = Pdf::loadView('laporan.laporanadmin', [
            'laporan' => $laporan,
            'periode_terpilih' => $periode_terpilih,
            'status_terpilih' => $request->status,
            'status_perbaikan_terpilih' => $request->status_perbaikan ?? null,

            // Statistik tambahan
            'totalLaporan' => $totalLaporan,
            'jumlahVerif' => $jumlahVerif,
            'jumlahTolak' => $jumlahTolak,
            'jumlahBelum' => $jumlahBelum,
            'fasilitasTerbanyak' => $fasilitasTerbanyak,
            'tempatTerbanyak' => $tempatTerbanyak,
            'jumlahPerbaikanSelesai' => $jumlahPerbaikanSelesai,
            'totalBiaya' => $totalBiaya,

            'teknisiStats' => $teknisiStats,
            'verifikatorStats' => $verifikatorStats,

            'totalFasilitasTersedia' => $totalFasilitasTersedia,
            'totalFasilitasRusak' => $totalFasilitasRusak,
            'totalFasilitasSudahDiperbaiki' => $totalFasilitasSudahDiperbaiki,
            'totalFasilitasBelumDiperbaiki' => $totalFasilitasBelumDiperbaiki,
        ])
            ->setPaper('A4', 'landscape')
            ->setOptions(['defaultFont' => 'sans-serif'])
            ->setOptions([
                'isRemoteEnabled' => true,
                // 'isHtml5ParserEnabled' => true,
            ]);

        return $pdf->stream('Laporan Admin ' . Carbon::now()->format('Y-m-d_H-i-s') . '.pdf');
    }
}
