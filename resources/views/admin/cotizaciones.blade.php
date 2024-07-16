<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

    <div class="container-elementos-completos container-elementos-completos-cotizaciones">
        <h1>Todas las cotizaciones</h1>
        <x-cotizaciones.agregar-cotizacion />
        <x-cotizaciones.todos-cotizaciones />
        <x-todos-archivos />
    </div>
               
</x-dynamic-component>