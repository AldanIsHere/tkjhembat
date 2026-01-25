<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Admin;

class AuthController extends Controller
{
    // FORM LOGIN
    public function loginForm()
    {
        return view('auth.login'); // login untuk admin, guru, siswa
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek login Siswa
        $siswa = Siswa::where('email', $request->email)->first();
        if($siswa && $siswa->password === $request->password) {
            session(['user_id' => $siswa->id, 'role' => 'siswa']);
            return redirect()->route('siswa.dashboard');
        }

        // Cek login Guru
        $guru = Guru::where('email', $request->email)->first();
        if($guru && $guru->password === $request->password) {
            session(['user_id' => $guru->id, 'role' => 'guru']);
            return redirect()->route('guru.dashboard');
        }

        // Cek login Admin
        $admin = Admin::where('email', $request->email)->first();
        if($admin && $admin->password === $request->password) {
            session(['user_id' => $admin->id, 'role' => 'admin']);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email atau password salah!');
    }

    // FORM REGISTER
    public function registerForm()
    {
        return view('auth.register');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        Siswa::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silahkan login.');
    }

    // LOGOUT
    public function logout()
    {
        session()->flush();
        return redirect()->route('auth.login');
    }
}
