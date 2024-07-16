<label for="moneda">MONEDA</label>
<select name="moneda_id" id="{{ $selectId }}" required>
    <option value="">Seleccionar moneda</option>
    @foreach($monedas as $moneda)
        <option value="{{ $moneda->id }}" data-name-code="{{ $moneda->code }}" data-tipo-cambio="{{ $moneda->tipo_cambio }}">{{ $moneda->symbol }} {{ $moneda->name }}</option> {{-- Asegúrate de cambiar 'name' si tu modelo de usuario usa un campo diferente para el nombre --}}
    @endforeach
</select>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener el elemento select por su ID
        var selectMoneda = document.getElementById("{{ $selectId }}");
    
        // Verificar cuando el valor del select cambie
        selectMoneda.addEventListener("change", function() {
            // Obtener el input donde se desea mostrar el tipo de cambio
            var inputTipoCambio = document.getElementById("tipo-de-cambio");
    
            // Verificar si el input existe
            if (inputTipoCambio) {
                // Obtener la opción seleccionada
                var opcionSeleccionada = selectMoneda.options[selectMoneda.selectedIndex];
    
                // Obtener el valor de data-tipo-cambio de la opción seleccionada
                var tipoCambio = opcionSeleccionada.getAttribute("data-tipo-cambio");
    
                // Cambiar el valor del input al tipo de cambio seleccionado
                inputTipoCambio.value = tipoCambio;
            }
        });
    });
    </script>


