@include('web.pdf.partials.header', array('title' => $title))
<span class="date">{{ $date }}</span>
<span class="title">Werkliste Wohnen</span>
<div class="content">
  @if ($projects)
    @foreach($projects as $project_category)
      @foreach($project_category as $category)
        @foreach($category->activeTypes as $type)
          @php
            $activeProjects = collect($type->activeProjects);
            $sortedProjects = $activeProjects->sortByDesc('year');
          @endphp
          @if ($activeProjects->count() > 0)
            <span class="content-title">{{$type->name_plural}}</span>
            <div class="content-items">
              @foreach($sortedProjects as $project)
                <div class="content-item">{{ $project->name }}, {{ $project->location }} – {{ $project->year }}</div>
              @endforeach
            </div>
          @endif
        @endforeach
      @endforeach
    @endforeach
  @endif
</div>
@include('web.pdf.partials.footer')
