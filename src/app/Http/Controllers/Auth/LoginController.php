<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials, false)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin'); // 成功時
        }

        return back()->withErrors([
            'email' => '認証情報と一致するレコードがありません。',
        ])->onlyInput('email');
    }
}
