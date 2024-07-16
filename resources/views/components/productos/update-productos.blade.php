
<div class="fondo-div-update-elemento" id="fondo-div-update-elemento"></div>
<div class="form-update-div" id="form-update-elemento-div">
        <button id="cerrar-div-update-elemento" class="cerrar-div-update-elemento">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Actualizar producto</h3>
        <form id="update-elemento" method="POST" data-update-elemento-id="">
            @csrf
            <input id="id-elemento-update" type="hidden" name="id_elemento">
            <!-- Campos del formulario -->

            <div class="form-group">
                <label for="name">Titulo</label>
                <input type="text" name="name" id="name-elemento-update" required>
            </div>

            <div class="form-group contain-image-agre form-group-50">
                <input type="hidden" name="image_id" id="update-imagen-elemento" value="">
                <button id="imagen-cambiar-5" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Seleccionar imagen destacada</button>
                <div class="imagen-individual-form" id="div-imagen-destacada-update"></div>
            </div>

            <div class="form-group contain-image-agre form-group-50">
                <input type="hidden" name="imagenes_id" id="update-imagenes-galeria" value="">
                <button id="imagen-cambiar-4" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="20">Selecionar imagenes de la galeria</button>
                <div class="imagen-individual-form" id="div-imagenes-galeria-update"></div>
            </div>

            <div class="form-group">
                <label for="description" >DESCRIPCION</label>
                <textarea id="descripcion" name="description" rows="10">
                </textarea>
            </div>

            <x-buscadores.buscar-taxonomias-terminos/>

            <div class="form-group">
                <label for="datos_tecnicos" >DATOS TECNICOS</label>
                <textarea id="datos_tecnicos" name="datos_tecnicos" rows="5">
                </textarea>
            </div>

            <div class="form-group">
                <label for="cont_envio" >CONTENIDO DE ENVIO</label>
                <textarea id="cont_envio" name="cont_envio" rows="5">
                </textarea>
            </div>

            <div class="form-group form-group-33">
                <x-productos.buscador-marca idPrincipal="marca1" nombre="MARCA" cantidad="10"/>
            </div>

            <div class="form-group form-group-33">
                <x-productos.buscador-procedencia idPrincipal="procedencia1" nombre="PROCEDENCIA" cantidad="5"/>
            </div>

            <div class="form-group form-group-33">
                <x-productos.buscador-categoria idPrincipal="categoria1" nombre="CATEGORIA" cantidad="20"/>
            </div>

            <div class="form-group form-group-33">
                <label for="modelo">MODELO</label>
                <input type="text" name="modelo" id="modelo" required="">
            </div>

            <div class="form-group form-group-33">
                <x-productos.select-moneda selectId="idmoneda" />
            </div>

            <div class="form-group form-group-33">
                <label for="name">PRECIO</label>
                <input type="number" name="precio" id="precio" step="0.01" required="">
            </div>

            <div class="form-group">
                <button class="button" type="submit">Actualizar producto</button>
            </div>
        </form>
