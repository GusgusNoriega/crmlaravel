<div class="form-group">
    <input type="hidden" name="taxonomias-terminos-input" id="taxonomias-terminos-input">
</div>
<div class="container-buscar-taxonomias-terminos form-group">
    <h2>TAXONOMIAS</h2>
   <div class="container-buscar-taxonomias-terminos-buscador">
    <input type="text" name="buscar-taxonomia" placeholder="buscar-taxonomia">
     <select name="seleccionar-taxonomia" id="seleccionar-taxonomia">
        <option>Seleccionar taxonomia</option>
     </select>
     <button class="button" type="button" id="agregar-taxonomia">
        Agregar
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
    </button>
   </div>
   <div class="container-buscar-taxonomias-terminos-seleccionadas" id="container-todas-taxonomias">

  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
    // Asegurarse de que el DOM esté completamente cargado

        document.getElementById('agregar-taxonomia').addEventListener('click', function() {
            // Evento click para el botón

            var seleccion = document.getElementById('seleccionar-taxonomia');
            var opcionSeleccionada = seleccion.options[seleccion.selectedIndex];

            // Extraer los datos de la opción seleccionada
            var taxonomiaId = opcionSeleccionada.getAttribute('data-taxonomia-id');
            var taxonomiaName = opcionSeleccionada.getAttribute('data-taxonomia-name');

            if(!taxonomiaId) {
                alert("La taxonomía no es valida, busque una taxonomia, seleccionela y vuelva a presionar el boton");
                return;
            }

            if (document.querySelector(`.container-taxonomia-individual[data-taxonomia-id="${taxonomiaId}"]`)) {
                mostrarError("La taxonomía ya existe, seleccione otra taxonomia", '');
                return; // Detener la ejecución adicional
            }

            // Crear el HTML del nuevo div
            var nuevoDivHtml = `<div class="container-taxonomia-individual" data-taxonomia-id="${taxonomiaId}">
                                     <button class="abrir-terminos-de-taxonomias" type="button" data-taxonomia-id="${taxonomiaId}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icono-isquierdo" viewBox="0 0 384 512"><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"/></svg>
                                        ${taxonomiaName}
                                        <svg xmlns="http://www.w3.org/2000/svg" class="flecha-derecha" viewBox="0 0 256 512"><path d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z"/></svg>
                                        </button>
                                    <button class="eliminar-taxonomias" data-taxonomia-id="${taxonomiaId}" type="button">
                                        Eliminar
                                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                            <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path>
                                        </svg>
                                    </button>
                                    <div class="container-hidden-taxonomia" data-taxonomia-id="${taxonomiaId}">
                                        <div class="container-terminos-seleccionados" data-taxonomia-id="${taxonomiaId}">
                                            
                                        </div>
                                        <div class="container-buscar-terminos">
                                            <input class="buscar-terminos" type="text" name="buscar-terminos" placeholder="buscar-terminos" data-taxonomia-id="${taxonomiaId}">
                                            <select class="seleccionar-terminos" name="seleccionar-terminos" data-taxonomia-id="${taxonomiaId}">
                                                <option value="">Seleccionar terminos</option>
                                            </select>
                                            <button class="button buton-agregar-termino" type="button" data-taxonomia-id="${taxonomiaId}">
                                                Agregar
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5V80C0 53.5 21.5 32 48 32H197.5c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
                                            </button>
                                        </div>
                                    </div> 
                                </div>`;

            // Insertar el nuevo div en el contenedor usando innerHTML
            var contenedorTaxonomias = document.getElementById('container-todas-taxonomias');
            contenedorTaxonomias.innerHTML += nuevoDivHtml;
            obtenerIdsTaxonomias();
        });


        
        document.getElementById('container-todas-taxonomias').addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('buton-agregar-termino')) {
                
                var taxonomiaId = event.target.getAttribute('data-taxonomia-id');
                var selectores = document.querySelectorAll(`.container-buscar-terminos select[data-taxonomia-id='${taxonomiaId}']`);

                selectores.forEach(function(select) {
                    var opcionSeleccionada = select.options[select.selectedIndex];
                    var valorSeleccionado = opcionSeleccionada.value;
                    var textoSeleccionado = opcionSeleccionada.text;

                    if (document.querySelector(`.termino-individual[data-taxonomia-id="${taxonomiaId}"][data-termino-id="${valorSeleccionado}"]`)) {
                        mostrarError('El término ya existe, por favor selecciona otro', '');
                        return; // Detener la ejecución adicional
                    }

                    var nuevoDivHtml = `
                                        <div class="termino-individual" data-taxonomia-id="${taxonomiaId}" data-termino-id="${valorSeleccionado}">
                                            <p>${textoSeleccionado}</p>
                                            <button class="borrar-termino" type="button" data-termino-id="${valorSeleccionado}">
                                                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                                                    <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path>
                                                </svg>
                                            </button>
                                        </div>`;

                    var contenedorTerminos = document.querySelector(`.container-terminos-seleccionados[data-taxonomia-id='${taxonomiaId}']`);
                    if (contenedorTerminos) {
                        contenedorTerminos.innerHTML += nuevoDivHtml;
                        obtenerIdsTaxonomias();
                    }
                    
                });
            }
            if (event.target && event.target.classList.contains('borrar-termino')) {
                var terminoParaBorrar = event.target.closest('.termino-individual');
                if (terminoParaBorrar) {
                    terminoParaBorrar.remove(); // Elimina el término del DOM
                    obtenerIdsTaxonomias();
                }
            }
            if (event.target && event.target.classList.contains('eliminar-taxonomias')) {
                var terminoParaBorrar = event.target.closest('.container-taxonomia-individual');
                if (terminoParaBorrar) {
                    if (confirm("¿Deseas eliminar esta taxonomia? recuerda que se eliminaran los terminos que tambien pertenecen a esta taxonomia")) {
                        terminoParaBorrar.remove(); // Elimina el término del DOM
                        obtenerIdsTaxonomias();
                        mostrarConfirmacion('Se a eliminado la taxonomia del producto seleccionado');
                    } else {
                        console.log("El usuario hizo clic en Cancelar");
                    }
                    
                }
            }
            if (event.target && event.target.classList.contains('abrir-terminos-de-taxonomias')) {
                var botonSeleccionado = event.target;
                var taxonomiaId = event.target.getAttribute('data-taxonomia-id');
                var divParaAlternar = document.querySelector(`.container-hidden-taxonomia[data-taxonomia-id="${taxonomiaId}"]`);
                
                if (divParaAlternar) {
                    divParaAlternar.classList.toggle('active');
                    botonSeleccionado.classList.toggle('active');
                }
            }
            
        });

        document.getElementById('container-todas-taxonomias').addEventListener('input', function(event) {
            if (event.target && event.target.classList.contains('buscar-terminos')) {
                var textoIngresado = event.target.value;
                var elementoSiguiente = event.target.nextElementSibling;
                var taxonomiaId = event.target.getAttribute('data-taxonomia-id');
                /*console.log("Escribiendo en el input:", event.target.value, taxonomiaId);*/
                if (textoIngresado.length >= 3) {
                    buscarTerminos(taxonomiaId, textoIngresado, elementoSiguiente);
                } else {
                    buscarTerminos(taxonomiaId, '', elementoSiguiente); 
                }

                if (elementoSiguiente) {
                    elementoSiguiente.classList.add('active');
                }
            }
        });

        const inputTaxonomia = document.querySelector('input[name="buscar-taxonomia"]');

        inputTaxonomia.addEventListener('input', function() {
            const textoIngresado = this.value;

            if (textoIngresado.length >= 3) {
                buscarTaxonomias(textoIngresado);
            } else if (textoIngresado.length < 3) {
                buscarTaxonomias('');
            }
        });


  
