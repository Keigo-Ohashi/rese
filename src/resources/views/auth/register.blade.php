@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('title')
  <title>会員登録</title>
@endsection

@section('header-left')
  <a class="menu-button" href="/menu">
    <img src="{{ asset('image/menuButton.png') }}" alt="メニューボタン">
  </a>

  <h1><a href="/">Rese</a></h1>
@endsection

@section('main')
  <div class="auth">
    <h2 class="title">
      <div class="inner-title">Registration</div>
    </h2>

    <form action="/register" method="post">
      @csrf
      <div class="form-items">
        @if ($errors->has('name'))
          <div class="error">
            <div class="inner-error">
              {{ $errors->first('name') }}
            </div>
          </div>
        @endif

        <div class="form-item">
          <div class="form-icon"> <img src="{{ asset('image/auth/user.png') }}" alt=""> </div>
          <div class="form-input"> <input type="text" name="name" placeholder="Username"
              value="{{ old('name') }}"> </div>
        </div>

        @if ($errors->has('email'))
          <div class="error">
            <div class="inner-error">
              {{ $errors->first('email') }}
            </div>
          </div>
        @endif

        <div class="form-item">
          <div class="form-icon"> <img src="{{ asset('image/auth/email.png') }}" alt=""> </div>
          <div class="form-input"> <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
          </div>
        </div>

        @if ($errors->has('password'))
          <div class="error">
            <div class="inner-error">
              {{ $errors->first('password') }}
            </div>
          </div>
        @endif

        <div class="form-item">
          <div class="form-icon"> <img src="{{ asset('image/auth/password.png') }}" alt=""> </div>
          <div class="form-input"> <input type="password" name="password" placeholder="Password"> </div>
        </div>

        <div class="submit-button">
          <button>登録</button>
        </div>
      </div>
    </form>
  </div>
@endsection
