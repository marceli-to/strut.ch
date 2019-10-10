@extends('web.layout.app')
@section('content')
<section class="content works">
  @include('web.pages.works.nav')
  <div class="works-list">
    @if ($projects)
      @foreach($projects as $project_category)
        @foreach($project_category as $category)
          <div class="span">
            <article class="is-type">
              <h2>{{$category->name}}</h2>
              @foreach($category->activeTypes as $type)
                <article>
                  <h3>{{$type->name_plural}}</h3>
                  @foreach($type->activeProjects as $project)
                    @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'type'))
                  @endforeach
                </article>
              @endforeach
            </article>
          </div>
        @endforeach
      @endforeach
    @endif
  </div>
</section>
@endsection