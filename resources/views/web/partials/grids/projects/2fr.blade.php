<div class="grid-2x1fr">
  <div class="span">
    @if (isset($elements[0]))
      <a href="/media/{{$elements[0]->image->name}}/lg" data-fancybox="gallery" data-caption="{{$elements[0]->image->caption}}">
        <img src="/media/{{$elements[0]->image->name}}/md" 
          width="687" 
          height="458"
          alt="{{$elements[0]->image->caption}}">
      </a>
    @endif
  </div>
  <div class="span">
    @if (isset($elements[1]))
      <a href="/media/{{$elements[1]->image->name}}/lg" data-fancybox="gallery" data-caption="{{$elements[1]->image->caption}}">
        <img src="/media/{{$elements[1]->image->name}}/md" 
          width="687" 
          height="458"
          alt="{{$elements[0]->image->caption}}">
      </a>
    @endif
  </div>
</div>