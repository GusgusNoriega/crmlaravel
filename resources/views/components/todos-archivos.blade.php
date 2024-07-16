<div class="popup-archivos">
    <div class="barra-lateral-archivos">
        <ul id="menuArchivos">
            <li>
                <button class="accordion">        
                <svg class="svg-menu-1" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>image-picture</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-360.000000, -99.000000)" > <path d="M368,109 C366.896,109 366,108.104 366,107 C366,105.896 366.896,105 368,105 C369.104,105 370,105.896 370,107 C370,108.104 369.104,109 368,109 L368,109 Z M368,103 C365.791,103 364,104.791 364,107 C364,109.209 365.791,111 368,111 C370.209,111 372,109.209 372,107 C372,104.791 370.209,103 368,103 L368,103 Z M390,116.128 L384,110 L374.059,120.111 L370,116 L362,123.337 L362,103 C362,101.896 362.896,101 364,101 L388,101 C389.104,101 390,101.896 390,103 L390,116.128 L390,116.128 Z M390,127 C390,128.104 389.104,129 388,129 L382.832,129 L375.464,121.535 L384,112.999 L390,118.999 L390,127 L390,127 Z M364,129 C362.896,129 362,128.104 362,127 L362,126.061 L369.945,118.945 L380.001,129 L364,129 L364,129 Z M388,99 L364,99 C361.791,99 360,100.791 360,103 L360,127 C360,129.209 361.791,131 364,131 L388,131 C390.209,131 392,129.209 392,127 L392,103 C392,100.791 390.209,99 388,99 L388,99 Z" id="image-picture" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                    <span>Imagenes</span>
                <svg class="svg-menu-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"></path></svg>
                </button>
                <ul class="submenu">
                    <div class="tab">
                        <button class="tablinks" onclick="openTab(event, 'Upload')">Subir Imágenes</button>
                        <button class="tablinks active" onclick="openTab(event, 'Select')">Seleccionar Imágenes</button>
                    </div>
                </ul>
            </li>
        </ul>

        <div id="form-editar-imagen">
            <form class="form-edit-images" id="update-image-form">
            </form>
        </div>
    </div>
    <div id="contenido-archivos" class="contenido-archivos">
        <div>
            <div id="Upload" class="tabcontent">
                <h3 class="titulo-tab-oscuro">Subir Imágenes</h3>
                <x-uploadimages />
            </div>
            
            <div id="Select" class="tabcontent">     
                    <x-select-images />
            </div>
        </div>
    </div>
     <button class="cerrar-archivos"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
</div>
<div id="fondo-edit-images"></div>
<script>
   document.addEventListener('DOMContentLoaded', (event) => {
    const botonesAbrir = document.querySelectorAll('.seleccionar-archivos');
    const botonCerrar = document.querySelector('.cerrar-archivos');
    const popup = document.querySelector('.popup-archivos');
    const fondoEditImages = document.querySelector('#fondo-edit-images');

    botonesAbrir.forEach(boton => {
        boton.addEventListener('click', () => {
            popup.classList.add('active');
            fondoEditImages.classList.add('active');
            openTab({}, 'Select');
        });
    });

    botonCerrar.addEventListener('click', () => {
        popup.classList.remove('active');
        fondoEditImages.classList.remove('active');
    });
    
});

function formatearFechaHora(fechaHoraISO) {
  const fecha = new Date(fechaHoraISO);
  const opciones = { 
      year: 'numeric', 
      month: 'long', 
      day: 'numeric', 
      hour: '2-digit', 
      minute: '2-digit', 
      second: '2-digit', 
      timeZoneName: 'short' 
  };
  return new Intl.DateTimeFormat('es-ES', opciones).format(fecha);
}

console.log(formatearFechaHora("2023-12-14T13:49:40.000000Z"));

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "flex";

    // Verificar si evt es un evento real
    if (evt instanceof Event) {
        evt.currentTarget.className += " active";
    } else {
        // Si no es un evento, encontrar y activar el botón correspondiente
        var targetTabLink = Array.from(tablinks).find(el => el.getAttribute('onclick').includes("'" + tabName + "'"));
        if (targetTabLink) {
            targetTabLink.className += " active";
        }
    }
}

// Agregar un escuchador de eventos al documento
const container_imagenes = document.getElementById('contenido-archivos');
const container_imagen_delete = document.getElementById('form-editar-imagen');

container_imagenes.addEventListener('click', function(event) {
    // Buscar el elemento ascendente más cercano con la clase 'editar-imagen-seleccionada'
    const button = event.target.closest('.editar-imagen-seleccionada');
  
    if (button) {
        // Obtener el valor del atributo 'data-image-id' del botón encontrado
        const imageId = button.getAttribute('data-image-id');

        // Llamar a la función 'mostrarImagenPorId' con el ID obtenido
        mostrarImagenPorId(imageId);
    }
     
});

container_imagen_delete.addEventListener('click', function(event) { 
    const button2 = event.target.closest('.button-delete-image');
    if (button2) {
        // Obtener el valor del atributo 'data-image-id' del botón encontrado
        const imageId2 = button2.getAttribute('data-deleteid');
        // Mostrar un cuadro de diálogo de confirmación
        if (confirm('¿Estás seguro de que deseas eliminar esta imagen?')) {
            // Si el usuario confirma, llama a la función 'deleteImage'
            deleteImage(imageId2);
        } else {
            // Si el usuario cancela, no hagas nada
            console.log('Eliminación cancelada');
        }
    }
});


document.getElementById('update-image-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // Obtener los valores del formulario
        const imageId = document.getElementById('image-id').value;
        const imageName = document.getElementById('image-name').value;

        // Configurar la petición AJAX
        fetch('/admin/imagen/update/' + imageId, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken // Asegúrate de incluir el token CSRF
            },
            body: JSON.stringify({ name: imageName })
        })
        .then(response => response.json())
        .then(data => {
            mostrarConfirmacion(data.message); // Manejar la respuesta
        })
        .catch(error => console.error('Error:', error));
    });

    
function deleteImage(imageId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/admin/imagen/destroy/' + imageId, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
    })
    .then(response => {
        if (!response.ok) {
            // Si la respuesta no es exitosa, lanza un error con el estado
            throw new Error('Error en la solicitud: ' + response.statusText);
        }
        return response.json();
    })
    .then(result => {
        mostrarConfirmacion(result.message);
        eliminarDivPorId(imageId);
    })
    .catch(error => {
        // Mostrar más detalles sobre el error
        alert('Error: ' + error.message);
    });
}

function limpiarFormularioImagen() {
    // Seleccionar el formulario por su ID
    const formulario = document.getElementById('update-image-form');

    // Verificar si el formulario existe
    if (formulario) {
        // Establecer el contenido interno del formulario en una cadena vacía
        formulario.innerHTML = '';
    }
}

function eliminarDivPorId(imagenId) {
    // Seleccionar el contenedor padre
    const container = document.getElementById('image-container');
    const container2 = document.getElementById('imagenes-seleccionadas');

    // Buscar el div con el 'data-imagenid' correspondiente
    const divParaEliminar = container.querySelector(`div[data-imagenid='${imagenId}']`);
    const divParaEliminar2 = container2.querySelector(`div[data-idimage='${imagenId}']`);

    // Si el div existe, eliminarlo
    if (divParaEliminar) {
        container.removeChild(divParaEliminar);
    }
    if (divParaEliminar2) {
        container2.removeChild(divParaEliminar2);
    }
    limpiarFormularioImagen();
}


</script>