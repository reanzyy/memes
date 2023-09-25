<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }

    public function storeLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|max:255',
            'password' => 'required|max:255',
        ], [
            'username.required' => 'Username harus diisi!',
            'username.max' => 'Username hanya boleh diisi maksimal 255 karakter!',
            'password.required' => 'Password harus diisi!',
            'password.max' => 'Password hanya boleh diisi maksimal 255 karakter',
        ]);

        $user = User::where('username', $request->username)
            ->first();

        if (!$user) {
            return redirect('login')->with('error', 'Username dan password tidak sesuai!');
        }

        if (Hash::check($request->password, $user->password)) {
            Auth::loginUsingId($user->id);
            return redirect()->route('dashboard')->withSuccess("Selamat Datang {$user->name}");
        }

        return redirect('login')->with('error', 'Username dan password tidak sesuai!');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|confirmed|min:8'
        ],[
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username tidak tersedia',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Password dan Password konfirmasi tidak sama!',
            'password.min' => 'Minimal 8 karakter',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('login')->with('success', 'Akun berhasil dibuat silahkan login ulang!');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect('login')->with('success', 'Anda sudah logout');
    }
}