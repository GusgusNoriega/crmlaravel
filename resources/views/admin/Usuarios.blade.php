<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

<div><h1>usuarios</h1></div>

<x-registration-form />
<x-usuarios />
<x-update-users />
<x-todos-archivos />

        
</x-dynamic-component>

