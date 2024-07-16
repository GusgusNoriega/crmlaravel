<button id="button-abrir-notificaciones">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v25.4c0 45.4-15.5 89.5-43.8 124.9L5.3 377c-5.8 7.2-6.9 17.1-2.9 25.4S14.8 416 24 416H424c9.2 0 17.6-5.3 21.6-13.6s2.9-18.2-2.9-25.4l-14.9-18.6C399.5 322.9 384 278.8 384 233.4V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm0 96c61.9 0 112 50.1 112 112v25.4c0 47.9 13.9 94.6 39.7 134.6H72.3C98.1 328 112 281.3 112 233.4V208c0-61.9 50.1-112 112-112zm64 352H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7s18.7-28.3 18.7-45.3z"/></svg>
    <span id="cantidad-notificaciones">0</span>
</button>
<div class="fondo-notificaciones" id="fondo-notificaciones"></div>

<div class="contenedor-de-notificaciones" id="contenedor-de-notificaciones">
    <button id="button-cerrar-notificaciones">
        <svg class="svg-cerrar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
    </button>
    <div class="div-container-notificaciones" id="div-container-notificaciones">
     
    </div>
    <div class="container-pagination-notificaciones">
        <button id="boton-cargar-anterior-notificaciones">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
             pagina anterior
        </button>
        <button id="boton-cargar-siguiente-notificaciones">
            pagina siguiente
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M438.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L338.8 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l306.7 0L233.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160z"/></svg>
        </button>
    </div>
</div>
<script>

var botonAbrirNotificaciones = document.getElementById('button-abrir-notificaciones');
var botonCerrarNotificaciones = document.getElementById('button-cerrar-notificaciones');
var divFondoNotificaciones = document.getElementById('fondo-notificaciones');
var divNotificaciones = document.getElementById('contenedor-de-notificaciones');


botonAbrirNotificaciones.addEventListener('click', function() {
    divFondoNotificaciones.classList.add('active'); 
    divNotificaciones.classList.add('active'); 
});

botonCerrarNotificaciones.addEventListener('click', function() {
    divFondoNotificaciones.classList.remove('active'); 
    divNotificaciones.classList.remove('active'); 
});

document.getElementById('div-container-notificaciones').addEventListener('submit', function(event) {
    // Verifica si el evento es disparado por un formulario
    if (event.target.matches('.actualizar-notificaciones')) {
        event.preventDefault(); // Previene el envío normal del formulario

        let form = event.target; // Referencia al formulario que disparó el evento
        let formData = new FormData(form);

        var urlActual = window.location.href;


        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/admin/comentarios/create', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 201) {
                    form.reset();
                    mostrarConfirmacion(JSON.parse(xhr.responseText).message);
                    getNotificaciones();
                    if (urlActual.includes("/admin/empresas/")) {
                        cargarElementos();
                    }
                           
                } else {
                    mostrarError(JSON.parse(xhr.responseText).message, JSON.parse(xhr.responseText).errors);
                }
            }
        };

        xhr.send(formData);
    }
});

document.getElementById('div-container-notificaciones').addEventListener('click', function(event) {
    // Verifica si el evento es disparado por un botón con la clase específica
    if (event.target.matches('.abrir-actualizar-notificacion')) {
       console.log('abrir div');  

       event.target.classList.toggle('active');

        // Encuentra el div justo debajo del botón y agrega/quita la clase 'active'
        var nextDiv = event.target.nextElementSibling;
        if (nextDiv && nextDiv.tagName === 'DIV') {
            nextDiv.classList.toggle('active');
        }
    }
});



function getNotificaciones(pagina = 1) {
    const url = `/admin/comentarios/notificaciones?page=${pagina}`;

    return fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta de la red');
            }
            return response.json(); // Devuelve una promesa con los datos en formato JSON
        })
        .then(json => insertarComentariosEnDiv(json)) // Ahora maneja los datos JSON
        .catch(error => console.error('Error al realizar la petición:', error));
}

