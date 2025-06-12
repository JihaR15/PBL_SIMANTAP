<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\LaporanModel;
use App\Models\TeknisiModel;
use Illuminate\Http\Request;
use App\Models\PerbaikanModel;
use App\Models\PrioritasModel;
use App\Models\NotifikasiModel;
use Yajra\DataTables\Facades\DataTables;

class PerbaikanController extends Controller
{
    public function index()
    {
        $activeMenu = 'perbaikan';

        // $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
        //     ->where('status_perbaikan', '=', 'belum')
        //     ->get();

        return view('perbaikan.index', [
            'title' => 'Tugas Perbaikan',
            // 'perbaikan' => $perbaikan,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Tugas Perbaikan', 'url' => '/public/perbaikan']
            ]
        ]);
    }

    public function list(Request $request)
    {
        $teknisi = TeknisiModel::where('user_id', auth()->user()->user_id)->first();

        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
            ->where('status_perbaikan', '=', 'belum')
            ->where('teknisi_id', $teknisi->teknisi_id)
            ->get()
            ->sortByDesc(function ($perbaikan) {
                return optional($perbaikan->laporan->prioritas)->nilai_topsis ?? 0;
            })
            ->values();

        return DataTables::of($perbaikan)
            ->addIndexColumn()
            ->addColumn('action', function ($perbaikan) {
                return '<button onclick="modalAction(\'' . url('/perbaikan/' . $perbaikan->perbaikan_id . '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>';
            })
            ->addColumn('nama_barang', function ($perbaikan) {
                return optional($perbaikan->laporan->barangLokasi->jenisBarang)->nama_barang ?? '-';
            })
            ->addColumn('nama_tempat', function ($perbaikan) {
                return optional($perbaikan->laporan->tempat)->nama_tempat ?? '-';
            })
            ->addColumn('nama_unit', function ($perbaikan) {
                return optional($perbaikan->laporan->unit)->nama_unit ?? '-';
            })
            ->addColumn('prioritas', function ($perbaikan) {
                if ($perbaikan->laporan->prioritas && $perbaikan->laporan->prioritas->nilai_topsis >= 0.6) {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-danger text-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Urgent</span>';
                } elseif ($perbaikan->laporan->prioritas && $perbaikan->laporan->prioritas->nilai_topsis >= 0.4) {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Biasa</span>';
                } else {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Tidak Urgent</span>';
                }
            })
            ->addColumn('created_at', function ($laporan) {
                return Carbon::parse($laporan->created_at)->format('d M Y');
            })
            ->addColumn('jumlah_barang_rusak', function ($perbaikan) {
                return optional($perbaikan->laporan)->jumlah_barang_rusak ?? '-'; // Menampilkan jumlah barang rusak
            })
            ->rawColumns(['action', 'prioritas'])
            ->make(true);
    }

    public function show($perbaikan_id)
    {
        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
            ->where('perbaikan_id', $perbaikan_id)
            ->firstOrFail();

        return view('perbaikan.show', compact('perbaikan'));
    }

    public function showdikerjakan($perbaikan_id)
    {
        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
            ->where('perbaikan_id', $perbaikan_id)
            ->firstOrFail();

        return view('perbaikan.showdikerjakan', compact('perbaikan'));
    }

    public function kerjakan(Request $request, $id)
    {
        try {
            $perbaikan = PerbaikanModel::findOrFail($id);

            // Cek apakah statusnya masih 'belum'
            if ($perbaikan->status_perbaikan === 'belum') {
                $perbaikan->status_perbaikan = 'sedang diperbaiki';
                // Update waktu ditugaskan
                $perbaikan->ditugaskan_pada = now();
                $perbaikan->save();

                NotifikasiModel::create([
                    'user_id' => $perbaikan->laporan->user_id,
                    'laporan_id' => $perbaikan->laporan_id,
                    'sender_id' => auth()->user()->user_id,
                    'isi_notifikasi' => 'Laporan Anda dengan ID #' . $perbaikan->laporan_id . ' kini sedang dalam proses perbaikan oleh teknisi.',
                    'is_read' => false,
                ]);

                return response()->json(['message' => 'Status berhasil diperbarui. Pengerjaan telah dimulai.']);
            } else {
                return response()->json(['message' => 'Status tidak bisa diperbarui.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function dikerjakan(Request $request)
    {
        $activeMenu = 'Sedang Dikerjakan';
        $teknisi = TeknisiModel::where('user_id', auth()->user()->user_id)->first();
        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
            ->where('status_perbaikan', '=', 'sedang diperbaiki')
            ->where('teknisi_id', $teknisi->teknisi_id)
            ->get()
            ->sortByDesc(function ($perbaikan) {
                return optional($perbaikan->laporan->prioritas)->nilai_topsis ?? 0;
            })
            ->values();
        return view('perbaikan.dikerjakan', [
            'title' => 'Sedang Dikerjakan',
            'perbaikan' => $perbaikan,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Sedang Dikerjakan', 'url' => '/public/dikerjakan']
            ]
        ]);
    }

    public function list2(Request $request)
    {
        $teknisi = TeknisiModel::where('user_id', auth()->user()->user_id)->first();

        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
            ->where('status_perbaikan', '=', 'sedang diperbaiki')
            ->where('teknisi_id', $teknisi->teknisi_id)
            ->get()
            ->sortByDesc(function ($perbaikan) {
                return optional($perbaikan->laporan->prioritas)->nilai_topsis ?? 0;
            })
            ->values();

        return DataTables::of($perbaikan)
            ->addIndexColumn()
            ->addColumn('action', function ($perbaikan) {
                return '<button onclick="modalAction(\'' . url('/dikerjakan/' . $perbaikan->perbaikan_id . '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>';
            })
            ->addColumn('nama_barang', function ($perbaikan) {
                return optional($perbaikan->laporan->barangLokasi->jenisBarang)->nama_barang ?? '-';
            })
            ->addColumn('nama_tempat', function ($perbaikan) {
                return optional($perbaikan->laporan->tempat)->nama_tempat ?? '-';
            })
            ->addColumn('nama_unit', function ($perbaikan) {
                return optional($perbaikan->laporan->unit)->nama_unit ?? '-';
            })
            ->addColumn('prioritas', function ($perbaikan) {
                if ($perbaikan->laporan->prioritas && $perbaikan->laporan->prioritas->nilai_topsis >= 0.6) {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-danger text-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Urgent</span>';
                } elseif ($perbaikan->laporan->prioritas && $perbaikan->laporan->prioritas->nilai_topsis >= 0.4) {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Biasa</span>';
                } else {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Tidak Urgent</span>';
                }
            })
            ->addColumn('created_at', function ($laporan) {
                return Carbon::parse($laporan->created_at)->format('d M Y');
            })
            ->addColumn('jumlah_barang_rusak', function ($perbaikan) {
                return optional($perbaikan->laporan)->jumlah_barang_rusak ?? '-'; // Menampilkan jumlah barang rusak
            })
            ->rawColumns(['action', 'prioritas'])
            ->make(true);
    }

    public function konfirmasi($perbaikan_id)
    {
        $perbaikan = PerbaikanModel::findOrFail($perbaikan_id);

        return view('perbaikan.konfirmasi', compact('perbaikan'));
    }

    public function selesai(Request $request, $id)
    {
        try {
            $perbaikan = PerbaikanModel::findOrFail($id);

            // Validasi input
            $validated = $request->validate([
                'biaya' => 'required|numeric|min:0',
                'catatan_perbaikan' => 'required|string',
                'foto_perbaikan' => 'image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Cek apakah statusnya masih 'sedang diperbaiki'
            if ($perbaikan->status_perbaikan === 'sedang diperbaiki') {
                $perbaikan->status_perbaikan = 'selesai';
                $perbaikan->biaya = $validated['biaya'];
                $perbaikan->catatan_perbaikan = $validated['catatan_perbaikan'];
                $perbaikan->selesai_pada = now();
                $file = $request->file('foto_perbaikan');
                $path = $file->store('perbaikan', 'public');
                $perbaikan->foto_perbaikan = $path;

                $perbaikan->save();

                NotifikasiModel::create([
                    'user_id' => $perbaikan->laporan->user_id,
                    'laporan_id' => $perbaikan->laporan_id,
                    'sender_id' => auth()->user()->user_id,
                    'isi_notifikasi' => 'Perbaikan kerusakan pada laporan Anda dengan ID #' . $perbaikan->laporan_id . ' telah selesai.',
                    'is_read' => false,
                ]);

                return response()->json([
                    'message' => 'Status dan data perbaikan berhasil diperbarui. Perbaikan selesai.',
                    'success' => true
                ]);
            } else {
                return response()->json(['message' => 'Status tidak bisa diperbarui.'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function riwayatPerbaikan()
    {
        $activeMenu = 'riwayat_perbaikan';
        $teknisi = TeknisiModel::where('user_id', auth()->user()->user_id)->first();
        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
            ->where('status_perbaikan', '=', 'selesai')
            ->where('teknisi_id', $teknisi->teknisi_id)
            ->get()
            ->sortByDesc(function ($perbaikan) {
                return optional($perbaikan->laporan->prioritas)->nilai_topsis ?? 0;
            })
            ->values();

        return view('perbaikan.riwayat', [
            'title' => 'Riwayat Perbaikan',
            'perbaikan' => $perbaikan,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Riwayat Perbaikan', 'url' => '/public/riwayat']
            ]
        ]);
    }
    public function riwayatList(Request $request)
    {
        $teknisi = TeknisiModel::where('user_id', auth()->user()->user_id)->first();

        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
            ->where('status_perbaikan', '=', 'selesai')
            ->where('teknisi_id', $teknisi->teknisi_id)
            ->orderBy('updated_at', 'desc')
            ->get();

        return DataTables::of($perbaikan)
            ->addIndexColumn()
            ->addColumn('action', function ($perbaikan) {
                return '<button onclick="modalAction(\'' . url('/riwayatperbaikan/' . $perbaikan->perbaikan_id . '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>';
            })
            ->addColumn('nama_barang', function ($perbaikan) {
                return optional($perbaikan->laporan->barangLokasi->jenisBarang)->nama_barang ?? '-';
            })
            ->addColumn('nama_tempat', function ($perbaikan) {
                return optional($perbaikan->laporan->tempat)->nama_tempat ?? '-';
            })
            ->addColumn('nama_unit', function ($perbaikan) {
                return optional($perbaikan->laporan->unit)->nama_unit ?? '-';
            })
            ->addColumn('prioritas', function ($perbaikan) {
                if ($perbaikan->laporan->prioritas && $perbaikan->laporan->prioritas->nilai_topsis >= 0.6) {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-danger text-danger" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Urgent</span>';
                } elseif ($perbaikan->laporan->prioritas && $perbaikan->laporan->prioritas->nilai_topsis >= 0.4) {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Biasa</span>';
                } else {
                    return '<span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Tidak Urgent</span>';
                }
            })
            ->addColumn('created_at', function ($laporan) {
                return Carbon::parse($laporan->created_at)->format('d M Y');
            })
            ->addColumn('jumlah_barang_rusak', function ($perbaikan) {
                return optional($perbaikan->laporan)->jumlah_barang_rusak ?? '-'; // Menampilkan jumlah barang rusak
            })
            ->rawColumns(['action', 'prioritas'])
            ->make(true);
    }

    public function showRiwayatPerbaikan($perbaikan_id)
    {
        $perbaikan = PerbaikanModel::with(['laporan', 'teknisi'])
            ->where('perbaikan_id', $perbaikan_id)
            ->firstOrFail();

        // Format selesai_pada dengan Carbon
        if ($perbaikan->selesai_pada) {
            $perbaikan->selesai_pada_formatted = Carbon::parse($perbaikan->selesai_pada)->format('d M Y H:i');
        } else {
            $perbaikan->selesai_pada_formatted = '-';
        }

        // Format ditugaskan_pada dengan Carbon
        if ($perbaikan->ditugaskan_pada) {
            $perbaikan->ditugaskan_pada_formatted = Carbon::parse($perbaikan->ditugaskan_pada)->format('d M Y');
        } else {
            $perbaikan->ditugaskan_pada_formatted = '-';
        }

        return view('perbaikan.showriwayat', compact('perbaikan'));
    }

    public function showFeedback($perbaikan_id)
    {
        $perbaikan = PerbaikanModel::with('laporan.feedback.rating')->findOrFail($perbaikan_id);
        $feedback = $perbaikan->laporan->feedback ?? collect();

        return view('perbaikan.modalfeedback', compact('feedback'));
    }



    // public function create()
    // {
    //     return view('perbaikan.create');
    // }

    // public function store(Request $request)
    // {
    //     // Logic to store the data
    //     return redirect()->route('perbaikan.index')->with('success', 'Data berhasil disimpan.');
    // }

    // public function edit($id)
    // {
    //     return view('perbaikan.edit', compact('id'));
    // }

    // public function update(Request $request, $id)
    // {
    //     // Logic to update the data
    //     return redirect()->route('perbaikan.index')->with('success', 'Data berhasil diperbarui.');
    // }

    // public function destroy($id)
    // {
    //     // Logic to delete the data
    //     return redirect()->route('perbaikan.index')->with('success', 'Data berhasil dihapus.');
    // }
}
