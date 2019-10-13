@extends('web.layout.app')
@section('content')
<section class="content contact">
  @if ($contact)
    <div class="contact-grid">
      <div class="span">
        <h1>{{ $contact->title }}</h1>
        <article>
          {!! $contact->text !!}
        </article>
        @if ($imprint)
          <div class="contact__imprint">
            <a href="javascript:;" class="icon-toggle js-btn-toggle">Impressum</a>
            <div style="display:none">
                {!! $imprint->text !!}
            </div>
          </div>
        @endif
      </div>
      <div class="span has-media">
        <div class="contact__maps" id="js-maps"></div>
        <a href="https://goo.gl/maps/iP116gayDdwGiKFm7" target="_blank" rel="noopener">Auf Google Maps anzeigen</a>
      </div>
    </div>
  @endif
</section>
@endsection