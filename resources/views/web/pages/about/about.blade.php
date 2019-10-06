@extends('web.layout.app')
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
        <figure class="about-image">
          <a href="/media/{{$content->media}}/lg" data-fb="gallery">
            <img src="/media/{{$content->media}}/sm" width="960" height="650" alt="{{ config('app.name') }} - Team">
          </a>
        </figure>
      </div>
    </div>
  @endif
  <h2>Team</h2>
  <div class="about__team js-msnry">
    @foreach($team as $t)
      <div class="team-member js-msnry-item">
        <article>
          <header>
            <h3>{{$t->firstname}} {{$t->name}}</h3>
            @if ($t->role) {{$t->role}}<br>@endif
            @if ($t->position) {{$t->position}}<br>@endif
          </header>
          <figure>
              <a href="/media/{{$t->media}}/lg" data-fb="gallery">
                <img src="/media/{{$t->media}}/sm" width="432" height="500" alt="{{ config('app.name') }} - {{$t->firstname}} {{$t->name}}">
              </a>
          </figure>
          <div>
            @if ($t->phone) {{$t->phone}}<br> @endif
            @if ($t->phone) {{$t->email}} @endif
          </div>
          <a href="javascript:;" class="icon-toggle js-msnry-btn">Lebenslauf</a>
          <div class="team-member__cv" style="display:none">{!! $t->cv !!}</div>
        </article>
      </div>
    @endforeach
  </div>
</section>
@endsection