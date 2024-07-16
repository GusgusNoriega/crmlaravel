<div class="form-group form-group-25">
    <label for="direccion">Vendedor</label>
    <select name="user_id" id="{{ $selectId }}">
        <option value="">Seleccionar vendedor</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option> {{-- Asegúrate de cambiar 'name' si tu modelo de usuario usa un campo diferente para el nombre --}}
        @endforeach
    </select>
</div>