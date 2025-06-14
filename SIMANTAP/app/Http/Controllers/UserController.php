<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\TeknisiModel;
use App\Models\JenisTeknisiModel;
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
        try {
            $rules = [ 
                'file_user' => ['required', 'mimes:xlsx', 'max:1024'] 
            ];

            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([ 
                        'status' => false, 
                        'message' => 'Validasi gagal: ' . $validator->errors()->first(),
                        'errors' => $validator->errors(),
                        'redirect' => route('user.import')
                    ]);
                }
                return redirect()->route('user.import')
                    ->withErrors($validator)
                    ->withInput();
            }

            $file = $request->file('file_user');
            
            if (!$file->isValid()) {
                throw new \Exception('File tidak valid');
            }

            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getRealPath()); 
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, false, true, true);

            if (count($data) <= 1) {
                $message = 'File Excel kosong atau hanya berisi header';
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => $message,
                        'redirect' => route('user.import')
                    ]);
                }
                return redirect()->route('user.import')->with('error', $message);
            }

            DB::beginTransaction();
            
            try {
                $insert = [];
                foreach ($data as $baris => $value) {
                    if ($baris > 1) {
                        $password = $value['D'] ?? '';
                        if (strlen($password) < 5) {
                            $password = str_pad($password, 5, '0');
                        }
                        
                        $insert[] = [ 
                            'role_id' => $value['A'] ?? null, 
                            'username' => $value['B'] ?? '', 
                            'name' => $value['C'] ?? '',
                            'password' => bcrypt($password),
                            'status' => $value['E'] ?? 1,
                            'created_at' => now(),
                        ];
                    }
                }

                if (count($insert) > 0) {
                    UserModel::insert($insert);
                    DB::commit();
                    
                    $successMessage = count($insert) . ' data berhasil diimport';
                    
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([ 
                            'status' => true, 
                            'message' => $successMessage,
                            'redirect' => route('user.index')
                        ]);
                    }
                    
                    return redirect()->route('user.index')->with('success', $successMessage);
                }

                throw new \Exception('Tidak ada data yang valid untuk diimport');

            } catch (\Exception $e) {
                DB::rollBack();
                
                $errorMessage = 'Gagal mengimport data: ' . $e->getMessage();
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'status' => false,
                        'message' => $errorMessage,
                        'redirect' => route('user.import')
                    ]);
                }
                return redirect()->route('user.import')->with('error', $errorMessage);
            }

        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan: ' . $e->getMessage();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => $errorMessage,
                    'redirect' => route('user.import')
                ], 500);
            }
            return redirect()->route('user.import')->with('error', $errorMessage);
        }
    }
}
