@extends('layouts.app')

    @section('css')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}"> 
    @endsection

    @section('header_actions')
    <nav class="hd-actions">
        <a href="{{ route('login') }}" class="btn btn--ghost btn--sm">login</a>
    </nav>
    @endsection

    @section('content')
    <h1 class="subttl">Register</h1>

    <div class="card card--narrow">
        <form method="POST" action="{{ route('register.custom') }}" novalidate>
            @csrf

            {{-- お名前 --}}
            <div class="form_group">
            <label class="form_label">お名前 </label>
            <input type="text" name="name" value="{{ old('name') }}" class="form_input" placeholder="例:山田 太郎">
            @error('name')   <div class="form_error">{{ $message }}</div> @enderror
            </div>

            {{-- メールアドレス --}}
            <div class="form_group">
            <label class="form_label">メールアドレス</label>
            <input type="email" name="email" value="{{ old('email') }}" class="form_input" placeholder="例:test@example.com">
            @error('email')  <div class="form_error">{{ $message }}</div> @enderror
            </div>

            {{-- パスワード --}}
            <div class="form_group">
            <label class="form_label">パスワード </label>
            <input type="password" name="password" class="form_input" placeholder="例:coachtech1106">
            @error('password') <div class="form_error">{{ $message }}</div> @enderror
            </div>

            {{-- パスワード確認 --}}
        <div class="form_group">
        <label class="form_label">パスワード確認 <span class="req">※</span></label>
        <input type="password" name="password_confirmation" class="form_input" placeholder="同じパスワードを入力">
        </div>

            <div class="form_actions" style="text-align:center;margin-top:18px;">
            <button type="submit" class="btn">登録</button>
            </div>
        </form>
    </div>


    @endsection