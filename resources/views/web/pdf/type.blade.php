@include('web.pdf.partials.header', array('title' => $title))
<span class="date">{{ $date }}</span>
<span class="title">Werkliste nach Typ</span>
<div class="content">
    @if ($projects)
      @foreach($projects as $project_category)
        @foreach($project_category as $category)
          <span class="content-title">{{$category->name}}</span>
          <div class="content-items">
          @foreach($category->activeTypes as $type)
            @if ($category->show_types)
                <div class="content-item"><strong>{{$type->name_plural}}</strong></div>
                @php
                  $activeProjects = collect($type->activeProjects);
                  $sortedProjects = $activeProjects->sortByDesc('year');
                @endphp
                @foreach($sortedProjects as $project)
                  <div class="content-item">{{ $project->name }}, {{ $project->location }} – {{ $project->year }}</div>
                @endforeach
                <br>
            @else
                @php
                  $activeProjects = collect($type->activeProjects);
                  $sortedProjects = $activeProjects->sortByDesc('year');
                @endphp
                @foreach($sortedProjects as $project)
                  <div class="content-item">{{ $project->name }}, {{ $project->location }} – {{ $project->year }}</div>
                @endforeach
            @endif
          @endforeach
          </div>
        @endforeach
      @endforeach
    @endif
</div>

@include('web.pdf.partials.footer')
