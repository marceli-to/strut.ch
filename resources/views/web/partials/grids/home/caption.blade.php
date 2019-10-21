<figcaption>
  @if ($element->projectimage->project->title)
    <span>{{$element->projectimage->project->title}}</span>
  @else
    <span>{{$element->projectimage->project->name}}, {{$element->projectimage->project->location}}</span>
  @endif
</figcaption>