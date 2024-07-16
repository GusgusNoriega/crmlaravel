<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

    <div class="container-elementos-completos container-elementos-single">
        <h1>Todas las procedencias</h1>
        <x-procedencias.agregar-procedencia />
        <x-procedencias.todos-procedencia />
        <x-procedencias.update-procedencia />
    </div>

    <x-todos-archivos />

</x-dynamic-component>