@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/shop/list.css') }}">
  <link rel="stylesheet" href="{{ asset('css/shop/card.css') }}">
@endsection

@section('title')
  <title>飲食店一覧</title>
@endsection

@section('header-left')
  @include('parts.menuButton')
@endsection

@section('header-right')
  <form action="/search" method="get">
    <div class="search-bar">

      <div class="search-options">
        <div class="search-option">
          <select name="areaId">
            <option value="">All area</option>
            @foreach ($areas as $area)
              <option value="{{ $area->id }}" @if (session('areaId') == $area->id) selected @endif>{{ $area->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="search-option">
          <select name="genreId" id="">
            <option value="">All genre</option>
            @foreach ($genres as $genre)
              <option value="{{ $genre->id }}" @if (session('genreId') == $genre->id) selected @endif>{{ $genre->name }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="search-names">
        <div class="search-name">
          <input type="text" name="shopName" placeholder="Search ..." value="{{ session('shopName') }}">
        </div>

        <div class="submit-button">
          <button><img src="{{ asset('image/shop/search.png') }}" alt=""></button>
        </div>
      </div>
    </div>

  </form>
@endsection

@section('main')
  <div class="cards">
    @foreach ($shops as $shop)
      @include('parts.shopCard', compact('shop'))
    @endforeach
  </div>
@endsection
