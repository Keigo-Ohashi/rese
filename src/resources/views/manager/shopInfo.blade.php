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
    <button type="button" onclick="location.href='{{ session('back') }}'">戻る</button>
  </h2>

  <form @if (isset($shop)) action="/manager/shop/modify" @else action="/manager/shop/register" @endif
    class="shop-info-form" method="post" enctype="multipart/form-data">

    @csrf

    @if (isset($shop))
      <input type="hidden" name="id" value="{{ $shop->id }}">
    @endif

    <table class="shop-options">
      <tr>
        <td>店名</td>
        <td>
          @if ($errors->has('name'))
            <span class="error">{{ $errors->first('name') }}</span><br>
          @endif
          @if (is_null(old('name')))
            @if (isset($shop))
              <input type="text" name="name" value="{{ $shop->name }}">
            @else
              <input type="text" name="name">
            @endif
          @else
            <input type="text" name="name" value="{{ old('name') }}">
          @endif

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
              @if (old('areaId') == $area->id)
                <option value="{{ $area->id }}" selected>{{ $area->name }}
                </option>
              @else
                @if (is_null(old('areaId')) and isset($shop) and $shop->area_id == $area->id)
                  <option value="{{ $area->id }}" selected>{{ $area->name }}
                  </option>
                @else
                  <option value="{{ $area->id }}">{{ $area->name }}
                  </option>
                @endif
                <option value="{{ $area->id }}">{{ $area->name }}
                </option>
              @endif
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
              @if (old('genreId') == $genre->id)
                <option value="{{ $genre->id }}" selected>{{ $genre->name }}
                </option>
              @else
                @if (is_null(old('genreId')) and isset($shop) and $shop->genre_id == $genre->id)
                  <option value="{{ $genre->id }}" selected>{{ $genre->name }}
                  </option>
                @else
                  <option value="{{ $genre->id }}">{{ $genre->name }}
                  </option>
                @endif
                <option value="{{ $genre->id }}">{{ $genre->name }}
                </option>
              @endif
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
          @if (is_null(old('detail')))
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

          @if (is_null(session('image')))
            @if (isset($image))
              <img src="{{ $image }}" alt="" id="preview">
            @else
              <img src="{{ asset('image/manager/no_image.jpg') }}" alt="" id="preview">
            @endif
          @else
            <img src="{{ session('image') }}" alt="" id="preview">
          @endif

          <br>

          <input type="file" id="input-file" name="image" onchange="previewImage(this)" accept=".jpeg,.jpg,.png">

          @if (is_null(session('imagePath')))
            @if (is_null(old('imagePath')))
              @if (isset($shop))
                <input type="hidden" name="imagePath" value="{{ $shop->image }}">
              @else
                <input type="hidden" name="imagePath">
              @endif
            @else
              <input type="hidden" name="imagePath" value="{{ old('imagePath') }}">
            @endif
          @else
            <input type="hidden" name="imagePath" value="{{ session('imagePath') }}">
          @endif
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
