@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/shop/detail.css') }}">
@endsection

@section('title')
  <title>飲食店詳細</title>
@endsection

@section('header-left')
  <a class="menu-button" href="/menu">
    <img src="{{ asset('image/common/menuButton.png') }}" alt="メニューボタン">
  </a>

  <h1><a href="/">Rese</a></h1>
@endsection



@section('main')
  <div class="shop-info">
    <div class="shop-title">
      <div class="back-link">
        <a href="{{ $back }}"><img src="{{ asset('image/shop/back_link.png') }}" alt=""></a>
      </div>
      <h2 class="shop-name">{{ $shop->name }}</h2>
      @if (Auth::check())
        <form method="post" class="shop-like">
          @csrf
          @if (is_null($shop->like_id))
            <button formaction="/like" class="icon" name="shopId" value="{{ $shop->id }}">
              <img src="/image/shop/not-like.png" alt="">
            </button>
          @else
            <button formaction="/unlike" class="icon" name="shopId" value="{{ $shop->id }}">
              <img src="/image/shop/like.png" alt="">
            </button>
          @endif
          <input type="hidden" name="referrer" value="{{ $referrer }}">
        </form>
      @endif
    </div>
    <div class="shop-image"><img src="{{ $image }}" alt=""></div>
    <div class="shop-tag">#{{ $shop->area_name }} #{{ $shop->genre_name }}</div>
    <div class="shop-description">
      <p>{{ $shop->detail }}</p>
    </div>
  </div>


  <form action="/reserve" method="post" class="reserve-form">
    <div class="reserve-inputs">
      @csrf
      <h3 class="reserve-title">
        予約
      </h3>
      <div class="reserve-input">
        日付 ：@if (is_null(old('date')))
          <input type="date" name="date" value="{{ date('Y-m-d') }}">
        @else
          <input type="date" name="date" value="{{ old('date') }}">
        @endif
      </div>
      <div class="reserve-input">
        時間 ： <input type="time" name="time" value="{{ old('time') }}">
      </div>
      <div class="reserve-input">
        人数 ： <input type="number" name="numPeople" value="{{ old('numPeople') }}">
      </div>
    </div>
    <div class="submit-button">
      <button>予約する</button>
    </div>
  </form>

@endsection
