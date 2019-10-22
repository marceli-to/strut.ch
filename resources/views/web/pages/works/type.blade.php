@extends('web.layout.app')
@section('seo_title', 'Werkliste')
@section('seo_description', 'Strut Architekten AG entwickelt und plant anspruchsvolle Wohn- und Gewerbebauten. Das Büro kann auf erfolgreiche Projekte und mehr als 20-jährige Erfahrungen zurückgreifen.')
@section('content')
<section class="content works">
  @include('web.pages.works.nav')
  <div class="works-list">
    @if ($projects)
      @foreach($projects as $project_category)
        @foreach($project_category as $category)
          <div class="span">
            <article class="is-type">
              @if (array_key_exists($category->id, $categories))
                <h2>{{$category->name}}</h2>
                @foreach($category->activeTypes as $type)
                  @if (array_key_exists($type->id, $types))
                    @if ($category->show_types)
                      <article>
                        <h3>{{$type->name_plural}}</h3>
                        @foreach($type->activeProjects as $project)
                          @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'type'))
                        @endforeach
                      </article>
                    @else
                      <div>
                        @foreach($type->activeProjects as $project)
                          @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'type'))
                        @endforeach
                      </div>
                    @endif
                  @endif
                @endforeach
              @endif
            </article>
          </div>
        @endforeach
      @endforeach
    @endif
  </div>
</section>
@endsection