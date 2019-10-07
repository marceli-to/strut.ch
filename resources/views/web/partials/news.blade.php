<article class="news">
  <div class="news__date">{{$news->date}}</div>
  <div class="news__body">
    <h2>{{$news->title}}</h2>
    <p>{{$news->text}}</p>
    @if ($news->media)
      <figure>
        <img src="/media/{{$news->media}}/sm">
      </figure>
    @endif
    @if ($news->link && $news->linkText)
      <p>
        <a href="{{$news->link}}">
          {{ $news->linkText }}
        </a>
      </p>
    @endif
  </div>
</article>