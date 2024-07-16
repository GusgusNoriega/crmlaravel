<div class="container-buscador-elementos" id="elementos-container-buscador{{ $idPrincipal }}" data-id-principal="{{ $idPrincipal }}">
    <label for="buscar-elementos{{ $idPrincipal }}">BUSCAR {{ $nombre }}</label>
    <div class="elementos-seleccionados" data-seleccion-id="buscar-elementos{{ $idPrincipal }}" id="div-buscar-elementos{{ $idPrincipal }}"></div>
    <input id="resultados-seleccionados{{ $idPrincipal }}" data-cantidad="{{ $cantidad }}" name="{{ $idPrincipal }}" type="hidden">
    <input id="buscar-elementos{{ $idPrincipal }}" name="buscar-elementos{{ $idPrincipal }}" type="text">
    <div class="elementos-container" id="elementos-container{{ $idPrincipal }}" data-id="buscar-elementos{{ $idPrincipal }}"></div>
</div>

<script>
var elementosContainer{{ $idPrincipal }} = document.querySelector('#elementos-container-buscador{{ $idPrincipal }} #elementos-container{{ $idPrincipal }}');

 
function handleClick{{ $idPrincipal }}(event) {
    /* Seleccionar elementos relevantes y obtener el límite de la cantidad */
    var iputElementoSeleccionado{{ $idPrincipal }} = document.querySelector('#resultados-seleccionados{{ $idPrincipal }}');
    var seleccionContainer{{ $idPrincipal }} = document.querySelector('#elementos-container-buscador{{ $idPrincipal }} [data-seleccion-id="buscar-elementos{{ $idPrincipal }}"]');  // Asegúrate de tener este selector correcto
    var limiteCantidad{{ $idPrincipal }} = parseInt(iputElementoSeleccionado{{ $idPrincipal }}.getAttribute('data-cantidad'));

    /* Obtener el elemento clicado */
    var clickedElement{{ $idPrincipal }} = event.target.closest('[data-elemento-id]');
    if (clickedElement{{ $idPrincipal }} && clickedElement{{ $idPrincipal }}.dataset.elementoId) {
        // Obtener el ID del elemento clicado y los IDs existentes
        var elementoId = clickedElement{{ $idPrincipal }}.dataset.elementoId;
        var idsExistentes = iputElementoSeleccionado{{ $idPrincipal }}.value ? iputElementoSeleccionado{{ $idPrincipal }}.value.split(',') : [];

        // Verificar si ya se alcanzó el límite
        if (idsExistentes.length < limiteCantidad{{ $idPrincipal }}) {
            // Agregar el nuevo ID si no está presente
            if (!idsExistentes.includes(elementoId)) {
                idsExistentes.push(elementoId);
                iputElementoSeleccionado{{ $idPrincipal }}.value = idsExistentes.join(',');

                // Clonar y agregar el elemento clicado al contenedor
                var clonedElement = clickedElement{{ $idPrincipal }}.cloneNode(true);
                seleccionContainer{{ $idPrincipal }}.appendChild(clonedElement);  // Agregar el elemento clonado
            }
        } else {
            mostrarError('Se ha alcanzado el límite de elementos seleccionados, por favor elimina elementos dentro del campo para poder agregar otro.', '');
        }
   
       
    }
}

// Agregar el listener para el evento de clic en el contenedor principal
elementosContainer{{ $idPrincipal }}.addEventListener('click', handleClick{{ $idPrincipal }});

// Obtener los elementos del DOM por sus IDs

var elementosContainerBuscador{{ $idPrincipal }} = document.querySelector('#elementos-container-buscador{{ $idPrincipal }}');

// Verificar si ambos elementos existen
if (elementosContainer{{ $idPrincipal }} && elementosContainerBuscador{{ $idPrincipal }}) {
    // Evento cuando el mouse entra sobre el elemento
    elementosContainerBuscador{{ $idPrincipal }}.addEventListener('mouseover', function() {
        elementosContainer{{ $idPrincipal }}.classList.add('active');
    });

    // Evento cuando el mouse sale del elemento
     elementosContainerBuscador{{ $idPrincipal }}.addEventListener('mouseout', function() {
         elementosContainer{{ $idPrincipal }}.classList.remove('active');
     });
}


