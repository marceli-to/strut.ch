<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name') }}</title>
<meta name="csrf-token" value="{{ csrf_token() }}" />
<meta name="description" content="{{ config('app.name') }} - Winterthur">
<meta name="format-detection" content="telephone=no">
<link href="{{ asset('assets/css/app.css') }}" type="text/css" rel="stylesheet" />
<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
</head>
<body>
<header class="site-header">
  <div>
    <a href="javascript:;" class="icon-menu js-btn-menu" title="Menü anzeigen"></a>
    <a href="/" class="brand" title="Home | strut.ch">
      <img src="/assets/img/logo-strut.svg" height="161" width="313" alt="{{ config('app.name') }}">
    </a>
  </div>
  <nav class="site-nav js-menu" role="navigation">
    <div>
      <ul>
        <li>
          <a href="javascript:;" 
             class="js-btn-sub-menu is-parent {{request()->routeIs('page.project*') ? 'is-active' : ''}}"
          >Bauten</a>
          <ul class="is-projects">
            @foreach ($menu['projects']['items'] as $c)
              <li>
                  <a href="javascript:;" 
                     class="js-btn-sub-menu {{ $c['is-active'] ? 'is-active' : '' }}">
                    {{$c['name']}}
                  </a>
                  @if ($c['show_types'])
                    <ul>
                      @foreach ($c['types'] as $t)
                        <li>
                          <a href="javascript:;" 
                            class="js-btn-sub-menu {{ $t['is-active'] ? 'is-active' : '' }}">
                            {{$t['name']}}
                          </a>
                          <ul class="has-indent">
                            @foreach ($t['projects'] as $p)
                              <li>
                                <a href="{{ url($p['route'] .'/'. $p['slug']) }}" 
                                   title="{{ $p['name'] }}"
                                   class="{{ $p['is-active'] ? 'is-active' : '' }}"
                                >
                                  {{ $p['name'] }}
                                </a>
                              </li>
                            @endforeach
                          </ul>
                        </li>
                      @endforeach
                    </ul>
                  @else
                    @foreach ($c['types'] as $t)
                      <ul class="has-indent">
                        @foreach ($t['projects'] as $p)
                          <li>
                            <a href="{{ url($p['route'] .'/'. $p['slug']) }}" 
                               title="{{ $p['name'] }}"
                               class="{{ $p['is-active'] ? 'is-active' : '' }}">
                              {{ $p['name'] }}
                            </a>
                          </li>
                        @endforeach
                      </ul>
                    @endforeach
                  @endif
              </li>
            @endforeach   
          </ul>
        </li>
        <li>
          <a href="{{ route($menu['works']['route']) }}" 
            class="{{ $menu['works']['is-active'] ? 'is-active' : '' }}"
            title="{{ $menu['works']['name'] }}">
            {{ $menu['works']['name'] }}
          </a>
        </li>                
        <li>
            <a href="javascript:;" class="js-btn-sub-menu is-parent {{ $menu['publications']['is-active'] ? 'is-active' : '' }}">
              Publikationen
            </a>
            @if (!empty($menu['publications']['items']))
              <ul>
                @foreach($menu['publications']['items'] as $m)
                  <li>
                    <a href="{{ route($m['route']) }}"
                      class="{{ $m['is-active'] ? 'is-active' : '' }}"
                      title="{{ $m['name'] }}">
                      {{ $m['name'] }}
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif
        </li>
        <li>
          <a href="javascript:;" 
            class="js-btn-sub-menu is-parent {{ $menu['about']['is-active'] ? 'is-active' : '' }}"
          >
            Büro
          </a>
          @if (!empty($menu['about']['items']))
            <ul>
              @foreach($menu['about']['items'] as $m)
                <li>
                  <a href="{{ route($m['route']) }}"
                    class="{{ $m['is-active'] ? 'is-active' : '' }}"
                    title="{{ $m['name'] }}">
                    {{ $m['name'] }}
                  </a>
                </li>
              @endforeach
            </ul>
          @endif
        </li>
        <li>
          <a href="{{ route($menu['contact']['route']) }}" 
            class="{{ $menu['contact']['is-active'] ? 'is-active' : '' }}"
            title="{{ $menu['contact']['name'] }}">
            {{ $menu['contact']['name'] }}
          </a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<main class="site-content" role="main">
  <div>@yield('content')</div>
</main>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD87zTe10NbK_liZzlO93W17qHiFVwlU8c"></script>
<script src="{{ asset('assets/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/fancybox.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/imagesloaded.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/packery.min.js') }}" type="text/javascript"></script>
</body>
<!-- made with ❤ by marceli.to -->
</html>