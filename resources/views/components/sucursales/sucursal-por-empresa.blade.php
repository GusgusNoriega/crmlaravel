<div class="form-group">
    <label for="">Sucursal</label>
    <select name="sucursales" id="seleccionar-sucursal{{ $elementoId }}">
        <option value="">Seleccionar sucursal</option>
    </select>
</div>
<script>

function cargarSucursales{{ $elementoId }}(empresaId, sucursalId = null) {
    fetch('/admin/sucursales/empresa/' + empresaId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la red');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);
            llenarSelectConJson{{ $elementoId }}(data, sucursalId);
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
        });
}

function llenarSelectConJson{{ $elementoId }}(jsonData, sucursalId = null) {
    // Encuentra el select por su ID
    var select = document.getElementById('seleccionar-sucursal{{ $elementoId }}');

    // Limpia las opciones existentes
    select.innerHTML = '';

    // Itera sobre cada objeto en el JSON
    jsonData.forEach(function(item) {
        // Crea un nuevo elemento <option>
        var option = document.createElement('option');
        
        // Establece el valor y el texto del <option>
        option.value = item.id;
        option.textContent = item.name;

        if (sucursalId !== null && item.id === sucursalId) {
            option.selected = true;
        }

        // Agrega el <option> al <select>
        select.appendChild(option);
    });
}

</script>