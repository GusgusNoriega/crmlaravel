
<div class="fondo-div-update-elemento" id="fondo-div-update-elemento"></div>
<div class="form-update-div" id="form-update-elemento-div">
        <button id="cerrar-div-update-elemento" class="cerrar-div-update-elemento">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Actualizar moneda</h3>
        <form id="update-elemento" method="POST" data-update-elemento-id="">
            @csrf
            <input id="id-elemento-update" type="hidden" name="id_elemento">
            <!-- Campos del formulario -->
    
            <div class="form-group">
                <label for="name">Nombre de la moneda</label>
                <input type="text" name="name" id="name-elemento-update" required>
            </div>

            
            <div class="form-group">
                <label for="code">Codigo de moneda (mayusculas)</label>
                <input type="text" name="code" id="code-update" oninput="this.value = this.value.toUpperCase()" required>
            </div>

            <div class="form-group">
                <label for="tipo_cambio">Tipo de cambio</label>
                <input type="number" step="0.01" name="tipo_cambio" id="tipo-cambio-update" required>
            </div>

            <div class="form-group">
                <label for="symbol">Simbolo</label>
                <input type="text" step="0.01" name="symbol" id="symbol-update" required>
            </div>


            <div class="form-group">
                <button class="button" type="submit">Actualizar moneda</button>
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
        document.querySelector('#code-update').value = datos.code || '';
        document.querySelector('#tipo-cambio-update').value = datos.tipo_cambio || '';
        document.querySelector('#symbol-update').value = datos.symbol || '';
        
    }

    function obtenerElementoPorId(id) {
        
       // Configurar la solicitud
        var request = new XMLHttpRequest();
        request.open('GET', '/admin/monedas/get/' + id, true);
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
        xhr.open('POST', '/admin/monedas/update/' + misEmpresaId, true);
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
        xhr.open('DELETE', '/admin/monedas/delete/' + id, true);
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
