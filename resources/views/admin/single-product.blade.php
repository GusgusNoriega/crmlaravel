<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">

<div class="container-elemento-producto">

  

    @if($producto->tipo == 2)
   
            @php   
                $botonVolver = '<a class="button button-volver" href="http://sistema3.test/admin/servicios">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                                     Volver a servicios
                                </a>';
            @endphp
    @else  
    
            @php  
                $botonVolver = '<a class="button button-volver" href="http://sistema3.test/admin/productos">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M9.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.2 288 416 288c17.7 0 32-14.3 32-32s-14.3-32-32-32l-306.7 0L214.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>
                                    Volver a productos
                                </a>';
            @endphp
      
    @endif

    {{!! $botonVolver !!}}
    <div class="container-elemento-producto-div">
        <div class="container-elemento-producto-div-left">
           
            <h1>{{ $producto->title }}</h1>
            @php
                $imagenPorDefecto = 'http://sistema3.test/storage/imagen_por_defecto.jpg';
                $listaImagenes = '';
            @endphp

            @if($producto->galeria && $producto->galeria->images->count() > 0)
                @foreach ($producto->galeria->images as $imagen)
               
                @php
                    // Agregar la URL de la imagen a la lista
                    $listaImagenes .= 'http://sistema3.test/storage/' . $imagen->ruta;

                    // Si no es la última imagen, agregar una coma
                    if (!$loop->last) {
                        $listaImagenes .= ',';
                    }
                   
                @endphp
                @endforeach
            @endif
            
            <x-productos.slider imagen-principal="{{ $producto->imagenDestacada ? 'http://sistema3.test/storage/' . $producto->imagenDestacada->ruta : $imagenPorDefecto }}" :imagenes="$listaImagenes" />

            @php
                $htmlContent = '';
                if ($producto->description) {
                    // Decodificar entidades HTML antes de procesar
                    $description = html_entity_decode($producto->description);
                    
                    // Eliminar espacios blancos redundantes entre etiquetas
                    $htmlContent = preg_replace('/\s+/', ' ', $description);
                    
                    // Eliminar etiquetas <p> vacías o con espacios en blanco/&nbsp;
                    $htmlContent = preg_replace('/<p>(\s|&nbsp;)*<\/p>/', '', $htmlContent);
                }
                if($producto->description) {
                    echo '<div class="seccion-contenido-elemento">
                            <h2 class="titulo-objeto">DESCRIPCION</h2>
                            ' . $htmlContent . '</div>';
                }
            @endphp

            @if($producto->cont_envio)
                <div class="seccion-contenido-elemento">
                    <h2 class="titulo-objeto">CONTENIDO DE ENVIO</h2>
                    {!! $producto->cont_envio !!}
                </div>
            @endif

            @if($producto->datos_tecnicos)
                <div class="seccion-contenido-elemento">
                    <h2 class="titulo-objeto">DATOS TECNICOS</h2>
                    {!! $producto->datos_tecnicos !!}
                </div>
            @endif

        </div>
        <div class="container-elemento-producto-div-right" id="resultadosElementos">

            <button class="button-update-elemento" data-update-elemento="{{ $producto->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path></svg>
            </button>

            <button class="button-delete-elemento" data-delete-elemento="{{ $producto->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path></svg>
            </button>

            <div class="seccion-contenido-elemento">
                <h2 class="titulo-objeto">PRECIO</h2>
                <p>{{ $producto->monedaRelacionada->symbol }} {{ $producto->precio }}</p>
            </div>

            <div class="seccion-contenido-elemento">
                <h2 class="titulo-objeto">SKU</h2>
                <p>{{ $producto->sku }}</p>
            </div>

            <div class="seccion-contenido-elemento">
                <h2 class="titulo-objeto">MODELO</h2><!-- modelo -->
                <p>{{ $producto->modelo }}</p>
            </div>

            <div class="seccion-contenido-elemento">
                <h2 class="titulo-objeto">MONEDA</h2>
                <p>{{ $producto->monedaRelacionada->code }} {{ $producto->monedaRelacionada->symbol }}</p>
            </div>

                    @if($producto->marcas && $producto->marcas->count() > 0)
                        <div class="seccion-contenido-elemento2">
                            <h2 class="titulo-objeto">Marcas</h2>
                            <ul>
                                @foreach($producto->marcas as $marca)
                                    <li>{{ $marca->name }}</li> <!-- Reemplaza ia -->
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        
                    @if($producto->procedencias && $producto->procedencias->count() > 0)
                        <div class="seccion-contenido-elemento2">
                            <h2 class="titulo-objeto">Procedencias</h2>
                            <ul>
                                @foreach($producto->procedencias as $procedencia)
                                    <li>{{ $procedencia->name }}</li> <!-- Reemplaza 'nombre' con el campo real de tu modelo Categoria -->
                                @endforeach
                            </ul>
                        </div>
                    @endif
              
                    @if($producto->categorias && $producto->categorias->count() > 0)
                        <div class="seccion-contenido-elemento2">
                            <h2 class="titulo-objeto">CATEGORIAS</h2>
                            <ul>
                                 @foreach($producto->categorias as $categoria)
                                        <li>{{ $categoria->name }}</li> <!-- Reemplaza 'nombre' con el campo real de tu modelo Categoria -->
                                 @endforeach
                            </ul>
                        </div>
                    @endif
              
            @php
                $terminosPorTaxonomia = $producto->terminos->groupBy('taxonomia.id');
            @endphp
            
            @if($terminosPorTaxonomia->isNotEmpty())
            <div class="seccion-contenido-elemento2">
                <h2 class="titulo-objeto">TERMINOS Y TAXONOMIAS</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Taxonomía</th>
                            <th>Términos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($terminosPorTaxonomia as $taxonomiaId => $terminos)
                            <tr>
                                <td>{{ $terminos->first()->taxonomia->name }}</td><!--este es un comentario para el loop de laravel, se tiene que sesolver una variable-->
                                <td>
                                    {{ $terminos->implode('name', ', ') }} 
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
            @endif
              
        </div>
    </div>
<x-productos.update-productos />   
</div>
       
<x-todos-archivos />
</x-dynamic-component>