@include('web.pdf.partials.header', array('title' => $title))

<span class="date">{{ $date }}</span>
<span class="title">Werkliste nach Jahr</span>
<div class="content">
  @if ($projects)
    @foreach($projects as $year => $project)
      <span class="content-title">{{ $year }}</span>
      <div class="content-items">
        @foreach($projects[$year] as $project)
          <div class="content-item">
            {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{$project->status}}
          </div>
        @endforeach
      </div>
    @endforeach
  @endif
</div>

@include('web.pdf.partials.footer')