function insertarComentariosEnDiv(json) {
    // Encuentra el div contenedor donde se insertarán los comentarios
    var contenedor = document.getElementById('div-container-notificaciones');

    // Limpia el contenedor actual
    contenedor.innerHTML = '';

    // Verifica que el JSON tiene comentarios
    if (json && json.comentarios && json.comentarios.data) {
        // Itera sobre los comentarios y crea un div para cada uno
        json.comentarios.data.forEach(comentario => {
            // Crea un nuevo div para el comentario
            var divComentario = document.createElement('div');

            const modeloAsignado = comentario.comentable_type === 'App\\Models\\Empresa' ? '<svg class="svg-asignado-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 48c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16h80V400c0-26.5 21.5-48 48-48s48 21.5 48 48v64h80c8.8 0 16-7.2 16-16V64c0-8.8-7.2-16-16-16H64zM0 64C0 28.7 28.7 0 64 0H320c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zm88 40c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H104c-8.8 0-16-7.2-16-16V104zM232 88h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H232c-8.8 0-16-7.2-16-16V104c0-8.8 7.2-16 16-16zM88 232c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H104c-8.8 0-16-7.2-16-16V232zm144-16h48c8.8 0 16 7.2 16 16v48c0 8.8-7.2 16-16 16H232c-8.8 0-16-7.2-16-16V232c0-8.8 7.2-16 16-16z"></path></svg></div><div class="elemento-user-name"><span>Empresa</span>' :
                                   comentario.comentable_type === 'App\\Models\\Cliente' ? '<svg class="svg-asignado-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M272.2 64.6l-51.1 51.1c-15.3 4.2-29.5 11.9-41.5 22.5L153 161.9C142.8 171 129.5 176 115.8 176H96V304c20.4 .6 39.8 8.9 54.3 23.4l35.6 35.6 7 7 0 0L219.9 397c6.2 6.2 16.4 6.2 22.6 0c1.7-1.7 3-3.7 3.7-5.8c2.8-7.7 9.3-13.5 17.3-15.3s16.4 .6 22.2 6.5L296.5 393c11.6 11.6 30.4 11.6 41.9 0c5.4-5.4 8.3-12.3 8.6-19.4c.4-8.8 5.6-16.6 13.6-20.4s17.3-3 24.4 2.1c9.4 6.7 22.5 5.8 30.9-2.6c9.4-9.4 9.4-24.6 0-33.9L340.1 243l-35.8 33c-27.3 25.2-69.2 25.6-97 .9c-31.7-28.2-32.4-77.4-1.6-106.5l70.1-66.2C303.2 78.4 339.4 64 377.1 64c36.1 0 71 13.3 97.9 37.2L505.1 128H544h40 40c8.8 0 16 7.2 16 16V352c0 17.7-14.3 32-32 32H576c-11.8 0-22.2-6.4-27.7-16H463.4c-3.4 6.7-7.9 13.1-13.5 18.7c-17.1 17.1-40.8 23.8-63 20.1c-3.6 7.3-8.5 14.1-14.6 20.2c-27.3 27.3-70 30-100.4 8.1c-25.1 20.8-62.5 19.5-86-4.1L159 404l-7-7-35.6-35.6c-5.5-5.5-12.7-8.7-20.4-9.3C96 369.7 81.6 384 64 384H32c-17.7 0-32-14.3-32-32V144c0-8.8 7.2-16 16-16H56 96h19.8c2 0 3.9-.7 5.3-2l26.5-23.6C175.5 77.7 211.4 64 248.7 64H259c4.4 0 8.9 .2 13.2 .6zM544 320V176H496c-5.9 0-11.6-2.2-15.9-6.1l-36.9-32.8c-18.2-16.2-41.7-25.1-66.1-25.1c-25.4 0-49.8 9.7-68.3 27.1l-70.1 66.2c-10.3 9.8-10.1 26.3 .5 35.7c9.3 8.3 23.4 8.1 32.5-.3l71.9-66.4c9.7-9 24.9-8.4 33.9 1.4s8.4 24.9-1.4 33.9l-.8 .8 74.4 74.4c10 10 16.5 22.3 19.4 35.1H544zM64 336a16 16 0 1 0 -32 0 16 16 0 1 0 32 0zm528 16a16 16 0 1 0 0-32 16 16 0 1 0 0 32z"/></svg></div><div class="elemento-user-name"><span>Cliente</span>' :
                                   comentario.comentable_type === 'App\\Models\\Cotizacion' ? 'Cotizacion' :
                                   'default';

            const urlModelo = comentario.comentable_type === 'App\\Models\\Empresa' ? 'http://sistema3.test/admin/empresas/' + comentario.comentable_id :
                              comentario.comentable_type === 'App\\Models\\Cliente' ? 'http://sistema3.test/admin/clientes/' + comentario.comentable_id :
                              'default';

            const imagenUsuarioAsignado = comentario.user_asig_id && comentario.user_asignado.image_id ? '<img src="http://sistema3.test/storage/' + comentario.user_asignado.image.ruta + '" alt="">' : '<p>hola</p>';
            const usuarioAsignado = comentario.user_asig_id != null ? '<div class="container-seccion-usuario"><div class="elemento-user-image">' + imagenUsuarioAsignado + '</div><div class="elemento-user-name"><span>Asignado a</span><p>' + comentario.user_asignado.name + '</p></div></div>' : '';

            const imagenUsuario = comentario.user_id && comentario.user.image_id ? '<img src="http://sistema3.test/storage/' + comentario.user.image.ruta + '" alt="">' : '<p>hola</p>';
            const usuarioCreador = comentario.user_id != null ? '<div class="container-seccion-usuario"><div class="elemento-user-image">' + imagenUsuario + '</div><div class="elemento-user-name"><span>Creado por</span><p>' + comentario.user.name + '</p></div></div>' : '';
            const nombreOjetoAsignado = comentario.comentable && comentario.comentable.name ? comentario.comentable.name : '';

            const fechaCreacion = new Date(comentario.created_at);
            const fechaCreacionFormateada = fechaCreacion.toLocaleDateString("es-ES", {
                year: 'numeric', month: '2-digit', day: '2-digit',
                hour: '2-digit', minute: '2-digit', second: '2-digit',
                hour12: false // Cambia a true si prefieres el formato de 12 horas
            });

            divComentario.innerHTML = `
            <div class="notificacion-individual">

                <div class="elemento-asignado">
                    <div class="elemento-user-image">
                     ${modeloAsignado}
                     <p>${nombreOjetoAsignado}</p>
                    </div>
                       
                    <a class="ver-elemento-asignado" href="${urlModelo}">
                        Ver
                    <svg class="svg-ver-elemento-asignado" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                    </a>
                </div>

              ${usuarioCreador}

               ${usuarioAsignado}

                <div class="container-seccion-elemento">
                    <p>Fecha asignada</p>
                    <div>
                        <p>${comentario.fecha_asignada}</p>
                    </div>
                </div>

                <div class="container-seccion-elemento">
                    <p>Fecha de creacion</p>
                    <div><p>${fechaCreacionFormateada}</p></div>
                </div>

                <div class="container-seccion-elemento" id="contenido-de-la-notificacion">
                    <div><p>${comentario.contenido}</p></div>
                </div>

                <span class="comentario-pendiente">Pendiente</span>
                <button class="abrir-actualizar-notificacion">
                    <svg class="svg-cerrar" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
                    Cambiar estado
                </button>
                <div class="container-form-notificaciones">
                    <form class="actualizar-notificaciones" data-tipo="formulario1" >
                        <!-- Campos del formulario 1 -->
                        <h3>Escribe como cumpliste con esta asignacion</h3>
                        <input type="hidden" name="user_id" value="">
                        <label>Fecha asignada (solo si se coordino otra instrucción)</label>
                        <input type="datetime-local" name="fecha_asignada" id="fecha-asinada-notificaciones">
                        <input type="hidden" name="id_notificacion" value="${comentario.id}">
                        <input type="hidden" name="comentable_type" value="${comentario.comentable_type}">
                        <input type="hidden" name="comentable_id" value="${comentario.comentable_id}">
                        <textarea id="comentario" name="contenido" required>
                        </textarea>
                        <button class="actualizar-notificacion">Actualizar</button>
                    </form>
                </div>

                </div>
            `;

            // Inserta el div del comentario en el contenedor
            contenedor.appendChild(divComentario);
        });
        const catidadNotificaciones = document.getElementById('cantidad-notificaciones');
        catidadNotificaciones.innerHTML = json.totalComentarios;

            const botonCargarSiguienteNotificaciones = document.getElementById('boton-cargar-siguiente-notificaciones');
            if (json.comentarios.current_page < json.comentarios.last_page) {
                            // No es la última página, muestra el botón y prepara para la próxima página
                            botonCargarSiguienteNotificaciones.style.display = 'flex'; // Muestra el botón
                            botonCargarSiguienteNotificaciones.setAttribute('data-pagina-siguiente', json.comentarios.current_page + 1); // Establece la próxima página
                                    
                            // Asegúrate de que el botón carga la próxima página cuando se hace clic
                            botonCargarSiguienteNotificaciones.onclick = () => {
                                getNotificaciones(json.comentarios.current_page + 1);
                            };
                } else {
                        // Es la última página, oculta el botón
                        botonCargarSiguienteNotificaciones.style.display = 'none';
            }
        
            const botonCargarAnteriorNotificaciones = document.getElementById('boton-cargar-anterior-notificaciones');
            
                    // Verifica si hay una página anterior (página actual es mayor que 1)
            if (json.comentarios.current_page > 1) {
                                    // Hay una página anterior, muestra el botón y prepara para la página anterior
                        botonCargarAnteriorNotificaciones.style.display = 'flex'; // Muestra el botón
                        botonCargarAnteriorNotificaciones.setAttribute('data-pagina-anterior', json.comentarios.current_page - 1); // Establece la página anterior
                                    
                                    // Asegúrate de que el botón carga la página anterior cuando se hace clic
                                    botonCargarAnteriorNotificaciones.onclick = () => {
                                        getNotificaciones(json.comentarios.current_page - 1);
                                    };
                } else {
                        // No hay una página anterior (estás en la primera página), oculta el botón
                        botonCargarAnteriorNotificaciones.style.display = 'none';
            }
       

    } else {
        // Manejo del caso en que no hay comentarios o el JSON no es válido
        contenedor.innerHTML = '<p>No hay comentarios para mostrar.</p>';
    }
}
/*getNotificaciones().then(json => console.log(json));*/
getNotificaciones();
</script>