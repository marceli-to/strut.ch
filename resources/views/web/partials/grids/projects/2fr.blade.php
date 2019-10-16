<div class="grid-2x1fr">
  @if (isset($elements[0]))
    <div class="span">
      <a href="{!! ImageHelper::get($elements[0]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[0]->image->caption}}">
        <img src="{!! ImageHelper::get($elements[0]->image->name, 'md') !!}" 
          width="687" 
          height="458"
          alt="{{$elements[0]->image->caption}}">
      </a>
    </div>
  @endif
  @if (isset($elements[1]))
    <div class="span">
      <a href="{!! ImageHelper::get($elements[1]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[1]->image->caption}}">
        <img src="{!! ImageHelper::get($elements[1]->image->name, 'md') !!}" 
          width="687" 
          height="458"
          alt="{{$elements[1]->image->caption}}">
      </a>
    </div>
  @endif
</div>