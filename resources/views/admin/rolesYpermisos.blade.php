<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">
<div class="div-roles-permisos">
    <div><h1>Roles y permisos</h1></div>

    <x-upload-rol />
    <div class="roles-y-permisos">
        <div class="container-roles" id="container-roles">
            <h3>Todos los roles</h3>
            <div id="lista-de-botones-roles">
                @foreach ($roles as $role)
                <div class="boton-individual">
                <button class="button" type="button" data-id-rol="{{ $role->id }}" data-name-rol="{{ $role->name }}">{{ $role->name }}</button> {{-- Asumiendo que cada rol tiene un atributo 'name' --}}
                </div>
                @endforeach
            </div>
        </div>
        <div class="container-permisos" id="container-permisos">
            <form id="form-actualizar-permisos" action="/admin/roles/permisos/update">
                <button type="button" id="borrar-rol" data-id-rol="">
                    Eliminar Rol
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512">
                        <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"/>
                    </svg>
                </button>
                <h3 id="titulo-rol-seleccionado">rol seleccionado</h3>
                <input id="id-rol-a-cambiar" type="hidden" name="id-rol" value="2">
                <div>
                    @foreach($modelos as $modelo)
                        <div class="container-elegir-permisos">
                            <h3>{{ $modelo }}</h3>
                            <div class="container-permiso-interno">
                                <label>
                                    <input type="checkbox" name="create_{{ $modelo }}"> Crear {{ ucfirst($modelo) }}
                                </label>
                                <label>
                                    <input type="checkbox" name="update_{{ $modelo }}"> Actualizar {{ ucfirst($modelo) }}
                                </label>
                                <label>
                                    <input type="checkbox" name="delete_{{ $modelo }}"> Eliminar {{ ucfirst($modelo) }}
                                </label>
                                <label>
                                    <input type="checkbox" name="update_todos_{{ $modelo }}"> Actualizar todos {{ ucfirst($modelo) }}
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>  
                    <button type="submit" class="button boton-actualizar">
                        Actulizar permisos
                        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512">
                            <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"/>
                        </svg>
                    </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    var formulario = document.getElementById('form-actualizar-permisos');

    formulario.addEventListener('submit', function (e) {
        e.preventDefault(); // Previene el envío normal del formulario

        var checkboxes = formulario.querySelectorAll('input[type="checkbox"]');
        var estados = {};
        var idRol = formulario.querySelector('input[name="id-rol"]').value; // Obtiene el valor del ID del rol

        checkboxes.forEach(function (checkbox) {
            estados[checkbox.name] = checkbox.checked;
        });


        // Realizar la llamada AJAX
        fetch('/admin/roles/permisos/update/' + idRol, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Asegúrate de enviar el token CSRF
            },
            body: JSON.stringify({ permisos: estados })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                mostrarConfirmacion(data.message); // Muestra un mensaje de éxito
            } else {
                alert('Error: ' + data.message); // Muestra un mensaje de error
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurrió un error: ' + error.message); // Manejo de errores de red o de solicitud
        });
    });

      var contenedorBotonesRoles = document.getElementById('lista-de-botones-roles');
      var contenedorTituloRol = document.getElementById('titulo-rol-seleccionado');
      var idRolCambiar = document.getElementById('id-rol-a-cambiar');
      var borrarRol = document.getElementById('borrar-rol');
      

        contenedorBotonesRoles.addEventListener('click', function (e) {
            var botonRol = e.target; // Obtiene el elemento que desencadenó el evento

            if (botonRol.tagName === 'BUTTON') { // Verifica si es un botón
                var idRol = botonRol.getAttribute('data-id-rol'); // Obtiene el valor del atributo data-id-rol
                var nombreRol = botonRol.getAttribute('data-name-rol'); // Obtiene el valor del atributo data-name-rol

                formulario.classList.add('active');
                contenedorTituloRol.textContent = 'Rol: ' + nombreRol;
                borrarRol.setAttribute('data-id-rol', idRol);
                idRolCambiar.value = idRol;
                
                actualizarCheckboxesConPermisos(idRol);
            }
        });

            borrarRol.addEventListener('click', function() {
                var idRol = this.getAttribute('data-id-rol');
                var confirmacion = window.confirm('¿Está seguro de que desea eliminar este rol de usuario? Esta acción no se puede deshacer.');

                if (confirmacion) {
                    fetch('/admin/roles/delete/' + idRol, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => { throw err; });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Eliminar el botón correspondiente del DOM
                            mostrarConfirmacion(data.message); // Mostrar mensaje de éxito
                            eliminarContenedorPorId(idRol);
                            formulario.classList.remove('active');
                        } else {
                            throw data; // Lanzar error si la respuesta contiene un estado de éxito falso
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Mostrar detalles del error
                        let errorMessage = 'Error: ';
                        if (error.errors && Object.keys(error.errors).length > 0) {
                            errorMessage += Object.values(error.errors).map(e => e.join(', ')).join('; ');
                        } else {
                            errorMessage += error.message || 'Error en la solicitud';
                        }
                        alert(errorMessage);
                    });
                }
            });

        function actualizarCheckboxesConPermisos(roleId) {
                obtenerPermisosDelRol(roleId)
                    .then(permisos => {
                        // Itera sobre todos los checkboxes del formulario
                        var checkboxes = document.querySelectorAll('#form-actualizar-permisos input[type="checkbox"]');
                        checkboxes.forEach(checkbox => {
                            // Formato del nombre del permiso en el checkbox (por ejemplo, "create_usuarios")
                            var nombrePermiso = checkbox.name;

                            // Actualiza el estado del checkbox
                            checkbox.checked = permisos.includes(nombrePermiso);
                        });
                    })
                    .catch(error => {
                        console.error(error);
                        // Maneja el error aquí, por ejemplo, mostrando un mensaje al usuario
                    });
            }

        function obtenerPermisosDelRol(roleId) {
            return new Promise((resolve, reject) => {
                fetch('/admin/roles/' + roleId + '/permisos', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Respuesta de red no fue ok.');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        resolve(data.permisos); // Resuelve la promesa con los permisos
                    } else {
                        reject('Error: ' + data.message); // Rechaza la promesa con el mensaje de error
                    }
                })
                .catch(error => {
                    reject('Error de captura: ' + error.message); // Rechaza la promesa con el mensaje de error
                });
            });
        }

        function eliminarContenedorPorId(id) {
            // Obtén el contenedor por su ID
            var contenedorRoles = document.getElementById('lista-de-botones-roles');

            // Busca todos los botones dentro del contenedor
            var botones = contenedorRoles.querySelectorAll('.boton-individual button');

            // Encuentra el botón que tiene el data-id-rol igual al ID proporcionado
            var botonAEliminar = Array.from(botones).find(function(boton) {
                return boton.getAttribute('data-id-rol') === id.toString();
            });

            // Si se encuentra el botón, elimina su contenedor padre
            if (botonAEliminar) {
                botonAEliminar.parentElement.remove();
            }
        }
});


</script>
</x-dynamic-component>