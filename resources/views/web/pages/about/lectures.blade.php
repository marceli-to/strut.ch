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
      .grid-lectures {
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
      <h2>Vorträge</h2>
      <div class="grid-lectures">
        @foreach($lectures as $l)
          <article style="border-top: 1px solid #000;padding-top: 10px">
            <div style="font-size:24px; margin-bottom: 10px">{{$l->year}}</div>
            <div>
              <strong>{{ $l->title }}</strong><br>
              {!! $l->description !!}
              @if ($l->media)
                <img src="/media/{{$l->media}}/sm" style="margin-top: 10px; max-width: 80%">
              @endif
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
@endsection