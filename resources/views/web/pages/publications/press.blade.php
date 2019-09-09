@extends('web.layout.app')
@section('content')
<div style="padding-bottom: 40px">
  
    <style>
      .grid {
        display: grid;
        grid-template-columns: 1fr 2fr;
        grid-gap: 30px;
        margin-top: 30px;
      }
      .grid-press {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 30px;
      }
      p {
        line-height: 1.25;
      }
      article {
        margin-bottom: 30px;
      }
      img {
        display: block;
        height: auto;
        width: 100%;
      }
    </style>
    <div>
      <h2>Presse</h2>
      <div class="grid-press">
        @foreach($press as $p)
          <article style="border-top: 1px solid #000;padding-top: 10px">
            <div style="font-size:24px; margin-bottom: 10px">{{$p->year}}</div>
            <div>
              <strong>{{ $p->title }}</strong><br>
              {!! $p->description !!}
              @if ($p->media)
                <img src="/media/{{$p->media}}/sm" style="margin-top: 10px; max-width: 80%">
              @endif
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
@endsection