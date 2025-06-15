<?php

namespace App\Http\Controllers;

use App\Models\BobotModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PrioritasModel;
use Illuminate\Support\Facades\Validator;

class BobotController extends Controller
{
    public function index()
    {
        $activeMenu = 'bobot';
        $bobot = BobotModel::all();
        return view('bobot.index', [
            'title' => 'Manajemen Bobot',
            'bobot' => $bobot,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/'],
                ['label' => 'Manajemen Prioritas Perbaikan', 'url' => '/bobot']
            ]
        ]);
    }

    public function list(Request $request)
    {
        $bobot = BobotModel::select('bobot_id', 'nama_parameter', 'bobot');

        if ($request->bobot_id) {
            $bobot->where('bobot_id', $request->bobot_id);
        }

        return DataTables::of($bobot)
            ->addIndexColumn()
            // ->addColumn('action', function ($bobot) {
            //     return '<a href="'.route('bobot.show', $bobot->bobot_id).'" class="btn btn-sm btn-info">
            //     <i class="mdi mdi-pencil"></i>
            //     Detail</a>';
            // })
            // ->rawColumns(['action'])
            ->make(true);
    }

    public function edit()
    {
        $bobot = BobotModel::all();
        return view('bobot.edit', compact('bobot'));
    }

    public function updateAll(Request $request)
    {
        $bobotInput = $request->input('bobot');
        $total = 0;
        foreach ($bobotInput as $val) {
            $total += floatval($val);
        }

        if (abs($total - 1) > 0.001) {
            return response()->json([
                'status' => false,
                'message' => 'Total bobot harus = 1'
            ]);
        }

        foreach ($bobotInput as $id => $val) {
            BobotModel::where('bobot_id', $id)->update(['bobot' => $val]);
        }

        // Hitung ulang semua TOPSIS
        $this->hitungSemuaTopsis();

        return response()->json([
            'status' => true,
            'message' => 'Bobot berhasil diperbarui'
        ]);
    }

    private function hitungSemuaTopsis()
    {
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

        $requiredKeys = array_values($map);
        foreach ($requiredKeys as $key) {
            if (!isset($bobot[$key])) {
                return; // bisa pakai log error jika perlu
            }
        }

        $tipeKriteria = [
            'tingkat_kerusakan' => 'benefit',
            'dampak_terhadap_aktivitas_akademik' => 'benefit',
            'frekuensi_penggunaan_fasilitas' => 'benefit',
            'ketersediaan_barang_pengganti' => 'cost',
            'tingkat_risiko_keselamatan' => 'benefit',
        ];

        $allPrioritas = PrioritasModel::whereHas('laporan.perbaikan', function ($q) {
            $q->where('status_perbaikan', '!=', 'selesai');
        })->orWhereDoesntHave('laporan.perbaikan')->get();

        if ($allPrioritas->count() === 0) return;

        if ($allPrioritas->count() === 1) {
            $p = $allPrioritas->first();
            $skor = 0;
            foreach ($bobot as $kriteria => $b) {
                $skor += $p->$kriteria * $b;
            }
            $nilaiTopsis = $skor / count($bobot);

            $p->update([
                'jarak_positif' => 0,
                'jarak_negatif' => 0,
                'nilai_topsis' => $nilaiTopsis,
                'klasifikasi_urgensi' => $this->klasifikasiUrgensi($nilaiTopsis),
            ]);
            return;
        }

        $sumSquares = array_fill_keys(array_keys($bobot), 0);
        foreach ($allPrioritas as $p) {
            foreach ($bobot as $kriteria => $w) {
                $sumSquares[$kriteria] += pow($p->$kriteria, 2);
            }
        }

        foreach ($sumSquares as $key => $val) {
            $sumSquares[$key] = sqrt($val) ?: 1;
        }

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

        $Apositif = [];
        $Anegatif = [];
        foreach ($bobot as $kriteria => $w) {
            $values = array_column($allMatriksTerbobot, $kriteria);
            $Apositif[$kriteria] = ($tipeKriteria[$kriteria] === 'benefit') ? max($values) : min($values);
            $Anegatif[$kriteria] = ($tipeKriteria[$kriteria] === 'benefit') ? min($values) : max($values);
        }

        foreach ($allMatriksTerbobot as $lapId => $matriksTerbobotTarget) {
            $jarakPositif = 0;
            $jarakNegatif = 0;
            foreach ($matriksTerbobotTarget as $k => $v) {
                $jarakPositif += pow($v - $Apositif[$k], 2);
                $jarakNegatif += pow($v - $Anegatif[$k], 2);
            }
            $jarakPositif = sqrt($jarakPositif);
            $jarakNegatif = sqrt($jarakNegatif);

            $nilaiTopsis = ($jarakPositif + $jarakNegatif) == 0 ? 1 : $jarakNegatif / ($jarakPositif + $jarakNegatif);

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
    private function klasifikasiUrgensi($nilaiTopsis)
    {
        if ($nilaiTopsis >= 0.6) return 'Mendesak';
        if ($nilaiTopsis >= 0.4) return 'Biasa';
        return 'Tidak Mendesak';
    }
}
