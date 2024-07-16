<!-- En la vista del componente (components.select-images) -->

<div class="contain-sup-image">
    <h3 class="titulo-tab-oscuro">Seleccionar Imágenes</h3>
    <div class="search-image-contain">
        <div class="contain-input-search">
            <p class="text-input-search">Buscar por nombre</p>
            <input type="text" id="image-search" placeholder="Buscar por nombre...">
        </div>
        <div class="contain-input-search">
            <p class="text-input-search">fecha de subida (despues de)</p>
            <input type="date" id="fecha-imagen-desde" placeholder="Desde">
        </div>
        <div class="contain-input-search">
             <p class="text-input-search">fecha de subida (antes de)</p>
             <input type="date" id="fecha-imagen-hasta" placeholder="Hasta">
        </div>
        <button id="search-button-image">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
        </button>
    </div>
    <button id="reset-button-image">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M463.5 224H472c13.3 0 24-10.7 24-24V72c0-9.7-5.8-18.5-14.8-22.2s-19.3-1.7-26.2 5.2L413.4 96.6c-87.6-86.5-228.7-86.2-315.8 1c-87.5 87.5-87.5 229.3 0 316.8s229.3 87.5 316.8 0c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0c-62.5 62.5-163.8 62.5-226.3 0s-62.5-163.8 0-226.3c62.2-62.2 162.7-62.5 225.3-1L327 183c-6.9 6.9-8.9 17.2-5.2 26.2s12.5 14.8 22.2 14.8H463.5z"/></svg>
         Reset
    </button>
</div>
<div id="image-container">
    @foreach($images as $image)
      <div class="imagen-para-seleccion" data-imagenid="{{ $image->id }}">
        <div>
            <input type="checkbox" class="check-image" id="image{{ $image->id }}" data-idimage="{{ $image->id }}" name="image{{ $image->id }}">
            <label for="image{{ $image->id }}">
              <img src="http://sistema3.test/storage/{{ $image->ruta }}" alt="{{ $image->alt }}">
            </label>
            <button class="button editar-imagen-seleccionada" data-image-id="{{ $image->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path></svg>
            </button>
        </div>
      </div>
    @endforeach
</div>
<div class="seccion-inferior-images">
    <button id="load-more-image"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>Cargar más</button>
    <div class="container-imagenes-seleccionadas">
        <div class="container-ant-seleccion">
            <h3>Imagenes seleccionadas</h3>
        </div>
        <div id="imagenes-seleccionadas" data-limite="10">
            
        </div>
    </div>
    <div class="div-container-boton-imagenes-select">
       <button id="productos-seleccionados-select" class="button" data-button-id="">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M160 32c-35.3 0-64 28.7-64 64V320c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H160zM396 138.7l96 144c4.9 7.4 5.4 16.8 1.2 24.6S480.9 320 472 320H328 280 200c-9.2 0-17.6-5.3-21.6-13.6s-2.9-18.2 2.9-25.4l64-80c4.6-5.7 11.4-9 18.7-9s14.2 3.3 18.7 9l17.3 21.6 56-84C360.5 132 368 128 376 128s15.5 4 20 10.7zM192 128a32 32 0 1 1 64 0 32 32 0 1 1 -64 0zM48 120c0-13.3-10.7-24-24-24S0 106.7 0 120V344c0 75.1 60.9 136 136 136H456c13.3 0 24-10.7 24-24s-10.7-24-24-24H136c-48.6 0-88-39.4-88-88V120z"/></svg>
            Actualizar imagenes
        </button>
    </div>
   
</div>


<script>
    
let currentPage = 1;   
document.getElementById('search-button-image').addEventListener('click', function() {
    resetAndLoadImages();
});

