<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

    <div class="container-elementos-completos container-elementos-single">
        <h1>Todas las taxonomias</h1>
        <x-taxonomias.agregar-taxonomia />
        <x-taxonomias.todos-taxonomia />
        <x-taxonomias.update-taxonomia />
    </div>
    
</x-dynamic-component>