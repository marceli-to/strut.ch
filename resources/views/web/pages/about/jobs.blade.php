@extends('web.layout.app')
@section('seo_title', 'Jobs')
@section('seo_description', 'Roger Studerus und Felix Rutishauser tragen gemeinsam die Verantwortung für die Strut Architekten AG. Im Team mit Peter Kunz werden eigenständige Projekte entwickelt, welche den Menschen ins Zentrum rücken.')
@section('content')
<section class="content jobs">
  <div class="jobs-grid">
    <div class="span">
      <h1>Jobs</h1>
      @if (!$jobs->isEmpty())
        @foreach($jobs as $j)
          <article class="job">
            <h2>
              {{$j->title}}
            </h2>
            <p class="job__lead">
              {{$j->lead}}
            </p>
            <div class="job__description">
              {!!$j->info!!}
              @if ($j->media)
              <br>
              <a 
                href="/storage/media/downloads/{{ $j->media }}" 
                target="_blank"
                aria-label="Download Stelleninserat">
                Download Stelleninserat
              </a>
              @endif
            </div>
          </article>
        @endforeach
      @else
        @if ($content)
          <article class="job">
            {!! $content->text !!}
          </article>
        @endif
      @endif
    </div>
    <div class="span has-media">
      @if ($content->images)
        @foreach($content->images as $image)
          <figure>
            <a href="{!! ImageHelper::get($image->name, 'lg') !!}" @if ($content->images->count() > 1)data-fancybox="gallery" @else data-fancybox="single" @endif>
              <img src="{!! ImageHelper::get($image->name, 'md') !!}" width="960" height="650" alt="{{ config('app.name') }} - Jobs">
            </a>
          </figure>
        @endforeach
      @endif
    </div>
  </div>
</section>
@endsection