<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return response()->json(['name' => Auth::user()->name], 200);
        }

        throw ValidationException::withMessages([
            'email' => '認証情報が正しくありません'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'ログアウト成功'], 200);
    }
}
