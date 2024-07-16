<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

    <div class="container-elementos-completos container-elementos-clientes">
        <h1>Conecciones apis</h1>
        <x-apiweb.agregar-apiweb />
        <x-apiweb.todos-apiweb />
        <x-apiweb.update-apiweb />

        <x-todos-archivos />
    </div>
            
</x-dynamic-component>