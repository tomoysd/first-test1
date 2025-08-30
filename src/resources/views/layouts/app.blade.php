<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>FashionablyLate</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
  @yield('css')
</head>
<body>

  {{-- thanks 等でヘッダーを消したいときは、そのビューで @section('no_header') を宣言 --}}
  @hasSection('no_header')
      {{-- ヘッダー無し --}}
  @else
      <header class="header">
        <div class="wrap header__bar">
          <div class="header__logo">FashionablyLate</div>
          @yield('header_actions')
        </div>
      </header>
  @endif

  <main>
    <div class="wrap">
      @yield('content')
    </div>
  </main>

</body>
</html>