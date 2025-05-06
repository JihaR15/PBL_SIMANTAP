<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
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
