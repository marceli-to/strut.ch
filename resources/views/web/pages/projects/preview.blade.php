@extends('web.layout.app')
@section('content')
<style>
.label-preview {
  background-color: rebeccapurple;
  color: #fff;
  display: inline-block;
  right: 5px;
  top: 5px;
  padding: 10px 15px;
  line-height: 1;
  position: fixed;
  width: auto;
  z-index: 1000;
}
</style>
<span class="label-preview">Vorschau</span>
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
          <div class="grid-2x1fr">
              <div class="span">
                @if (isset($g['elements'][0]))
                  <img src="/media/{{$g['elements'][0]->image->name}}/sm">
                @endif
              </div>
              <div class="span">
                @if (isset($g['elements'][1]))
                  <img src="/media/{{$g['elements'][1]->image->name}}/sm">
                @endif
              </div>
          </div>
        @endif
        @if ($g['key'] == '1fr_stacked-1fr')
          <div class="grid-2x1fr">
            <div class="span">
              <div class="grid-stack">
                <div style="margin-bottom: 24px">
                  @if (isset($g['elements'][0]))
                    <img src="/media/{{$g['elements'][0]->image->name}}/sm">
                  @endif
                </div>
                <div>
                  @if (isset($g['elements'][1]))
                    <img src="/media/{{$g['elements'][1]->image->name}}/sm">
                  @endif
                </div>
              </div>
            </div>
            <div class="span">
              @if (isset($g['elements'][2]))
                <img src="/media/{{$g['elements'][2]->image->name}}/sm">
              @endif
            </div>
          </div>
        @endif
        @if ($g['key'] == '1fr-1fr_stacked')
          <div class="grid-2x1fr">
            <div class="span">
              @if (isset($g['elements'][0]))
                <img src="/media/{{$g['elements'][0]->image->name}}/sm">
              @endif
            </div>
            <div class="span">
              <div class="grid-stack">
                  <div style="margin-bottom: 24px">
                    @if (isset($g['elements'][1]))
                      <img src="/media/{{$g['elements'][1]->image->name}}/sm">
                    @endif
                  </div>
                  <div>
                    @if (isset($g['elements'][2]))
                      <img src="/media/{{$g['elements'][2]->image->name}}/sm">
                    @endif
                  </div>
                </div>
            </div>
          </div>
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