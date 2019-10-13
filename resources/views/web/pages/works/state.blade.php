@extends('web.layout.app')
@section('seo_title', 'Werkliste')
@section('seo_description', '')
@section('content')
<section class="content works">
  @include('web.pages.works.nav')
  <div class="works-list">
    @if (isset($projects['Ausgeführt']))
      <div class="span">
        <article class="work-group">
          <h2>Ausgeführt</h2>
          @foreach($projects['Ausgeführt'] as $project)
             @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'))
          @endforeach
        </article>
      </div>
    @endif
    @if (isset($projects['In Planung']) || isset($projects['Studie']))
      <div class="span">
        @if (isset($projects['In Planung']))
          <article class="work-group">
            <h2>In Planung</h2>
            @foreach($projects['In Planung'] as $project)
              @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'))
            @endforeach
          </article>
        @endif
        @if (isset($projects['Studie']))
          <article class="work-group">
            <h2>Studie</h2>
            @foreach($projects['Studie'] as $project)
              @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'))
            @endforeach
          </article>
        @endif
      </div>
    @endif

    @if (isset($competition['1. Preis']) || isset($competition['2. Preis']) || isset($competition['Andere']))
      <div class="span">
        <article class="is-competition">
          <h2>Wettbewerb</h2>
          @if (isset($competition['1. Preis']))
            <article class="work-group">
              <div class="article">
                <h3>1. Preis</h3>
                @foreach($competition['1. Preis'] as $project)
                  @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'))
                @endforeach
              </div>
            </article>
          @endif
          @if (isset($competition['2. Preis']))
            <article class="work-group is-competition">
              <div class="article">
                <h3>2. Preis</h3>
                @foreach($competition['2. Preis'] as $project)
                  @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'))
                @endforeach
              </div>
            </article>
          @endif
          @if (isset($competition['Andere']))
            <article class="work-group is-competition">
              <div class="article">
                <h3>Andere</h3>
                @foreach($competition['Andere'] as $project)
                  @include('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'))
                @endforeach
              </div>
            </article>
          @endif      
        </article>      
      </div> 
    @endif   
  </div>
</section>
@endsection