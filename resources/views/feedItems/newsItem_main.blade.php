<div class="jumbotron p-3 p-md-5 text-white rounded bg-dark">
        <div class="col-md-6 px-0">
            <strong class="d-inline-block mb-2 text-light">{{ $feedEntity->category->title }}</strong>
            <h1 class="display-4 font-italic"><span style="font-size: 40px">Главная новость: </span> <br> {{ $feedEntity->feedEntitiable->title }}</h1>
            <div class="mb-1">{{ date("H:i - d M y", strtotime($feedEntity->created_at)) }}</div>
            <p class="lead my-3">{{ $feedEntity->feedEntitiable->content }}</p>
            @if(isset($article) && $article == true)
                <a href="{{ url()->previous() }}" style="color: white">Назад</a>
            @else
                <a href="{{ route('article', $feedEntity) }}" style="color: white">Открыть новость</a>
            @endif
        </div>
</div>
