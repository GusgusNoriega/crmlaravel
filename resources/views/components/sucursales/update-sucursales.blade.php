
<div class="fondo-div-update-elemento" id="fondo-div-update-elemento2"></div>
<div class="form-update-div" id="form-update-elemento-div2">
        <button id="cerrar-div-update-elemento2" class="cerrar-div-update-elemento">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Actualizar sucursal</h3>
        <form id="update-elemento2" method="POST" data-update-elemento-id="">
            @csrf
            <input id="id-elemento-update3" type="hidden" name="id_elemento">
            <!-- Campos del formulario -->

            
            <div class="form-group">
                <label for="name-sucursal">Nombre de la sucursal</label>
                <input type="text" id="name-sucursal-update" name="name" required>
            </div>

            <div class="form-group">
                <label for="contenido-sucursal">Direccion</label>
                <textarea name="direccion" id="contenido-sucursal-update" cols="30" rows="10"></textarea>
            </div>

            <div class="form-group">
                <button class="button" type="submit">Actualizar sucursal</button>
            </div>
        </form>
</div>
<script>
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var divFondoDivUpdateUsuario2 = document.getElementById('fondo-div-update-elemento2');
    var divContentUpdateUsuario2 = document.getElementById('form-update-elemento-div2');
    var botonCerrarUpdateUsuario2 = document.getElementById('cerrar-div-update-elemento2');
        

    botonCerrarUpdateUsuario2.addEventListener('click', function() {
        divContentUpdateUsuario2.classList.remove('active');
        divFondoDivUpdateUsuario2.classList.remove('active');
    });
    
    document.getElementById('resultadosElementos2').addEventListener('click', function(event) {
        // Verifica si el clic provino de un botón con la clase 'button-update-elemento'
        if (event.target.classList.contains('button-update-elemento')) {
            // Obtiene el valor del atributo 'data-update-elemento'
            const updateMisempresaId = event.target.getAttribute('data-update-elemento');
            divFondoDivUpdateUsuario2.classList.add('active');
            divContentUpdateUsuario2.classList.add('active');

            // Llama a la función con el valor obtenido
            obtenerSucursalPorId(updateMisempresaId);
            console.log(updateMisempresaId);
           
        }
        if (event.target.classList.contains('button-delete-elemento')) {
            const updateMisempresaId = event.target.getAttribute('data-delete-elemento');
            if (confirm('¿Estás seguro de que quieres eliminar esta empresa? Esta acción no se puede deshacer.')) {
                eliminarSucursal(updateMisempresaId);
            } else {
                    console.log('Eliminación cancelada');
            }             
        }
    });

    function llenarFormularioConDatos2(datos2) {
        // Asegúrate de que tienes los datos que esperas
        if (!datos2) {
            console.error('No hay datos para llenar el formulario.');
            return;
        }

        // Llenar los campos del formulario
        document.querySelector('#id-elemento-update3').value = datos2.id || '';
        document.querySelector('#name-sucursal-update').value = datos2.name || '';
        document.querySelector('#contenido-sucursal-update').value = datos2.direccion || '';
              
    }

    function obtenerSucursalPorId(id) {
        
       // Configurar la solicitud
        var request = new XMLHttpRequest();
        request.open('GET', '/admin/sucursales/get/' + id, true);
        request.setRequestHeader('Content-Type', 'application/json');
        request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        request.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        // Definir qué hacer cuando se reciba la respuesta
        request.onload = function() {
            if (this.status >= 200 && this.status < 400) {
                // Éxito: mostrar la respuesta y llenar el formulario
                var datos2 = JSON.parse(this.response);
                console.log(datos2);
                llenarFormularioConDatos2(datos2);
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
    
    document.getElementById('update-elemento2').addEventListener('submit', function (event) {
        event.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let misEmpresaId = document.querySelector('#id-elemento-update3').value;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/sucursales/update/' + misEmpresaId, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', formData.get('_token'));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Si la petición fue exitosa, recargar las empresas y mostrar confirmación.
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                    cargarElementosSucursales();
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

    function eliminarSucursal(id) {
        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/admin/sucursales/delete/' + id, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                    cargarElementosSucursales();
                } else {
                    mostrarError('Error al elinar el comentario', JSON.parse(xhr.responseText).error);
                    // Manejar errores
                }
            }
        };

        xhr.send();
    }
    
</script>
