<div class="grid-2x1fr">
  <div class="span">
    <div class="grid-stack">
      <div>
        @if (isset($elements[0]))
          <a href="{!! ImageHelper::get($elements[0]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[0]->image->caption}}">
            <img src="{!! ImageHelper::get($elements[0]->image->name, 'md') !!}"
              width="687"
              height="458"
              alt="{{$elements[0]->image->caption}}">
          </a>
        @endif
      </div>
      <div>
        @if (isset($elements[1]))
          <a href="{!! ImageHelper::get($elements[1]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[1]->image->caption}}">
            <img src="{!! ImageHelper::get($elements[1]->image->name, 'md') !!}"
              width="687"
              height="458"
              alt="{{$elements[1]->image->caption}}">
          </a>
        @endif
      </div>
    </div>
  </div>
  <div class="span">
    @if (isset($elements[2]))
      <a href="{!! ImageHelper::get($elements[2]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[2]->image->caption}}">
        <img src="{!! ImageHelper::get($elements[2]->image->name, 'lg') !!}"
          width="687"
          height="940"
          alt="{{$elements[2]->image->caption}}">
      </a>
    @endif
  </div>
</div>