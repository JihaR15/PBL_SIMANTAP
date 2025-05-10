<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login() 
    { 
        if(Auth::check()){ // jika sudah login, maka redirect ke halaman home 
            return redirect('/'); 
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
                        'redirect' => url('/')
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

}
