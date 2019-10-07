<div class="box-2fr1fr_stacked">
  <div>
    <div class="box__d">
      @if (isset($elements[0]))
        @if ($elements[0]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[0]->projectimage->project->id}}">
            <figure>
              <figcaption>
                <span>{{$elements[0]->projectimage->project->name}}, {{$elements[0]->projectimage->project->location}}</span>
              </figcaption>
              <img src="/media/{{$elements[0]->projectimage->name}}/lg" 
                height="616" 
                width="900" 
                alt="{{$elements[0]->projectimage->caption}}">
            </figure>
          </a>
        @endif
      @endif
    </div>
  </div>
  <div>
    <div class="box__c">
      @if (isset($elements[1]))
        @if ($elements[1]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[1]->projectimage->project->id}}">
            <figure>
              <figcaption>
                <span>{{$elements[1]->projectimage->project->name}}, {{$elements[1]->projectimage->project->location}}</span>
              </figcaption>
              <img src="/media/{{$elements[1]->projectimage->name}}/lg" 
                height="296" 
                width="450" 
                alt="{{$elements[1]->projectimage->caption}}">
            </figure>
          </a>
        @endif
        @if ($elements[1]->news_id)
          @include('web.partials.news', array('news' => $elements[1]->news))
        @endif
      @endif
    </div>
    <div class="box__c">
      @if (isset($elements[2]))
        @if ($elements[2]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[2]->projectimage->project->id}}">
            <figure>
              <figcaption>
                <span>{{$elements[2]->projectimage->project->name}}, {{$elements[2]->projectimage->project->location}}</span>
              </figcaption>
              <img src="/media/{{$elements[2]->projectimage->name}}/lg" 
                height="296" 
                width="450" 
                alt="{{$elements[2]->projectimage->caption}}">
            </figure>
          </a>
        @endif
        @if ($elements[2]->news_id)
          @include('web.partials.news', array('news' => $elements[2]->news))
        @endif
      @endif
    </div>
  </div>
</div>