@extends('web.layout.app')
@section('seo_title', $project->name . ', ' . $project->location .' - '. $project->categoryType->name_singular)
@section('seo_description', substr(strip_tags($project->description),0,255))
@section('og_image', url('/') . ImageHelper::get($og_image, 'lg'))
@section('content')
<section class="project js-project">
  <header class="project__header">
    <div>
      <h2>{{$project->categoryType->name_singular}}</h2>
      <nav class="project-browse">
        <span data-label-prev style="display:none">Vorheriges Projekt</span>
        <span data-label-next style="display:none">Nächstes Projekt</span>
        <a href="{{ route('page.projects') }}/{!! AppHelper::getSlug($browse['prev']) !!}" class="icon-browse-prev" data-prev></a>
        <a href="{{ route('page.projects') }}/{!! AppHelper::getSlug($browse['next']) !!}" class="icon-browse-next" data-next></a>
      </nav>
    </div>
  </header>
  <article>
    <a href="javascript:;" 
       class="btn-project-toggle" 
       data-toggle=".project__description"
       title="Projektbeschreibung anzeigen">
      <span>Info</span>
    </a>
    <h1>{{$project->name}}, {{$project->location}}</h1>
    <div class="project__images">
      @foreach($grids as $g)
        
        @if ($g['key'] == '2fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.projects.2fr', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '1fr_stacked-1fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.projects.1fr_stacked1fr', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '1fr-1fr_stacked')
          @if (isset($g['elements']))
            @include('web.partials.grids.projects.1fr1fr_stacked', array('elements' => $g['elements']))
          @endif
        @endif

      @endforeach
    </div>
    <div class="project__description">
      <div>
        <div class="span project__description-body">{!! $project->description !!}</div>
        <div class="span">
            {!! $project->info !!}
            @if ($project->downloads)
              <p>
                @foreach($project->downloads as $download)
                  <a href="/storage/media/downloads/{{$download->name}}" 
                    target="_blank"
                    class="icon-file" 
                    title="Download Projektdokumentation">
                    {{$project->name}}, {{$project->location}}
                  </a>
                @endforeach
              </p>
            @endif
        </div>
      </div>
    </div>
    <div class="project__nav">
      <article>
        <a href="{{ route('page.projects') }}/{{$browse['next']->id}}" title="Nächstes Projekt">
          <span>Nächstes Projekt</span>
          <h3>{{$browse['next']->name}}, {{$browse['next']->location}}</h3>
          @if ($browse['next']->images)
            @foreach($browse['next']->activeImages as $image)
              <figure>
                <img src="{!! ImageHelper::get($image->name, 'sm') !!}" width="900" height="500" alt="{{$browse['next']->name}}, {{$browse['next']->location}}">
              </figure>
              @php break; @endphp
            @endforeach
          @endif
        </a>
      </article>
    </div>
  </article>
</section>
@endsection