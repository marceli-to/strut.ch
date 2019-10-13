@extends('web.layout.app')
@section('content')
<section class="content downloads">
  <h1>Downloads</h1>
  <div class="downloads__grid">
    <div class="span">
      <article>
        <h2>Projektdokumentationen</h2>
        @if ($projects)
          @foreach($projects as $project_category)
              @foreach($project_category as $category)
                @if (array_key_exists($category->id, $categories))
                  <div class="download-group is-article">
                    <h3>{{$category->name}}</h3>
                    <a href="{{ route('pdf.concat.category', [$category->id, str_slug($category->name)]) }}" 
                      class="icon-file"
                      target="_blank"
                      title="Projektdokumentationen {{$category->name}}">
                      Alle {{$category->name}}
                    </a>
                    @foreach($category->activeTypes as $type)
                      @if (array_key_exists($type->id, $types))
                        @if ($category->show_types)
                          <div class="download-group__item">
                            <h4>{{$type->name_plural}}</h4>
                            @foreach($type->activeProjects as $project)
                              @if ($project->downloads)
                                @foreach($project->downloads as $file)
                                  @if ($file->name)
                                    <div>
                                      <a href="{{asset('storage/media/downloads/' . $file->name)}}" 
                                        class="icon-file"
                                        target="_blank"
                                        title="Projektdokumentation {{$project->name}}, {{$project->location}}">
                                        {{$project->name}}, {{$project->location}}
                                      </a>
                                    </div>
                                  @endif
                                @endforeach
                              @endif
                            @endforeach
                          </div>
                        @else
                          <div class="download-group__item">
                            @foreach($type->activeProjects as $project)
                              @if ($project->downloads)
                                @foreach($project->downloads as $file)
                                  @if ($file->name)
                                    <div>
                                      <a href="{{asset('storage/media/downloads/' . $file->name)}}" 
                                        class="icon-file"
                                        target="_blank"
                                        title="Projektdokumentation {{$project->name}}, {{$project->location}}">
                                        {{$project->name}}, {{$project->location}}
                                      </a>
                                    </div>
                                  @endif
                                @endforeach
                              @endif
                            @endforeach
                          </div>
                        @endif
                      @endif
                    @endforeach
                  </div>
                @endif
              @endforeach
          @endforeach
        @endif
      </article>
    </div>
    <div class="span">
      <article>
        <h2>Werkliste</h2>
        <div class="download-group has-offset">
        <div><a href="{{ route('pdf.works.all') }}" class="icon-file" target="_blank">Gesamt</a></div>
          <div><a href="{{ route('pdf.works.living') }}" class="icon-file" target="_blank">Wohnen</a></div>
          <div><a href="{{ route('pdf.works.business') }}" class="icon-file" target="_blank">Gewerbe</a></div>
          <div><a href="{{ route('pdf.works.public') }}" class="icon-file" target="_blank">Öffentlich</a></div>
          <div><a href="{{ route('pdf.works.competition') }}" class="icon-file" target="_blank">Wettbewerb</a></div>
          <div><a href="{{ route('pdf.works.state') }}" class="icon-file" target="_blank">Nach Status</a></div>
          <div><a href="{{ route('pdf.works.year') }}" class="icon-file" target="_blank">Nach Jahr</a></div>
          <div><a href="{{ route('pdf.works.type') }}" class="icon-file" target="_blank">Nach Typ</a></div>
        </div>
      </article>
    </div>
    <div class="span">
      <article>
        <h2>Jobs</h2>
        @if ($jobs->isNotEmpty())
          <div class="download-group has-offset">
            @foreach($jobs as $j)
              <div>
                @if ($j->media)
                  <a href="{{asset('storage/media/downloads/' . $j->media)}}" 
                     class="icon-file"
                     target="_blank"
                     title="Ausschreibung {{$j->title}}">
                     {{$j->title}}
                  </a>
                @endif
              </div>
            @endforeach
          </div>
        @else
          <p>Zur Zeit sind alle unsere Stellen besetzt.</p>
        @endif
      </article>
    </div>    
  </div>
</section>
@endsection