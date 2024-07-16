<!-- Formulario para Crear Rol -->
<button id="crear-rol-button" class="button" type="button">
    Crear nuevo rol
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg>
</button>
<div id="fondo-crear-rol"></div>
<div id="form-crear-rol">
    <button class="cerrar-div-rol">
        <svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg>
    </button>
    <h3>Crear un nuevo rol</h3>
    <form id="crear-rol-form">
        <div>
            <label for="nombre-rol">Nombre del Rol:</label>
            <input type="text" id="nombre-rol" name="name" required>
        </div>
        <button class="button" type="submit">Crear Rol</button>
    </form>
</div>

<script>
    // Escuchar el evento submit del formulario
    document.getElementById('crear-rol-form').addEventListener('submit', function(e) {

        e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

        // Obtener el valor del campo del formulario
        const nombreRol = document.getElementById('nombre-rol').value;
        const containerRoles = document.getElementById('lista-de-botones-roles');
        // Enviar la solicitud AJAX
        fetch('/admin/rol/create', { // Asegúrate de usar la ruta correcta
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: nombreRol
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                mostrarConfirmacion(data.message); // Mostrar mensaje de éxito
                const newRoleDiv = document.createElement('div');
                newRoleDiv.classList.add('boton-individual');

                // Crear un nuevo botón con los datos del rol
                const newRoleButton = document.createElement('button');
                newRoleButton.classList.add('button');
                newRoleButton.setAttribute('type', 'button');
                newRoleButton.setAttribute('data-id-rol', data.role.id); // Asignar el ID del rol
                newRoleButton.setAttribute('data-name-rol', data.role.name); // Asignar el nombre del rol
                newRoleButton.textContent = data.role.name; // Establecer el texto del botón como el nombre del rol

                // Añadir el botón al div
                newRoleDiv.appendChild(newRoleButton);

                // Añadir el nuevo div al contenedor de roles
                containerRoles.appendChild(newRoleDiv);
            } else {
                throw data; // Lanzar error si la respuesta contiene un estado de éxito falso
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Mostrar los detalles del error de validación
            let errorMessage = 'Error: ';
            if (error.errors && Object.keys(error.errors).length > 0) {
                errorMessage += Object.values(error.errors).map(e => e.join(', ')).join('; ');
            } else {
                errorMessage += error.message || 'Error en la solicitud';
            }
            alert(errorMessage);
        });
    });
    
    const botonAbrirCreateRol = document.querySelector('#crear-rol-button');
    const botonCerrarCreateRol = document.querySelector('.cerrar-div-rol');
    const divRol = document.querySelector('#fondo-crear-rol');
    const fondoDivRol = document.querySelector('#form-crear-rol');

    botonCerrarCreateRol.addEventListener('click', () => {
        divRol.classList.remove('active');
        fondoDivRol.classList.remove('active');
    });

    botonAbrirCreateRol.addEventListener('click', () => {
        divRol.classList.add('active');
        fondoDivRol.classList.add('active');
    });

</script>