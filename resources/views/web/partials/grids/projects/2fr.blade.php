<div class="grid-2x1fr">
  @if (isset($elements[0]))
    <div class="span">
      @include('web.partials.grids.projects.media', ['element' => $elements[0], 'size' => 'md', 'width' => '687', 'height' => '458'])
    </div>
  @endif
  @if (isset($elements[1]))
    <div class="span">
      @include('web.partials.grids.projects.media', ['element' => $elements[1], 'size' => 'md', 'width' => '687', 'height' => '458'])
    </div>
  @endif
</div>