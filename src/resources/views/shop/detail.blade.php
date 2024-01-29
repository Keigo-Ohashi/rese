@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/shop/detail.css') }}">
@endsection

@section('title')
  <title>飲食店詳細</title>
@endsection

@section('header-left')
  @include('parts.menuButton')
@endsection



@section('main')
  <div class="shop-info">
    <div class="shop-title">
      <div class="back-link">
        <a href="{{ session('back') }}"><img src="{{ asset('image/shop/back_link.png') }}" alt=""></a>
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

      <table>
        @if ($errors->has('date'))
          <tr>
            <td></td>
            <td class="error">
              <div>{{ $errors->first('date') }}</div>
            </td>
          </tr>
        @endif
        <tr>
          <td class="item-name">日付：</td>
          <td class="item-input">
            @if (is_null(old('date')))
              <input type="date" name="date" value="{{ date('Y-m-d') }}">
            @else
              <input type="date" name="date" value="{{ old('date') }}">
            @endif
          </td>
        </tr>
        @if ($errors->has('time'))
          <tr>
            <td></td>
            <td class="error">
              <div>{{ $errors->first('time') }}</div>
            </td>
          </tr>
        @endif
        <tr>
          <td class="item-name">時間：</td>
          <td class="item-input">
            <input type="time" name="time" value="{{ old('time') }}">
          </td>
        </tr>
        @if ($errors->has('numPeople'))
          <tr>
            <td></td>
            <td class="error">
              <div>{{ $errors->first('numPeople') }}</div>
            </td>
          </tr>
        @endif
        <tr>
          <td class="item-name">人数：</td>
          <td class="item-input">
            @if (is_null(old('numPeople')))
              <input type="number" name="numPeople" value="1">
            @else
              <input type="number" name="numPeople" value="{{ old('numPeople') }}">
            @endif
          </td>
        </tr>
      </table>
      <input type="hidden" name="shopId" value="{{ $shop->id }}">
    </div>
    <div class="submit-button">
      <button>予約する</button>
    </div>
  </form>
@endsection