function loadImages() {
    const searchValue = document.getElementById('image-search').value;
    const fechaDesde = document.getElementById('fecha-imagen-desde').value;
    const fechaHasta = document.getElementById('fecha-imagen-hasta').value;
    document.getElementById('load-more-image').style.display = 'flex';
    fetch(`/load-more-images?page=${currentPage}&search=${searchValue}&desde=${fechaDesde}&hasta=${fechaHasta}`, {
        headers: {
            'Cache-Control': 'no-cache'
        }
    })
    .then(response => response.json())
    .then(data => {
        data.images.data.forEach(image => {
            // Crea un nuevo div externo para cada imagen
            const outerDivElement = document.createElement('div');
            outerDivElement.classList.add('imagen-para-seleccion');
            outerDivElement.setAttribute('data-imagenid', image.id);

           
            // Crea un div interno
            const innerDivElement = document.createElement('div');

            // Crea el input checkbox
            const checkbox = document.createElement('input');
            checkbox.setAttribute('type', 'checkbox');
            checkbox.classList.add('check-image');
            checkbox.id = 'image' + image.id;
            checkbox.setAttribute('data-idimage', image.id);
            checkbox.name = 'image' + image.id;

            // Crea la etiqueta label
            const label = document.createElement('label');
            label.setAttribute('for', 'image' + image.id);

            // Crea el elemento img
            const imgElement = document.createElement('img');
            imgElement.src = `http://sistema3.test/storage/${image.ruta}`;
            imgElement.alt = image.alt;

            // Añade la imagen y el checkbox al label
            label.appendChild(imgElement);

            // Añade el label y el checkbox al div interno
            innerDivElement.appendChild(checkbox);
            innerDivElement.appendChild(label);

             // Crea el boton de editar y lo añade al div interno
             const editButton = document.createElement('button');
            editButton.classList.add('editar-imagen-seleccionada');
            editButton.setAttribute('data-image-id', image.id);
            editButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path></svg>`;
            innerDivElement.appendChild(editButton);

            // Añade el div interno al div externo
            outerDivElement.appendChild(innerDivElement);

            // Añade el div interno al div externo
            outerDivElement.appendChild(innerDivElement);

            // Añade el div externo al contenedor de imágenes
            document.getElementById('image-container').appendChild(outerDivElement);
        });

        if (currentPage >= data.images.last_page) {
            document.getElementById('load-more-image').style.display = 'none';
            actualizarCheck();
        } else {
            document.getElementById('load-more-image').style.display = 'flex';
            actualizarCheck();
        }
    });
}



document.getElementById('load-more-image').addEventListener('click', function() {
    currentPage++;
    loadImages();
});

function resetSearchImage() {
    document.getElementById('image-search').value = ''; // Limpia el campo de búsqueda
    document.getElementById('fecha-imagen-desde').value = ''; // Limpia el campo de búsqueda
    document.getElementById('fecha-imagen-hasta').value = ''; // Limpia el campo de búsqueda
    resetAndLoadImages();
}

document.getElementById('reset-button-image').addEventListener('click', resetSearchImage);

// Seleccionar todos los checkboxes
const imageContainer = document.getElementById('image-container');

imageContainer.addEventListener('change', function(event) {
    // Verificar si el cambio se realizó en un checkbox
    if (event.target.classList.contains('check-image')) {
        if (event.target.checked) {
            // Verificar si se ha alcanzado el límite
            if (!isLimitReached()) {
                // Agregar la imagen al contenedor de imágenes seleccionadas
                addImageToSelected(event.target.dataset.idimage, event.target.nextElementSibling.innerHTML);
            } else {
                // Si se ha alcanzado el límite, deseleccionar el checkbox
                alert('Se ha alcanzado el límite de selección');
                event.target.checked = false;
            }
        } else {
            // Eliminar la imagen del contenedor de imágenes seleccionadas
            removeImageFromSelected(event.target.dataset.idimage);
        }
    }
});


function isLimitReached() {
    const container = document.getElementById('imagenes-seleccionadas');
    const limite = container.getAttribute('data-limite');
    const selectedCount = container.querySelectorAll('div[data-idimage]').length;
    return selectedCount >= limite;
}



function addDeleteAndEditButtons(div, id) {
    // Verifica si ya existe un botón de eliminar
    if (!div.querySelector('button.delete-button')) {
        const deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-button');
        deleteButton.innerHTML = '<svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>'; // SVG del botón eliminar
        deleteButton.onclick = function() {
            removeImageAndUncheck(id);
        };
        div.appendChild(deleteButton);
    }

    // Agregar botón de editar si no existe
    if (!div.querySelector('button.editar-imagen-seleccionada')) {
        const editButton = document.createElement('button');
        editButton.classList.add('editar-imagen-seleccionada');
        editButton.setAttribute('data-image-id', id);
        editButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2023 Fonticons, Inc.--><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>'; // O puedes usar SVG/Icono para el botón
        // Aquí puedes agregar un evento onclick si es necesario
        div.appendChild(editButton);
    }
}

function removeImageAndUncheck(id) {
    // Eliminar la imagen del contenedor de imágenes seleccionadas
    removeImageFromSelected(id);

    // Desmarcar el checkbox correspondiente
    const correspondingCheckbox = document.querySelector(`.check-image[data-idimage="${id}"]`);
    if (correspondingCheckbox) {
        correspondingCheckbox.checked = false;
    }
}

function removeImageFromSelected(id) {
    const container = document.getElementById('imagenes-seleccionadas');
    const imageToRemove = container.querySelector(`div[data-idimage="${id}"]`);
    if (imageToRemove) {
        container.removeChild(imageToRemove);
    }
}

function actualizarCheck() { 
    const selectedImagesContainer = document.getElementById('imagenes-seleccionadas');
    const selectedImages = selectedImagesContainer.querySelectorAll('div[data-idimage]');

    selectedImages.forEach(function(imageDiv) {
        const imageId = imageDiv.getAttribute('data-idimage');
        const correspondingCheckbox = document.querySelector(`.check-image[data-idimage="${imageId}"]`);
        if (correspondingCheckbox) {
            correspondingCheckbox.checked = true;
        }

        addDeleteAndEditButtons(imageDiv, imageId); // Añade el botón de eliminar a las imágenes ya presentes
    });
}
actualizarCheck();

function obtenerImagenesPorId(ids) {
    // Convertir 'ids' en una cadena si es un array
    const idsParam = Array.isArray(ids) ? ids.join(',') : ids;

    // Crear la URL para la solicitud
    const url = '/imagen/' + idsParam; // Ajusta la URL según tu configuración de rutas

    return fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('La solicitud falló con el estado ' + response.status);
            }
            return response.json(); // Convierte la respuesta en JSON
        })
        .then(jsonResponse => {
            console.log(jsonResponse);
            return jsonResponse; // Retorna la respuesta JSON para su posterior uso
        })
        .catch(error => {
            console.error('Error en la solicitud:', error);
            throw error; // Propagar el error para que pueda ser manejado por el llamador
        });
}

function mostrarImagenPorId(id) {
    obtenerImagenesPorId(id)
        .then(jsonResponse => {
            if (jsonResponse.success) {
                const data = jsonResponse.data;
                const fechaCreacion = formatearFechaHora(data.created_at);
                const fechaActualizacion = formatearFechaHora(data.updated_at);

                const htmlContent = `
                        <button type="button" class="button-delete button-delete-image" data-deleteid="${data.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
                        </button>
                        <input type="hidden" id="image-id" value="${data.id}">
                        <div class="container-imagen-edit-imagen">
                         <img src="http://sistema3.test/storage/${data.ruta}" alt="${data.alt}">
                        </div>
                        <input type="text" id="image-name" value="${data.name}">
                        <p>Tipo: ${data.tipo || 'No especificado'}</p>
                        <p>Ruta Anterior: ${data.ruta_anterior}</p>
                        <p>Creado: ${fechaCreacion} </p>
                        <p>Actualizado: ${fechaActualizacion}</p>
                        <input class="button" type="submit" value="Actualizar">
                `;

                // Insertar el HTML en el div con el id 'form-editar-imagen'
                document.getElementById('update-image-form').innerHTML = htmlContent;
            } else {
                console.error('No se encontraron datos');
            }
        })
        .catch(error => {
            console.error('Error al obtener la imagen:', error);
        });
}


document.querySelectorAll('.seleccion-produc-individual').forEach(button => {
    button.addEventListener('click', function() {
        limpiarImagenesSeleccionadas();
        const productId = this.getAttribute('data-product-id');
        const limit = parseInt(this.getAttribute('data-limit'), 10);

        const inputField = this.previousElementSibling;
        if (inputField && inputField.tagName === 'INPUT') {
            inputField.value = productId;
        }

        // Cambiar el atributo data-limite del div con ID "imagenes-seleccionadas"
        const imagenesSeleccionadasDiv = document.getElementById('imagenes-seleccionadas');
        if (imagenesSeleccionadasDiv) {
            imagenesSeleccionadasDiv.setAttribute('data-limite', limit);
        }

        const botonActualizarImagenes = document.getElementById('productos-seleccionados-select');
        if (botonActualizarImagenes) {
            botonActualizarImagenes.setAttribute('data-button-id', this.id);
        }

        if (productId) {
            seleccionarProducto(productId, limit);
        }
        
        
    });
});

function seleccionarProducto(productIds, limit) {
    let ids = productIds.split(',').slice(0, limit);

    obtenerImagenesPorId(ids)
        .then(response => {
            if (response.success) {
                // Asegurarse de que los datos sean siempre un array
                const images = Array.isArray(response.data) ? response.data : [response.data];

                images.forEach(image => {
                    const imageHtml = `<img src="http://sistema3.test/storage/${image.ruta}" alt="${image.alt}">`;
                    addImageToSelected(image.id, imageHtml);
                });

                actualizarCheck();
            }
        })
        .catch(error => console.error('Error:', error));
}

function addImageToSelected(id, imageHtml) {
    const container = document.getElementById('imagenes-seleccionadas');
    
    let outerDiv = container.querySelector(`div[data-idimage="${id}"]`);
    if (!outerDiv) {
        outerDiv = document.createElement('div');
        outerDiv.setAttribute('data-idimage', id);

        const innerDiv = document.createElement('div');
        innerDiv.innerHTML = imageHtml;
        
        addDeleteAndEditButtons(outerDiv, id); // Agrega el botón de eliminar si no existe

        outerDiv.appendChild(innerDiv);
        container.appendChild(outerDiv);
    }
}

function limpiarImagenesSeleccionadas() {
    const contenedor = document.getElementById('imagenes-seleccionadas');
    if (contenedor) {
        contenedor.innerHTML = '';
    }
    actualizarCheckboxImagenes();
}

function actualizarCheckboxImagenes() {
    // Obtener todos los IDs de las imágenes seleccionadas
    const imagenesSeleccionadas = document.querySelectorAll('#imagenes-seleccionadas div[data-idimage]');
    const idsSeleccionados = Array.from(imagenesSeleccionadas).map(div => div.getAttribute('data-idimage'));

    // Obtener todos los checkboxes en el contenedor de imágenes
    const checkboxes = document.querySelectorAll('#image-container .check-image');

    // Actualizar el estado de los checkboxes
    checkboxes.forEach(checkbox => {
        if (idsSeleccionados.includes(checkbox.getAttribute('data-idimage'))) {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }
    });
}

function resetAndLoadImages() {
    currentPage = 1; // Reiniciar la paginación
    document.getElementById('image-container').innerHTML = ''; // Limpiar imágenes actuales
    loadImages(); // Cargar nuevas imágenes
}

document.getElementById('productos-seleccionados-select').addEventListener('click', function() {
    const targetButtonId = this.getAttribute('data-button-id');
    const targetButton = document.getElementById(targetButtonId);
    const popup = document.querySelector('.popup-archivos');
    const fondoEditImages = document.querySelector('#fondo-edit-images');

    if (targetButton) {
        const selectedImages = document.querySelectorAll('#imagenes-seleccionadas div[data-idimage]');
        const selectedIds = Array.from(selectedImages).map(div => div.getAttribute('data-idimage')).join(',');

        targetButton.setAttribute('data-product-id', selectedIds);

        const inputFieldAbove = targetButton.previousElementSibling;
        if (inputFieldAbove && inputFieldAbove.tagName === 'INPUT') {
            inputFieldAbove.value = selectedIds;
        }

        // Identificar el div justo después del botón
        const divAfterButton = targetButton.nextElementSibling;

        // Asegurarse de que es un div y limpiar su contenido actual
        if (divAfterButton && divAfterButton.tagName === 'DIV') {
            divAfterButton.innerHTML = '';

            // Clonar y añadir cada imagen seleccionada al div
            selectedImages.forEach(div => {
                const clone = div.cloneNode(true);
                divAfterButton.appendChild(clone);
            });
        }
    }
    popup.classList.remove('active');
    fondoEditImages.classList.remove('active');
});


</script>

