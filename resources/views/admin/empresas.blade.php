<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

<div class="container-elementos-completos">
    <h1>Todas las empresas de nuestros clientes</h1>
<x-agregar-empresas />
<x-todas-empresas-de-clientes />
<x-update-empresas />

<x-todos-archivos />
</div>
        
</x-dynamic-component>