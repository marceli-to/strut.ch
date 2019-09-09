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
      .grid-awards {
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
      <h2>Auszeichnungen</h2>
      <div class="grid-awards">
        @foreach($awards as $a)
          <article style="border-top: 1px solid #000;padding-top: 10px">
            <div style="font-size:24px; margin-bottom: 10px">{{$a->year}}</div>
            <div>
              <strong>{{ $a->title }}</strong><br>
              {!! $a->description !!}
              @if ($a->media)
                <img src="/media/{{$a->media}}/sm" style="margin-top: 10px; max-width: 80%">
              @endif
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
@endsection