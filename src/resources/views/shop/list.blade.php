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
            @foreach ($areas as $area)
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
