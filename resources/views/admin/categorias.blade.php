<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

  <div class="container-elementos-completos container-elementos-single">
        <h1>Todas las categorias</h1>
        <x-categorias.agregar-categoria />
        <x-categorias.todos-categoria />
        <x-categorias.update-categoria />
  </div>
 <x-todos-archivos />

</x-dynamic-component>