@if ($element->video)
  <video autoplay muted loop playsinline>
    <source src="/storage/media/{{ $element->video->name }}">
  </video>
@elseif ($element->image)
  <a href="{!! ImageHelper::get($element->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$element->image->caption}}">
    <img src="{!! ImageHelper::get($element->image->name, $size) !!}"
      width="{{ $width }}"
      height="{{ $height }}"
      alt="{{$element->image->caption}}">
  </a>
@endif
