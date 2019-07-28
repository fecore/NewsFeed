
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Новостая Лента</title>

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

{{--    <!-- Bootstrap core CSS -->--}}
{{--    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">--}}

{{--    <!-- Custom styles for this template -->--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">--}}
{{--    <link href="blog.css" rel="stylesheet">--}}
</head>

<body>

<div class="container">
    <header class="blog-header py-3">
        <div class="row flex-nowrap justify-content-between align-items-center">
            <div class="col-8 pt-1">
                <a class="text-muted" href="/">{{ config('app.name') }}</a>
            </div>
{{--            {{ --}}
{{--            <div class="col-4 text-center">--}}
{{--                <a class="blog-header-logo text-dark" href="#">Large</a>--}}
{{--            </div>--}}
            <div class="col-4 d-flex justify-content-end align-items-center">
                <a class="btn btn-sm btn-outline-secondary" href="{{route('login')}}">Войти</a>
            </div>
        </div>
    </header>

    <div class="nav-scroller py-1 mb-4">
        <nav class="nav d-flex justify-content-between">
            <a class="p-2 text-muted" href="{{route('index')}}">Главная</a>
        @foreach($allCategories as $category)
                <a class="p-2 text-muted" href="{{route('category', $category)}}">{{$category->title}}</a>
            @endforeach
        </nav>
    </div>

    @yield('content')
</div>

<footer class="blog-footer mt-5">
    <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
</footer>
</body>
</html>
