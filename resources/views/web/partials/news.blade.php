<article class="news">
  @if ($news->date)
    <div class="news__date">{{$news->date}}</div>
  @endif
  <div class="news__body @if ($news->date) has-date @endif">
    <h2>{{$news->title}}</h2>
    @if ($news->subtitle)
      <p class="news-subtitle">{{$news->subtitle}}</p>
    @endif
    @if ($news->text)
      <p>{{$news->text}}</p>
    @endif
    @if ($news->media)
      <figure>
        <img src="/media/{{$news->media}}/sm">
      </figure>
    @endif
    @if ($news->link && $news->linkText)
      <p>
        <a href="{{$news->link}}" class="icon-arrow">
          {{ $news->linkText }}
        </a>
      </p>
    @endif
  </div>
</article>