<div class="box-2x1fr">
  <div>
    <div class="box__b">
      @if (isset($elements[0]))
        @include('web.partials.grids.home.media', ['element' => $elements[0]])
      @endif
    </div>
  </div>
  <div>
    <div class="box__b">
      @if (isset($elements[1]))
        @include('web.partials.grids.home.media', ['element' => $elements[1]])
      @endif
    </div>
  </div>
</div>
