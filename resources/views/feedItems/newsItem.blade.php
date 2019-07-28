<div class="row mb-2">
    <div class="col-md-12">
        <div class="card flex-md-row mb-4 box-shadow">
            <div class="card-body d-flex flex-column align-items-start">
                <strong class="d-inline-block mb-2 text-primary">{{ $feedEntity->category->title }}</strong>
                <h3 class="mb-0">
                    <a class="text-dark" href="{{ route('article', $feedEntity) }}">{{ $feedEntity->feedEntitiable->title }}</a>
                </h3>
                <div class="mb-1">{{ date("H:i - d M y", strtotime($feedEntity->created_at)) }}</div>
                <p class="card-text mb-auto">{{ $feedEntity->feedEntitiable->content }}</p>
                @if(isset($article) && $article == true)
                    <a href="{{ url()->previous() }}">Назад</a>
                @else
                    <a href="{{ route('article', $feedEntity) }}">Открыть новость</a>
                @endif
            </div>
        </div>
    </div>
</div>
