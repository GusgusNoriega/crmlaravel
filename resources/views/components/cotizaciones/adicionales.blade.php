<label for="adicionales-input">adicionales</label>
<input type="hidden" name="adicionales" id="adicionales-input" required>
<div id="adicionales">
</div>
<button type="button" id="agregarAdicional">Agregar Adicional</button>
<label for="total-adicionales-monto">total adicionales monto</label>
<input type="number" id="total-adicionales-monto" readonly>
<script>
document.getElementById('agregarAdicional').addEventListener('click', function() {
        // Crear un nuevo div con la clase "adicional-individual"
        var nuevoDiv = document.createElement('div');
        nuevoDiv.className = 'adicional-individual';
        
        // Agregar contenido interno, incluyendo el botón de eliminar
        nuevoDiv.innerHTML = `<button class="eliminar-elemento-buscador" type="button"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
                              <div>
                                <label>Titulo</label>
                                <input class="nombre-adicional" type="text" value="adicional">
                              </div>
                              <div>
                                <label>Precio</label>
                                <input class="monto-adicional" type="number" value="10">
                              </div>
                              <div>
                                <label>Cantidad</label>
                                <input class="cantidad-adicional" type="number" value="1">
                              </div>
                              <div>
                                <label>Total</label>
                                <input class="total-adicional" type="number" value="0" disabled>
                              </div>`;
    
        // Agregar el nuevo div a "adicionales"
        document.getElementById('adicionales').appendChild(nuevoDiv);
    
        inicializarDivsAdicionalesExistentes();
});

function inicializarDivsAdicionalesExistentes() {
    var adicionalesExistentes = document.querySelectorAll('.adicional-individual');
    adicionalesExistentes.forEach(function(nuevoDiv) {
        // Suponiendo que cada div adicional ya tiene un botón de eliminar y los inputs necesarios
        var botonEliminar = nuevoDiv.querySelector('.eliminar-elemento-buscador');
        if (botonEliminar) {
            botonEliminar.addEventListener('click', function() {
                nuevoDiv.parentNode.removeChild(nuevoDiv);
                calcularTotalGeneral(); // Recalcular el total después de eliminar un elemento
                generarJsonAdicionales();
            });
        }

        var montoInput = nuevoDiv.querySelector('.monto-adicional');
        var cantidadInput = nuevoDiv.querySelector('.cantidad-adicional');

        // Agregar eventos para recalcular el total al modificar cantidad o monto
        montoInput.addEventListener('input', function() { calcularTotalIndividual(nuevoDiv); });
        cantidadInput.addEventListener('input', function() { calcularTotalIndividual(nuevoDiv); });

        // Inicialmente calcular el total para cada div adicional existente
        calcularTotalIndividual(nuevoDiv);
    });

    // Calcular el total general inicial
    calcularTotalGeneral();
    generarJsonAdicionales();
}

function calcularTotalIndividual(nuevoDiv) {
    var montoInput = nuevoDiv.querySelector('.monto-adicional');
    var cantidadInput = nuevoDiv.querySelector('.cantidad-adicional');
    var totalInput = nuevoDiv.querySelector('.total-adicional');
    var monto = parseFloat(montoInput.value) || 0;
    var cantidad = parseFloat(cantidadInput.value) || 0;
    var total = monto * cantidad;
    totalInput.value = total.toFixed(2); // Asumiendo que queremos dos decimales
    calcularTotalGeneral();
    generarJsonAdicionales();
}

function calcularTotalGeneral() {
    var todosLosTotales = document.querySelectorAll('.total-adicional');
    var sumaTotal = 0;
    todosLosTotales.forEach(function(input) {
        sumaTotal += parseFloat(input.value) || 0;
    });
    document.getElementById('total-adicionales-monto').value = sumaTotal.toFixed(2); // Asumiendo que queremos dos decimales
    actualizarTotalGeneral();
}

function generarJsonAdicionales() {
    var adicionales = document.querySelectorAll('.adicional-individual');
    var datosAdicionales = Array.from(adicionales).map(function(div) {
        return {
            titulo: div.querySelector('.nombre-adicional').value,
            precio: parseFloat(div.querySelector('.monto-adicional').value) || 0,
            cantidad: parseFloat(div.querySelector('.cantidad-adicional').value) || 0,
            total: parseFloat(div.querySelector('.total-adicional').value) || 0
        };
    });

    var jsonAdicionales = JSON.stringify(datosAdicionales);
    document.getElementById('adicionales-input').value = jsonAdicionales;
}

// Llamar a inicializarDivsAdicionalesExistentes() cuando la página carga
document.addEventListener('DOMContentLoaded', function() {
    inicializarDivsAdicionalesExistentes();
});
    </script>