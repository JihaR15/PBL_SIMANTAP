<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->user_id;
        $userRole = $user->role->kode_role ?? null;

        $query = NotifikasiModel::query();
        $query->where('user_id', $userId);

        if ($userRole === 'TKS') {
            $query->orWhere('role', 'TKS');
        }

        $notifikasis = $query->orderBy('created_at', 'desc')
                            ->take(5)
                            ->paginate(10);
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
