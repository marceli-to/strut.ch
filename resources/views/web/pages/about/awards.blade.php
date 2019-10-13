@extends('web.layout.app')
@section('content')
<section class="content awards">
  <h1>Auszeichnungen</h1>
  <div class="awards-list">
    @if ($awards)
      @foreach($awards as $award_year_group)
        <div class="span">
          <article class="award-group">
            @foreach($award_year_group as $year => $award_group)
              <h2>{{$year}}</h2>
              @foreach($award_group as $award)
                <div class="award">
                  <h3>{{$award['title']['de']}}</h3>
                  <div>{{$award['description']['de']}}</div>
                  @if ($award['media'])
                    <figure>
                      <img src="{!! ImageHelper::get($award['media'], 'xs') !!}" width="600" height="400" alt="{{$award['title']['de']}}">
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