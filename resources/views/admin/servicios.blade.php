<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

    <div class="container-elementos-completos container-elementos-completos-productos">
        <h1>Todos los servicios</h1>
        <x-servicios.agregar-servicio />
        <x-servicios.todos-servicios />
        <x-todos-archivos />
    </div>
            
</x-dynamic-component>