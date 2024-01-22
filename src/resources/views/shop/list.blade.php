@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/shop/list.css') }}">
@endsection

@section('title')
  <title>飲食店一覧</title>
@endsection

@section('header-left')
  <a class="menu-button" href="/menu">
    <img src="{{ asset('image/menuButton.png') }}" alt="メニューボタン">
  </a>

  <h1><a href="/">Rese</a></h1>
@endsection

@section('header-right')
  <form action="/search" method="get">
    <div class="search-bar">

      <div class="search-option">
        <select name="areaId">
          <option value="">All area</option>
          @foreach ($areas as $area)
            <option value="{{ $area->id }}" @if (isset($areaId) and $areaId == $area->id) selected @endif>{{ $area->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="search-option">
        <select name="genreId" id="">
          <option value="">All genre</option>
          @foreach ($genres as $genre)
            <option value="{{ $genre->id }}" @if (isset($genreId) and $genreId == $genre->id) selected @endif>{{ $genre->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="search-name">
        <input type="text" name="shopName" placeholder="Search ..."
          @if (isset($shopName)) value="{{ $shopName }}" @endif>
      </div>

      <div class="submit-button">
        <button><img src="{{ asset('image/search.png') }}" alt=""></button>
      </div>
    </div>

  </form>
@endsection

@section('main')
  <div class="cards">
    @foreach ($shops as $shop)
      <div class="card">
        <a href="/detail/{{ $shop->id }}">
          <div class="shop-image"><img src="{{ $images[$shop->id] }}" alt=""></div>
          <div class="card--description">
            <h2 class="shop-name">{{ $shop->name }}</h2>
            <h3 class="tag">#{{ $shop->area_name }} #{{ $shop->genre_name }}</h3>
            <div class="card--footer">
              <div class="detail">詳しく見る</div>
              @if (Auth::check())
                <form action="/change-like" method="post">
                  @csrf
                  <button class="icon" name="shopId" value="{{ $shop->id }}">
                    @if ($shop->like_id != null)
                      <img src="/image/like.png" alt="">
                    @else
                      <img src="/image/not-like.png" alt="">
                    @endif
                  </button>
                  <input type="hidden" name="referrer" value="{{ $referrer }}">
                </form>
              @endif
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
@endsection
