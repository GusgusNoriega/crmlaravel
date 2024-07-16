<!-- En resources/views/components/mostrar-usuario.blade.php -->
<div class="perfil-menu-principal">
    <p>Bienvenido, {{ $usuario->name }}</p>

    @if ($usuario->image)
        <div class="img-usuario-actual">
            <img src="{{ asset('storage/' . $usuario->image->ruta) }}" alt="{{ $usuario->name }}'s Avatar">
        </div>
    @else
        <div class="img-usuario-actual">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path></svg>
        </div>
    @endif
    <p>Email: {{ $usuario->email }}</p>
    <p>Cargo: {{ $usuario->cargo }}</p>
</div>