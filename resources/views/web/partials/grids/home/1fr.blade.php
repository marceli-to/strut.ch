<div class="box-1fr">
  <div>
    <div class="box__a">
      @if (isset($elements[0]))
        @if ($elements[0]->project_image_id)
          <a href="{{ route('page.projects') }}/{{$elements[0]->projectimage->project->id}}">
            <figure>
              @include('web.partials.grids.home.caption', array('element' => $elements[0]))
              <img src="{!! ImageHelper::get($elements[0]->projectimage->name, 'lg') !!}" 
                height="932" 
                width="1398" 
                alt="{{$elements[0]->projectimage->caption}}">
            </figure>
          </a>
        @endif
      @endif
    </div>
  </div>
</div>