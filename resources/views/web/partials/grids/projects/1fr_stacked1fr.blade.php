<div class="grid-2x1fr">
  <div class="span">
    <div class="grid-stack">
      <div>
        @if (isset($elements[0]))
          <img src="/media/{{$elements[0]->image->name}}/lg"
            width="687"
            height="458"
            alt="{{$elements[0]->image->caption}}">
        @endif
      </div>
      <div>
        @if (isset($elements[1]))
          <img src="/media/{{$elements[1]->image->name}}/lg"
            width="687"
            height="458"
            alt="{{$elements[1]->image->caption}}">
        @endif
      </div>
    </div>
  </div>
  <div class="span">
    @if (isset($elements[2]))
      <img src="/media/{{$elements[2]->image->name}}/lg"
        width="687"
        height="940"
        alt="{{$elements[2]->image->caption}}">
    @endif
  </div>
</div>