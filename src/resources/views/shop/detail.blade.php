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

  <form method="post" class="reserve-form">

    <div class="reserve-inputs">
      @csrf
      <h3 class="reserve-title">
        @if (isset($reservation))
          予約修正
        @else
          新規予約
        @endif
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
              @if (isset($reservation))
                <input type="date" name="date" value="{{ $reservation->date }}">
              @else
                <input type="date" name="date" value="{{ date('Y-m-d') }}">
              @endif
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
            @if (isset($reservation))
              <input type="time" name="time" value="{{ $reservation->time }}">
            @else
              <input type="time" name="time" value="{{ old('time') }}">
            @endif
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
              @if (isset($reservation))
                <input type="number" name="numPeople" value="{{ $reservation->num_people }}">
              @else
                <input type="number" name="numPeople" value="1">
              @endif
            @else
              <input type="number" name="numPeople" value="{{ old('numPeople') }}">
            @endif
          </td>
        </tr>
      </table>
      @if (isset($reservation))
        <input type="hidden" name="reservationId" value="{{ $reservation->id }}">
      @else
        <input type="hidden" name="shopId" value="{{ $shop->id }}">
      @endif
    </div>
    <div class="submit-button">
      @if (isset($reservation))
        <button formaction="/reservation/modify">予約修正</button>
      @else
        <button formaction="/reserve">予約する</button>
      @endif
    </div>
  </form>
@endsection
