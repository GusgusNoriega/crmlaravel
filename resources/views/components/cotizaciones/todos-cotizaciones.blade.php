
<div class="container-elementos">
   
    <!-- Filtros -->
   <div class="div-abrir-filtros">
       <button class="button abrir-filtros" id="abrir-filtros">
           <span><svg viewBox="-1.7 0 20.4 20.4" xmlns="http://www.w3.org/2000/svg" class="cf-icon-svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M16.417 10.283A7.917 7.917 0 1 1 8.5 2.366a7.916 7.916 0 0 1 7.917 7.917zm-6.804.01 3.032-3.033a.792.792 0 0 0-1.12-1.12L8.494 9.173 5.46 6.14a.792.792 0 0 0-1.12 1.12l3.034 3.033-3.033 3.033a.792.792 0 0 0 1.12 1.119l3.032-3.033 3.033 3.033a.792.792 0 0 0 1.12-1.12z"></path></g></svg></span>
           Abrir filtros
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"/></svg>
       </button>
   </div>
   <div class="filtros-principales" id="filtros-principales">
       <div>
           <h2>Filtros</h2>
           <div class="seccion-filtro">
               <h3>Nombre</h3>
               <input type="text" id="searchTerm" placeholder="Nombre...">
           </div>
          
           <div class="seccion-filtro">
               <h3>Fecha de creación desde</h3>
               <input type="date" id="fechaDesde">
           </div>

           <div class="seccion-filtro">
               <h3>Fecha de creación hasta</h3>
               <input type="date" id="fechaHasta">
           </div>

           <div class="seccion-filtro">
              <x-user-select-vendedor select-id="user-4"/>
           </div>

           <div class="seccion-filtro200">
                <x-buscador-empresa id-principal="empresaFiltro" nombre="empresas" cantidad="1"/>
            </div>

           <div class="seccion-filtro">
               <button class="button button-buscar" onclick="cargarCotizaciones()">
                   Buscar
                   <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"/></svg>
               </button>
           </div>

       </div>
   </div>

   <!-- Contenedor para los resultados -->
   <div class="resultados-generales-elementos" id="resultadosElementos"></div>
   <div class="container-botones-sisguiente-anterior">
       <button type="button" class="button" id="boton-cargar-anterior" data-pagina-anterior="" style="display: none;">
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M177.5 414c-8.8 3.8-19 2-26-4.6l-144-136C2.7 268.9 0 262.6 0 256s2.7-12.9 7.5-17.4l144-136c7-6.6 17.2-8.4 26-4.6s14.5 12.5 14.5 22l0 72 288 0c17.7 0 32 14.3 32 32l0 64c0 17.7-14.3 32-32 32l-288 0 0 72c0 9.6-5.7 18.2-14.5 22z"/></svg>
           pagina anterior
       </button>
       <button type="button" class="button" id="boton-cargar-elementos" data-pagina-siguiente="" style="display: none;">
           pagina siguiente
           <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M334.5 414c8.8 3.8 19 2 26-4.6l144-136c4.8-4.5 7.5-10.8 7.5-17.4s-2.7-12.9-7.5-17.4l-144-136c-7-6.6-17.2-8.4-26-4.6s-14.5 12.5-14.5 22l0 72L32 192c-17.7 0-32 14.3-32 32l0 64c0 17.7 14.3 32 32 32l288 0 0 72c0 9.6 5.7 18.2 14.5 22z"/></svg>
       </button>
   </div>
       <script>
           document.addEventListener("DOMContentLoaded", function() {
               // Cuando el documento esté cargado completamente.
               var boton = document.getElementById('abrir-filtros');
               var filtros = document.getElementById('filtros-principales');
   
               boton.addEventListener('click', function() {
                   boton.classList.toggle('active');
                   if(filtros.style.height === '0px' || filtros.style.height === '') {
                       // Si está cerrado, establecer la altura al contenido interno.
                       filtros.style.height = filtros.scrollHeight + 'px';
                   } else {
                       // Si está abierto, cerrar de nuevo.
                       filtros.style.height = '0';
                   }
               });
           });
   
           function cargarCotizaciones(page = 1) {
                   const searchTerm = document.getElementById('searchTerm').value;
                   const fechaDesde = document.getElementById('fechaDesde').value;
                   const fechaHasta = document.getElementById('fechaHasta').value;
                   const usuarioActual = document.getElementById('user-4').value;
                   
  
                   // Prepara los datos a enviar
                   const data = {
                       page: page,
                       search: searchTerm,
                       desde: fechaDesde,
                       hasta: fechaHasta,
                       usuario: usuarioActual,
                   };
   
                   // Configura la solicitud AJAX
                   fetch('/admin/cotizaciones/get', { // Cambia esto por la URL real
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
                       const contenedor = document.getElementById('resultadosElementos');
                       contenedor.innerHTML = ''; // Limpia los resultados anteriores
                       console.log(data);
                       data.elementos.data.forEach(elemento => {
                           // Suponiendo que 'elemento' tiene una propiedad 'name'
                           const rutaImagenUser = elemento.user && elemento.user.image_id ? '<img src="http://sistema3.test/storage/' + elemento.user.image.ruta + '" alt="">' : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path></svg>';
                           const rutaUser = elemento.user ? '<div class="container-seccion-usuario"><div class="elemento-user-image">' + rutaImagenUser + '</div><div class="elemento-user-name"><span>Vendedor</span><p>' + elemento.user.name + '</p></div></div>' : '';
                    
                           const rutaImagenCliente = elemento.cliente && elemento.cliente.imagen_destacada ? '<img src="http://sistema3.test/storage/' + elemento.cliente.imagen_destacada.ruta + '" alt="">' : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"></path></svg>';
                           const rutaCliente = elemento.cliente ? '<div class="container-seccion-usuario"><div class="elemento-user-image">' + rutaImagenCliente + '</div><div class="elemento-user-name"><span>Cliente</span><p>' + elemento.cliente.name + '</p></div></div>' : '';
                           const fechaCotizacion = elemento.fecha_cotizacion; // Tu fecha en formato "YYYY-MM-DD"
                           const anoCotizacion = new Date(fechaCotizacion).getFullYear();
                          
                           contenedor.innerHTML += `<div>
                                                      <div>

                                                           <div class="container-seccion-elemento">
                                                               <p>Nro de cotizacion</p>
                                                               <div><p>${elemento.misempresa.alias}-00${elemento.nro_cotizacion}-${anoCotizacion}<p></div>
                                                           </div>

                                                           <div class="container-seccion-elemento">
                                                               <p>Fecha de cotizacion</p>
                                                               <div><p>${elemento.fecha_cotizacion}<p></div>
                                                           </div>

                                                           <div class="container-seccion-elemento">
                                                               <p>Fecha de vencimiento</p>
                                                               <div><p>${elemento.fecha_vencimiento}</p></div>
                                                           </div>

                                                           ${rutaUser}

                                                           ${rutaCliente}

                                                           <div class="container-seccion-elemento">
                                                               <p>Total</p>
                                                               <div><p>${elemento.moneda.symbol} ${elemento.total}</p></div>
                                                           </div>
                                                                                                                                  
                                                           <div class="container-seccion-elemento">
                                                             <a href="http://sistema3.test/admin/cotizaciones/${elemento.id}" class="ver-elemento-individual">Ver Cotizacion</a>
                                                           </div>

                                                       </div>
                                                    </div>`; // Agrega cada elemento al contenedor
                       });
                       const botonCargar = document.getElementById('boton-cargar-elementos');
                       if (data.elementos.current_page < data.elementos.last_page) {
                           // No es la última página, muestra el botón y prepara para la próxima página
                           botonCargar.style.display = 'flex'; // Muestra el botón
                           botonCargar.setAttribute('data-pagina-siguiente', data.elementos.current_page + 1); // Establece la próxima página
                           
                           // Asegúrate de que el botón carga la próxima página cuando se hace clic
                           botonCargar.onclick = () => {
                               cargarCotizaciones(data.elementos.current_page + 1);
                           };
                       } else {
                           // Es la última página, oculta el botón
                           botonCargar.style.display = 'none';
                       }
   
                       const botonCargarAnterior = document.getElementById('boton-cargar-anterior');
       
                       // Verifica si hay una página anterior (página actual es mayor que 1)
                       if (data.elementos.current_page > 1) {
                           // Hay una página anterior, muestra el botón y prepara para la página anterior
                           botonCargarAnterior.style.display = 'flex'; // Muestra el botón
                           botonCargarAnterior.setAttribute('data-pagina-anterior', data.elementos.current_page - 1); // Establece la página anterior
                           
                           // Asegúrate de que el botón carga la página anterior cuando se hace clic
                           botonCargarAnterior.onclick = () => {
                               cargarCotizaciones(data.elementos.current_page - 1);
                           };
                       } else {
                           // No hay una página anterior (estás en la primera página), oculta el botón
                           botonCargarAnterior.style.display = 'none';
                       }
                       
                   })
                   .catch(error => {
                       console.error('Error al cargar los elementos:', error);
                   });
           }
   
           
   
   
           cargarCotizaciones();
       </script>
   </div>