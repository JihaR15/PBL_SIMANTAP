<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\TeknisiModel;
use Illuminate\Http\Request;
use App\Models\JenisTeknisiModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', ['user' => $user]);
    }

    public function edit()
    {
        $user = Auth::user();
        $role = RoleModel::all();
        $jenis_teknisi = JenisTeknisiModel::all();
        return view('profile.edit', ['user' => $user,
                                    'role'=> $role,
                                    'jenis_teknisi' => $jenis_teknisi]);
    }

    public function update(Request $request)
    {
        $id = auth()->user()->user_id;

        $rules = [
            'role_id' => 'required|exists:m_role,role_id',
            'username' => 'required|unique:m_users,username,' . $id . ',user_id',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'password' => 'nullable|min:5',
            'jenis_teknisi_id' => 'nullable|exists:m_jenis_teknisi,jenis_teknisi_id'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $user = UserModel::findOrFail($id);

        $user->role_id = $request->role_id;
        $user->username = $request->username;
        $user->name = $request->name;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        $role = RoleModel::find($request->role_id);
        if (strtolower($role->nama_role) === 'teknisi') {
            $teknisi = TeknisiModel::firstOrNew(['user_id' => $user->user_id]);
            $teknisi->jenis_teknisi_id = $request->jenis_teknisi_id;
            $teknisi->save();
        } else {
            TeknisiModel::where('user_id', $user->user_id)->delete();
        }

        if ($request->hasFile('foto_profile')) {
            // hapus foto profil lama
            if ($user->foto_profile) {
                $filePath = public_path('images/' . $user->foto_profile);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $file = $request->file('foto_profile');
            $filename = 'profile-' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $user->foto_profile = $filename;
            $user->save();
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Perubahan profil berhasil disimpan!.',
                'data' => $user
            ]);
        }

        return redirect()->route('/')->with('success', 'Profil berhasil diperbarui!');
    }
}
