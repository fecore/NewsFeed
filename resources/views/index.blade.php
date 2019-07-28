@extends('layouts.master')

@section('content')
        <div style="background-color: #0c5460; color: #fff;" class="card card-body mb-4">
            <div class="card-body">
                <h1 class="mt-0">Главная страница</h1>
                <h2 class="">Все новости:</h2>
            </div>
        </div>
    @if ($feedEntities->isEmpty())

        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card flex-md-row mb-4 box-shadow">
                    <div class="card-body d-flex flex-column align-items-start">
                        <p class="card-text mb-auto">Нет новостей.</p>
                    </div>
                </div>
            </div>
        </div>

            @endif
            @foreach($feedEntities as $feedEntity)

                @include('feedItems.bootstrap')

            @endforeach
@endsection
