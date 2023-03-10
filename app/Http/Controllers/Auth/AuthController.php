<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::guard('web')->attempt($data)) {
            return redirect()->intended('/admin/dashboard');
        } elseif(Auth::guard('costumer')->attempt($data)) {
            return redirect()->intended('/');
        }
        return back()->with(['errors' => 'Akun Tidak Terdaftar']);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->intended('/');
    }
}
