<div class="grid-2x1fr">
  @if (isset($elements[0]) || isset($elements[1]))
    <div class="span">
      <div class="grid-stack">
        @if (isset($elements[0]))
          <div>
              <a href="{!! ImageHelper::get($elements[0]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[0]->image->caption}}">
                <img src="{!! ImageHelper::get($elements[0]->image->name, 'md') !!}"
                  width="687"
                  height="940"
                  alt="{{$elements[0]->image->caption}}">
              </a>
          </div>
        @endif
        @if (isset($elements[1]))
          <div>
            <a href="{!! ImageHelper::get($elements[1]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[1]->image->caption}}">
              <img src="{!! ImageHelper::get($elements[1]->image->name, 'md') !!}"
                width="687"
                height="458"
                alt="{{$elements[1]->image->caption}}">
            </a>
          </div>
        @endif
      </div>
    </div>
  @endif
  @if (isset($elements[2]) || isset($elements[3]))
    <div class="span">
      <div class="grid-stack">
        @if (isset($elements[2]))
          <div>
              <a href="{!! ImageHelper::get($elements[2]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[2]->image->caption}}">
                <img src="{!! ImageHelper::get($elements[2]->image->name, 'md') !!}"
                  width="687"
                  height="458"
                  alt="{{$elements[2]->image->caption}}">
              </a>
          </div>
        @endif
        @if (isset($elements[3]))
          <div>
            <a href="{!! ImageHelper::get($elements[3]->image->name, 'lg') !!}" data-fancybox="gallery" data-caption="{{$elements[3]->image->caption}}">
              <img src="{!! ImageHelper::get($elements[3]->image->name, 'md') !!}"
                width="687"
                height="940"
                alt="{{$elements[3]->image->caption}}">
            </a>
          </div>
        @endif
      </div>
    </div>
  @endif
</div>