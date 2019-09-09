@extends('web.layout.app')
@section('content')
<div style="padding-bottom: 40px">
  
  <style>
    .project-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 30px;
      margin-top: 30px;
    }
    p {
      line-height: 1.25;
    }
    img {
      display: block;
      height: auto;
      width: 100%;
    }
  </style>
  <h2 style="border-bottom: 1px solid #000">
    {{$project->categoryType->name_singular}}
  </h2>
  <h1 style="padding-top: 10px; font-size: 24px">
      {{$project->name}}, {{$project->location}}
  </h1>
  <div class="project-grid">
    <div>{!! $project->description !!}</div>
    <div>
        {!! $project->info !!}<br>
        @if ($project->downloads)
          @foreach($project->downloads as $download)
            <a href="/storage/media/downloads/{{$download->name}}" target="_blank">
              {{$project->name}}, {{$project->location}}
            </a>
          @endforeach
        @endif
    </div>
  </div>
  <div class="project-grid">
      @if ($project->images)
      @foreach($project->images as $image)
        <a href="/media/{{$image->name}}/lg" target="_blank">
          <img src="/media/{{$image->name}}/sm"> 
        </a>
      @endforeach
    @endif
  </div>
</div>
@endsection