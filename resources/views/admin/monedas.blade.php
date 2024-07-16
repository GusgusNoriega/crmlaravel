<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

    <div class="container-elementos-completos container-elementos-single">
        <h1>Todas las monedas</h1>
        <x-monedas.agregar-moneda />
        <x-monedas.todos-moneda />
        <x-monedas.update-moneda />
    </div>

    <x-todos-archivos />

</x-dynamic-component>