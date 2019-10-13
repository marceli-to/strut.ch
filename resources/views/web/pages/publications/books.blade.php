@extends('web.layout.app')
@section('seo_title', 'Bücher')
@section('seo_description', '')
@section('content')
<section class="content books">
  <h1>Bücher</h1>
  <div class="books__grid js-msnry">
      @foreach($books as $b)
        <div class="book js-msnry-item">
          <article>
              <header>
                <h3>{{$b->title}}</h3>
                <figure>
                  <img src="{!! ImageHelper::get($b->media, 'sm') !!}" width="600" height="400" alt="{{$b->title}}">
                </figure>
                <div class="book__detail">
                  <p>@php echo nl2br($b->description) @endphp</p>
                  <div>
                    <a href="javascript:;" class="icon-toggle is-reverse js-msnry-btn">Info</a>
                    <div class="book__info" style="display:none">{!! $b->info !!}</div>
                    @if ($b->url)
                      <div class="book__order">
                        @php if (strpos($b->url, '@') != FALSE): @endphp
                          <a href="mailto:{{$b->url}}?subject=Bestellung {{$b->title}}&body=Ich bestelle 1 Exemplar '{{$b->title}}'" 
                             title="Buch «{{$b->title}}» Bestellen" class="icon-arrow">
                            Bestellen
                          </a>
                        @php else: @endphp
                          <a href="{{$b->url}}" 
                             target="_blank" 
                             title="Buch «{{$b->title}}» Bestellen" class="icon-arrow">
                             Bestellen
                          </a>
                        @php endif; @endphp
                      </div>
                    @endif
                  </div>
                </div>
              </header>
          </article>
        </div>
      @endforeach
    </div>
</section>
@endsection