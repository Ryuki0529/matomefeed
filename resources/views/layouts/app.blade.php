<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>まとめサイト速報・サクサク読める（{{ config('app.name', 'Laravel') }}）| まとめニュースの決定版！</title>
  <meta name="description" content="数多く存在する5ch・Twitterまとめサイトを集約し、画像付きのリッチなUIで配信します。記事はカテゴリーとタグで細かく分類し、好きな記事を簡単に探すことができます。アカウント登録することで、オリジナルのフィルターを作って記事を絞り込んだり、お気に入りのまとめサイトを登録できます。">
  <meta name="keywords" content="5ch,2ch,まとめサイト,Twitter,ニュース,速報">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-M6JCYX13KQ"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-M6JCYX13KQ');
  </script>
</head>

<body>
  <div id="app">
    <nav class="header-navber">
      <div class="left-nav">
        <a class="navbar-brand" href="{{ url('/') }}">
          {{ config('app.name', 'Laravel') }}
        </a>
      </div>
      <div class="right-nav">
        <ul class="navbar-nav">
          <!-- Authentication Links -->
          @guest
          @if (Route::has('login'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">サインイン</a>
          </li>
          @endif

          @if (Route::has('register'))
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">アカウント登録</a>
          </li>
          @endif
          @else
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
              </form>
            </div>
          </li>
          @endguest
        </ul>
      </div>
    </nav>

    <main class="py-4">
      @yield('content')
    </main>
  </div>
</body>

</html>
