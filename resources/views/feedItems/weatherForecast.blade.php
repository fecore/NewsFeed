<div class="jumbotron p-3 p-md-5 text-white rounded bg-primary">
    <div class="col-md-12 px-0">
        <h1 class="font-italic" style="font-size: 35px;">{{ $feedEntity->feedEntitiable->title }}: {{ date("H:i - d M", strtotime($feedEntity->created_at)) }} </h1>
        <p class="lead my-3">{{ $feedEntity->feedEntitiable->content }}</p>
    </div>
</div>
