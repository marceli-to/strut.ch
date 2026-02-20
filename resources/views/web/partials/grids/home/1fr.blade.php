<div class="box-1fr">
  <div>
    <div class="box__a">
      @if (isset($elements[0]))
        @include('web.partials.grids.home.media', ['element' => $elements[0]])
      @endif
    </div>
  </div>
</div>
