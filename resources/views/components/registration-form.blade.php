<!-- resources/views/components/registration-form.blade.php -->
<button id="abrir-div-crear-usuario" class="button">Crear un nuevo usuario</button>
<div class="fondo-div-crear-usuario" id="fondo-div-crear-usuario"></div>
<div class="form-product-div" id="form-usuario-div">
    <button id="cerrar-div-usuario" class="cerrar-div-usuario">
        <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
    </button>
    <h3>Agregar usuarios</h3>
    <form id="registrationForm">
        @csrf
        <!-- Campos del formulario -->
        <div class="form-group contain-image-agre">
            <input type="hidden" name="image_id" placeholder="id del producto" value="">
            <button id="imagen-cambiar-1" type="button" class="seleccion-produc-individual seleccionar-archivos button" data-product-id="" data-limit="1">Selecionar imagen</button>
            <div class="imagen-individual-form"></div>
        </div>
        <!-- Campos de nombre -->
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name">
        </div>
        <!-- Campos de email -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email">
         </div>
          <!-- Campos de telefono -->
         <div class="form-group">
            <label for="telefono">Telefono</label>
            <input type="text" name="telefono">
         </div>
        <!-- Campos de cargo -->
         <div class="form-group">
            <label for="cargo">Cargo</label>
            <input type="text" name="cargo">
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
            <select name="role_id">
                @foreach ($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                @endforeach
            </select>
        </div>
        <!-- Campos de agregar usuario -->
        <div class="form-group">
            <button class="button" type="submit">Agregar usuario</button>
        </div>

    </form>
</div>

<script>
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;

            fetch('/admin/register', { // Cambiar la URL aquí
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    name: this.name.value,
                    email: this.email.value,
                    password: this.password.value,
                    password_confirmation: this.password_confirmation.value,
                    role_id: this.role_id.value,
                    image_id: this.image_id.value,
                    cargo: this.cargo.value,
                    telefono: this.telefono.value,
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                mostrarConfirmacion('Usuario registrado exitozamente');
                limpiarDivsImagenIndividual();
                actualizarUsuariosDentroDeDiv();
                form.reset();
            })
            .catch(error => { 
                // Manejar error, por ejemplo, mostrar un mensaje de error
            });
        });

        var botonAgregarUsuario = document.getElementById('abrir-div-crear-usuario');
        var divContentUsuario = document.getElementById('form-usuario-div');
        var botonCerrarAgregarUsuario = document.getElementById('cerrar-div-usuario');
        var divFondoDivUsuario = document.getElementById('fondo-div-crear-usuario');

        // Agregar un evento de clic al botón
        botonAgregarUsuario.addEventListener('click', function() {
            // Agregar la clase al div
            divContentUsuario.classList.add('active');
            divFondoDivUsuario.classList.add('active');
        });
        botonCerrarAgregarUsuario.addEventListener('click', function() {
            // Agregar la clase al div
            divContentUsuario.classList.remove('active');
            divFondoDivUsuario.classList.remove('active');
        });


        function obtenerDatosUsuarioPorId(id) {
            
            const obtenerDatos = () => {
                fetch(`/admin/usuarios/get/${id}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => {
                    if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                        console.log(data);
                    })
                .catch(error => {
                    console.error('Error al obtener datos:', error);
                });
            };

            obtenerDatos(); // Llama a la función interna
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('todos-los-usuarios').addEventListener('click', function(event) {
                // Verifica si el clic provino de un botón con la clase 'button-update-user'
                if (event.target.classList.contains('button-update-user')) {
                    // Obtiene el valor del atributo 'data-update-user'
                    const updateUserId = event.target.getAttribute('data-update-user');
                    
                    // Imprime el valor en la consola
                    console.log(updateUserId);

                    // Llama a la función con el valor obtenido
                    obtenerDatosUsuarioPorId(updateUserId);
                }
            });
        });
        
</script>