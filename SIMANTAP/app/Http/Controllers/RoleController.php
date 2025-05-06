<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\TeknisiModel;
use App\Models\JenisTeknisiModel;
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
                return '<button onclick="modalAction(\'' . url('/role/' . $role->role_id . '/show') . '\')"class="btn btn-sm btn-primary" onclick="editUser(' . $role->role_id . ')">Detail</button>
                <button onclick="modalAction(\'' . url('/role/' . $role->role_id . '/edit') . '\')"class="btn btn-sm btn-warning" onclick="editUser(' . $role->role_id . ')">Edit</button>
                <button onclick="modalAction(\'' . url('/role/' . $role->role_id . '/delete') .  '\')"class="btn btn-sm btn-danger">Delete</button>';
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
                'message' => 'Role created successfully.',
                'data' => $role
            ]);
        }
        return redirect()->route('role.index')->with('success', 'Role created successfully.');
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
                'message' => 'Role updated successfully.',
                'data' => $role
            ]);
        }
        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
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
        $role = RoleModel::findOrFail($id);
        $role->delete();
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Role deleted successfully.'
            ]);
        }
        return redirect()->route('role.index')->with('success', 'Role deleted successfully.');
    }

}
