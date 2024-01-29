@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('title')
  @yield('title')
@endsection

@section('header-left')
  @include('parts.menuButton')
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
