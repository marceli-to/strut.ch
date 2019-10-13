@include('web.pdf.partials.header', array('title' => $title))

<span class="date">{{ $date }}</span>
<span class="title">Werkliste nach Status</span>
<div class="content">
  @if (isset($projects['Ausgeführt']))
    <span class="content-title">Ausgeführt</span>
    <div class="content-items">
      @foreach($projects['Ausgeführt'] as $project)
        <div class="content-item">
          {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
        </div>
      @endforeach
    </div>
  @endif

  @if (isset($projects['In Planung']))
    <span class="content-title">In Planung</span>
    <div class="content-items">
      @foreach($projects['In Planung'] as $project)
        <div class="content-item">
          {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
        </div>
      @endforeach
    </div>
  @endif

  @if (isset($projects['Studie']))
    <span class="content-title">Studie</span>
    <div class="content-items">
      @foreach($projects['Studie'] as $project)
        <div class="content-item">
          {{ $project->name }}, {{ $project->location }} – {{ $project->categoryType->name_singular }}, {{ $project->year }}
        </div>
      @endforeach
    </div>
  @endif

  {{-- @if (isset($competition['1. Preis']) || isset($competition['2. Preis']) || isset($competition['Andere']))
    <span class="content-title">Wettbewerb</span>
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
  @endif --}}

</div>

@include('web.pdf.partials.footer')
