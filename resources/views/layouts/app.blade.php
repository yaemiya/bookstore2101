<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ 'BOOKSTORE' }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    {{-- 住所自動表示 --}}
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
</head>

<body>
    <div id="app">
        <div class="mt-3 container">
            {{-- 会員名 --}}
            <div class="text-right text-dark lead">
                @auth
                {{Auth::user()->name }}さん
                @else
                {{'ゲスト '}}さん
                @endauth
            </div>
            <nav class="navbar navbar-expand-md navbar-light shadow-sm bt-2 bg-dark">
                {{-- ロゴ --}}
                <div class="logo mr-auto">
                    <a class="navbar-brand ml-5" href="{{ url('/') }}">
                        <h3 class="text-light">BOOKSTORE</h3>
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>

                <ul class="navbar-nav ml-auto">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        {{-- カートアイコン --}}
                        <li class="d-flex align-items-center justify-content-center">
                            <a href="{{ url('cart') }}"><i class="fas fa-shopping-cart h4"></i></a>
                        </li>　
                        {{-- アカウントアイコン --}}
                        <li class="d-flex align-items-center justify-content-center dropdown">
                            <a href="" class="dropdown-toggle" id="dropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fas fa-user h4 ml-3"></i></a>
                            <!-- Authentication Links -->
                            {{-- ゲスト時 --}}
                            @guest
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                {{-- ログイン --}}
                                <a class="dropdown-item" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                                {{-- 新規会員登録 --}}
                                @if (Route::has('register'))
                                <a class="dropdown-item" href="{{ route('register') }}">{{ __('アカウント新規登録') }}</a>
                                @endif
                                {{-- ログイン時 --}}
                                @else
                                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    {{-- ログアウト --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ログアウト') }}
                                    </a>
                                    {{-- アカウント情報編集 --}}
                                    <a class="dropdown-item" href="{{ route('auth.edit') }}">
                                        {{ __('アカウント編集') }}
                                    </a>
                                    {{-- アカウント情報削除 --}}
                                    <a class="dropdown-item" href="{{ route('auth.delete') }}">
                                        {{ __('アカウント削除') }}
                                    </a>
                                    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    </form> --}}
                                </div>
                        </li>
                        @endguest
                    </div>
                </ul>
            </nav>

            {{-- 検索 --}}
            <nav class="navbar navbar-expand-md navbar-dark bg-dark">
                <form class="mr-2 my-auto w-100 d-inline-block order-1" action="{{ url('search') }}">
                    <div class="d-flex flex-grow-1">
                        <select class="form-control flex-grow-1 mr-4" name="genre" id="exampleFormControlSelect1"
                            style="width:250px;">
                            <option>すべて</option>
                            <option value="本" @if(isset($genre) && $genre==='本' ) selected @endif>本</option>
                            <option value="コミック" @if(isset($genre) && $genre==='コミック' ) selected @endif>コミック</option>
                            <option value="雑誌" @if(isset($genre) && $genre==='雑誌' ) selected @endif>雑誌</option>
                            <option value="洋書" @if(isset($genre) && $genre==='洋書' ) selected @endif>洋書</option>
                        </select>
                        <div class="input-group">
                            <input type="text" name="keywords" @isset($keywords) value="{{ $keywords }}" @endisset
                                class=" form-control border border-right-0" placeholder="">
                            <span class="input-group-append">
                                <button class="btn border border-left-0" type="submit">
                                    <i class="fa fa-search text-light"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    <button class="navbar-toggler order-0" type="button" data-toggle="collapse" data-target="#navbar7">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </form>
            </nav>

            {{-- ジャンルタブ --}}
            <nav class="navbar navbar-expand-md navbar-light shadow-sm pb-4 bg-dark">

                <ul class="nav nav-tabs nav-justified w-100">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">トップ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('books_genre') }}">本</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('comics_genre') }}">コミック</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('magazines_genre') }}">雑誌</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('foreign_books_genre') }}">洋書</a>
                    </li>
                </ul>
            </nav>
        </div>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>