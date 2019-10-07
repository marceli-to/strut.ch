<div class="box-3x1fr">
  <div>
    <div class="box__e">
      @if (isset($elements[0]))
        @if ($elements[0]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[0]->projectimage->project->id}}">
            <figure>
              <figcaption>
                <span>{{$elements[0]->projectimage->project->name}}, {{$elements[0]->projectimage->project->location}}</span>
              </figcaption>
              <img src="/media/{{$elements[0]->projectimage->name}}/lg" 
                height="616" 
                width="450" 
                alt="{{$elements[0]->projectimage->caption}}">
            </figure>
          </a>
        @endif
        @if ($elements[0]->news_id)
          @include('web.partials.news', array('news' => $elements[0]->news))
        @endif
      @endif
    </div>
  </div>
  <div>
    <div class="box__e">
      @if (isset($elements[1]))
        @if ($elements[1]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[1]->projectimage->project->id}}">
            <figure>
              <figcaption>
                <span>{{$elements[1]->projectimage->project->name}}, {{$elements[1]->projectimage->project->location}}</span>
              </figcaption>
              <img src="/media/{{$elements[1]->projectimage->name}}/lg" 
                height="616" 
                width="450" 
                alt="{{$elements[1]->projectimage->caption}}">
            </figure>
          </a>
        @endif
      @endif
    </div>
  </div>
  <div>
    <div class="box__e">
      @if (isset($elements[2]))
        @if ($elements[2]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[2]->projectimage->project->id}}">
            <figure>
              <figcaption>
                <span>{{$elements[2]->projectimage->project->name}}, {{$elements[2]->projectimage->project->location}}</span>
              </figcaption>
              <img src="/media/{{$elements[2]->projectimage->name}}/lg" 
                height="616" 
                width="450" 
                alt="{{$elements[2]->projectimage->caption}}">
            </figure>
          </a>
        @endif
      @endif
    </div>
  </div>
</div>