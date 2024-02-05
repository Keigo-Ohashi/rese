@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/manager/shopInfo.css') }}">
@endsection

@section('title')
  <title>
    @if (isset($shop))
      店舗情報修正
    @else
      店舗新規登録
    @endif
  </title>
@endsection

@section('header-left')
  @include('parts.menuButton')
@endsection

<script language="javascript">
  function previewImage(obj) {
    var fileReader = new FileReader();
    fileReader.onload = (function() {
      document.getElementById('preview').src = fileReader.result;
    });
    fileReader.readAsDataURL(obj.files[0]);
  }
</script>

@section('main')
  <h2>
    @if (isset($shop))
      店舗情報修正
    @else
      店舗情報新規登録
    @endif
  </h2>
  <form action="/manager/shop/register" class="shop-info-form" method="post" enctype="multipart/form-data">
    @csrf
    <table class="shop-options">
      <tr>
        <td>店名</td>
        <td>
          @if ($errors->has('name'))
            <span class="error">{{ $errors->first('name') }}</span><br>
          @endif
          <input type="text" name="name">
        </td>
      </tr>
      <tr>
        <td>エリア</td>
        <td>
          @if ($errors->has('areaId'))
            <span class="error">{{ $errors->first('areaId') }}</span><br>
          @endif
          <select name="areaId">
            <option value="">All area</option>
            @foreach ($areas as $area)
              <option value="{{ $area->id }}" @if (isset($shop) or old('areaId') == $area->id) selected @endif>{{ $area->name }}
              </option>
            @endforeach
          </select>
        </td>
      </tr>
      <tr>
        <td>ジャンル</td>
        <td>
          @if ($errors->has('genreId'))
            <span class="error">{{ $errors->first('genreId') }}</span><br>
          @endif
          <select name="genreId">
            <option value="">All genre</option>
            @foreach ($genres as $genre)
              <option value="{{ $genre->id }}" @if (isset($shop) or old('genreId') == $genre->id) selected @endif>{{ $genre->name }}
              </option>
            @endforeach
          </select>
        </td>
      </tr>

      <tr>
        <td>説明文</td>
        <td>
          @if ($errors->has('detail'))
            <span class="error">{{ $errors->first('detail') }}</span><br>
          @endif
          @if (!is_null(old('detail')))
            @if (isset($shop))
              <textarea name="detail" cols="30" rows="10">{{ $shop->detail }}</textarea>
            @else
              <textarea name="detail" cols="30" rows="10"></textarea>
            @endif
          @else
            <textarea name="detail" cols="30" rows="10">{{ old('detail') }}</textarea>
          @endif
        </td>
      </tr>

      <tr>
        <td>店舗画像</td>
        <td>
          @if ($errors->has('image'))
            <span class="error">{{ $errors->first('image') }}</span><br>
          @endif
          @if (isset($image))
            <img src="{{ $image }}" alt="" id="preview">
          @else
            <img src="{{ asset('image/manager/no_image.jpg') }}" alt="" id="preview">
          @endif
          <br>
          <input type="file" name="image" onchange="previewImage(this)">
        </td>
      </tr>

      <tr>
        <td class="submit-button">
          <button>
            @if (isset($shop))
              修正
            @else
              登録
            @endif
          </button>
        </td>
      </tr>
    </table>
  </form>
@endsection
