<div class="box-1fr_stacked2fr">
  <div>
    <div class="box__c">
      @if (isset($elements[0]))
        @include('web.partials.grids.home.media', ['element' => $elements[0]])
        @if ($elements[0]->news_id)
          @include('web.partials.news', array('news' => $elements[0]->news))
        @endif
      @endif
    </div>
    <div class="box__c">
      @if (isset($elements[1]))
        @include('web.partials.grids.home.media', ['element' => $elements[1]])
      @endif
    </div>
  </div>
  <div>
    <div class="box__d">
      @if (isset($elements[2]))
        @include('web.partials.grids.home.media', ['element' => $elements[2]])
      @endif
    </div>
  </div>
</div>
