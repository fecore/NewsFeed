@if($feedEntity->feed_entitiable_type == 'App\NewsItem')

    @if($feedEntity->feedEntitiable->main_news == 1)
        @include('feedItems.newsItem_main')
    @else
        @include('feedItems.newsItem')
    @endif
@elseif($feedEntity->feed_entitiable_type == 'App\WeatherForecast')
    @if($feedEntity->feedEntitiable->created_at <= date('Y-m-d H:i:s'))
        @include('feedItems.weatherForecast')
    @endif

@elseif($feedEntity->feed_entitiable_type == 'App\DaySummary')
{{--    Only if it's bigger --}}
    @if($feedEntity->feedEntitiable->publish_at <= date('Y-m-d H:i:s'))
        @include('feedItems.daySummary')
    @endif
@endif
