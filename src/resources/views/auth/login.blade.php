@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

{{-- ヘッダー右上に「register」ボタン --}}
    @section('header_actions')
    <nav class="hd-actions">
        <a href="{{ route('register') }}" class="btn btn--ghost btn--sm">register</a>
    </nav>
    @endsection

    @section('content')
    <div class ="auth">
    <h1 class="subttl">Login</h1>
    
        <div class="card card--narrow">
            <form method="POST" action="{{ route('login.custom') }}" novalidate>
            @csrf

        {{-- メールアドレス --}}
        <div class="form_group">
            <label class="form_label">メールアドレス </label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="form_input" placeholder="例:test@example.com" autofocus>
            @error('email')
            <div class="form_error">{{ $message }}</div>
            @enderror
        </div>

        {{-- パスワード --}}
        <div class="form_group">
            <label class="form_label">パスワード </label>
            <input type="password" name="password" class="form_input" placeholder="例：coachtech1106">
            @error('password')
            <div class="form_error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form_actions" style="text-align:center;margin-top:18px;">
            <button type="submit" class="btn">ログイン</button>
        </div>
            </form>
        </div>
    </div>
    @endsection