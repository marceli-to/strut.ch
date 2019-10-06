@extends('web.layout.app')
@section('content')
<section class="content lectures">
  <h1>Vorträge</h1>
  <div class="lectures-list">
    @if ($lectures)
      @foreach($lectures as $lecture_year_group)
        <div class="span">
          <article class="lecture-group">
            @foreach($lecture_year_group as $year => $lecture_group)
              <h2>{{$year}}</h2>
              @foreach($lecture_group as $lecture)
                <div class="lecture">
                  <h3>{{$lecture['title']['de']}}</h3>
                  <div>{{$lecture['description']['de']}}</div>
                  @if ($lecture['media'])
                    <figure>
                      <img src="/media/{{$lecture['media']}}/sm" width="600" height="400" alt="{{$lecture['title']['de']}}">
                    </figure>
                  @endif
                </div>
              @endforeach
            @endforeach
          </article>
        </div>
      @endforeach
    @endif
  </div>
</section>
@endsection