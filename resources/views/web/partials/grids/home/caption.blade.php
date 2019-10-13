<figcaption class="is-sm">
    <span>{{$element->projectimage->project->name}}, {{$element->projectimage->project->location}}</span>
</figcaption>
<figcaption class="is-md">
  @if ($element->projectimage->project->title)
    <span>{{$element->projectimage->project->title}}</span>
  @else
    <span>{{$element->projectimage->project->name}}, {{$element->projectimage->project->location}}</span>
  @endif
</figcaption>