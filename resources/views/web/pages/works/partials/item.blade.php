<div class="work-item {{$project->has_detail ? 'has-link' : ''}}">
  <h3>
    @if ($project->has_detail)
      <a href="{{ route('page.projects') }}/{!! AppHelper::getSlug($project) !!}">
        {{$project->name}}, {{$project->location}}
      </a>
    @else
      {{$project->name}}, {{$project->location}}
    @endif
  </h3>
  @foreach($project->images as $img)
    @if ($image_by == 'type')
      @if ($img->is_preview_type)
        <figure>
          <img src="{!! ImageHelper::get($img->name, 'sm') !!}" 
              width="600"
              height="400"
              alt="@if ($img->caption){{$img->caption}} – @endif{{$project->name}}, {{$project->location}}">
        </figure>
        @php break; @endphp
      @endif
    @endif
    @if ($image_by == 'status')
      @if ($img->is_preview_status)
        <figure>
          <img src="{!! ImageHelper::get($img->name, 'sm') !!}" 
              width="600"
              height="400"
              alt="@if ($img->caption){{$img->caption}} – @endif{{$project->name}}, {{$project->location}}">
        </figure>
        @php break; @endphp
      @endif
    @endif
  @endforeach
</div>