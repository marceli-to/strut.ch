@extends('web.layout.app')
@section('seo_title', 'Presse')
@section('seo_description', 'Strut Architekten AG zeigt in verschieden Publikationen eine breite Palette an ausgeführten Gebäuden: Schulgebäude, Private Wohnbauten und Siedlungen, Produktions- und Verwaltungsgebäude.')
@section('content')
<section class="content press">
  <h1>Presse</h1>
  <div class="press-list">
    @if ($press)
      @foreach($press as $press_year_group)
        <div class="span">
          <article class="press-group">
            @foreach($press_year_group as $year => $press_group)
              <h2>{{$year}}</h2>
              @foreach($press_group as $p)
                <div class="press-item @if ($p['file'] || $p['url']) has-link @endif">
                  <h3>
                    @if ($p['file'])
                      <a href="{{ asset('storage/media/downloads/' . $p['file']) }}" target="_blank" title="{{$p['title']['de']}}">
                        {{$p['title']['de']}}
                      </a>
                    @elseif ($p['url'])
                      <a href="{{ $p['url'] }}" target="_blank" title="{{$p['title']['de']}}">
                        {{$p['title']['de']}}
                      </a>
                    @else
                      {{$p['title']['de']}}
                    @endif
                  </h3>
                  <div>
                    {{$p['description']['de']}}@if ($p['project']), {{$p['project']['name']['de']}} {{$p['project']['location']['de']}} ({{$p['project']['year']}})@endif
                  </div>
                  @if ($p['media'])
                    <figure>
                      <img src="{!! ImageHelper::get($p['media'], 'xs') !!}" width="600" height="400" alt="{{$p['title']['de']}}">
                    </figure>
                  @endif
                </div>
              @endforeach
            @endforeach
          </article>
        </div>
      @endforeach
    @endif
  </div>
</section>
@endsection

