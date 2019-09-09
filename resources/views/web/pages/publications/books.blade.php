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
      .grid-books {
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
      <h2>Bücher</h2>
      <div class="grid-books">
        @foreach($books as $b)
          <article style="border-top: 1px solid #000;padding-top: 10px">
            <div style="font-size:24px; margin-bottom: 10px">{{$b->title}}</div>
            @if ($b->media)
              <img src="/media/{{$b->media}}/sm" style="margin-top: 10px; margin-bottom: 5px">
            @endif
            <div>
              <p>@php echo nl2br($b->description) @endphp</p>
              {!! $b->info !!}
              @if ($b->url)
                <a href="{{$b->url}}" target="_blank">bestellen</a>
              @endif
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </div>
@endsection