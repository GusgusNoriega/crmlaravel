<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

<div class="container-elementos-completos container-elementos-completos-productos">
    <h1>Todos los productos</h1>
    <x-productos.agregar-productos/>
    <x-productos.todos-productos/>

<x-todos-archivos />
</div>
        
</x-dynamic-component>