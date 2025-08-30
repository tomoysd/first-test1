@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('content')
<h1 class="confirm-title">Confirm</h1>

  @php
    $genderTextMap = [
    '1' => '男性',
    '2' => '女性',
    '3' => 'その他',
    ];
    // 入力値（数字 or 文字列どちらでも対応）
    $genderValue = strval($inputs['gender'] ?? '');
    $genderText  = $genderTextMap[$genderValue] ?? '';
  @endphp


  <table class="table">
    <tr><th>お名前</th><td>{{ $inputs['last_name'] }} {{ $inputs['first_name'] }}</td></tr>
    <tr><th>性別</th><td>{{ $genderText }}</td></tr>
    <tr><th>メールアドレス</th><td>{{ $inputs['email'] }}</td></tr>
    <tr><th>電話番号</th><td>{{ $inputs['tel'] }}</td></tr>
    <tr><th>住所</th><td>{{ $inputs['address'] }}</td></tr>
    <tr><th>建物名</th><td>{{ $inputs['building'] ?? '' }}</td></tr>
    <tr><th>お問い合わせの種類</th><td>{{ $inputs['category_id'] }}</td></tr>
    <tr><th>お問い合わせ内容</th><td>{{ $inputs['detail'] }}</td></tr>
  </table>

  {{-- ボタンの横並びブロック --}}
  <div class="confirm-actions">
    {{-- 修正（入力に戻る） --}}
    <form method="GET" action="{{ url('/') }}">
      @foreach($inputs as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
      @endforeach
      <button class="btn btn--secondary" type="submit">修正</button>
    </form>

    {{-- 送信（保存/サンクスへ） --}}
    <form method="POST" action="{{ url('/send') }}">
      @csrf
      @foreach($inputs as $name => $value)
        <input type="hidden" name="{{ $name }}" value="{{ $value }}">
      @endforeach
      <button class="btn" type="submit">送信</button>
    </form>
  </div>
@endsection