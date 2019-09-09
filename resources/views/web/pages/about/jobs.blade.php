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
    <div class="grid">
      <div>
        <h2 style="border-bottom: 1px solid #000">
          Jobs
        </h2>
        @foreach($jobs as $j)
          <article>
            <h1 style="padding-top: 10px; font-size: 24px; margin-bottom: 30px">
                {{$j->title}}
            </h1>
            <p style="font-size: 24px;">
              {{$j->lead}}
            </p>
            <p>
              {!!$j->info!!}
            </p>
          </article>
        @endforeach
      </div>
    </div>
  </div>
@endsection