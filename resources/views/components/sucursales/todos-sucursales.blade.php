<div class="container-elementos container-elementos-clientes">
  
    <div class="div-abrir-filtros">
        <button class="button abrir-filtros" id="abrir-filtros2">
            <span><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></span>
            Abrir filtros
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
        </button>
    </div>
    <div class="filtros-principales" id="filtros-principales2">
        <div>
            <h2>Filtros</h2>
            <div class="seccion-filtro">
                <h3>Nombre</h3>
                <input type="text" id="searchTerm2" placeholder="Nombre...">
            </div>
            <div class="seccion-filtro">
                <h3>Fecha de creación desde</h3>
                <input type="date" id="fechaDesde2">
            </div>
            <div class="seccion-filtro">
                <h3>Fecha de creación hasta</h3>
                <input type="date" id="fechaHasta2">
            </div>
            <div class="seccion-filtro">
                <button class="button button-buscar" onclick="cargarElementosSucursales()">
                    Buscar
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
                </button>
            </div>
        </div>
    </div>
 
    <!-- Contenedor para los resultados -->
    <div class="resultados-generales-elementos" id="resultadosElementos2"></div>
    <div class="container-botones-sisguiente-anterior">
        <button type="button" class="button" id="boton-cargar-anterior2" data-pagina-anterior="" style="display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"/></svg>
            pagina anterior
        </button>
        <button type="button" class="button" id="boton-cargar-elementos2" data-pagina-siguiente="" style="display: none;">
            pagina siguiente
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M334.5 414c8.8 3.8 19 2 26-4.6l144-136c4.8-4.5 7.5-10.8 7.5-17.4s-2.7-12.9-7.5-17.4l-144-136c-7-6.6-17.2-8.4-26-4.6s-14.5 12.5-14.5 22l0 72L32 192c-17.7 0-32 14.3-32 32l0 64c0 17.7 14.3 32 32 32l288 0 0 72c0 9.6 5.7 18.2 14.5 22z"/></svg>
        </button>
    </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                // Cuando el documento esté cargado completamente.
                var boton2 = document.getElementById('abrir-filtros2');
                var filtros2 = document.getElementById('filtros-principales2');
    
                boton2.addEventListener('click', function() {
                    boton2.classList.toggle('active');
                    if(filtros2.style.height === '0px' || filtros2.style.height === '') {
                        // Si está cerrado, establecer la altura al contenido interno.
                        filtros2.style.height = filtros2.scrollHeight + 'px';
                    } else {
                        // Si está abierto, cerrar de nuevo.
                        filtros2.style.height = '0';
                    }
                });
            });
    
            function cargarElementosSucursales(page = 1) {
                    const searchTerm2 = document.getElementById('searchTerm2').value;
                    const fechaDesde2 = document.getElementById('fechaDesde2').value;
                    const fechaHasta2 = document.getElementById('fechaHasta2').value;
                    const elementoid = {{ $idElemento }};
                  
                    // Prepara los datos a enviar
                    const data = {
                        page: page,
                        search: searchTerm2,
                        desde: fechaDesde2,
                        hasta: fechaHasta2,
                        empresaId: elementoid
                    };
    
                    // Configura la solicitud AJAX
                    fetch('/admin/sucursales/get', { // Cambia esto por la URL real
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Asegúrate de tener un meta tag con tu CSRF token
                        },
                        body: JSON.stringify(data) // Convierte los datos a una cadena JSON
                    })
                    .then(response => response.json()) // Convierte la respuesta a JSON
                    .then(data => {        
                        // Aquí manejas la respuesta. Por ejemplo, actualizar el HTML con los resultados.
                        const contenedor2 = document.getElementById('resultadosElementos2');
                        contenedor2.innerHTML = ''; // Limpia los resultados anteriores
                        console.log(data);
                        data.elementos.data.forEach(elemento => {
                          
                            contenedor2.innerHTML += `<div>
                                                       <div>
                                                            <button class="button-update-elemento" data-update-elemento="${elemento.id}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path></svg>
                                                            </button>
                                                            <button class="button-delete-elemento" data-delete-elemento="${elemento.id}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path></svg>
                                                            </button>


                                                            <div class="container-seccion-elemento">
                                                                <p>name</p>
                                                                <div><p>${elemento.name}<p></div>
                                                            </div>

                                                            <div class="container-seccion-elemento">
                                                                <p>Direccion</p>
                                                                <div><p>${elemento.direccion}<p></div>
                                                            </div>
                                                            
                                                        </div>
                                                     </div>`; // Agrega cada elemento al contenedor
                        });

                        const botonCargar2 = document.getElementById('boton-cargar-elementos2');

                        if (data.elementos.current_page < data.elementos.last_page) {
                            // No es la última página, muestra el botón y prepara para la próxima página
                            botonCargar2.style.display = 'flex'; // Muestra el botón
                            botonCargar2.setAttribute('data-pagina-siguiente', data.elementos.current_page + 1); // Establece la próxima página
                            
                            // Asegúrate de que el botón carga la próxima página cuando se hace clic
                            botonCargar2.onclick = () => {
                                cargarElementosSucursales(data.elementos.current_page + 1);
                            };
                        } else {
                            // Es la última página, oculta el botón
                            botonCargar2.style.display = 'none';
                        }
    
                        const botonCargarAnterior2 = document.getElementById('boton-cargar-anterior2');
        
                        // Verifica si hay una página anterior (página actual es mayor que 1)
                        if (data.elementos.current_page > 1) {
                            // Hay una página anterior, muestra el botón y prepara para la página anterior
                            botonCargarAnterior2.style.display = 'flex'; // Muestra el botón
                            botonCargarAnterior2.setAttribute('data-pagina-anterior', data.elementos.current_page - 1); // Establece la página anterior
                            
                            // Asegúrate de que el botón carga la página anterior cuando se hace clic
                            botonCargarAnterior2.onclick = () => {
                                cargarElementosSucursales(data.elementos.current_page - 1);
                            };
                        } else {
                            // No hay una página anterior (estás en la primera página), oculta el botón
                            botonCargarAnterior2.style.display = 'none';
                        }
                        
                    })
                    .catch(error => {
                        console.error('Error al cargar los elementos:', error);
                    });
            }
    
            
    
    
            cargarElementosSucursales();
        </script>
    </div>