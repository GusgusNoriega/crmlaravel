<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

    <div class="container-elementos-completos container-elementos-single">
        <h1>Todas las marcas</h1>
        <x-marcas.agregar-marca />
        <x-marcas.todos-marca />
        <x-marcas.update-marca />
    </div>

    <x-todos-archivos />

</x-dynamic-component>