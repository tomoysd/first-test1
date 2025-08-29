@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/common.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
  <p class="center" style="font-size:20px;margin:40px 0;">
    お問い合わせありがとうございました
  </p>
  <p class="center">
    <a class="btn" href="{{ url('/') }}">HOME</a>
  </p>
@endsection