</div>
<script>
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var divFondoDivUpdateUsuario = document.getElementById('fondo-div-update-elemento');
    var divContentUpdateUsuario = document.getElementById('form-update-elemento-div');
    var botonCerrarUpdateUsuario = document.getElementById('cerrar-div-update-elemento');
        

    botonCerrarUpdateUsuario.addEventListener('click', function() {
        divContentUpdateUsuario.classList.remove('active');
        divFondoDivUpdateUsuario.classList.remove('active');
    });
    
    document.getElementById('resultadosElementos').addEventListener('click', function(event) {
        // Verifica si el clic provino de un botón con la clase 'button-update-elemento'
        if (event.target.classList.contains('button-update-elemento')) {
            // Obtiene el valor del atributo 'data-update-elemento'
            const updateElementosId = event.target.getAttribute('data-update-elemento');
            divFondoDivUpdateUsuario.classList.add('active');
            divContentUpdateUsuario.classList.add('active');

            //resetear campos de imagen y relaciones
            document.querySelector('#update-imagen-elemento').value = '';
            document.querySelector('#div-imagen-destacada-update').innerHTML = '';
            document.getElementById('imagen-cambiar-5').setAttribute('data-product-id', '');
            
            // Llama a la función con el valor obtenido
            obtenerEmpresaPorId(updateElementosId);
            console.log(updateElementosId);
           
        }
        if (event.target.classList.contains('button-delete-elemento')) {
            const updateElementosId = event.target.getAttribute('data-delete-elemento');
            if (confirm('¿Estás seguro de que quieres eliminar este elemento? Esta acción no se puede deshacer.')) {
                    eliminarProducto(updateElementosId);
            } else {
                    console.log('Eliminación cancelada');
            }             
        }
    });

    function llenarFormularioConDatos(datos) {
        // Asegúrate de que tienes los datos que esperas
        if (!datos) {
            console.error('No hay datos para llenar el formulario.');
            return;
        }
       
        // Llenar los campos del formulario
        document.querySelector('#id-elemento-update').value = datos.id || '';
        document.querySelector('#name-elemento-update').value = datos.title || '';
        document.querySelector('#descripcion').value = datos.description || '';
        document.querySelector('#modelo').value = datos.modelo || '';
        document.querySelector('#idmoneda').value = datos.moneda || '';
        document.querySelector('#precio').value = datos.precio || '';
        

        // Suponiendo que quieres mostrar la ruta de la imagen como texto en los campos correspondientes
        if(datos.imagen_destacada && datos.imagen_destacada.ruta) {
            document.querySelector('#div-imagen-destacada-update').innerHTML = `<div>
                                                                                <img src="http://sistema3.test/storage/${datos.imagen_destacada.ruta}" alt="${datos.imagen_destacada.alt}">
                                                                               </div>`;
            document.querySelector('#update-imagen-elemento').value = datos.imagen_destacada.id || '';
            var botonImagenLogo = document.getElementById('imagen-cambiar-5');
            botonImagenLogo.setAttribute('data-product-id', datos.imagen_destacada.id);
        }

        var divParaInsertarMarca = document.querySelector('#div-buscar-elementosmarca1');
        divParaInsertarMarca.innerHTML = '';

        var divParaInsertarMarcaValores = document.querySelector('#resultados-seleccionadosmarca1');
        divParaInsertarMarcaValores.value = '';
        
        if(datos.marcas) {
           
            if (!Array.isArray(datos.marcas)) {
                
            }else {
                var idsMarcas = [];

                datos.marcas.forEach(function(marca) {
                    // Construir el contenido HTML para cada marca
                    var contenidoMarca = `<div data-elemento-id="${marca.id}">
                                                <button class="eliminar-elemento-buscador" data-id-eliminar="${marca.id}"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
                                                <div class="imagen-destacada-buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg></div>
                                                    <div class="contenido-opciones-buscador">
                                                        <h3>${marca.name}</h3>
                                                    </div>
                                            </div>`;

                    // Añadir el contenido de la marca al div
                    divParaInsertarMarca.innerHTML += contenidoMarca;
                    idsMarcas.push(marca.id);
                });

              divParaInsertarMarcaValores.value = idsMarcas.join(',');

            }
                                                                                        
        }

        var divParaInsertarProcedencia = document.querySelector('#div-buscar-elementosprocedencia1');
        divParaInsertarProcedencia.innerHTML = '';

        var divParaInsertarProcedenciaValores = document.querySelector('#resultados-seleccionadosprocedencia1');
        divParaInsertarProcedenciaValores.value = '';
        
        if(datos.procedencias) {
           
            if (!Array.isArray(datos.procedencias)) {
                
            }else {
                var idsProcedencias = [];

                datos.procedencias.forEach(function(procedencia) {
                    // Construir el contenido HTML para cada marca
                    var contenidoProcedencia = `<div data-elemento-id="${procedencia.id}">
                                                <button class="eliminar-elemento-buscador" data-id-eliminar="${procedencia.id}"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
                                                <div class="imagen-destacada-buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg></div>
                                                    <div class="contenido-opciones-buscador">
                                                        <h3>${procedencia.name}</h3>
                                                    </div>
                                                </div>`;

                    // Añadir el contenido de la marca al div
                    divParaInsertarProcedencia.innerHTML += contenidoProcedencia;
                    idsProcedencias.push(procedencia.id);
                });

              divParaInsertarProcedenciaValores.value = idsProcedencias.join(',');

            }
                                                                                        
        }

        var divParaInsertarCategoria = document.querySelector('#div-buscar-elementoscategoria1');
        divParaInsertarCategoria.innerHTML = '';

        var divParaInsertarCategoriaValores = document.querySelector('#resultados-seleccionadoscategoria1');
        divParaInsertarCategoriaValores.value = '';
        
        if(datos.categorias) {
           
            if (!Array.isArray(datos.categorias)) {
                
            }else {
                var idsCategorias = [];

                datos.categorias.forEach(function(categoria) {
                    // Construir el contenido HTML para cada marca
                    var contenidoCategoria = `<div data-elemento-id="${categoria.id}">
                                                <button class="eliminar-elemento-buscador" data-id-eliminar="${categoria.id}"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
                                                <div class="imagen-destacada-buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"></path></svg></div>
                                                    <div class="contenido-opciones-buscador">
                                                        <h3>${categoria.name}</h3>
                                                    </div>
                                            </div>`;

                    // Añadir el contenido de la marca al div
                    divParaInsertarCategoria.innerHTML += contenidoCategoria;
                    idsCategorias.push(categoria.id);
                });

              divParaInsertarCategoriaValores.value = idsCategorias.join(',');

            }
                                                                                        
        }
      
        var divParaInsertarImagenes = document.querySelector('#div-imagenes-galeria-update');
        divParaInsertarImagenes.innerHTML = '';

        var divParaInsertarValoresImagenes = document.querySelector('#update-imagenes-galeria');
        divParaInsertarValoresImagenes.value = '';

        var buttonImagenesIds = document.querySelector('#imagen-cambiar-4'); 
        buttonImagenesIds.setAttribute('data-product-id', '');

        if(datos.galeria_id) {
            if (!Array.isArray(datos.galeria.images)) {
                
            }else{
              
              var idsimagenes = [];

              datos.galeria.images.forEach(function(imagen) {
                    // Construir el contenido HTML para cada marca
                    var contenidoImagen = `<div data-idimage="${imagen.id}">
                                             <div>
                                                <img src="http://sistema3.test/storage/${imagen.ruta}" alt="Texto Alternativo Predeterminado">
                                             </div>
                                           </div>`;

                    // Añadir el contenido de la marca al div
                    divParaInsertarImagenes.innerHTML += contenidoImagen;
                    idsimagenes.push(imagen.id);
              });

              divParaInsertarValoresImagenes.value = idsimagenes.join(',');
              buttonImagenesIds.setAttribute('data-product-id', idsimagenes.join(','));

            }

        }
           
        if (datos.terminos) {
            mostrarTaxonomiasYTerminos(datos.terminos);
        }
        if (datos.description) {
            tinyMCE.get('descripcion').setContent(datos.description);
        }
        if (datos.cont_envio) {
            tinyMCE.get('cont_envio').setContent(datos.cont_envio);
        }
        if (datos.datos_tecnicos) {
            tinyMCE.get('datos_tecnicos').setContent(datos.datos_tecnicos);
        }
        
    }

    function obtenerEmpresaPorId(id) {
        
       // Configurar la solicitud
        var request = new XMLHttpRequest();
        request.open('GET', '/admin/productos/get/' + id, true);
        request.setRequestHeader('Content-Type', 'application/json');
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        // Definir qué hacer cuando se reciba la respuesta
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                // Éxito: mostrar la respuesta y llenar el formulario
                var datos = JSON.parse(this.response);
                console.log(datos);
                llenarFormularioConDatos(datos);
            } else {
                // Se alcanzó el servidor, pero devolvió un error
                console.error('Error del servidor');
            }
        };

        // Definir qué hacer en caso de error
        request.onerror = function() {
            console.error('Error de conexión');
        };

        // Enviar la solicitud
        request.send();
    }
    
    document.getElementById('update-elemento').addEventListener('submit', function (event) {
        event.preventDefault();
        tinyMCE.triggerSave();

        let form = this;
        let formData = new FormData(form);
        let misEmpresaId = document.querySelector('#id-elemento-update').value;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/productos/update/' + misEmpresaId, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', formData.get('_token'));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Si la petición fue exitosa, recargar las elementos y mostrar confirmación.
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                } else {
                    // Si la petición falló, intentar mostrar el error.
                    try {
                        let response = JSON.parse(xhr.responseText);
                        if (response.message && response.errors) {
                            mostrarError(response.message, response.errors);
                        } else {
                            console.error('La respuesta no tiene el formato esperado:', response);
                        }
                    } catch (e) {
                        console.error('Error al analizar la respuesta:', xhr.responseText, e);
                    }
                }
            }
        };

        xhr.send(formData);
    });

    function eliminarProducto(id) {
        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/admin/productos/delete/' + id, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                    setTimeout(function() {
                        window.location.href = '/admin/productos';
                    }, 300);
                } else {
                    mostrarError('Error al elinar el elemento', JSON.parse(xhr.responseText).error);
                    // Manejar errores
                }
            }
        };

        xhr.send();
    }
    
    document.addEventListener('DOMContentLoaded', function() {
                tinymce.init({
                    selector: '#descripcion, #cont_envio, #datos_tecnicos',
                    language: 'es',
                    plugins: 'table code',
                    toolbar: 'table code',
                    content_style: `
                        body {
                            background-color: #273b49; 
                            color: #ffff; 
                        }
                    
                    ` 
                });  
    });



