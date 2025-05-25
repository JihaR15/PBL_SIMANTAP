<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LaporanModel;
use App\Models\PerbaikanModel;

class WelcomeController extends Controller
{

    public function landing(){
        $activeMenu = 'landing';
        $userCount = UserModel::count();
        $laporanCount = LaporanModel::count();
        $perbaikanCount = PerbaikanModel::count();
        return view('landing', [
            'title' => 'Selamat Datang di SIMANTAP',
            'activeMenu' => $activeMenu,
            'userCount' => $userCount,
            'laporanCount' => $laporanCount,
            'perbaikanCount' => $perbaikanCount,
            'breadcrumbs' => [
                ['label' => 'Landing']
            ]
        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        $activeMenu = 'dashboard';
        return view('welcome', [
            'title' => 'Selamat Datang, ' . $user->name,
            'activeMenu' => $activeMenu,
            'breadcrumbs' => [
                ['label' => 'Dashboard']
            ]
        ]);
    }
}
