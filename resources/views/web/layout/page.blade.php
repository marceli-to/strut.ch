<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>strut.ch</title>
<meta name="csrf-token" value="{{ csrf_token() }}" />
<meta name="format-detection" content="telephone=no">
<script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
<link href="{{ asset('assets/css/app.css') }}" type="text/css" rel="stylesheet" />
</head>
<body>
<header class="site-header">
    <div>
        <a href="javascript:;" class="icon-menu js-btn-menu" title=""></a>
        <a href="/" class="brand" title="Home | strut.ch">
            <img src="/assets/img/logo-strut.svg" height="161" width="313">
        </a>
    </div>
    <nav class="site-nav js-menu" role="navigation">
        <div>
            <ul>
                <li>
                    <a href="javascript:;" class="js-btn-sub-menu is-parent">Bauten</a>
                    <ul>
                        @foreach ($menu['projects']['categories'] as $category)
                            <li>
                                <a href="javascript:;" class="js-btn-sub-menu">
                                    {{$category['name']}}
                                </a>
                                @if ($category['show_types'])
                                    <ul>
                                        @foreach ($category['types'] as $type)
                                            <li>
                                                <a href="javascript:;" class="js-btn-sub-menu">
                                                    {{$type['name']}}
                                                </a>
                                                <ul class="has-indent">
                                                    @foreach ($type['projects'] as $p)
                                                        <li>{{$p['name']}}</li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    @foreach ($category['types'] as $type)
                                        <ul class="has-indent">
                                            @foreach ($type['projects'] as $p)
                                                <li>{{$p['name']}}</li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                @endif
                            </li>
                        @endforeach   
                    </ul>
                </li>
                <li><a href="">Werkliste</a></li>
                <li>
                    <a href="javascript:;" class="js-btn-sub-menu is-parent">Publikationen</a>
                    <ul>
                        <li><a href="">Presse</a></li>
                        <li><a href="">Bücher</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" class="js-btn-sub-menu is-parent">Büro</a>
                    <ul>
                        <li><a href="/ueber-uns">Über uns</a></li>
                        <li><a href="">Jobs</a></li>
                        <li><a href="">Auszeichnungen</a></li>
                        <li><a href="">Vorträge</a></li>
                    </ul>
                </li>
                <li><a href="">Kontakt</a></li>

                {{-- <li class="is-inline is-language"><a href="">De</a></li>
                <li class="is-inline is-language"><a href="" class="is-inactive">En</a></li> --}}
            </ul>
        </div>
    </nav>
</header>
<main class="site-content" role="main">
    <div>@yield('content')</div>
</main>
<script src="{{ asset('assets/js/app.js') }}" type="text/javascript"></script>
</body>
<!-- made with ❤ by marceli.to -->
</html>