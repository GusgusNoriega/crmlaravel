<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">
<div class="single-taxonomia">
  <a class="button button-volver" href="http://sistema3.test/admin/taxonomias">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
    Volver a taxonomias
  </a>
   <h1 class="{{ $taxonomia->id }}">{{ $taxonomia->name }}</h1>
   <div class="single-terminos-de-taxonomia">
     <h2>terminos de {{ $taxonomia->name }}</h2>
     <x-terminos.agregar-termino elementoId="{{ $taxonomia->id }}" />
     <x-terminos.todos-termino elementoId="{{ $taxonomia->id }}" />
     <x-terminos.update-termino />
   </div>
</div>
</x-dynamic-component>