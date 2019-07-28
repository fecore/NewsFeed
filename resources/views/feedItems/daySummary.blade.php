
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card flex-md-row mb-4 box-shadow">
                <div class="card-body d-flex flex-column align-items-start">
                    <strong class="d-inline-block mb-2 text-primary">World</strong>
                    <h3 class="mb-0">
                        <a class="text-dark " href="#">Итог дня</a>
                    </h3>
                    <div class="mb-1 text-muted">{{ date("H:i - d M y", strtotime($feedEntity->feedEntitiable->publish_at)) }}</div>
                    <ul>
                        @php
                            $newsItems = $feedEntity->feedEntitiable->newsItems->all();
                        @endphp

                            @foreach($newsItems as $newsItem)

                                <li>
                                    <a href="{{ route('article', $newsItem->feedEntity) }}">{{$newsItem->title}}</a>
                                </li>

                            @endforeach
                    </ul>
                        <div class="mb-1 text-muted">
                            Здесь находятся все новости за период <br>
                            с ({{ date("d-m-y H:i", strtotime($feedEntity->feedEntitiable->publish_at) - 24 * 60 * 60) }})
                            по ({{ date("d-m-y H:i", strtotime($feedEntity->feedEntitiable->publish_at)) }})
                            <br>
                            Т.е. за последние 24 часа
                        </div>
                </div>
            </div>
        </div>
    </div>
