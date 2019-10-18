<nav class="work-groups">
  <div class="span">
    <ul>
      <li>
        <a href="{{ route('page.works.status') }}" @if ($listBy == 'status') class="is-active" @endif>Status</a>
      </li>
      <li>
        <a href="{{ route('page.works.year') }}" @if ($listBy == 'year') class="is-active" @endif>Jahr</a>
      </li>
      <li>
        <a href="{{ route('page.works.type') }}" @if ($listBy == 'type') class="is-active" @endif>Typ</a>
      </li>
    </ul>
  </div>
  <div class="span">
      @if ($listBy == 'status')
        <a href="{{ route('pdf.works.state') }}" target="_blank" class="icon-file"><span>Werkliste nach Status</span></a>
      @endif
      @if ($listBy == 'year')
        <a href="{{ route('pdf.works.year') }}" target="_blank" class="icon-file"><span>Werkliste nach Jahr</span></a>
      @endif
      @if ($listBy == 'type')
        <a href="{{ route('pdf.works.type') }}" target="_blank" class="icon-file"><span>Werkliste nach Typ</span></a>
      @endif
    </a>
  </div>
</nav>