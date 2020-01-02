<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo')</title>
    <link rel="stylesheet" href="{{public_path('css/css_reportes/bootstrap.css')}}">
    <link rel="stylesheet" href="{{public_path('/css/procedimientos/singlepage.css')}}">
    @yield('styles')
</head>
<body>
    <header>
        <div class="row">
            <div class="col-xs-12">
                @yield('content-header')
            </div>
        </div>
    </header>
    <main>
        <div class="row">
            <div class="col-xs-12">
                @yield('content-main')
            </div>
        </div>
    </main>
    <footer>
        <div class="row">
            <div class="col-xs-12">
                @yield('content-footer')
            </div>
        </div>
    </footer>
</body>
</html>