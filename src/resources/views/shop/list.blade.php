@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/shop/list.css') }}">
@endsection

@section('title')
  <title>飲食店一覧</title>
@endsection

@section('header-right')
  <form action="/search" method="get">

    <table class="search-bar">
      <tr>
        <td class="search-option">
          <select name="area" id="">
            <option value="">All area</option>
            @foreach ($areas as $area)
              <option value="{{ $area->id }}">{{ $area->name }}</option>
            @endforeach
          </select>
        </td>

        <td class="search-option">
          <select name="genre" id="">
            <option value="">All genre</option>
            @foreach ($genres as $genre)
              <option value="{{ $genre->id }}">{{ $genre->name }}</option>
            @endforeach
          </select>
        </td>

        <td class="search-name">
          <input type="text" name="shop" placeholder="Search ...">
        </td>
      </tr>
    </table>

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
              {{-- @if (Auth::check()) --}}
              <form action="/change-like" method="post">
                @csrf
                <button class="icon" name="shopId" value="{{ $shop->id }}">
                  @if ($shop->like_id != null)
                    <img src="/image/like.png" alt="">
                  @else
                    <img src="/image/not-like.png" alt="">
                  @endif
                </button>
              </form>
              {{-- @endif --}}
            </div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
@endsection
