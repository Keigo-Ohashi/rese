@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endsection

@section('title')
  <title>メニュ－</title>
@endsection

@section('header-left')
  <a class="menu-button" href="/">
    <img src="{{ asset('image/common/menuExitButton.png') }}" alt="メニューボタン">
  </a>
@endsection

@section('main')
  <nav class="link-list">
    <ul>
      <li class="link">
        <a href="/">Home</a>
      </li>
      @if (Auth::check())
        <li class="link">
          <form action="logout" method="post">
            @csrf
            <button>Logout</button>
          </form>
        </li>
        @hasanyrole('user')
          <li class="link">
            <a href="/my-page">Mypage</a>
          </li>
        @endhasanyrole
      @else
        <li class="link">
          <a href="/register">Registration</a>
        </li>
        <li class="link">
          <a href="/login">Login</a>
        </li>
      @endif
    </ul>
  </nav>
@endsection
