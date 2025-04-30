<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function dashboard()
    {
        return view('welcome', [
            'title' => 'Selamat Datang, user',
            'breadcrumbs' => [
                ['label' => 'Dashboard']
            ]
        ]);
    }
}
