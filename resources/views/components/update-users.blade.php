<!-- resources/views/components/registration-form.blade.php -->
<div class="fondo-div-update-usuario" id="fondo-div-update-usuario"></div>
<div class="form-update-div" id="form-update-usuario-div">
    <button id="cerrar-div-update-usuario" class="cerrar-div-update-usuario">
        <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
    </button>
    <h3>Actualizar usuarios</h3>
    <form id="updateUserForm" method="POST" data-user-id="">
        @csrf
        <input id="id-user-update" type="hidden" name="id_user">
        <!-- Campos del formulario -->
        <div class="form-group contain-image-agre">
            <input id="update-user-image-input" type="hidden" name="image_id" placeholder="id del producto" value="">
            <button id="imagen-cambiar-3" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Selecionar imagen</button>
            <div id="update-user-image" class="imagen-individual-form"></div>
        </div>
        <!-- Campos de nombre -->
        <div class="form-group">
            <label for="name">Nombre</label>
            <input id="user-update-name" type="text" name="name">
        </div>
        <!-- Campos de email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input id="user-update-email" type="email" name="email">
         </div>
          <!-- Campos de telefono -->
         <div class="form-group">
            <label for="telefono">Telefono</label>
            <input id="user-update-telefono" type="text" name="telefono">
         </div>
        <!-- Campos de cargo -->
         <div class="form-group">
            <label for="cargo">Cargo</label>
            <input id="user-update-cargo" type="text" name="cargo">
         </div>
        <!-- Campos de contraseña -->
         <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" name="password">
         </div>
        <!-- Campos de confirmar contraseña -->
         <div class="form-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation">
        </div>
        <!-- Campos de seleccion de rol -->
        <div class="form-group">
            <label for="role_id">Seleccionar un rol</label>
            <select id="user-update-role" name="role_id">
                <option value="">Sin rol asignado</option>
                @foreach ($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Campos de agregar usuario -->
        <div class="form-group">
            <button class="button" type="submit">Actualizar usuario</button>
        </div>
    </form>
</div>

<script>

async function obtenerDatosUsuarioPorId(id) {
    try {
        const response = await fetch(`/admin/usuarios/get/${id}`, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        const data = await response.json();
        /*console.log(data);*/
        return data;
    } catch (error) {
        console.error('Error al obtener datos:', error);
        throw error; // Puedes decidir manejar el error aquí o dejar que se propague
    }
}

async function llenarFormulario(id) {
    const idUsuario = id; // Cambia esto con el ID del usuario que deseas obtener

    try {
        const datosUsuario = await obtenerDatosUsuarioPorId(idUsuario);

        // Actualizar campos del formulario con los datos obtenidos
        document.getElementById('id-user-update').value = datosUsuario.id;
        document.getElementById('user-update-name').value = datosUsuario.name;
        document.getElementById('user-update-email').value = datosUsuario.email;
        document.getElementById('user-update-telefono').value = datosUsuario.telefono;
        document.getElementById('user-update-cargo').value = datosUsuario.cargo;
        var formulario = document.getElementById('updateUserForm');
        formulario.dataset.userId = datosUsuario.id;

        // Puedes agregar más campos según sea necesario
        const selectRole = document.getElementById('user-update-role');
       
        if (datosUsuario.role_id) {
            // Si hay un role_id en los datos del usuario, selecciona esa opción
            selectRole.value = datosUsuario.role_id.toString();
        } else {
            // Si no hay role_id, selecciona la opción por defecto (sin rol asignado)
            selectRole.value = "";
        }

        const updateImageDiv = document.getElementById('update-user-image');
        updateImageDiv.innerHTML = '';

        if (datosUsuario.image) {
        document.getElementById('update-user-image-input').value = datosUsuario.image.id;
        updateImageDiv.innerHTML = `
            <div data-idimage="${datosUsuario.image.id}">
                <button class="delete-button">
                    <!-- Aquí va tu SVG para el botón de eliminar -->
                </button>
                <button class="editar-imagen-seleccionada" data-image-id="${datosUsuario.image.id}">
                    <!-- Aquí va tu SVG para el botón de editar imagen -->
                </button>
                <div>
                    <img src="http://sistema3.test/storage/${datosUsuario.image.ruta}" alt="${datosUsuario.image.alt}">
                </div>
            </div>
        `;

        const seleccionarImagenBtn = document.getElementById('imagen-cambiar-3');
        seleccionarImagenBtn.dataset.productId = datosUsuario.image.id;     
        }

       

    } catch (error) {
        console.error('Error al llenar el formulario:', error);
    }
}


document.addEventListener('DOMContentLoaded', () => {
    var divFondoDivUpdateUsuario = document.getElementById('fondo-div-update-usuario');
    var divContentUpdateUsuario = document.getElementById('form-update-usuario-div');
    var botonCerrarUpdateUsuario = document.getElementById('cerrar-div-update-usuario');
        

    botonCerrarUpdateUsuario.addEventListener('click', function() {
            // Agregar la clase al div
        divContentUpdateUsuario.classList.remove('active');
        divFondoDivUpdateUsuario.classList.remove('active');
    });
    document.getElementById('todos-los-usuarios').addEventListener('click', function(event) {
        // Verifica si el clic provino de un botón con la clase 'button-update-user'
        if (event.target.classList.contains('button-update-user')) {
            // Obtiene el valor del atributo 'data-update-user'
            const updateUserId = event.target.getAttribute('data-update-user');
            divFondoDivUpdateUsuario.classList.add('active');
            divContentUpdateUsuario.classList.add('active');
            
            // Llama a la función con el valor obtenido
             llenarFormulario(updateUserId);
        }
        if (event.target.classList.contains('button-delete-user')) {
            // Obtiene el valor del atributo 'data-update-user'
            var userIdToDelete = event.target.dataset.deleteUser;

            // Ahora puedes utilizar userIdToDelete como desees
            eliminarUsuario(userIdToDelete);
        }
    });



    document.getElementById('updateUserForm').addEventListener('submit', function (event) {
        event.preventDefault();

        let form = this;
        let formData = new FormData(form);
        let userId = form.getAttribute('data-user-id');

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/usuarios/update/' + userId, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', formData.get('_token'));

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    /*console.log(JSON.parse(xhr.responseText).message);*/
                    actualizarUsuariosDentroDeDiv();
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                } else {
                    console.error('Error al actualizar el nombre');
                }
            }
        };

        xhr.send(formData);
    });


         

});

        
</script>