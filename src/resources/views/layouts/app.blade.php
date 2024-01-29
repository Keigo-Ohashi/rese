<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/common/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common/common.css') }}">
  @yield('css')
  @yield('title')
</head>

<body>
  <header>

    <div class="header-left">
      @yield('header-left')
    </div>

    <div class="header-right">
      @yield('header-right')
    </div>
  </header>

  <main>
    @yield('main')
  </main>

</body>

</html>