// Función para verificar si el contenido es un número o un texto
function verificarContenido{{ $idPrincipal }}(contenido) {
    if (contenido.length >= 2 ) {
        // Verificar si el contenido es un número
        if (!isNaN(contenido) && !isNaN(parseFloat(contenido))) {
            //console.log("Es un número");
            buscarElementos{{ $idPrincipal }}(contenido, 'name', '{{ route('buscarClientes') }}');
        } else {
            buscarElementos{{ $idPrincipal }}(contenido, 'name', '{{ route('buscarClientes') }}');
        }
    }
}

// Seleccionar el campo de entrada
var inputBuscarEmpresas{{ $idPrincipal }} = document.querySelector('#elementos-container-buscador{{ $idPrincipal }} #buscar-elementos{{ $idPrincipal }}');
// Escuchar el evento 'input' en el campo
inputBuscarEmpresas{{ $idPrincipal }}.addEventListener('input', function() {
    // Obtener el contenido del campo de entrada
    var contenido = inputBuscarEmpresas{{ $idPrincipal }}.value;
    // Llamar a la función para verificar el contenido
    verificarContenido{{ $idPrincipal }}(contenido);
});



// Agregar un listener de eventos para los clics
var divBuscarEmpresas{{ $idPrincipal }} = document.querySelector('#elementos-container-buscador{{ $idPrincipal }} #div-buscar-elementos{{ $idPrincipal }}');

divBuscarEmpresas{{ $idPrincipal }}.addEventListener('click', function(event) {

   if (event.target.classList.contains('eliminar-elemento-buscador')) {
    let idEliminar = event.target.getAttribute('data-id-eliminar');
        // Encontrar el div padre del botón y eliminarlo
    if (idEliminar) {
            // Encontrar el input y obtener sus valores actuales
        let inputResultados = document.querySelector('#elementos-container-buscador{{ $idPrincipal }} #resultados-seleccionados{{ $idPrincipal }}');
        if (inputResultados) {
            // Convertir los valores del input a un array, eliminar el id y volver a unirlos
            let ids = inputResultados.value.split(',').filter(id => id.trim() !== idEliminar);
            inputResultados.value = ids.join(',');
        }
     }

        let divPadre = event.target.closest('div');
        if (divPadre) {
            divPadre.remove(); 
        }
    }

});
/*eliminar div seleccionado y id de input seleccionado*/

function buscarElementos{{ $idPrincipal }}(searchTerm, field, rutaBuscar) {
    // Crear un nuevo objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    
    // Configurar el método y la URL de la solicitud
    xhr.open('GET', rutaBuscar + '?searchTerm=' + encodeURIComponent(searchTerm) + '&field=' + encodeURIComponent(field), true);

    // Establecer el tipo de contenido esperado
    xhr.setRequestHeader('Content-Type', 'application/json');

    // Definir qué hacer cuando la solicitud se haya completado
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Parsear la respuesta JSON
            var elementos = JSON.parse(xhr.responseText);
            var elementosContainer{{ $idPrincipal }} = document.querySelector('#elementos-container-buscador{{ $idPrincipal }} #elementos-container{{ $idPrincipal }}');
            elementosContainer{{ $idPrincipal }}.innerHTML = '';
            // Hacer algo con los clientes (mostrarlos en la UI, por ejemplo)
           // console.log(elementos);
            elementos.forEach(function(elemento) {
                // Crear un elemento para cada empresa
                var elementoElement = document.createElement('div');
                elementoElement.setAttribute('data-elemento-id', elemento.id);
                const rutaImagen = elemento.imagen_destacada ? '<div class="imagen-destacada-buscador"><img src="http://sistema3.test/storage/' + elemento.imagen_destacada.ruta + '" alt="Gustavos Avatar"></div>' : '<div class="imagen-destacada-buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg></div>';

                elementoElement.innerHTML = `
                <button class="eliminar-elemento-buscador" data-id-eliminar="${elemento.id}"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
                   ${rutaImagen}
                    <div class="contenido-opciones-buscador">
                        <h3>${elemento.name}</h3>
                    </div>
                    <!-- Añadir más detalles según sea necesario -->
                `;
                // Añadir el elemento al contenedor
                elementosContainer{{ $idPrincipal }}.appendChild(elementoElement);
            });
            
        } else {
            // Manejar errores (p.ej., mostrar un mensaje de error)
            //console.error('Error en la solicitud', xhr.status, xhr.statusText);
        }
    };

    // Enviar la solicitud
    xhr.send();
}


</script>