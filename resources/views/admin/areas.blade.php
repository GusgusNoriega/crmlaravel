<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

<div class="container-elementos-completos container-elementos-single">
    <h1>Todos las areas de trabajo</h1>
    <x-areas.agregar-area />
    <x-areas.todos-areas />
    <x-areas.update-area />
</div>

</x-dynamic-component>