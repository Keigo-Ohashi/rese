@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/manager/reservation.css') }}">
@endsection

@section('title')
  <title>予約確認</title>
@endsection

@section('header-left')
  @include('parts.menuButton')
@endsection


@section('main')
  <h2 class="reservation-title">{{ $shop->name }} 予約一覧 <button type="button"
      onclick="location.href='{{ session('back') }}'">戻る</button></h2>

  @if (count($reservationsToday) == 0)
    <p class="message">本日の予約はありません</p>
  @else
    <p class="message">本日の予約</p>
    <form action="/manager/shop/reservation/came" method="post">
      @csrf
      <input type="hidden" name="shopId" value="{{ $shopId }}">
      <table class="reservations">
        <tr>
          <th>ユーザー名</th>
          <th>予約日時</th>
          <th>人数</th>
          <th>来店状況</th>
        </tr>
        @foreach ($reservationsToday as $reservation)
          <tr>
            <td>{{ $reservation->user_name }}</td>
            <td>{{ $reservation->date_time }}</td>
            <td>{{ $reservation->num_people }}人</td>
            <td>
              @if ($reservation->is_came == 1)
                来店済
              @else
                <button name="reservationId" value="{{ $reservation->id }}">来店確認</button>
              @endif
            </td>
          </tr>
        @endforeach
      </table>
    </form>
  @endif

  @if (count($reservationsAfterToday) == 0)
    <p class="message">明日以降の予約はありません</p>
  @else
    <p class="message">明日以降の予約</p>
    <table class="reservations">
      <tr>
        <th>ユーザー名</th>
        <th>予約日時</th>
        <th>人数</th>
      </tr>
      @foreach ($reservationsAfterToday as $reservation)
        <tr>
          <td>{{ $reservation->user_name }}</td>
          <td>{{ $reservation->date_time }}</td>
          <td>{{ $reservation->num_people }}人</td>
        </tr>
      @endforeach
    </table>
  @endif

@endsection
