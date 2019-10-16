@extends('web.layout.app')
@section('seo_title', 'Über uns')
@section('seo_description', substr(strip_tags($content->text),0,255))
@section('content')
<section class="content about">
  @if ($content)
    <div class="about-grid">
      <div class="span">
        <h1>{{ $content->title }}</h1>
        <article>
          {!! $content->text !!}
        </article>
      </div>
      <div class="span has-media">
        @foreach($content->images as $image)
          <figure class="about-image">
            <a href="{!! ImageHelper::get($image->name, 'lg') !!}" data-fancybox="single">
              <img src="{!! ImageHelper::get($image->name, 'md') !!}" width="960" height="650" alt="{{ config('app.name') }} - Team">
            </a>
          </figure>
        @endforeach
      </div>
    </div>
  @endif
  <h2>Team</h2>
  <div class="about__team js-msnry">
    @foreach($team as $t)
      <div class="team-member js-msnry-item">
        <article>
          <header>
            @if ($t->email)
              <h3>
                <a href="mailto:{{$t->email}}">{{$t->firstname}} {{$t->name}}</a>
              </h3>
            @else
              <h3>
                {{$t->firstname}} {{$t->name}}
              </h3>
            @endif
            @if ($t->role) {{$t->role}}<br>@endif
            @if ($t->position) {{$t->position}}<br>@endif
          </header>
          <figure>
            <img src="{!! ImageHelper::get($t->media, 'sm') !!}" width="432" height="500" alt="{{ config('app.name') }} - {{$t->firstname}} {{$t->name}}">
          </figure>
          <div>
            @if ($t->phone) {{$t->phone}}<br> @endif
            @if ($t->email) <a href="mailto:{{$t->email}}" class="anchor-dark">{{$t->email}}</a> @endif
          </div>
          <a href="javascript:;" class="icon-toggle js-msnry-btn">Lebenslauf</a>
          <div class="team-member__cv" style="display:none">{!! $t->cv !!}</div>
        </article>
      </div>
    @endforeach
  </div>
</section>
@endsection