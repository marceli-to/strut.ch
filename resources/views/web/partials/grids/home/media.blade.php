@if ($element->project_video_id && $element->projectvideo)
  <a href="{{ route('page.projects') }}/{!! AppHelper::getSlug($element->projectvideo->project) !!}">
    <figure>
      @include('web.partials.grids.home.caption', array('element' => $element))
      <video autoplay muted loop playsinline>
        <source src="/storage/media/{{ $element->projectvideo->name }}">
      </video>
    </figure>
  </a>
@elseif ($element->project_image_id && $element->projectimage)
  <a href="{{ route('page.projects') }}/{!! AppHelper::getSlug($element->projectimage->project) !!}">
    <figure>
      @include('web.partials.grids.home.caption', array('element' => $element))
      <img src="{!! ImageHelper::get($element->projectimage->name, 'lg') !!}" 
        height="932" 
        width="1398" 
        alt="{{ $element->projectimage->caption }}">
    </figure>
  </a>
@endif
