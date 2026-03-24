<div class="grid-2x1fr">
  @if (isset($elements[0]) || isset($elements[1]))
    <div class="span">
      <div class="grid-stack">
        @if (isset($elements[0]))
          <div>
            @include('web.partials.grids.projects.media', ['element' => $elements[0], 'size' => 'md', 'width' => '687', 'height' => '458'])
          </div>
        @endif
        @if (isset($elements[1]))
          <div>
            @include('web.partials.grids.projects.media', ['element' => $elements[1], 'size' => 'md', 'width' => '687', 'height' => '458'])
          </div>
        @endif
      </div>
    </div>
  @endif
  @if (isset($elements[2]))
    <div class="span">
      @include('web.partials.grids.projects.media', ['element' => $elements[2], 'size' => 'lg', 'width' => '687', 'height' => '940'])
    </div>
  @endif
</div>