@extends('web.layout.app')
@section('seo_title', '404 - Seite nicht gefunden')
@section('content')
<section class="content errors">
  <div class="errors-grid">
    <div class="span">
      <h1>404</h1>
      <article>
        <p>Die gewünschte Seite wurde nicht gefun­den. Die Seite wurde ent­we­der gelöscht oder die von Ihnen ein­gegebene Adresse war nicht kor­rekt.</p>
        <p><a href="/" title="Zur Startseite">Zur Start­seite.</a></p>
      </article>
    </div>
    <div class="span"></div>
  </div>
</section>
@endsection