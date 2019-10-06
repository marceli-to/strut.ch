@extends('web.layout.app')
@section('content')
<section class="content downloads">
  <h1>Downloads</h1>
  <div class="downloads__grid">
    <div class="span">
      <article>
        <h2>Projektdokumentationen</h2>
        <div class="download-group is-article">
          <h3>Wohnen</h3>
          <a href="" class="icon-file">Alle Wohnen</a>
          <div class="download-group__item">
            <h4>Einfamilienhäuser</h4>
            <div><a href="" class="icon-file">Einfamilienhaus, Volketswil</a></div>
            <div><a href="" class="icon-file">Einfamilienhaus, Volketswil</a></div>
            <div><a href="" class="icon-file">Einfamilienhaus, Volketswil</a></div>
          </div>
          <div class="download-group__item">
            <h4>Villen</h4>
            <div><a href="" class="icon-file">Villa, Volketswil</a></div>
            <div><a href="" class="icon-file">Villa, Volketswil</a></div>
            <div><a href="" class="icon-file">Villa, Volketswil</a></div>
          </div>
          <div class="download-group__item">
            <h4>Wohnüberbauungen</h4>
            <div><a href="" class="icon-file">Leimenegg, Volketswil</a></div>
            <div><a href="" class="icon-file">Leimenegg, Volketswil</a></div>
            <div><a href="" class="icon-file">Leimenegg, Volketswil</a></div>
          </div>
        </div>
        <div class="download-group is-article">
          <h3>Gewerbe</h3>
          <a href="" class="icon-file">Alle Gewerbe</a>
          <div class="download-group__item">
            <div><a href="" class="icon-file">Einfamilienhaus, Volketswil</a></div>
            <div><a href="" class="icon-file">Einfamilienhaus, Volketswil</a></div>
            <div><a href="" class="icon-file">Einfamilienhaus, Volketswil</a></div>
          </div>
        </div>
      </article>
    </div>
    <div class="span">
      <article>
        <h2>Werkliste</h2>
        <div class="download-group has-offset">
          <div><a href="" class="icon-file">Gesamt</a></div>
          <div><a href="" class="icon-file">Wohnen</a></div>
          <div><a href="" class="icon-file">Gewerbe</a></div>
          <div><a href="" class="icon-file">Öffentlich</a></div>
          <div><a href="" class="icon-file">Wettbewerb</a></div>
          <div><a href="" class="icon-file">Nach Status</a></div>
          <div><a href="" class="icon-file">Nach Jahr</a></div>
          <div><a href="" class="icon-file">Nach Typ</a></div>
        </div>
      </article>
    </div>
    <div class="span">
      <article>
        <h2>Jobs</h2>
        @if ($jobs->isNotEmpty())
          <div class="download-group has-offset">
            @foreach($jobs as $j)
              <div>
                @if ($j->media)
                  <a href="{{asset('storage/media/downloads/' . $j->media)}}" 
                     class="icon-file"
                     target="_blank"
                     title="Ausschreibung {{$j->title}}">
                     {{$j->title}}
                  </a>
                @endif
              </div>
            @endforeach
          </div>
        @else
          <p>Zur Zeit sind alle unsere Stellen besetzt.</p>
        @endif
      </article>
    </div>    
  </div>
</section>
@endsection