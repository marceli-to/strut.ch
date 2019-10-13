@include('web.pdf.partials.header', array('title' => $title))
<span class="date">{{ $date }}</span>
<span class="title">Werkliste Gesamt</span>
<div class="content">
  @if ($projects)
    @foreach($projects as $project_category)
      @foreach($project_category as $category)
        @if (count($category->activeTypes) > 0)
          <span class="content-title">{{$category->name}}</span>
          <div class="content-items">
          @foreach($category->activeTypes as $type)
            @if ($category->show_types && count($type->activeProjects) > 0)
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
        @endif
      @endforeach
    @endforeach
  @endif

  @if (isset($competition['1. Preis']) || isset($competition['2. Preis']) || isset($competition['Andere']))
    <span class="content-title">Wettbewerbe</span>
    <div class="content-items">
      @if (isset($competition['1. Preis']))
        <div class="content-item"><strong>1. Preis</strong></div>
        @foreach($competition['1. Preis'] as $project)
          <div class="content-item">
            {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
          </div>
        @endforeach
        <br>
      @endif

      @if (isset($competition['2. Preis']))
        <div class="content-item"><strong>2. Preis</strong></div>
        @foreach($competition['2. Preis'] as $project)
          <div class="content-item">
            {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
          </div>
        @endforeach
        <br>
      @endif

      @if (isset($competition['Andere']))
        <div class="content-item"><strong>Andere</strong></div>
        @foreach($competition['Andere'] as $project)
          <div class="content-item">
            {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
          </div>
        @endforeach
      @endif
    </div>
  @endif
</div>

@include('web.pdf.partials.footer')
