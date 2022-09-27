<!DOCTYPE html>
<html lang="ja">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="/ress/ress.min.css">
        <link rel="stylesheet" href="/css/modaal.min.css">
        <link rel="stylesheet" href="/css/style.css">
        @yield('css')
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    </head>

    <!-- メインページ組み込み -->
    <body>
        <div class="wrapper">
          

        <header id="header" class="container">
                @include('includes.header')
            </header>

            <main>
                @yield('content')
            </main>

            <footer id="footer" class="container main">
                @include('includes.footer')
            </footer>
        </div>  

        <!-- jsファイルの読み込み -->        
        <script src="/js/jquery-3.6.0.min.js"></script>
        <script src="/js/modaal.min.js"></script>
        <script src="/js/main.js"></script>
        @yield('js')

    </body>

</html>
