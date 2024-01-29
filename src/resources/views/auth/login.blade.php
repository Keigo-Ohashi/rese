@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('title')
  <title>会員登録</title>
@endsection

@section('header-left')
  @include('parts.menuButton')
@endsection

@section('main')
  <div class="auth">
    <h2 class="title">
      <div class="inner-title">Login</div>
    </h2>

    <form action="/login" method="post">
      @csrf
      <div class="form-items">
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
          <button>ログイン</button>
        </div>
      </div>
    </form>
  </div>
@endsection
