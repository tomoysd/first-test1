@extends('layouts.app')

@section('no_header')  @endsection  {{-- これでヘッダー消える --}}

@section('css')
<link rel="stylesheet" href="{{ asset('css/thanks.css') }}">
@endsection

@section('content')
<div class="thanks">
  {{-- 薄く入る背景テキスト --}}
  <div class="thanks__bg">Thank you</div>

  {{-- 真ん中のメッセージ＆ボタン --}}
  <div class="thanks__panel">
    <p class="thanks__msg">お問い合わせありがとうございました</p>
    <a href="{{ url('/') }}" class="btn btn--home">HOME</a>
  </div>
</div>
@endsection