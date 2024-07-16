<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

<div class="container-elementos-completos container-elementos-clientes">
    <h1>Todos nuestros clientes</h1>
    <x-agregar-clientes />
    <x-todos-clientes />
    <x-update-cliente />
  
<x-todos-archivos />

</div>
        
</x-dynamic-component>