<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

<div class="container-misempresas">
<h1>Todas nuestras empresas</h1>
<x-agregar-misempresas />
<x-todas-mis-empresas />
<x-update-misempresa />
<x-todos-archivos />

</div>
        
</x-dynamic-component>