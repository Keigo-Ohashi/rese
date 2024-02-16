@extends('layouts.message')

@section('title')
  <title>店舗情報修正</title>
@endsection

@section('message')
  店舗情報が見つかりませんでした
@endsection

@section('link')
  <a href="{{ session('back') }}">戻る</a>
@endsection
