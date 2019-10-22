@extends('web.layout.app')
@section('seo_title', 'Home')
@section('seo_description', 'Strut Architekten AG aus Winterthur, Schweiz. Gegründet im Jahre 2015 durch Roger Studerus, Felix Rutishauser und Peter Kunz.')
@section('content')
<section class="home">
  @if ($highlight)
    <figure class="is-highlight">
      <a href="{{ route('page.projects') }}/{{ $highlight['slug'] }}" title="{{ config('app.name') }} - {{ $highlight['title'] }}">
        <figcaption>
          @if ($highlight['title'])
            <span>{{$highlight['title']}}</span>
          @else
            <span>{{$highlight['name']}}</span>
          @endif
        </figcaption>
        <img src="{!! ImageHelper::get($highlight['image'], 'lg') !!}" 
          width="1600" 
          height="1066"
          alt="{{ $highlight['name'] }}">
      </a>
    </figure>
  @endif
  <div class="home__grids">
    <div class="ratio-boxes">

      @foreach($grids as $g)
        
        @if ($g['key'] == '1fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.1fr', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '2fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.2fr', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '3fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.3fr', array('elements' => $g['elements']))
          @endif
        @endif
        
        @if ($g['key'] == '3fr-landscape')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.3fr_landscape', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '2fr-1fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.2fr1fr', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '1fr-2fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.1fr2fr', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '2fr-1fr_stacked')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.2fr1fr_stacked', array('elements' => $g['elements']))
          @endif
        @endif
        
        @if ($g['key'] == '1fr_stacked-2fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.1fr_stacked2fr', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '1fr-1fr-1fr_stacked')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.1fr1fr1fr_stacked', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '1fr-1fr_stacked-1fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.1fr1fr_stacked1fr', array('elements' => $g['elements']))
          @endif
        @endif

        @if ($g['key'] == '1fr_stacked-1fr-1fr')
          @if (isset($g['elements']))
            @include('web.partials.grids.home.1fr_stacked1fr1fr', array('elements' => $g['elements']))
          @endif
        @endif

      @endforeach
    </div>
  </div>
</section>
@endsection