obtenerIdsTaxonomias();

});

function buscarTaxonomias(nombreABuscar) {
            fetch(`/admin/taxonomias/buscar?name=${encodeURIComponent(nombreABuscar)}`)
                .then(response => response.json())
                .then(data => {
                    /*console.log(data);*/
                    selectObjeto = document.getElementById('seleccionar-taxonomia');
                    actualizarSelectTaxonomias(data, selectObjeto);
                })
                .catch(error => {
                    console.error('Error al realizar la solicitud:', error);
                });
}


function buscarTerminos(taxonomiaId, nombreABuscar, selectObjeto) {
            fetch(`/admin/terminos/buscar?taxonomia_id=${encodeURIComponent(taxonomiaId)}&name=${encodeURIComponent(nombreABuscar)}`)
                .then(response => response.json())
                .then(data => {
                    /*console.log(data);*/
                    actualizarSelectTermino(data, selectObjeto);
                })
                .catch(error => {
                    console.error('Error al realizar la solicitud:', error);
                });
}


function actualizarSelectTaxonomias(jsonData, selectObjeto) {
            
            // Limpiar opciones existentes, excepto la primera
            selectObjeto.length = 0;

            // Agregar nuevas opciones desde JSON
            jsonData.forEach(objeto => {
                let opcion = new Option(objeto.name, objeto.id); // texto, valor
                opcion.setAttribute('data-taxonomia-id', objeto.id);
                opcion.setAttribute('data-taxonomia-name', objeto.name);
                selectObjeto.add(opcion);
            });
}

function actualizarSelectTermino(jsonData, selectObjeto) {
            // Limpiar opciones existentes
            selectObjeto.length = 0;

            // Agregar nuevas opciones desde JSON
            jsonData.forEach(objeto => {
                let opcion = new Option(objeto.name, objeto.id);
                opcion.setAttribute('data-termino-id', objeto.id);
                opcion.setAttribute('data-taxonomia-name', objeto.name);
                selectObjeto.add(opcion);
            });
}

function obtenerIdsTaxonomias() {
            const container = document.getElementById('container-todas-taxonomias');
            const taxonomias = container.querySelectorAll('.container-taxonomia-individual');

            const arrayDeTaxonomias = Array.from(taxonomias).map(taxonomia => {
                // Obtener el ID de la taxonomía
                const taxonomiaId = taxonomia.getAttribute('data-taxonomia-id');

                // Buscar todos los términos asociados con esta taxonomía
                const terminos = taxonomia.querySelectorAll('.termino-individual');
                const terminosArray = Array.from(terminos).map(termino => {
                    return {
                        terminoId: termino.getAttribute('data-termino-id')
                    };
                });

                // Retornar el objeto de taxonomía con sus términos
                return {
                    taxonomiaId: taxonomiaId,
                    terminos: terminosArray
                };
            });

            const jsonDeTaxonomias = JSON.stringify(arrayDeTaxonomias);
            document.getElementById('taxonomias-terminos-input').value = jsonDeTaxonomias;
            console.log(jsonDeTaxonomias);
           
}



</script>

