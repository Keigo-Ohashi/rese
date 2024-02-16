@extends('layouts.message')

@section('title')
  <title>飲食店詳細</title>
@endsection

@section('message')
  お店の情報が見つかりませんでした
@endsection

@section('link')
  <a href="{{ session('back') }}">戻る</a>
@endsection
