@extends('web.layout.app')
@section('content')
<section class="content jobs">
  <div class="jobs-grid">
    <div class="span">
      <h1>Jobs</h1>
      @if ($jobs)
        @foreach($jobs as $j)
          <article class="job">
            <h2>{{$j->title}}</h2>
            <p class="job__lead">{{$j->lead}}</p>
            <div class="job__description">{!!$j->info!!}</div>
          </article>
        @endforeach
      @endif
    </div>
    <div class="span has-media">
      <figure>
        <img src="/storage/media/static/strut.ch_jobs-1.jpg" width="918" height="657" alt="Strut Architekten - Jobs">
      </figure>
      <figure>
        <img src="/storage/media/static/strut.ch_jobs-1.jpg" width="918" height="657" alt="Strut Architekten - Jobs">
      </figure>
    </div>
  </div>
</section>
@endsection