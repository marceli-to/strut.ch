<div class="box-3x1fr">
  <div>
    <div class="box__e">
      @if (isset($elements[0]))
        @include('web.partials.grids.home.media', ['element' => $elements[0]])
        @if ($elements[0]->news_id)
          @include('web.partials.news', array('news' => $elements[0]->news))
        @endif
      @endif
    </div>
  </div>
  <div>
    <div class="box__e">
      @if (isset($elements[1]))
        @include('web.partials.grids.home.media', ['element' => $elements[1]])
        @if ($elements[1]->news_id)
          @include('web.partials.news', array('news' => $elements[1]->news))
        @endif
      @endif
    </div>
  </div>
  <div>
    <div class="box__e">
      @if (isset($elements[2]))
        @include('web.partials.grids.home.media', ['element' => $elements[2]])
        @if ($elements[2]->news_id)
          @include('web.partials.news', array('news' => $elements[2]->news))
        @endif
      @endif
    </div>
  </div>
</div>
