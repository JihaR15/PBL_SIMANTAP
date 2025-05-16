<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->user_id;
        $notifikasis = NotifikasiModel::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->paginate(10);

        return view('notifikasi.index', compact('notifikasis'));
    }

    public function markRead($id)
    {
        $notif = NotifikasiModel::where('notifikasi_id', $id)
            ->where('user_id', Auth::user()->user_id)
            ->firstOrFail();

        $notif->is_read = true;
        $notif->save();

        return response()->json(['success' => true]);
    }
}
