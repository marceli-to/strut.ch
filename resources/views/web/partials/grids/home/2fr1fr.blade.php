<div class="box-2fr1fr">
    <div>
      <div class="box__d">
        @if (isset($elements[0]))
          @if ($elements[0]->project_image_id)
            <a href="{{ route('page.projects') }}/{!! AppHelper::getSlug($elements[0]->projectimage->project) !!}">
              <figure>
                @include('web.partials.grids.home.caption', array('element' => $elements[0]))
                <img src="{!! ImageHelper::get($elements[0]->projectimage->name, 'lg') !!}" 
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
      <div class="box__e">
        @if (isset($elements[1]))
          @if ($elements[1]->project_image_id)
            <a href="{{ route('page.projects') }}/{!! AppHelper::getSlug($elements[1]->projectimage->project) !!}">
              <figure>
                @include('web.partials.grids.home.caption', array('element' => $elements[1]))
                <img src="{!! ImageHelper::get($elements[1]->projectimage->name, 'md') !!}" 
                  height="616" 
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
  </div>