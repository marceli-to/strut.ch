<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@if(trim($__env->yieldContent('seo_title')))@yield('seo_title') - {{config('seo.title')}}@else{{config('seo.title')}}@endif</title>
<meta name="description" content="@if(trim($__env->yieldContent('seo_description')))@yield('seo_description')@else{{config('seo.description')}}@endif">
<meta property="og:title" content="@if(trim($__env->yieldContent('seo_title')))@yield('seo_title') - {{config('seo.title')}}@else{{config('seo.title')}}@endif">
<meta property="og:description" content="@if(trim($__env->yieldContent('seo_description')))@yield('seo_description')@else{{config('seo.description')}}@endif">
<meta property="og:url" content="{{url()->current()}}">
<meta property="og:image" content="@if(trim($__env->yieldContent('og_image')))@yield('og_image')@else{{ asset('assets/img/strut.ch-og.png') }}@endif">
<meta property="og:site_name" content="{{config('seo.title')}}">
<link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="/assets/img/favicon/site.webmanifest">
<link rel="mask-icon" href="/assets/img/favicon/safari-pinned-tab.svg" color="#666666">
<link rel="shortcut icon" href="/assets/img/favicon/favicon.ico">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-config" content="/assets/img/favicon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
<meta name="csrf-token" content="{{ csrf_token() }}" />
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
            @if (isset($menu['projects']['items']))
              @foreach ($menu['projects']['items'] as $c)
                <li>
                    <a href="javascript:;" 
                      class="js-btn-sub-menu {{ $c['is-active'] ? 'is-active' : '' }}">
                      {{$c['name']}}
                    </a>
                    @if ($c['show_types'])
                      <ul>
                        @if (isset($c['types']))
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
                        @endif
                      </ul>
                    @else
                      @if (isset($c['types']))
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
                    @endif
                </li>
              @endforeach
            @endif   
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
<main class="site-content {{request()->routeIs('page.home') ? 'site-content--home' : ''}}" role="main">
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