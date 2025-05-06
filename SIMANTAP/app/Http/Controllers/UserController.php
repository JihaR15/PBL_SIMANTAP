<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\TeknisiModel;
use App\Models\JenisTeknisiModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $activeMenu = 'user';
        $role = RoleModel::all();
        return view('user.index', [
            'title' => 'Manajemen Pengguna',
            'role' => $role,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Manajemen Pengguna', 'url' => '/public/user']
            ]

        ]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'name', 'role_id')
            ->with('role');

        if ($request->role_id) {
            $users->where('role_id', $request->role_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show') . '\')"class="btn btn-sm btn-primary" onclick="editUser(' . $user->user_id . ')">Detail</button>
                        <button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit') . '\')"class="btn btn-sm btn-warning" onclick="editUser(' . $user->user_id . ')">Edit</button>
                        <button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete') .  '\')"class="btn btn-sm btn-danger">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $admin = RoleModel::where('kode_role', 'ADM')->get();
        $pelapor = RoleModel::whereIn('kode_role', ['MHS', 'DSN', 'TDK'])->get();
        $sarpras = RoleModel::where('kode_role', ['SRN'])->get();
        $teknisi = RoleModel::where('kode_role', ['TDK'])->get();
        $role = RoleModel::all();
        $jenis_teknisi = JenisTeknisiModel::all();
        return view('user.create', compact('role', 'pelapor','sarpras','admin','teknisi', 'jenis_teknisi'));
    }
    public function store(Request $request)
    {
        $rules = [
            'role_id' => 'required|exists:m_role,role_id',
            'username' => 'required|unique:m_users,username',
            'foto_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'password' => 'required|min:5',
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
        
        $user = new UserModel();
        $user->role_id = $request->role_id;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        
        // simpan teknisi
        $role = RoleModel::find($request->role_id);
        if (strtolower($role->nama_role) === 'teknisi') {
            $teknisi = new TeknisiModel();
            $teknisi->user_id = $user->user_id;
            $teknisi->jenis_teknisi_id = $request->jenis_teknisi_id;
            $teknisi->save();
        }
        
        if ($request->hasFile('foto_profile')) {
            $file = $request->file('foto_profile');
            $filename = 'profile-' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $user->foto_profile = $filename;
            $user->save();
        }
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'User created successfully.',
                'data' => $user
            ]);
        }
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }
    public function edit($id)
    {
        $user = UserModel::with('role')->findOrFail($id);
        $role = RoleModel::select('role_id', 'nama_role')->get();
        $teknisi = TeknisiModel::select('teknisi_id', 'user_id', 'jenis_teknisi_id')->get();
        $jenis_teknisi = JenisTeknisiModel::all();
        return view('user.edit', compact('user', 'role', 'teknisi', 'jenis_teknisi'));
    }
    public function update(Request $request, $id)
    {
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

        // Update data teknisi jika role adalah teknisi
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
                'message' => 'User updated successfully.',
                'data' => $user
            ]);
        }

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
    public function show($id)
    {
        $user = UserModel::with('role')->findOrFail($id);
        $teknisi = TeknisiModel::where('user_id', $user->user_id)->first();
        return view('user.show', compact('user'));
    }

    public function confirmDelete($id)
    {
        $user = UserModel::findOrFail($id);
        return view('user.confirm_delete', compact('user'));
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        // hapus data teknisi jika ada
        TeknisiModel::where('user_id', $user->user_id)->delete();
        // Hapus foto profil jika ada
        if ($user->foto_profile) {
            $filePath = public_path('images/' . $user->foto_profile);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        $user->delete();
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'User Berhasil dihapus.',
            ]);
        }
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
    public function getUser(Request $request)
    {
        $user = UserModel::find($request->id);
        return response()->json($user);
    }
    public function getUserByRole(Request $request)
    {
        $users = UserModel::where('role_id', $request->role_id)->get();
        return response()->json($users);
    }
}
