@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('title')
  @yield('title')
@endsection

@section('header-left')
  <a class="menu-button" href="/menu">
    <img src="{{ asset('image/common/menuButton.png') }}" alt="メニューボタン">
  </a>

  <h1><a href="/">Rese</a></h1>
@endsection

@section('main')
  <div class="card">
    <h2 class="message">
      @yield('message')
    </h2>
    <div class="link">
      @yield('link')
    </div>
  </div>
@endsection
