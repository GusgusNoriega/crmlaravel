<div class="fondo-div-update-elemento" id="fondo-div-update-elemento"></div>
<div class="form-update-div" id="form-update-elemento-div">
        <button id="cerrar-div-update-elemento" class="cerrar-div-update-elemento">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Actualizar mi categoria</h3>
        <form id="update-elemento" method="POST" data-update-elemento-id="">
            @csrf
            <input id="id-elemento-update" type="hidden" name="id_elemento">
            <!-- Campos del formulario -->

            <div class="form-group contain-image-agre">
                <input type="hidden" name="image_id" id="update-imagen-elemento" value="">
                <button id="imagen-cambiar-5" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Seleccionar imagen destacada</button>
                <div class="imagen-individual-form" id="div-imagen-destacada-update"></div>
            </div>
    
            <div class="form-group">
                <label for="name">Nombre de la categoria</label>
                <input type="text" name="name" id="name-elemento-update" required>
            </div>

            <div class="form-group form-group-33">
                <x-productos.buscador-categoria idPrincipal="categoria2" nombre="CATEGORIA PADRE" cantidad="1" subcategorias="true"/>
            </div>

            <div class="form-group">
                <button class="button" type="submit">Actualizar categoria</button>
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
            const ocultarCategoriaPadre = event.target.getAttribute('data-subcategoria');
            if (ocultarCategoriaPadre == '0') {
                document.getElementById('elementos-container-buscadorcategoria2').style.display = 'none';
            }else {
                document.getElementById('elementos-container-buscadorcategoria2').style.display = 'block';
            }

            divFondoDivUpdateUsuario.classList.add('active');
            divContentUpdateUsuario.classList.add('active');

            // Llama a la función con el valor obtenido

            obtenerElementoPorId(updateElementosId);
            console.log(updateElementosId);
           
        }
        if (event.target.classList.contains('button-delete-elemento')) {
            const updateElementosId = event.target.getAttribute('data-delete-elemento');
            if (confirm('¿Estás seguro de que quieres eliminar este elemento? Esta acción no se puede deshacer.')) {
                    eliminarElemento(updateElementosId);
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
        document.querySelector('#name-elemento-update').value = datos.name || '';
        document.querySelector('#resultados-seleccionadoscategoria2').value = datos.categoria_padre_id || '';

        if(datos.imagen_destacada && datos.imagen_destacada.ruta) {
            document.querySelector('#div-imagen-destacada-update').innerHTML = `<div>
                                                                                <img src="http://sistema3.test/storage/${datos.imagen_destacada.ruta}" alt="">
                                                                               </div>`;
            document.querySelector('#update-imagen-elemento').value = datos.imagen_destacada.id || '';
            var botonImagenLogo = document.getElementById('imagen-cambiar-5');
            botonImagenLogo.setAttribute('data-product-id', datos.imagen_destacada.id);
        }
        document.querySelector('#div-buscar-elementoscategoria2').innerHTML = '';
        if(datos.categoria_padre) {
            var nombreCategoriaPadre = datos.categoria_padre.name;

            if (datos.categoria_padre.imagen_destacada) {
                rutaImagenCategoriaPadre = datos.categoria_padre.imagen_destacada.ruta;
                var imagenCategoriaPadre = '<div class="imagen-destacada-buscador"><img src="http://sistema3.test/storage/' + rutaImagenCategoriaPadre + '" alt="Gustavos Avatar"></div>';
            }else {
                var imagenCategoriaPadre = '<div class="imagen-destacada-buscador"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M448 80c8.8 0 16 7.2 16 16V415.8l-5-6.5-136-176c-4.5-5.9-11.6-9.3-19-9.3s-14.4 3.4-19 9.3L202 340.7l-30.5-42.7C167 291.7 159.8 288 152 288s-15 3.7-19.5 10.1l-80 112L48 416.3l0-.3V96c0-8.8 7.2-16 16-16H448zM64 32C28.7 32 0 60.7 0 96V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V96c0-35.3-28.7-64-64-64H64zm80 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z"/></svg></div>';
            }
            document.querySelector('#div-buscar-elementoscategoria2').innerHTML = `<div data-elemento-id="${datos.categoria_padre_id}"><button class="eliminar-elemento-buscador" data-id-eliminar="${datos.categoria_padre_id}"><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></button>
                                                                                    ${imagenCategoriaPadre}
                                                                                        <div class="contenido-opciones-buscador">
                                                                                            <h3>${nombreCategoriaPadre}</h3>  
                                                                                        </div>
                                                                                    </div>`;
                                                                                        
        }
        
        
    }

    function obtenerElementoPorId(id) {
        
       // Configurar la solicitud
        var request = new XMLHttpRequest();
        request.open('GET', '/admin/categorias/get/' + id, true);
        request.setRequestHeader('Content-Type', 'application/json');
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        // Definir qué hacer cuando se reciba la respuesta
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                // Éxito: mostrar la respuesta y llenar el formulario
                limpiarDivsImagenIndividual();
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

        let form = this;
        let formData = new FormData(form);
        let misEmpresaId = document.querySelector('#id-elemento-update').value;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/categorias/update/' + misEmpresaId, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', formData.get('_token'));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Si la petición fue exitosa, recargar las elementos y mostrar confirmación.
                    cargarElementos();
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

    function eliminarElemento(id) {
        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/admin/categorias/delete/' + id, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                    cargarElementos();
                } else {
                    mostrarError('Error al elinar el elemento', JSON.parse(xhr.responseText).error);
                    // Manejar errores
                }
            }
        };

        xhr.send();
    }
    
</script>