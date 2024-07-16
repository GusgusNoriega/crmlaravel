
<div class="fondo-div-update-elemento" id="fondo-div-update-elemento"></div>
<div class="form-update-div" id="form-update-elemento-div">
        <button id="cerrar-div-update-elemento" class="cerrar-div-update-elemento">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Actualizar mi empresa</h3>
        <form id="update-elemento" method="POST" data-update-elemento-id="">
            @csrf
            <input id="id-elemento-update" type="hidden" name="id_elemento">
            <!-- Campos del formulario -->
            <div class="form-group contain-image-agre">
                <input type="hidden" name="image_id" id="update-imagen-elemento" value="">
                <button id="imagen-cambiar-5" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Seleccionar imagen del logo</button>
                <div class="imagen-individual-form" id="div-imagen-destacada-update"></div>
            </div>            
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name-elemento-update" required>
            </div>
            <div class="form-group">
                <label for="ruc">Ruc</label>
                <input type="text" name="ruc" id="ruc-elemento-update" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email-elemento-update" required>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" id="telefono-elemento-update" required>
            </div>
            <x-user-select-vendedor select-id="user-5"/>
            <div class="form-group">
                <button class="button" type="submit">Actualizar empresa</button>
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
            const updateMisempresaId = event.target.getAttribute('data-update-elemento');
            divFondoDivUpdateUsuario.classList.add('active');
            divContentUpdateUsuario.classList.add('active');

            //resetear campos de imagen y relaciones
            document.querySelector('#update-imagen-elemento').value = '';
            document.querySelector('#div-imagen-destacada-update').innerHTML = '';
            document.getElementById('imagen-cambiar-5').setAttribute('data-product-id', '');
            
            // Llama a la función con el valor obtenido
            obtenerEmpresaPorId(updateMisempresaId);
            console.log(updateMisempresaId);
           
        }
        if (event.target.classList.contains('button-delete-elemento')) {
            const updateMisempresaId = event.target.getAttribute('data-delete-elemento');
            if (confirm('¿Estás seguro de que quieres eliminar esta empresa? Esta acción no se puede deshacer.')) {
                    eliminarEmpresa(updateMisempresaId);
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
        document.querySelector('#ruc-elemento-update').value = datos.ruc || '';
        document.querySelector('#email-elemento-update').value = datos.email || '';
        document.querySelector('#telefono-elemento-update').value = datos.telefono || '';
        document.querySelector('#user-5').value = datos.user_id || '';
     
        // Suponiendo que quieres mostrar la ruta de la imagen como texto en los campos correspondientes
        if(datos.imagen_destacada && datos.imagen_destacada.ruta) {
            document.querySelector('#div-imagen-destacada-update').innerHTML = `<div>
                                                                                <img src="http://sistema3.test/storage/${datos.imagen_destacada.ruta}" alt="${datos.imagen_destacada.alt}">
                                                                               </div>`;
            document.querySelector('#update-imagen-elemento').value = datos.imagen_destacada.id || '';
            var botonImagenLogo = document.getElementById('imagen-cambiar-5');
            botonImagenLogo.setAttribute('data-product-id', datos.imagen_destacada.id);
        }
        
    }

    function obtenerEmpresaPorId(id) {
        
       // Configurar la solicitud
        var request = new XMLHttpRequest();
        request.open('GET', '/admin/empresas/get/' + id, true);
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

        let form = this;
        let formData = new FormData(form);
        let misEmpresaId = document.querySelector('#id-elemento-update').value;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/empresas/update/' + misEmpresaId, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', formData.get('_token'));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Si la petición fue exitosa, recargar las empresas y mostrar confirmación.
                    cargarEmpresas();
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

    function eliminarEmpresa(id) {
        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/admin/empresas/delete/' + id, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                    cargarEmpresas();
                } else {
                    mostrarError('Error al elinar la empresa', JSON.parse(xhr.responseText).error);
                    // Manejar errores
                }
            }
        };

        xhr.send();
    }
    
</script>
