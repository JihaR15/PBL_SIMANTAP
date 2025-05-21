<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\TeknisiModel;
use App\Models\JenisTeknisiModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class JenisTeknisiController extends Controller
{
    public function index()
    {
        $activeMenu = 'jenisteknisi';
        $role = RoleModel::all();
        return view('jenisteknisi.index', [
            'title' => 'Manajemen Jenis Teknisi',
            'role' => $role,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Home', 'url' => '/public'],
                ['label' => 'Manajemen Jenis Teknisi', 'url' => '/public/jenisteknisi']
            ]

        ]);
    }

    public function list(Request $request)
    {
        $jenisteknisis = JenisTeknisiModel::select('jenis_teknisi_id', 'nama_jenis_teknisi', 'created_at', 'updated_at');

        return DataTables::of($jenisteknisis)
            ->addIndexColumn()
            ->addColumn('action', function ($jenisteknisi) {
                return '<button onclick="modalAction(\'' . url('/jenisteknisi/' . $jenisteknisi->jenis_teknisi_id . '/show') . '\')"class="btn btn-sm btn-primary" onclick="editUser(' . $jenisteknisi->jenis_teknisi_id . ')">Detail</button>
                <button onclick="modalAction(\'' . url('/jenisteknisi/' . $jenisteknisi->jenis_teknisi_id . '/edit') . '\')"class="btn btn-sm btn-warning" onclick="editUser(' . $jenisteknisi->jenis_teknisi_id . ')">Edit</button>
                <button onclick="modalAction(\'' . url('/jenisteknisi/' . $jenisteknisi->jenis_teknisi_id . '/delete') .  '\')"class="btn btn-sm btn-danger">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        $jenisteknisi = JenisTeknisiModel::all();
        return view('jenisteknisi.create', compact('jenisteknisi'));
    }
    public function store(Request $request)
    {
        $rules = [
            'nama_jenis_teknisi' => 'required|unique:m_jenis_teknisi,nama_jenis_teknisi',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }
        $jenisteknisi = new JenisTeknisiModel();
        $jenisteknisi->nama_jenis_teknisi = $request->nama_jenis_teknisi;
        $jenisteknisi->save();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Jenis Teknisi created successfully.',
                'data' => $jenisteknisi
            ]);
        }
        return redirect()->route('jenisteknisi.index')->with('success', 'Jenis Teknisi created successfully.');
    }
    public function edit($id)
    {
        $jenisteknisi = JenisTeknisiModel::findOrFail($id);
        return view('jenisteknisi.edit', compact('jenisteknisi'));
    }
    public function update(Request $request, $id)
    {
        $rules = [
            'nama_jenis_teknisi' => 'required|unique:m_jenis_teknisi,nama_jenis_teknisi,' . $id . ',jenis_teknisi_id',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }
        $jenisteknisi = JenisTeknisiModel::findOrFail($id);
        $jenisteknisi->nama_jenis_teknisi = $request->nama_jenis_teknisi;
        $jenisteknisi->save();
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Jenis Teknisi updated successfully.',
                'data' => $jenisteknisi
            ]);
        }
        return redirect()->route('jenisteknisi.index')->with('success', 'Jenis Teknisi updated successfully.');
    }
    public function show($id)
    {
        $jenisteknisi = JenisTeknisiModel::findOrFail($id);
        return view('jenisteknisi.show', compact('jenisteknisi'));
    }

    public function confirmDelete($id)
    {
        $jenisteknisi = JenisTeknisiModel::findOrFail($id);
        return view('jenisteknisi.confirm_delete', compact('jenisteknisi'));
    }

    public function destroy($id)
    {
        // Gunakan transaksi agar aman jika terjadi error
        DB::beginTransaction();
        try {
            $jenisteknisi = JenisTeknisiModel::findOrFail($id);

            // Ambil semua teknisi yang punya jenis_teknisi_id = $id
            $teknisis = TeknisiModel::where('jenis_teknisi_id', $id)->get();

            foreach ($teknisis as $teknisi) {
                // Hapus user yang terkait (via user_id)
                $user = UserModel::find($teknisi->user_id);
                if ($user) {
                    $user->delete();
                }

                // Hapus teknisinya
                $teknisi->delete();
            }

            // Hapus jenis teknisinya
            $jenisteknisi->delete();

            DB::commit();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Jenis Teknisi dan teknisi serta user terkait berhasil dihapus.',
                ]);
            }

            return redirect()->route('jenisteknisi.index')->with('success', 'Jenis Teknisi dan teknisi serta user terkait berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
