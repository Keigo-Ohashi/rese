@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/shop/card.css') }}">
  <link rel="stylesheet" href="{{ asset('css/shop/myPage.css') }}">
@endsection

@section('title')
  <title>マイページ</title>
@endsection

@section('header-left')
  @include('parts.menuButton')
@endsection

@section('main')
  <div class="user-name">
    {{ Auth::user()->name }}さん
  </div>
  <div class="my-page-content">
    <div class="reservations">
      <h2>予約状況</h2>
      @if ($reservations->count() == 0)
        <p>予約情報がありません</p>
      @endif
      @foreach ($reservations as $reservation)
        <a href="/modify-reservation/{{ $reservation->id }}" class="reservation">
          <div class="reservation-head">
            <div class="reservation-img">
              <img src="/image/myPage/clock.png" alt="">
            </div>
            <form action="delete-reservation" method="post" class="delete-button">
              @csrf
              <button name="reservationId" value="{{ $reservation->id }}">
                <img src="/image/myPage/delete.png" alt="">
              </button>
            </form>
          </div>
          <table class="reservation-content">
            <tr>
              <td>Shop</td>
              <td>{{ $reservation->shop_name }}</td>
            </tr>
            <tr>
              <td>Date</td>
              <td>{{ $reservation->date }}</td>
            </tr>
            <tr>
              <td>Time</td>
              <td>{{ $reservation->time }}</td>
            </tr>
            <tr>
              <td>Number</td>
              <td>{{ $reservation->num_people }}人</td>
            </tr>
          </table>
        </a>
      @endforeach

    </div>

    <div class="like-shops">
      <h2>お気に入り店舗</h2>
      <div class="cards">
        @if ($shops->count() == 0)
          <p>お気に入り店舗がありません</p>
        @endif
        @foreach ($shops as $shop)
          @include('parts.shopCard', compact('shop'))
        @endforeach
      </div>
    </div>
  </div>
@endsection
