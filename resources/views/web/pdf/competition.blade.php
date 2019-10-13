@include('web.pdf.partials.header', array('title' => $title))
<span class="date">{{ $date }}</span>
<span class="title">Werkliste Wettbewerbe</span>
<div class="content">
  @if (isset($projects['1. Preis']))
    <span class="content-title">1. Preis</span>
    <div class="content-items">
      @foreach($projects['1. Preis'] as $project)
        <div class="content-item">
          {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
        </div>
      @endforeach
    </div>
  @endif
  @if (isset($projects['2. Preis']))
    <span class="content-title">2. Preis</span>
    <div class="content-items">
      @foreach($projects['2. Preis'] as $project)
        <div class="content-item">
          {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
        </div>
      @endforeach
    </div>
  @endif
  @if (isset($projects['Andere']))
    <span class="content-title">Andere</span>
    <div class="content-items">
      @foreach($projects['Andere'] as $project)
        <div class="content-item">
          {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
        </div>
      @endforeach
    </div>
  @endif
</div>
@include('web.pdf.partials.footer')
