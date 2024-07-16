<label for="area">AREA</label>
<select name="area_id" id="{{ $selectId }}">
    <option value="">Seleccionar area</option>
    @foreach($areas as $area)
        <option value="{{ $area->id }}">{{ $area->name }}</option> {{-- Asegúrate de cambiar 'name' si tu modelo de usuario usa un campo diferente para el nombre --}}
    @endforeach
</select>
