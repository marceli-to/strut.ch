@extends('web.layout.app')
@section('content')
<section class="project">
  <header class="project__header">
    <div>
      <h2>{{$project->categoryType->name_singular}}</h2>
      <nav class="project-browse">
        <a href="">&laquo;</a>
        <a href="">&raquo;</a>
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
          <div class="span">{!! $project->description !!}</div>
          <div class="span">
              {!! $project->info !!}<br>
              @if ($project->downloads)
                @foreach($project->downloads as $download)
                  <a href="/storage/media/downloads/{{$download->name}}" 
                    target="_blank" 
                    title="Download Projektdokumentation">
                    {{$project->name}}, {{$project->location}}
                  </a>
                @endforeach
              @endif
          </div>
        </div>
      </div>
  </article>
</section>
@endsection