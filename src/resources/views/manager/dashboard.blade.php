@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/manager/dashboard.css') }}">
@endsection

@section('title')
  <title>管理画面</title>
@endsection

@section('header-left')
  @include('parts.menuButton')
@endsection


@section('main')
  <form action="/manager/search" class="search-form">
    <table class="search-options">
      <tr>
        <td>エリア</td>
        <td class="search-option">
          <select name="areaId">
            <option value="">All area</option>
            @foreach ($areas as $area)
              <option value="{{ $area->id }}" @if (session('areaId') == $area->id) selected @endif>{{ $area->name }}
              </option>
            @endforeach
          </select>
        </td>
      </tr>
      <tr>
        <td>ジャンル</td>
        <td class="search-option">
          <select name="genreId" id="">
            <option value="">All genre</option>
            @foreach ($genres as $genre)
              <option value="{{ $genre->id }}" @if (session('genreId') == $genre->id) selected @endif>{{ $genre->name }}
              </option>
            @endforeach
          </select>
        </td>
      </tr>
      <tr>
        <td>店名</td>
        <td class="search-option">
          <input type="text" name="shopName" value="{{ session('shopName') }}">
        </td>
      </tr>
      <tr class="search-button">
        <td><button>検索</button></td>
      </tr>
    </table>

  </form>

  <table class="shop-list">
    <tr>
      <th>店名</th>
      <th>エリア</th>
      <th>ジャンル</th>
      <th><button type="button" onclick="location.href='/manager/shop/register'">新規登録</button></th>
    </tr>
    @foreach ($shops as $shop)
      <tr class="shop">
        <td>{{ $shop->name }}</td>
        <td>{{ $shop->area_name }}</td>
        <td>{{ $shop->genre_name }}</td>
        <td>
          <button type="button" onclick="location.href='/manager/shop/{{ $shop->id }}/modify'">情報修正</button>
          <button type="button"
            onclick="location.href='/manager/shop/{{ $shop->id }}/confirm-reservation'">予約確認</button>
        </td>
      </tr>
    @endforeach
  </table>
@endsection
