@extends('web.layout.app')
@section('content')
<section class="home">
  @if ($highlight)
    <figure class="is-highlight">
      <a href="{{ route('page.projects') }}/{{ $highlight['slug'] }}" title="{{ config('app.name') }} - {{ $highlight['title'] }}">
        <img src="/media/{{ $highlight['image']}} " 
            width="1600" 
            height="1066"
            alt="{{ config('app.name') }} - {{ $highlight['title'] }}">
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