function agruparTerminosPorTaxonomia(datos) {
    const taxonomias = {};

    datos.forEach(termino => {
        const taxonomiaId = termino.taxonomia.id;
        if (!taxonomias[taxonomiaId]) {
            taxonomias[taxonomiaId] = {
                taxonomia: termino.taxonomia,
                terminos: []
            };
        }
        taxonomias[taxonomiaId].terminos.push(termino);
    });

    return taxonomias;
}

function mostrarTaxonomiasYTerminos(datos) {
    const taxonomias = agruparTerminosPorTaxonomia(datos);
    const container = document.querySelector('#container-todas-taxonomias');
    container.innerHTML = ''; // Limpiar el contenedor existente

    Object.values(taxonomias).forEach(({ taxonomia, terminos }) => {
        // Crear el contenedor principal de la taxonomía
        const taxonomiaDiv = document.createElement('div');
        taxonomiaDiv.className = 'container-taxonomia-individual';
        taxonomiaDiv.setAttribute('data-taxonomia-id', taxonomia.id);

        // Agregar botón para abrir términos y otro para eliminar taxonomía
        taxonomiaDiv.innerHTML = `
            <button class="abrir-terminos-de-taxonomias" type="button" data-taxonomia-id="${taxonomia.id}">
                <svg xmlns="http://www.w3.org/2000/svg" class="icono-isquierdo" viewBox="0 0 384 512"><path d="M0 48C0 21.5 21.5 0 48 0l0 48V441.4l130.1-92.9c8.3-6 19.6-6 27.9 0L336 441.4V48H48V0H336c26.5 0 48 21.5 48 48V488c0 9-5 17.2-13 21.3s-17.6 3.4-24.9-1.8L192 397.5 37.9 507.5c-7.3 5.2-16.9 5.9-24.9 1.8S0 497 0 488V48z"></path></svg>
                ${taxonomia.name}
                <svg xmlns="http://www.w3.org/2000/svg" class="flecha-derecha" viewBox="0 0 256 512"><path d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z"></path></svg>
            </button>
            <button class="eliminar-taxonomias" data-taxonomia-id="${taxonomia.id}" type="button">
                Eliminar
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path></svg>
            </button>
        `;

        // Crear el contenedor para términos oculto
        const terminosContainer = document.createElement('div');
        terminosContainer.className = 'container-hidden-taxonomia';
        terminosContainer.setAttribute('data-taxonomia-id', taxonomia.id);

        // Crear el contenedor de términos seleccionados
        const terminosSeleccionados = document.createElement('div');
        terminosSeleccionados.className = 'container-terminos-seleccionados';
        terminosSeleccionados.setAttribute('data-taxonomia-id', taxonomia.id);

        // Añadir cada término al contenedor de términos seleccionados
        terminos.forEach(termino => {
            let terminoDiv = document.createElement('div');
            terminoDiv.className = 'termino-individual';
            terminoDiv.setAttribute('data-taxonomia-id', taxonomia.id);
            terminoDiv.setAttribute('data-termino-id', termino.id);
            terminoDiv.innerHTML = `
                <p>${termino.name}</p>
                <button class="borrar-termino" type="button" data-termino-id="${termino.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path></svg>
                </button>
            `;
            terminosSeleccionados.appendChild(terminoDiv);
        });

        // Añadir el contenedor de términos seleccionados al contenedor de términos oculto
        terminosContainer.appendChild(terminosSeleccionados);

        // Agregar contenedores adicionales y elementos necesarios aquí...
        const buscarTerminosDiv = document.createElement('div');
        buscarTerminosDiv.className = 'container-buscar-terminos';
        buscarTerminosDiv.innerHTML = `
            <input class="buscar-terminos" type="text" name="buscar-terminos" placeholder="buscar-terminos" data-taxonomia-id="${taxonomia.id}">
            <select class="seleccionar-terminos" name="seleccionar-terminos" data-taxonomia-id="${taxonomia.id}">
                <option value="">Seleccionar terminos</option>
                <!-- Opciones adicionales aquí -->
            </select>
            <button class="button buton-agregar-termino" type="button" data-taxonomia-id="${taxonomia.id}">
                Agregar
                <!--SVG aquí -->
            </button>
            `;

        terminosContainer.appendChild(buscarTerminosDiv);

        // Añadir el contenedor de términos oculto al contenedor principal de la taxonomía
        taxonomiaDiv.appendChild(terminosContainer);
         // Finalmente, agregar el contenedor de la taxonomía al contenedor principal
        container.appendChild(taxonomiaDiv);

        
        });
        obtenerIdsTaxonomias();
 }
    
</script>
