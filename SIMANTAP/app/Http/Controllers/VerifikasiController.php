<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\BobotModel;
use App\Models\LaporanModel;
use App\Models\TeknisiModel;
use Illuminate\Http\Request;
use App\Models\PerbaikanModel;
use App\Models\PrioritasModel;
use Illuminate\Support\Carbon;
use App\Models\NotifikasiModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

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
            ->select('laporan_id', 'fasilitas_id', 'unit_id', 'tempat_id', 'barang_lokasi_id', 'jumlah_barang_rusak', 'status_verif', 'created_at')
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
                    // return '<span class="badge bg-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                    return '<span class="badge rounded-pill bg-opacity-25 bg-warning text-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                } elseif ($laporan->status_verif === 'diverifikasi') {
                    // return '<span class="badge bg-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                    return '<span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                } else {
                    // return '<span class="badge bg-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
                    return '<span class="badge rounded-pill bg-opacity-25 bg-danger text-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
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
            'fasilitas',
            'unit',
            'tempat',
            'barangLokasi.jenisBarang',
            'kategoriKerusakan',
            'periode'
        ])->findOrFail($laporan_id);

        $laporan->formatted_created_at = $laporan->created_at->format('d M Y');

        return view('verifikasi.show', compact('laporan'));
    }

    public function showPrioritas($laporan_id)
    {
        $laporan = LaporanModel::findOrFail($laporan_id);
        $teknisi = TeknisiModel::with(['user', 'jenis_teknisi'])->get();

        return view('verifikasi.prioritas', compact('laporan', 'teknisi'));
    }

    public function verify(Request $request, $laporan_id)
    {
        $laporan = LaporanModel::findOrFail($laporan_id);
        if ($laporan->status_verif === 'diverifikasi') {
            return response()->json([
                'success' => false,
                'message' => 'Laporan sudah diverifikasi oleh pengguna lain. Refresh halaman Anda untuk memperbarui data.',
            ], 400);
        }

        $request->validate([
            'teknisi_id' => 'required|exists:m_teknisi,teknisi_id',
            'tingkat_kerusakan' => 'required|integer|min:1|max:5',
            'dampak_terhadap_aktivitas_akademik' => 'required|integer|min:1|max:5',
            'frekuensi_penggunaan_fasilitas' => 'required|integer|min:1|max:5',
            'ketersediaan_barang_pengganti' => 'required|integer|min:1|max:5',
            'tingkat_risiko_keselamatan' => 'required|integer|min:1|max:5',
        ]);

        $bobotRows = BobotModel::all();
        $map = [
            'Tingkat Kerusakan' => 'tingkat_kerusakan',
            'Dampak Terhadap Aktivitas Akademik' => 'dampak_terhadap_aktivitas_akademik',
            'Frekuensi Penggunaan Fasilitas' => 'frekuensi_penggunaan_fasilitas',
            'Ketersediaan Barang Pengganti' => 'ketersediaan_barang_pengganti',
            'Tingkat Resiko Keselamatan' => 'tingkat_risiko_keselamatan',
        ];

        $bobot = [];
        foreach ($bobotRows as $row) {
            if (isset($map[$row->nama_parameter])) {
                $key = $map[$row->nama_parameter];
                $bobot[$key] = floatval($row->bobot);
            }
        }
        // dump('Bobot: ' . json_encode($bobot));

        // validasi bobot
        $requiredKeys = array_values($map);
        foreach ($requiredKeys as $key) {
            if (!isset($bobot[$key])) {
                return response()->json([
                    'success' => false,
                    'message' => "Bobot untuk parameter '$key' belum tersedia di database.",
                ], 400);
            }
        }

        // simpan prioritas
        PrioritasModel::updateOrCreate(
            ['laporan_id' => $laporan_id],
            [
                'tingkat_kerusakan' => $request->tingkat_kerusakan,
                'dampak_terhadap_aktivitas_akademik' => $request->dampak_terhadap_aktivitas_akademik,
                'frekuensi_penggunaan_fasilitas' => $request->frekuensi_penggunaan_fasilitas,
                'ketersediaan_barang_pengganti' => $request->ketersediaan_barang_pengganti,
                'tingkat_risiko_keselamatan' => $request->tingkat_risiko_keselamatan,
            ]
        );

        // ambil semua prioritas yang laporan & perbaikan belum selesai untuk TOPSIS
        $allPrioritas = PrioritasModel::whereHas('laporan.perbaikan', function ($q) {
            $q->where('status_perbaikan', '!=', 'selesai');
        })->orWhereDoesntHave('laporan.perbaikan')->get();

        // tipe kriteria benefit atau cost
        $tipeKriteria = [
            'tingkat_kerusakan' => 'benefit',
            'dampak_terhadap_aktivitas_akademik' => 'benefit',
            'frekuensi_penggunaan_fasilitas' => 'benefit',
            'ketersediaan_barang_pengganti' => 'cost',
            'tingkat_risiko_keselamatan' => 'benefit',
        ];

        // dump data prioritas
        $dataPrioritasDump = [];
        foreach ($allPrioritas as $p) {
            $dataPrioritasDump[$p->laporan_id] = [
                'tingkat_kerusakan' => $p->tingkat_kerusakan,
                'dampak_terhadap_aktivitas_akademik' => $p->dampak_terhadap_aktivitas_akademik,
                'frekuensi_penggunaan_fasilitas' => $p->frekuensi_penggunaan_fasilitas,
                'ketersediaan_barang_pengganti' => $p->ketersediaan_barang_pengganti,
                'tingkat_risiko_keselamatan' => $p->tingkat_risiko_keselamatan,
            ];
        }
        // dump('Data Prioritas: ' . json_encode($dataPrioritasDump));

        // data cuma 1, gunakan weighted sum sederhana sebagai nilai topsis
        if ($allPrioritas->count() == 1) {
            $p = $allPrioritas->first();

            $skor = (
                $p->tingkat_kerusakan * $bobot['tingkat_kerusakan'] +
                $p->dampak_terhadap_aktivitas_akademik * $bobot['dampak_terhadap_aktivitas_akademik'] +
                $p->frekuensi_penggunaan_fasilitas * $bobot['frekuensi_penggunaan_fasilitas'] +
                $p->ketersediaan_barang_pengganti * $bobot['ketersediaan_barang_pengganti'] +
                $p->tingkat_risiko_keselamatan * $bobot['tingkat_risiko_keselamatan']
            );

            $nilaiTopsis = $skor / 5;
            // dump("Single data, skor weighted sum: $skor, nilai TOPSIS: $nilaiTopsis");

            PrioritasModel::updateOrCreate(
                ['laporan_id' => $laporan_id],
                [
                    'jarak_positif' => 0,
                    'jarak_negatif' => 0,
                    'nilai_topsis' => $nilaiTopsis,
                    'klasifikasi_urgensi' => $this->klasifikasiUrgensi($nilaiTopsis),
                ]
            );
        } else {
            // menghitung akar jumlah kuadrat tiap kriteria
            $sumSquares = array_fill_keys(array_keys($bobot), 0);
            foreach ($allPrioritas as $p) {
                foreach ($bobot as $kriteria => $w) {
                    $sumSquares[$kriteria] += pow($p->$kriteria, 2);
                }
            }
            foreach ($sumSquares as $key => $val) {
                $sumSquares[$key] = sqrt($val);
                if ($sumSquares[$key] == 0) $sumSquares[$key] = 1;
            }
            // dump('SumSquares (akar jumlah kuadrat): ' . json_encode($sumSquares));

            // normalisasi & bobot
            $allMatriksTerbobot = [];
            foreach ($allPrioritas as $p) {
                $normalisasi = [];
                foreach ($bobot as $kriteria => $w) {
                    $normalisasi[$kriteria] = $p->$kriteria / $sumSquares[$kriteria];
                }
                $terbobot = [];
                foreach ($normalisasi as $k => $v) {
                    $terbobot[$k] = $v * $bobot[$k];
                }
                $allMatriksTerbobot[$p->laporan_id] = $terbobot;
            }
            // dump('Matriks Terbobot Normalisasi: ' . json_encode($allMatriksTerbobot));

            // solusi ideal positif & negatif
            $Apositif = [];
            $Anegatif = [];
            foreach ($bobot as $kriteria => $w) {
                $values = array_column($allMatriksTerbobot, $kriteria);
                if ($tipeKriteria[$kriteria] === 'benefit') {
                    $Apositif[$kriteria] = max($values);
                    $Anegatif[$kriteria] = min($values);
                } else { // cost
                    $Apositif[$kriteria] = min($values);
                    $Anegatif[$kriteria] = max($values);
                }
            }
            // dump('Solusi Ideal Positif: ' . json_encode($Apositif));
            // dump('Solusi Ideal Negatif: ' . json_encode($Anegatif));

            // hitung jarak Euclidean dari solusi ideal positif dan negatif untuk semua laporan yang perbaikannya belum selesai
            foreach ($allMatriksTerbobot as $lapId => $matriksTerbobotTarget) {
                $jarakPositif = 0;
                $jarakNegatif = 0;
                foreach ($matriksTerbobotTarget as $k => $v) {
                    $jarakPositif += pow($v - $Apositif[$k], 2);
                    $jarakNegatif += pow($v - $Anegatif[$k], 2);
                }
                $jarakPositif = sqrt($jarakPositif);
                $jarakNegatif = sqrt($jarakNegatif);

                $denominator = $jarakPositif + $jarakNegatif;
                $nilaiTopsis = $denominator == 0 ? 1 : $jarakNegatif / $denominator;

                PrioritasModel::updateOrCreate(
                    ['laporan_id' => $lapId],
                    [
                        'jarak_positif' => $jarakPositif,
                        'jarak_negatif' => $jarakNegatif,
                        'nilai_topsis' => $nilaiTopsis,
                        'klasifikasi_urgensi' => $this->klasifikasiUrgensi($nilaiTopsis),
                    ]
                );
            }
        }

        PerbaikanModel::updateOrCreate(
            ['laporan_id' => $laporan_id],
            [
                'teknisi_id' => $request->teknisi_id,
                'ditugaskan_pada' => Carbon::now(),
            ]
        );

        // $laporan = LaporanModel::findOrFail($laporan_id);
        $laporan->status_verif = 'diverifikasi';
        $laporan->verifikator_id = auth()->user()->user_id; // set verifikator ke user yang login
        $laporan->save();

        $teknisi = TeknisiModel::find($request->teknisi_id);
        if (!$teknisi) {
            return response()->json([
                'success' => false,
                'message' => 'Teknisi tidak ditemukan.'
            ], 404);
        }
        $userIdTeknisi = $teknisi->user_id;

        NotifikasiModel::create([
            'user_id' => $laporan->user_id,
            'laporan_id' => $laporan->laporan_id,
            'sender_id' => auth()->user()->user_id,
            'isi_notifikasi' => 'Laporan Anda dengan ID #' . $laporan->laporan_id . ' telah diverifikasi.',
            'is_read' => false,
        ]);

        NotifikasiModel::create([
            'user_id' => $userIdTeknisi,
            'laporan_id' => $laporan->laporan_id,
            'sender_id' => auth()->user()->user_id,
            'isi_notifikasi' => 'Anda telah ditugaskan untuk memperbaiki kerusakan dengan laporan ID #' . $laporan->laporan_id,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Verifikasi dan teknisi berhasil ditugaskan.',
            'klasifikasi_urgensi' => $this->klasifikasiUrgensi($nilaiTopsis),
        ]);
    }

    private function klasifikasiUrgensi($nilaiTopsis)
    {
        if ($nilaiTopsis >= 0.6) return 'Mendesak';
        if ($nilaiTopsis >= 0.4) return 'Biasa';
        return 'Tidak Mendesak';
    }

    public function reject($laporan_id)
    {
        $laporan = LaporanModel::findOrFail($laporan_id);
        $laporan->status_verif = 'ditolak';
        $laporan->verifikator_id = auth()->user()->user_id; // set verifikator ke user yang login
        $laporan->save();

        NotifikasiModel::create([
            'user_id' => $laporan->user_id,
            'laporan_id' => $laporan->laporan_id,
            'sender_id' => auth()->user()->user_id,
            'isi_notifikasi' => 'Laporan Anda dengan ID #' . $laporan->laporan_id . ' telah ditolak.',
            'is_read' => false,
        ]);

        return response()->json(['success' => true, 'message' => 'Laporan berhasil ditolak']);
    }

    public function riwayatVerifikasi(Request $request)
    {
        if ($request->ajax()) {
            $laporans = LaporanModel::with(['fasilitas', 'unit', 'tempat', 'barangLokasi.jenisBarang'])
                ->select('laporan_id', 'fasilitas_id', 'unit_id', 'tempat_id', 'barang_lokasi_id', 'jumlah_barang_rusak', 'status_verif', 'created_at')
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
                        // return '<span class="badge bg-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                        return '<span class="badge rounded-pill bg-opacity-25 bg-warning text-warning" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum Diverifikasi</span>';
                    } elseif ($laporan->status_verif === 'diverifikasi') {
                        // return '<span class="badge bg-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                        return '<span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Terverifikasi</span>';
                    } else {
                        // return '<span class="badge bg-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
                        return '<span class="badge rounded-pill bg-opacity-25 bg-danger text-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Ditolak</span>';
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

    public function showRiwayatVerif($laporan_id)
    {
        $laporan = LaporanModel::with([
            'fasilitas',
            'unit',
            'tempat',
            'barangLokasi.jenisBarang',
            'kategoriKerusakan',
            'periode',
            'perbaikan'
        ])->findOrFail($laporan_id);

        if ($laporan->perbaikan) {
            if ($laporan->perbaikan->ditugaskan_pada) {
                $laporan->perbaikan->formatted_tanggal_ditugaskan = Carbon::parse($laporan->perbaikan->ditugaskan_pada)->format('d M Y H:i');
            } else {
                $laporan->perbaikan->formatted_tanggal_ditugaskan = null;
            }
        }

        return view('verifikasi.showriwayatverif', compact('laporan'));
    }

    public function showFeedback($laporan_id)
    {
        $laporan = LaporanModel::with(['feedback.rating'])->findOrFail($laporan_id);

        return view('verifikasi.modalfeedback', compact('laporan'));
    }
}
