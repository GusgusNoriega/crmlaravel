
<div class="fondo-div-update-misempresa" id="fondo-div-update-misempresa"></div>
<div class="form-update-div" id="form-update-misempresa-div">
        <button id="cerrar-div-update-misempresa" class="cerrar-div-update-misempresa">
            <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
        </button>
        <h3>Actualizar mi empresa</h3>
        <form id="update-misempresa" method="POST" data-update-misempresa-id="">
            @csrf
            <input id="id-misempresa-update" type="hidden" name="id_misempresa">
            <!-- Campos del formulario -->
            <div class="form-group contain-image-agre">
                <input type="hidden" name="image_id" id="update-image-logo-misempresa" value="">
                <button id="imagen-cambiar-5" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Selecionar imagen del logo</button>
                <div class="imagen-individual-form" id="div-imagen-de-logo-update"></div>
            </div>            
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name-misempresa-update" required>
            </div>
            <div class="form-group">
                <label for="ruc">Ruc</label>
                <input type="text" name="ruc" id="ruc-misempresa-update" required>
            </div>
            <div class="form-group">
                <label for="alias">Alias</label>
                <input type="text" name="alias" id="alias-misempresa-update" required>
            </div>
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" id="telefono-misempresa-update" required>
            </div>
            <div class="form-group contain-image-agre">
                <input type="hidden" name="imagen_sello_id" id="update-image-sello-misempresa" value="">
                <button id="imagen-cambiar-6" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Selecionar imagen del sello</button>
                <div class="imagen-individual-form" id="div-imagen-de-sello-update"></div>
            </div>
            <div class="form-group">
                <label for="cuenta-soles">Cuenta soles</label>
                <input type="text" name="cuenta_soles" id="cuenta-soles-misempresa-update" required>
            </div>
            <div class="form-group">
                <label for="cuenta-dolares">Cuenta dolares</label>
                <input type="text" name="cuenta_dolares" id="cuenta-dolares-misempresa-update" required>
            </div>
            <div class="form-group">
                <label for="cuenta-nacion">Cuenta nacion</label> 
                <input type="text" name="cuenta_nacion" id="cuenta-nacion-misempresa-update" required>
            </div>
            <div class="form-group">
                <button class="button" type="submit">Actualizar mi empresa</button>
            </div>
        </form>
</div>
<script>
    var csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    var divFondoDivUpdateUsuario = document.getElementById('fondo-div-update-misempresa');
    var divContentUpdateUsuario = document.getElementById('form-update-misempresa-div');
    var botonCerrarUpdateUsuario = document.getElementById('cerrar-div-update-misempresa');
        

    botonCerrarUpdateUsuario.addEventListener('click', function() {
            // Agregar la clase al div
        divContentUpdateUsuario.classList.remove('active');
        divFondoDivUpdateUsuario.classList.remove('active');
    });
    
    document.getElementById('resultadosEmpresas').addEventListener('click', function(event) {
        // Verifica si el clic provino de un botón con la clase 'button-update-misempresa'
        if (event.target.classList.contains('button-update-misempresa')) {
            // Obtiene el valor del atributo 'data-update-misempresa'
            const updateMisempresaId = event.target.getAttribute('data-update-misempresa');
            divFondoDivUpdateUsuario.classList.add('active');
            divContentUpdateUsuario.classList.add('active');

            document.querySelector('#update-image-logo-misempresa').value = '';
            document.querySelector('#div-imagen-de-logo-update').innerHTML = '';
            document.getElementById('imagen-cambiar-5').setAttribute('data-product-id', '');

            document.querySelector('#update-image-sello-misempresa').value = '';
            document.querySelector('#div-imagen-de-sello-update').innerHTML = '';
            document.getElementById('imagen-cambiar-6').setAttribute('data-product-id', '');
            
            
            // Llama a la función con el valor obtenido
            obtenerEmpresaPorId(updateMisempresaId);
            console.log(updateMisempresaId);
           
        }
        if (event.target.classList.contains('button-delete-misempresa')) {
            // Obtiene el valor del atributo 'data-update-user'
            const updateMisempresaId = event.target.getAttribute('data-delete-misempresa');
            if (confirm('¿Estás seguro de que quieres eliminar esta empresa? Esta acción no se puede deshacer.')) {
                    // Si el usuario confirma, eliminar la empresa
                    eliminarEmpresa(updateMisempresaId);
            } else {
                    // Si el usuario cancela, no hacer nada
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
        document.querySelector('#id-misempresa-update').value = datos.id || '';
        document.querySelector('#name-misempresa-update').value = datos.name || '';
        document.querySelector('#ruc-misempresa-update').value = datos.ruc || '';
        document.querySelector('#alias-misempresa-update').value = datos.alias || '';
        document.querySelector('#telefono-misempresa-update').value = datos.telefono || '';
        document.querySelector('#cuenta-soles-misempresa-update').value = datos.cuenta_soles || '';
        document.querySelector('#cuenta-dolares-misempresa-update').value = datos.cuenta_dolares || '';
        document.querySelector('#cuenta-nacion-misempresa-update').value = datos.cuenta_nacion || '';

        // Suponiendo que quieres mostrar la ruta de la imagen como texto en los campos correspondientes
        if(datos.imagen_logo && datos.imagen_logo.ruta) {
            document.querySelector('#div-imagen-de-logo-update').innerHTML = `<div>
                                                                                <img src="http://sistema3.test/storage/${datos.imagen_logo.ruta}" alt="${datos.imagen_logo.alt}">
                                                                               </div>`;
            document.querySelector('#update-image-logo-misempresa').value = datos.imagen_logo.id || '';
            var botonImagenLogo = document.getElementById('imagen-cambiar-5');
            botonImagenLogo.setAttribute('data-product-id', datos.imagen_logo.id);
        }
        
        if(datos.imagen_sello && datos.imagen_sello.ruta) {
            // Asigna el segundo lugar de imagen-individual-form para imagen_sello
            document.querySelector('#div-imagen-de-sello-update').innerHTML = `<div>
                                                                                <img src="http://sistema3.test/storage/${datos.imagen_sello.ruta}" alt="${datos.imagen_sello.alt}">
                                                                               </div>`;
            document.querySelector('#update-image-sello-misempresa').value = datos.imagen_sello.id || '';
            var botonImagenSello = document.getElementById('imagen-cambiar-6');
            botonImagenSello.setAttribute('data-product-id', datos.imagen_sello.id);
        }
    }

    function obtenerEmpresaPorId(id) {
        
       // Configurar la solicitud
        var request = new XMLHttpRequest();
        request.open('GET', '/admin/nuestrasempresas/get/' + id, true);
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
    
    document.getElementById('update-misempresa').addEventListener('submit', function (event) {
        event.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let misEmpresaId = document.querySelector('#id-misempresa-update').value;

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/nuestrasempresas/update/' + misEmpresaId, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', formData.get('_token'));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    cargarEmpresas();
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                } else {
                    mostrarError(JSON.parse(xhr.responseText).message, JSON.parse(xhr.responseText).errors);
                    /*console.log(JSON.parse(xhr.responseText).errors);*/
                }
            }
        };

        xhr.send(formData);
    });

    function eliminarEmpresa(id) {
        let xhr = new XMLHttpRequest();
        xhr.open('DELETE', '/admin/nuestrasempresas/delete/' + id, true);
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
