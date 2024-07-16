<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">
    <x-slot name="header">
        <h2>
            {{ __('Crear un nuevo usuario') }}
        </h2>
    </x-slot>
<div class="container">
    <h1>Registrar Nuevo Usuario</h1>
    <form method="POST" action="{{ route('admin.register') }}">
        @csrf {{-- Protección CSRF --}}

        {{-- Campo Nombre --}}
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        {{-- Campo Email --}}
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        {{-- Campo Teléfono --}}
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono">
        </div>

        {{-- Campo Cargo --}}
        <div class="form-group">
            <label for="cargo">Cargo</label>
            <input type="text" class="form-control" id="cargo" name="cargo">
        </div>

        {{-- Campo Contraseña --}}
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        {{-- Campo Confirmación de Contraseña --}}
        <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        {{-- Selector de Rol --}}
        <div class="form-group">
            <label for="role">Rol</label>
            <select class="form-control" id="role" name="role_id">
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Botón de Envío --}}
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>

</x-dynamic-component>