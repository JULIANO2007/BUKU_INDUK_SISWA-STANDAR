<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class Authorization extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function auth(Request $request){
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        // Try to authenticate with email first
        if (Auth::attempt($credentials)){
            $request->session()->regenerate();
            if(auth()->user()->status == 'admin'){
                return redirect()->intended('/dashboard');
            }
            return redirect()->intended('/dashboard-siswa');
        }

        // If email authentication fails, try with NISN or nama_lengkap as username
        $user = \App\Models\User::where('nisn', $request->email)
                               ->orWhere('nama_lengkap', $request->email)
                               ->first();
                               
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();
            if($user->status == 'admin'){
                return redirect()->intended('/dashboard');
            }
            return redirect()->intended('/dashboard-siswa');
        }

        return back()->with('auth_error', 'Username atau Password anda salah');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function adjust(){
        if(auth()->user()->status == 'admin'){
            return redirect()->intended('/dashboard');
        }
        return redirect()->intended('/dashboard-siswa');
    }
}
