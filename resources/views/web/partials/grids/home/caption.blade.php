@php
  $project = $element->projectvideo->project ?? $element->projectimage->project ?? null;
@endphp
@if ($project)
<figcaption>
  @if ($project->title)
    <span>{{ $project->title }}</span>
  @else
    <span>{{ $project->name }}, {{ $project->location }}</span>
  @endif
</figcaption>
@endif
