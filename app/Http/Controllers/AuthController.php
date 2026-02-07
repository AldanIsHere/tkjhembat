<?php
<<<<<<< HEAD
namespace App\Http\Controllers;
=======

namespace App\Http\Controllers;

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Admin;
<<<<<<< HEAD
=======

>>>>>>> aa754e4d9f72db066b019e472b32ad5d3ec4e62d
class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $siswa = Siswa::where('email', $request->email)->first();
        if($siswa && $siswa->password === $request->password) {
            session(['user_id' => $siswa->id, 'role' => 'siswa']);
            return redirect()->route('siswa.dashboard');
        }
        $guru = Guru::where('email', $request->email)->first();
        if($guru && $guru->password === $request->password) {
            session(['user_id' => $guru->id, 'role' => 'guru']);
            return redirect()->route('guru.dashboard');
        }

        $admin = Admin::where('email', $request->email)->first();
        if($admin && $admin->password === $request->password) {
            session(['user_id' => $admin->id, 'role' => 'admin']);
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Email atau password salah!');
    }
    public function registerForm()
    {
        return view('auth.register');
    }

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
    public function logout()
    {
        session()->flush();
        return redirect()->route('auth.login');
    }
}
