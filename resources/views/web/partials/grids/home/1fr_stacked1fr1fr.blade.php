<div class="box-3x1fr">
  <div>
    <div class="box__c">
      @if (isset($elements[0]))
        @if ($elements[0]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[0]->projectimage->project->id}}">
            <figure>
              <figcaption>
                @if ($elements[0]->projectimage->project->title)
                  <span>{{$elements[0]->projectimage->project->title}}</span>
                @else
                  <span>{{$elements[0]->projectimage->project->name}}, {{$elements[0]->projectimage->project->location}}</span>
                @endif
              </figcaption>
              <img src="{!! ImageHelper::get($elements[0]->projectimage->name, 'sm') !!}" 
                height="296" 
                width="450" 
                alt="{{$elements[0]->projectimage->caption}}">
            </figure>
          </a>
        @endif
        @if ($elements[1]->news_id)
          @include('web.partials.news', array('news' => $elements[1]->news))
        @endif
      @endif
    </div>
    <div class="box__c">
      @if (isset($elements[1]))
        @if ($elements[1]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[1]->projectimage->project->id}}">
            <figure>
              <figcaption>
                @if ($elements[1]->projectimage->project->title)
                  <span>{{$elements[1]->projectimage->project->title}}</span>
                @else
                  <span>{{$elements[1]->projectimage->project->name}}, {{$elements[1]->projectimage->project->location}}</span>
                @endif
              </figcaption>
              <img src="{!! ImageHelper::get($elements[1]->projectimage->name, 'sm') !!}" 
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
  </div>  
  <div>
    <div class="box__e">
      @if (isset($elements[2]))
        @if ($elements[2]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[2]->projectimage->project->id}}">
            <figure>
              <figcaption>
                @if ($elements[2]->projectimage->project->title)
                  <span>{{$elements[2]->projectimage->project->title}}</span>
                @else
                  <span>{{$elements[2]->projectimage->project->name}}, {{$elements[2]->projectimage->project->location}}</span>
                @endif
              </figcaption>
              <img src="{!! ImageHelper::get($elements[2]->projectimage->name, 'md') !!}" 
                height="616" 
                width="450" 
                alt="{{$elements[2]->projectimage->caption}}">
            </figure>
          </a>
        @endif
      @endif
    </div>
  </div>
  <div>
    <div class="box__e">
      @if (isset($elements[3]))
        @if ($elements[3]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[3]->projectimage->project->id}}">
            <figure>
              <figcaption>
                @if ($elements[3]->projectimage->project->title)
                  <span>{{$elements[3]->projectimage->project->title}}</span>
                @else
                  <span>{{$elements[3]->projectimage->project->name}}, {{$elements[3]->projectimage->project->location}}</span>
                @endif
              </figcaption>
              <img src="{!! ImageHelper::get($elements[0]->projectimage->name, 'md') !!}" 
                height="616" 
                width="450" 
                alt="{{$elements[3]->projectimage->caption}}">
            </figure>
          </a>
        @endif
      @endif
    </div>
  </div>
</div>