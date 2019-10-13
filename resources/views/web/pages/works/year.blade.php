@extends('web.layout.app')
@section('seo_title', 'Werkliste')
@section('seo_description', '')
@section('content')
<section class="content works">
  @include('web.pages.works.nav')
  <div class="works-list">
    @if ($projects)
      @foreach($projects as $project_year_group)
        <div class="span">
          <article class="work-group">
            @foreach($project_year_group as $year => $project_group)
              <h2>{{$year}}</h2>
              @foreach($project_group as $p)
                <div class="work-item {{$p['has_detail'] ? 'has-link' : ''}}">
                  <h3>
                    @if ($p['has_detail'])
                      <a href="{{ route('page.projects') }}/{{$p['id']}}">
                        {{$p['name']['de']}}, {{$p['location']['de']}}
                      </a>
                    @else
                      {{$p['name']['de']}}, {{$p['location']['de']}}
                    @endif
                  </h3>
                  @foreach($p['images'] as $img)
                    @if ($img['is_preview_year'])
                      <figure>
                        <img src="/media/{{$img['name']}}/sm" 
                             width="600"
                             height="400"
                             alt="@if ($img['caption']['de']){{$img['caption']['de']}} – @endif{{$p['name']['de']}}, {{$p['location']['de']}}">
                      </figure>
                      @php break; @endphp
                    @endif
                  @endforeach
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