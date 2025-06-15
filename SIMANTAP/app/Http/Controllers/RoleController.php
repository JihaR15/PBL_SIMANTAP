<?php

namespace App\Http\Controllers;

use App\Models\RoleModel;
use App\Models\UserModel;
use App\Models\TeknisiModel;
use Illuminate\Http\Request;
use App\Models\JenisTeknisiModel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $activeMenu = 'role';
        $role = RoleModel::all();
        return view('role.index', [
            'title' => 'Manajemen Role',
            'role' => $role,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Manajemen Role', 'url' => '/public/role']
            ]

        ]);
    }

    public function list(Request $request)
    {
        $roles = RoleModel::select('role_id', 'kode_role', 'nama_role', 'created_at', 'updated_at');

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('action', function ($role) {
                // return '<button onclick="modalAction(\'' . url('/role/' . $role->role_id . '/show') . '\')"class="btn btn-sm btn-primary" onclick="editUser(' . $role->role_id . ')">Detail</button>
                // <button onclick="modalAction(\'' . url('/role/' . $role->role_id . '/edit') . '\')"class="btn btn-sm btn-warning" onclick="editUser(' . $role->role_id . ')">Edit</button>
                // <button onclick="modalAction(\'' . url('/role/' . $role->role_id . '/delete') .  '\')"class="btn btn-sm btn-danger">Delete</button>';
                return '<button onclick="modalAction(\'' . url('/role/' . $role->role_id . '/show') . '\')"class="btn btn-sm btn-primary" onclick="editUser(' . $role->role_id . ')">Detail</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $role = RoleModel::all();
        return view('role.create', compact('role'));
    }
    public function store(Request $request)
    {
        $rules = [
            'kode_role' => 'required|unique:m_role,kode_role',
            'nama_role' => 'required|unique:m_role,nama_role',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $role = new RoleModel();
        $role->kode_role = $request->kode_role;
        $role->nama_role = $request->nama_role;
        $role->save();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Role Berhasil dibuat.',
                'data' => $role
            ]);
        }
        return redirect()->route('role.index')->with('success', 'Role Berhasil dibuat.');
    }
    public function edit($id)
    {
        $role = RoleModel::findOrFail($id);
        return view('role.edit', compact('role'));
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'kode_role' => 'required|unique:m_role,kode_role,' . $id . ',role_id',
            'nama_role' => 'required|unique:m_role,nama_role,' . $id . ',role_id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $role = RoleModel::findOrFail($id);
        $role->kode_role = $request->kode_role;
        $role->nama_role = $request->nama_role;
        $role->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Role Berhasil diperbarui.',
                'data' => $role
            ]);
        }
        return redirect()->route('role.index')->with('success', 'Role Berhasil diperbarui.');
    }
    public function show($id)
    {
        $role = RoleModel::findOrFail($id);
        return view('role.show', compact('role'));
    }

    public function confirmDelete($id)
    {
        $role = RoleModel::findOrFail($id);
        return view('role.confirm_delete', compact('role'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $role = RoleModel::findOrFail($id);

            $usersCount = UserModel::where('role_id', $id)->count();
            if ($usersCount > 0) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus role karena terdapat '.$usersCount.' user terkait.'
                ], 422);
            }

            $role->delete();
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Role berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus role: '.$e->getMessage()
            ], 500);
        }
    }

}
