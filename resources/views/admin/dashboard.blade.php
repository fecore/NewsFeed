@extends('layouts.app')

@section('content')


    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="btn-group" role="group">
                            <a href="{{route('news.create')}}" type="button" class="btn btn-secondary">Создать новость +</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Новости</div>

                    <div class="card-body">
                        @if(!$feedEntitiesNewsItemsFiltered->isEmpty())
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Заголовок</th>
                                    <th scope="col">Категория</th>
                                    <th scope="col">Тип</th>
                                    <th scope="col">Создан</th>
                                    <th scope="col" style="text-align: right; width : 174px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($feedEntitiesNewsItemsFiltered as $item)
                                        <tr>
                                            <th>{{ $item->id }}</th>
                                            <td>{{ $item->feedEntitiable->title }}</td>
                                            <td>{{ $item->category->title }}</td>
                                            <td><span class="badge badge-success">Главная</span>

                                            </td>
                                            <td>{{ $item->created_at }}</td>
                                            <td  style="text-align: right">
                                                <form action="{{route('news.destroy', $item->feedEntitiable)}}" method="POST">
                                                <a href="{{route('news.show', $item->feedEntitiable->id)}}" class="btn btn-primary"><i class="material-icons md-18">visibility</i></a>
                                                <a href="{{route('news.edit', $item->feedEntitiable->id)}}" class="btn btn-primary"><i class="material-icons md-18">border_color</i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"><i class="material-icons md-18">delete</i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            Новостей не было найдено
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
