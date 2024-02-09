@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endsection

@section('title')
  <title>管理画面</title>
@endsection

@section('header-left')
  @include('parts.menuButton')
@endsection


@section('main')
  <h2 class="title">店舗代表者アカウント作成</h2>
  <form action="/admin/register" class="manager-form" method="post">
    @csrf
    <table class="register-contents">
      <tr>
        <td>氏名</td>
        <td>
          @if ($errors->has('name'))
            <span class="error">{{ $errors->first('name') }}</span><br>
          @endif
          <input type="text" name="name" value="{{ old('name') }}">
        </td>
      </tr>
      <tr>
        <td>メールアドレス</td>
        <td>
          @if ($errors->has('email'))
            <span class="error"> {{ $errors->first('email') }}</span><br>
          @endif
          <input type="email" name="email" value="{{ old('email') }}">
        </td>
      </tr>
      <tr>
        <td>パスワード</td>
        <td>
          @if ($errors->has('password'))
            <span class="error"> {{ $errors->first('password') }}</span><br>
          @endif
          <input type="password" name="password" value="{{ old('password') }}">
        </td>
      </tr>
    </table>
    <div class="submit-button">
      <button>登録</button>
    </div>
  </form>
@endsection
