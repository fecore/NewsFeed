@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Изменить новость #{{$newsItem->id}}</div>

                    <form action="{{route('news.update', $newsItem)}}" method="post">
                        @method('PUT')
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Заголовок</label>
                                <input type="text" name="title" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}" value="{{ old('title', $newsItem->title) }}">
                            </div>
                            <div class="form-group">
                                <label>Контент</label>
                                <textarea class="form-control {{$errors->has('content') ? 'is-invalid' : ''}}" name = "content" rows="10">{{ old('content', $newsItem->content) }}</textarea>
                            </div>

                            <div class="form-group form-check">
                                <input type="checkbox" name = "main_news" value = "1" class="form-check-input main_news_checkbox" id="main_news"
                                    {{
                                ($newsItem->main_news == 1)  ? 'checked' : ''
                                }}>
                                <label class="form-check-label" for="main_news">Главная новость (Будет добавлена в итог дня)</label>
                            </div>

                            <div class="form-group on_main_checkbox">
                                <label for="category">Категория</label>
                                <select name = "category_id" class="form-control {{$errors->has('category_id') ? 'is-invalid' : ''}}" id="category">

                                    <option></option>
                                    @forelse ($categories as $item)
                                        <option value="{{$item['id'] }}" {{ ($item['id'] == old('category_id', $newsItem->feedEntity->category_id)) ? 'selected' : '' }}>{{$item['title']}}</option>
                                    @empty
                                        <option disabled>No categories</option>
                                    @endforelse
                                </select>
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    <ul style="margin-bottom: 0; padding-left: 10px;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary mb-2">Сохранить</button>
                            <a type="submit" href = "{{route('news.show', $newsItem)}}" class="btn btn-secondary mb-2">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
