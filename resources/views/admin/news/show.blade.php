@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Новость #{{$newsItem->id}}</div>

                    <form action="{{route('news.update', $newsItem)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Заголовок</label>
                                <input type="text" name="title" class="form-control" disabled value="{{ $newsItem->title }}">
                            </div>
                            <div class="form-group">
                                <label>Контент</label>
                                <textarea class="form-control" name = "content" rows="10" disabled>{{ $newsItem->content }}</textarea>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" name = "main_news" value = "1"  disabled class="form-check-input main_news_checkbox" id="main_news"
                                    {{
                                        ($newsItem->main_news == 1)  ? 'checked' : ''
                                    }}
                                   >
                                <label class="form-check-label" for="main_news">Главная новость (Будет добавлена в итог дня)</label>
                            </div>
                            @if($newsItem->feedEntity->category->type != 'day_summary')
                            <div class="form-group">
                                <label for="category">Категория</label>
                                <select name = "category_id" class="form-control" id="category" disabled>
                                    <option>{{ $newsItem->feedEntity->category->title }}</option>
                                </select>
                            </div>
                            @endif

                            <a href="{{ route('news.edit', $newsItem) }}" class="btn btn-primary mb-2">Редактировать</a>
                            <a type="submit" href = "{{route('dashboard')}}" class="btn btn-secondary mb-2">Назад</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
