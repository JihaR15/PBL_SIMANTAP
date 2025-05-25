<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use App\Models\RoleModel;

class AuthController extends Controller
{
    public function login() 
    { 
        if(Auth::check()){ // jika sudah login, maka redirect ke halaman home 
            return redirect('/dashboard'); 
        } 
        return view('auth.login'); 
    }

    public function postlogin(Request $request) 
    { 
        if ($request->ajax() || $request->wantsJson()) { 
            $credentials = $request->only('username', 'password'); 
    
            if (Auth::attempt($credentials)) { 
                // Periksa apakah status pengguna adalah 1 (Aktif)
                if (Auth::user()->status == 1) {
                    $request->session()->regenerate();
                    return response()->json([ 
                        'status' => true, 
                        'user' => Auth::user(),
                        'message' => 'Login Berhasil', 
                        'redirect' => url('/dashboard')
                    ]); 
                }
    
                // Logout jika status pengguna bukan 1
                Auth::logout();
                return response()->json([
                    'status' => false,
                    'message' => 'Akun Anda tidak aktif. Silakan hubungi administrator.'
                ]);
            } 
    
            return response()->json([ 
                'status' => false, 
                'message' => 'Login Gagal. Username atau password salah.'
            ]); 
        } 
    
        return redirect('login'); 
    }

    public function logout(Request $request) 
    { 
        Auth::logout(); 
 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();     
        return redirect('login'); 
    }

    public function register() 
    { 
        $pelapor = RoleModel::whereIn('kode_role', ['MHS', 'DSN', 'TDK'])->get();
        return view('auth.register', compact('pelapor')); 
    }

    public function postregister(Request $request) 
    { 
        $this->validate($request, [ 
            'role_id' => 'required|exists:m_role,role_id',
            'username' => 'required|unique:m_users', 
            'name' => 'required', 
            'password' => 'required|min:5|confirmed', 
        ]); 

        $user = new UserModel(); 
        $user->role_id = $request->role_id;
        $user->username = $request->username; 
        $user->name = $request->name; 
        $user->password = bcrypt($request->password); 
        $user->save(); 

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Registrasi berhasil. Tunggu Akun Anda diaktifkan oleh admin.',
                'redirect' => url('/login')
            ]);
        }

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Tunggu Akun Anda diaktifkan oleh admin.'); 
    }

}
