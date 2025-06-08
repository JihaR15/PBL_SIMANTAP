<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\FeedbackModel;
use App\Models\RatingModel;
use App\Models\UserModel;
use App\Models\LaporanModel;
use App\Models\PerbaikanModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class FeedbackController extends Controller
{
    public function index()
    {
        $activeMenu = 'feedback';
        $feedbacks = FeedbackModel::with(['laporan', 'user', 'rating'])->get();
        return view('feedback.index', [
            'title' => 'Manajemen Feedback',
            'feedbacks' => $feedbacks,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Manajemen Feedback', 'url' => '/public/feedback']
            ]
        ]);
    }

    // public function list(Request $request)
    // {
    //     // Ambil user yang sedang login
    //     $userId = Auth::id();

    //     // Ambil laporan milik user yang login
    //     $laporanIds = LaporanModel::where('user_id', $userId)->pluck('laporan_id');

    //     // Ambil perbaikan yang status_perbaikan-nya 'selesai' dan terkait laporan user
    //     $perbaikanModel = app('App\Models\PerbaikanModel');
    //     $perbaikanIds = $perbaikanModel->whereIn('laporan_id', $laporanIds)
    //         ->where('status_perbaikan', 'selesai')
    //         ->pluck('perbaikan_id');

    //     // Ambil feedback yang terkait dengan perbaikan tersebut
    //     $feedbacks = FeedbackModel::with(['perbaikan.laporan', 'user', 'rating'])
    //         ->whereIn('perbaikan_id', $perbaikanIds)
    //         ->select('feedback_id', 'perbaikan_id', 'user_id', 'rating_id', 'komentar', 'created_at', 'updated_at');

    //     return DataTables::of($feedbacks)
    //         ->addIndexColumn()
    //         ->addColumn('perbaikan', function ($feedback) {
    //         // Tampilkan judul laporan dari relasi perbaikan->laporan
    //         return $feedback->perbaikan && $feedback->perbaikan->laporan
    //             ? $feedback->perbaikan->laporan->judul
    //             : 'N/A';
    //         })
    //         ->addColumn('user', function ($feedback) {
    //         return $feedback->user ? $feedback->user->name : 'N/A';
    //         })
    //         ->addColumn('rating', function ($feedback) {
    //         // Tampilkan bintang sesuai rating_id (misal rating_id 3 = ★★★☆☆)
    //         $stars = '';
    //         $maxStars = 5;
    //         $ratingValue = $feedback->rating ? (int)$feedback->rating->nilai : 0;
    //         for ($i = 1; $i <= $maxStars; $i++) {
    //             $stars .= $i <= $ratingValue ? '★' : '☆';
    //         }
    //         return '<span style="color: #ffc107; font-size: 1.2em;">' . $stars . '</span>';
    //         })
    //         ->addColumn('action', function ($feedback) {
    //         return '<button onclick="modalAction(\'' . url('/feedback/' . $feedback->feedback_id . '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>';
    //         })
    //         ->rawColumns(['action', 'rating'])
    //         ->make(true);
    // }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $laporans = LaporanModel::with([
                'fasilitas',
                'unit',
                'tempat',
                'barangLokasi.jenisBarang',
                'perbaikan',
                'feedback.rating'
            ])
                ->select('laporan_id', 'fasilitas_id', 'unit_id', 'tempat_id', 'barang_lokasi_id', 'created_at')
                ->whereHas('perbaikan', function ($query) {
                    $query->where('status_perbaikan', 'selesai');
                })
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
                    $status = $laporan->perbaikan->status_perbaikan ?? null;

                    if ($status === 'belum') {
                        return '<span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Belum dikerjakan</span>';
                    } elseif ($status === 'sedang diperbaiki') {
                        return '<span class="badge rounded-pill bg-opacity-25 bg-info text-info" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Sedang dikerjakan</span>';
                    } elseif ($status === 'selesai') {
                        return '<span class="badge rounded-pill bg-opacity-25 bg-success text-success" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">Selesai</span>';
                    } else {
                        return '<span class="badge rounded-pill bg-opacity-25 bg-secondary text-secondary" style="font-size: 12px; padding: 8px 10px; color: #fff; font-weight: 700;">-</span>';
                    }
                })
                ->addColumn('rating', function ($laporan) {
                    // Ambil feedback pertama (jika ada) untuk laporan ini
                    $feedback = $laporan->feedback->first();
                    if ($feedback && $feedback->rating_id) {
                        $stars = '';
                        $maxStars = 5;
                        $ratingValue = (int) $feedback->rating_id;
                        for ($i = 1; $i <= $maxStars; $i++) {
                            $stars .= $i <= $ratingValue ? '★' : '☆';
                        }
                        return '<span style="color: #ffc107; font-size: 1.2em;">' . $stars . '</span>';
                    }
                    return '-';
                })
                ->addColumn('created_at', function ($row) {
                    return Carbon::parse($row->created_at)->format('d M Y');
                })
                ->addColumn('action', function ($laporan) {
                    return '<button onclick="modalAction(\'' . url('/feedback/' . $laporan->laporan_id . '/show') . '\')" class="btn btn-sm btn-primary">Detail</button>';
                })
                ->rawColumns(['status_perbaikan', 'rating', 'action'])
                ->make(true);
        }
    }

    public function show($id)
    {
        $laporan = LaporanModel::with([
            'fasilitas',
            'unit',
            'tempat',
            'barangLokasi.jenisBarang',
            'kategoriKerusakan',
            'periode',
            'perbaikan'
        ])->findOrFail($id);

        $existingFeedback = FeedbackModel::where('laporan_id', $id)
            ->where('user_id', Auth::id())
            ->first();

        $laporan->formatted_created_at = Carbon::parse($laporan->created_at)->format('d M Y');
        if ($laporan->perbaikan && $laporan->perbaikan->ditugaskan_pada) {
            $laporan->perbaikan->formatted_tanggal_ditugaskan = Carbon::parse($laporan->perbaikan->ditugaskan_pada)->format('d M Y');
        } else {
            $laporan->perbaikan->formatted_tanggal_ditugaskan = null;
        }

        return view('feedback.show', compact('laporan', 'existingFeedback'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'laporan_id' => 'required|exists:t_laporan,laporan_id',
            'rating_id' => 'required|exists:m_rating,rating_id',
            'komentar' => 'required|string',
        ]);

        FeedbackModel::create([
            'laporan_id' => $request->laporan_id,
            'user_id' => Auth::id(),
            'rating_id' => $request->rating_id,
            'komentar' => $request->komentar,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Feedback berhasil disimpan.']);
        }

        return redirect()->back()->with('success', 'Feedback berhasil disimpan.');
    }

    public function update(Request $request, $laporan_id)
    {
        $request->validate([
            'rating_id' => 'required|exists:m_rating,rating_id',
            'komentar' => 'required|string',
        ]);

        $feedback = FeedbackModel::where('laporan_id', $laporan_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $feedback->update([
            'rating_id' => $request->rating_id,
            'komentar' => $request->komentar,
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Feedback berhasil diperbarui.']);
        }

        return redirect()->back()->with('success', 'Feedback berhasil diperbarui.');
    }
}
