<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\TeknisiModel;
use App\Models\JenisTeknisiModel;
use App\Models\LaporanModel;
use App\Models\NotifikasiModel;
use App\Models\FeedbackModel;
use App\Models\PerbaikanModel;
use App\Models\PrioritasModel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

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
        $users = UserModel::select('user_id', 'username', 'name', 'role_id', 'foto_profile', 'status')
            ->with('role')
            ->orderBy('created_at', 'desc');

        if ($request->role_id) {
            $users->where('role_id', $request->role_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('status_switch', function ($user) {
                $checked = $user->status == 1 ? 'checked' : '';
                return '<div class="form-check form-switch" style="width: fit-content; margin: 0 auto;">
                            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $user->user_id . '" ' . $checked . '>
                        </div>';
            })
            ->addColumn('action', function ($user) {
                return '<button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/show') . '\')"class="btn btn-sm btn-primary" onclick="editUser(' . $user->user_id . ')">Detail</button>
                        <button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/edit') . '\')"class="btn btn-sm btn-warning" onclick="editUser(' . $user->user_id . ')">Edit</button>
                        <button onclick="modalAction(\'' . url('/user/' . $user->user_id . '/delete') .  '\')"class="btn btn-sm btn-danger">Delete</button>';
            })
            ->rawColumns(['status_switch', 'action'])
            ->make(true);
    }

    public function toggleStatus(Request $request)
    {
        $user = UserModel::findOrFail($request->id);
        $user->status = $user->status == 1 ? 0 : 1; // Toggle status
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Status berhasil diperbarui.',
            'new_status' => $user->status
        ]);
    }

    public function create()
    {
        $admin = RoleModel::where('kode_role', 'ADM')->get();
        $pelapor = RoleModel::whereIn('kode_role', ['MHS', 'DSN', 'TDK'])->get();
        $sarpras = RoleModel::where('kode_role', ['SRN'])->get();
        $teknisi = RoleModel::where('kode_role', ['TDK'])->get();
        $role = RoleModel::all();
        $jenis_teknisi = JenisTeknisiModel::all();
        return view('user.create', compact('role', 'pelapor', 'sarpras', 'admin', 'teknisi', 'jenis_teknisi'));
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
                'message' => 'User Berhasil dibuat.',
                'data' => $user
            ]);
        }
        return redirect()->route('user.index')->with('success', 'User Berhasil dibuat.');
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
                'message' => 'User Berhasil diperbarui.',
                'data' => $user
            ]);
        }

        return redirect()->route('user.index')->with('success', 'User Berhasil diperbarui.');
    }
    public function show($id)
    {
        $user = UserModel::with('role')->findOrFail($id);
        $teknisi = TeknisiModel::where('user_id', $user->user_id)->first();
        return view('user.show', compact('user'));
    }

    public function confirmDelete($id)
    {
        $user = UserModel::with(['role', 'teknisi'])->findOrFail($id);
        $data = [
            'user' => $user,
            'laporan_count' => 0,
            'feedback_count' => 0,
            'laporan_diverifikasi' => 0,
            'perbaikan_count' => 0,
        ];

        $kodeRole = $user->role->kode_role;

        if (in_array($kodeRole, ['MHS', 'DSN', 'TDK'])) {
            $data['laporan_count'] = $user->laporan()->count();
            $data['feedback_count'] = $user->feedback()->count();
        }

        if ($kodeRole === 'SRN') {
            $data['laporan_diverifikasi'] = LaporanModel::where('verifikator_id', $user->user_id)->count();
        }

        if ($kodeRole === 'TKS' && $user->teknisi) {
            $data['perbaikan_count'] = PerbaikanModel::where('teknisi_id', $user->teknisi->teknisi_id)->count();
        }

        return view('user.confirm_delete', $data);
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);

        if ($user->role->kode_role === 'TKS' && $user->teknisi) {
            $teknisiId = $user->teknisi->teknisi_id;
            PerbaikanModel::where('teknisi_id', $teknisiId)->delete();
            TeknisiModel::where('teknisi_id', $teknisiId)->delete();
        }

        if ($user->role->kode_role === 'SRN') {
            LaporanModel::where('verifikator_id', $user->user_id)->update(['verifikator_id' => null]);
        }

        $laporanIds = LaporanModel::where('user_id', $user->user_id)->pluck('laporan_id');

        PrioritasModel::whereIn('laporan_id', $laporanIds)->delete();
        PerbaikanModel::whereIn('laporan_id', $laporanIds)->delete();
        NotifikasiModel::whereIn('laporan_id', $laporanIds)->delete();
        FeedbackModel::whereIn('laporan_id', $laporanIds)->delete();

        NotifikasiModel::where('user_id', $user->user_id)->delete();
        NotifikasiModel::where('sender_id', $user->user_id)->delete();

        LaporanModel::where('user_id', $user->user_id)->delete();

        FeedbackModel::where('user_id', $user->user_id)->delete();


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
        return redirect()->route('user.index')->with('success', 'User Berhasil dihapus.');
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

    public function import()
    {
        return view('user.import');
    }

    public function import_ajax(Request $request) 
{
    DB::beginTransaction();
    try {
        // Validate file
        $validator = Validator::make($request->all(), [
            'file_user' => 'required|mimes:xlsx|max:1024',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi file gagal',
                'errors' => $validator->errors(),
            ], 422)->header('Content-Type', 'application/json');
        }

        // Read Excel file
        $file = $request->file('file_user');
        $spreadsheet = IOFactory::load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();
        $data = $sheet->toArray();

        // Validate headers
        $expectedHeaders = ['role_id', 'username', 'name', 'password', 'status'];
        $headers = array_shift($data);
        
        if (count(array_diff($expectedHeaders, $headers)) > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Format header tidak sesuai',
                'errors' => [
                    'file_user' => ['Header kolom tidak sesuai dengan template'],
                    'general' => ['Download template untuk format yang benar']
                ],
            ], 422)->header('Content-Type', 'application/json');
        }

        // Process rows
        $errors = [];
        $duplicateUsernames = [];
        $insertData = [];

        foreach ($data as $rowIndex => $row) {
            $rowNumber = $rowIndex + 2;

            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            // Validate required fields
            if (empty($row[1])) {
                $errors[] = "Baris $rowNumber: Username wajib diisi";
                continue;
            }

            if (empty($row[2])) {
                $errors[] = "Baris $rowNumber: Nama wajib diisi";
                continue;
            }

            $username = $row[1];
            
            // Check duplicate username
            if (UserModel::where('username', $username)->exists()) {
                $duplicateUsernames[] = $username;
                $errors[] = "Baris $rowNumber: Username '$username' sudah terdaftar";
                continue;
            }

            // Format password
            $password = $row[3] ?? '';
            if (strlen($password) < 5) {
                $password = str_pad($password, 5, '0');
            }

            // Prepare data for insertion
            $insertData[] = [
                'role_id' => $row[0] ?? 2,
                'username' => $username,
                'name' => $row[2],
                'password' => bcrypt($password),
                'status' => $row[4] ?? 1,
                'created_at' => now(),
            ];
        }

        // Handle errors
        if (!empty($duplicateUsernames)) {
            return response()->json([
                'status' => false,
                'message' => 'Terdapat username yang sudah terdaftar',
                'errors' => [
                    'general' => $errors,
                    'file_user' => ['Duplikat username ditemukan']
                ],
            ], 422)->header('Content-Type', 'application/json');
        }

        if (!empty($errors)) {
            return response()->json([
                'status' => false,
                'message' => 'Terdapat kesalahan pada data',
                'errors' => ['general' => $errors],
            ], 422)->header('Content-Type', 'application/json');
        }

        if (empty($insertData)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang valid',
                'errors' => ['file_user' => ['File tidak mengandung data yang valid']],
            ], 422)->header('Content-Type', 'application/json');
        }

        // Insert data
        UserModel::insert($insertData);
        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengimport ' . count($insertData) . ' data pengguna',
            'count' => count($insertData),
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan sistem',
            'errors' => ['general' => [$e->getMessage()]],
        ], 500)->header('Content-Type', 'application/json');
    }
}
}
