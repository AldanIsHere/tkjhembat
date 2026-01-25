<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    // Halaman dashboard siswa
    public function index()
    {
        return view('siswa.dashboard');
    }
}
