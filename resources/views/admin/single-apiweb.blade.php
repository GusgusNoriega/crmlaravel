<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">
    <div class="single-taxonomia">
      <a class="button button-volver" href="http://sistema3.test/admin/apis">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
        Volver a todas las apis
      </a>
       <h1 class="{{ $apiweb->id }}">{{ $apiweb->name }}</h1>
       <div class="apiweb informacion">
         <h2>terminos de {{ $apiweb->name }}</h2>
         <button class="button" id="cargarProductos">Cargar Productos</button>
       </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
          document.getElementById('cargarProductos').addEventListener('click', function() {
              var apiwebId = '{{ $apiweb->id }}'; // Asegúrate de que este valor se imprime correctamente en el HTML generado por Laravel
              var baseUrl = `http://sistema3.test/admin/apis/producto/pagina/${apiwebId}/`;
              var paginaActual = 1;
                    
              var cargarPagina = function(pagina) {
                  fetch(baseUrl + pagina)
                      .then(response => response.json())
                      .then(data => {
                        var totalPaginas = parseInt(data.total_paginas, 10); // Convertir a número
                        paginaActual = parseInt(data.pagina_actual, 10); // Convertir a número
                          // Procesa los datos recibidos, por ejemplo, mostrando los productos
                          if (paginaActual < totalPaginas) {
                              cargarPagina(paginaActual + 1);
                          }
                      })
                      .catch(error => console.error('Error al cargar los productos:', error));
              };
              cargarPagina(paginaActual);
          });
    });
    </script>
</x-dynamic-component>