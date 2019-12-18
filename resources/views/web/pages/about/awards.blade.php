@extends('web.layout.app')
@section('seo_title', 'Auszeichnungen')
@section('seo_description', 'Roger Studerus und Felix Rutishauser tragen gemeinsam die Verantwortung für die Strut Architekten AG. Im Team mit Peter Kunz werden eigenständige Projekte entwickelt, welche den Menschen ins Zentrum rücken.')
@section('content')
<section class="content awards">
  <h1>Auszeichnungen</h1>
  <div class="awards-list">
    @if ($awards)
      @foreach($awards as $award_year_group)
        <div class="span">
          <article class="award-group">
            @foreach($award_year_group as $year => $award_group)
              <h2>{{$year}}</h2>
              @foreach($award_group as $award)
                <div class="award @if ($award['file'] || $award['url']) has-link @endif">
                  <h3>
                    @if ($award['file'])
                      <a href="{{ asset('storage/media/downloads/' . $award['file']) }}" target="_blank" title="{{$award['title']['de']}}">
                        {{$award['title']['de']}}
                      </a>
                    @elseif ($award['url'])
                      <a href="{{ $award['url'] }}" target="_blank" title="{{$award['title']['de']}}">
                        {{$award['title']['de']}}
                      </a>
                    @else
                      {{$award['title']['de']}}
                    @endif
                  </h3>
                  <div>{{$award['description']['de']}}</div>
                  @if ($award['media'])
                    <figure>
                      <img src="{!! ImageHelper::get($award['media'], 'xs') !!}" width="600" height="400" alt="{{$award['title']['de']}}">
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