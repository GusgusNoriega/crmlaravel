<!-- components/usuarios.blade.php -->

<div>
    <h2>Listado de Usuarios</h2>

 <div class="todos-los-usuarios" id="todos-los-usuarios">
        @foreach($usuarios as $usuario)
        <div class="usuario-individual" data-id-user="{{ $usuario->id }}">
         <div>
          <button class="button-delete-user" data-delete-user="{{ $usuario->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/></svg>
          </button>
          <button class="button-update-user" data-update-user="{{ $usuario->id }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/></svg>
          </button>
            <ul>
                @if ($usuario->image)
                    <li class="imagen-de-usuario">
                        <img src="http://sistema3.test/storage/{{ $usuario->image->ruta }}" alt="{{ $usuario->image->alt }}">
                    </li>
                @else
                    <!-- Muestra otra imagen en caso de que la relación image no exista -->
                    <li class="imagen-de-usuario">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/></svg>
                    </li>
                @endif
                <li>
                    <div class="clave-item">
                      <p>Nombre</p>
                    </div>
                    <div class="content-item">
                        <p>{{ $usuario->name }}</p>
                    </div>
                </li>
                <li>
                    <div class="clave-item">
                      <p>email</p>
                    </div>
                    <div class="content-item">
                       <p>{{ $usuario->email }}</p> 
                    </div>
                </li>
                @if (!empty($usuario->telefono))
                    <li>
                        <div class="clave-item">
                         <p>Telefono</p>
                        </div>
                        <div class="content-item">
                        <p>{{ $usuario->telefono }}</p>
                        </div>
                    </li>
                @else
                    <li>
                        <div class="clave-item">
                         <p>Telefono</p>
                        </div>
                        <div class="content-item">
                         <p>sin telefono</p>
                        </div>
                    </li>
                @endif
                @if (!empty($usuario->cargo))
                <li>
                    <div class="clave-item">
                      <p>Cargo</p>
                    </div>
                    <div class="content-item">
                      <p>{{ $usuario->cargo }}</p>
                    </div>
                </li>
                @else
                    <li>
                        <div class="clave-item">
                        <p>Cargo</p>
                        </div>
                        <div class="content-item">
                        <p>sin cargo</p>
                        </div>
                    </li>
                @endif
               
           
                <li>
                    <div class="clave-item">
                     <p>Rol:</p>
                    </div>
                    <div class="content-item">
                      <p>{{ $usuario->role->name ?? 'Sin rol' }}</p>
                    </div>
                </li>
                <!-- Agrega más información según tus necesidades -->
            </ul>
          </div>
        </div>
        @endforeach
    </div>
   
</div>

<script>
function actualizarVistaUsuarios() {
    return fetch('/admin/usuarios/get')
        .then(response => {
            // Verificar si la respuesta es exitosa (código de estado 200 OK)
            if (!response.ok) {
                throw new Error('Error al obtener usuarios');
            }
            return response.json();
        })
        .then(usuarios => {
            // Imprimir los usuarios en la consola
            //console.log('Usuarios:', usuarios);
            return usuarios; // Devolver los usuarios para encadenar la promesa
        })
        .catch(error => {
            console.error('Error:', error.message);
            throw error; // Propagar el error para que se maneje en la siguiente promesa
        });
}

function actualizarUsuariosDentroDeDiv() {
    // Llamar a la función y encadenar con then
    actualizarVistaUsuarios()
        .then(usuarios => {
            // Obtener el contenedor donde se agregarán los usuarios
            const contenedorUsuarios = document.getElementById('todos-los-usuarios');

            // Limpiar el contenido actual del contenedor
            contenedorUsuarios.innerHTML = '';

            // Iterar sobre cada usuario y crear elementos para cada uno
            usuarios.forEach(usuario => {
                const divUsuario = document.createElement('div');
                divUsuario.classList.add('usuario-individual');
                divUsuario.setAttribute('data-id-user', usuario.id);

                divUsuario.innerHTML = `
                <div>
                <button class="button-delete-user" data-delete-user="${usuario.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path></svg>
                </button>
                <button class="button-update-user" data-update-user="${usuario.id}">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path></svg>
                </button>
                <ul>
                    <li class="imagen-de-usuario">
                        <img src="${usuario.image ? 'http://sistema3.test/storage/' + usuario.image.ruta : 'ruta_por_defecto_si_no_hay_imagen'}" alt="${usuario.image ? usuario.image.alt : 'Texto alternativo por defecto'}">
                    </li>
                    <li>
                        <div class="clave-item">
                            <p>Nombre</p>
                        </div>
                        <div class="content-item">
                            <p>${usuario.name}</p>
                        </div>
                    </li>
                    <li>
                        <div class="clave-item">
                            <p>Email</p>
                        </div>
                        <div class="content-item">
                            <p>${usuario.email}</p>
                        </div>
                    </li>
                    <li>
                        <div class="clave-item">
                            <p>Teléfono</p>
                        </div>
                        <div class="content-item">
                            <p>${usuario.telefono ? usuario.telefono : 'No disponible'}</p>
                        </div>
                    </li>
                    <li>
                        <div class="clave-item">
                            <p>Cargo</p>
                        </div>
                        <div class="content-item">
                            <p>${usuario.cargo ? usuario.cargo : 'No disponible'}</p>
                        </div>
                    </li>
                    <li>
                        <div class="clave-item">
                            <p>Rol</p>
                        </div>
                        <div class="content-item">
                            <p>${usuario.role ? usuario.role.name : 'No disponible'}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
                `;

                // Agregar el usuario al contenedor
                contenedorUsuarios.appendChild(divUsuario);
            });
        })
        .catch(error => {
            // Manejar errores si es necesario
            console.error('Error en la actualización de usuarios:', error.message);
        });
}


function eliminarUsuario(id) {
    if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        var xhr = new XMLHttpRequest();

        // Configurar la solicitud DELETE
        xhr.open('DELETE', '/admin/usuarios/delete/' + id, true);

        // Configurar el token CSRF
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

        // Configurar la función que manejará la respuesta
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                // Éxito
                var response = JSON.parse(xhr.responseText);
                alert(response.message);
                actualizarUsuariosDentroDeDiv();
            } else {
                // Error
                alert('Error al eliminar el usuario');
            }
        };

        // Configurar la función que manejará los errores de red
        xhr.onerror = function () {
            alert('Error de red al intentar eliminar el usuario');
        };

        // Enviar la solicitud
        xhr.send();
    }
}
</script>