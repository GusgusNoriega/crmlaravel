
@php
    // Asegúrate primero de que ambas fechas no son null
    if ($cotizacion->fecha_cotizacion && $cotizacion->fecha_vencimiento) {
        // Calcula la diferencia en días entre las fechas
        $validez = $cotizacion->fecha_cotizacion->diffInDays($cotizacion->fecha_vencimiento);
        $textoValidez = "Válido hasta por {$validez} días";
    } else {
        $textoValidez = "Fechas no definidas";
    }
@endphp
<x-dynamic-component :component="Auth::check() ? 'appLayout' : 'guestlayout'">
    <h1>Cotizacion individual</h1>
     <div class="container-boton-cotizacion-pdf">
        <a class="boton-descargar-cotizacion" href="http://sistema3.test/admin/cotizaciones/pdf/{{ $cotizacion->id ?? '0' }}">Descargar cotizacion</a>
        <div class="container-elementos-completos-cotizaciones">
            <button id="abrir-editar-cotizacion" data-update-elemento="{{ $cotizacion->id ?? '0' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z"></path></svg>
            </button>
            <x-cotizaciones.update-cotizacion />
        </div>
         
     </div>
    <div class="cotizacion-individual-vista">
     <div class="container-elemento-cotizacion-div">
        <div class="container-elemento-cotizacion-div-borde">
  
        <img src="{{ encodeImageToBase64($cotizacion->misempresa->imagenLogo->ruta) }}" alt="">
        <div class="seccion-header-datos">
                <div>
                    <p class="texto-pdf"><strong>RUC: </strong>{{ $cotizacion->misempresa->ruc ?? 'N/A' }}</p>
                    <p class="texto-pdf"><strong>NUMERO DE COTIZACIÓN: </strong>{{ $cotizacion->misempresa->alias ?? 'N/A' }}-000{{ $cotizacion->nro_cotizacion ?? 'N/A' }}-{{ date('Y', strtotime($cotizacion->fecha_cotizacion)) }}</p>
                </div>
        </div>
        <div class="seccion-header-datos">
            <div>
    
                <div>
                    <p class="texto-pdf"><strong>ASESOR COMERCIAL: </strong>{{ $cotizacion->user->name ?? 'N/A' }}</p>
                    <p class="texto-pdf"><strong>CLIENTE: </strong>{{ $cotizacion->cliente->empresa->name ?? $cotizacion->cliente->name ?? 'N/A' }}</p>
                </div>
    
                <div>
                    <p class="texto-pdf"><strong>TELEFONO: </strong>{{ $cotizacion->user->telefono ?? 'N/A' }}</p>
                    <p class="texto-pdf"><strong>CONTACTO: </strong>{{ $cotizacion->cliente->name ?? 'N/A' }}</p>
                </div>
    
                <div>
                    <p class="texto-pdf"><strong>CORREO: </strong>{{ $cotizacion->user->email ?? 'N/A' }}</p>
                    <p class="texto-pdf"><strong>CORREO: </strong>{{ $cotizacion->cliente->email ?? 'N/A' }}</p>
                </div>
    
                <div>
                    <p class="texto-pdf"><strong>FECHA: </strong>{{ $cotizacion->fecha_cotizacion ? $cotizacion->fecha_cotizacion->format('d/m/Y') : 'N/A' }}</p>
                    <p class="texto-pdf"><strong>TELEFONO: </strong>{{ $cotizacion->cliente->telefono ?? 'N/A' }}</p>
                </div>
    
                <div>
                    <p class="texto-pdf"><strong>VALIDEZ: </strong>{{ $textoValidez ?? 'N/A' }}</p>
                    <p class="texto-pdf"><strong>RUC: </strong>{{ $cotizacion->cliente->empresa->ruc ?? $cotizacion->cliente->ruc ?? 'N/A' }}</p>
                </div>
                
            </div>
        </div>

 
@if($cotizacion->products && $cotizacion->products->count() > 0)
    @foreach($cotizacion->products as $product)

    @php
        if($product->description) {
            $htmlContent = html_entity_decode($product->description); // Asume que esto es tu HTML

            $dom = new DOMDocument();
            @$dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $paragraphs = $dom->getElementsByTagName('p');

            for ($i = $paragraphs->length - 1; $i >= 0; $i--) {
                $p = $paragraphs->item($i);
                if (!$p->hasChildNodes() || preg_match('/^(\s|&nbsp;)*$/', $dom->saveHTML($p))) {
                    $p->parentNode->removeChild($p);
                }
            }

            // Guarda el HTML limpio
            $htmlContent = $dom->saveHTML();

            // Eliminar espacios en blanco redundantes entre etiquetas HTML
            $htmlContent = preg_replace('/>\s+</', '><', $htmlContent);
        }
        if($product->datos_tecnicos) {
            $htmlContent2 = html_entity_decode($product->datos_tecnicos);
            $htmlContent2 = preg_replace('/\s+/', ' ', $htmlContent2);
            $htmlContent2 = preg_replace('/<p>([\s\x{00A0}]|&nbsp;)*<\/p>/u', '', $htmlContent2);
        }
        if($product->cont_envio) {
            $htmlContent3 = html_entity_decode($product->cont_envio);
            $htmlContent3 = preg_replace('/\s+/', ' ', $htmlContent3);
            $htmlContent3 = preg_replace('/<p>([\s\x{00A0}]|&nbsp;)*<\/p>/u', '', $htmlContent3);
        }
      @endphp
          <div class="imagen-con-titulo">
            <h2 class="titulo-producto">{{ $product->title }}</h2>
            <img class="imagen-destacada-productos" src="{{ encodeImageToBase64($product->imagendestacada->ruta) }}" alt="">
          </div>
          @php
            if($product->description) {
                echo '<h3 class="productos-dascripciones">Descripcion: </h3>';
                echo  $htmlContent;
            }
            if($product->datos_tecnicos) {
                echo '<h3 class="productos-dascripciones">Datos tecnicos: </h3>';
                echo  $htmlContent2;
            }
            if($product->cont_envio) {
                echo '<div class="imagen-con-titulo"><h3 class="productos-dascripciones">Contenido de envio: </h3>';
                echo  $htmlContent3; 
                echo '</div>';
            }
          @endphp

           
            <!-- Añade más campos según sea necesario -->
    @endforeach
@else
    <p>No hay productos asociados a esta cotización.</p>
@endif

    <h2 class="titulo-totales">RESUMEN Y TOTALES</h2>

    @if($cotizacion->products && $cotizacion->products->count() > 0)
    <table class="tabla-atributos">  
        <thead>
            <tr>
                <th colspan="4" style="width: 100%; text-align: center; background-color: #10103a; color: #fff;">PRODUCTOS</th>
            </tr>
            <tr>
                <th style="width: 60%;">Producto</th>
                <th style="width: 15%; text-align: center;">Precio</th>
                <th style="width: 10%; text-align: center;">Cantidad</th>
                <th style="width: 15%; text-align: center;">total</th>
                <!-- Añade más columnas según sea necesario -->
            </tr>
        </thead>
        <tbody>
            @php 
                $totalGeneralProductos = 0;
                $nombresDeMarcas = [];
                $nombresDeModelos = [];
                $nombresProcedencias = [];
             @endphp
            @foreach($cotizacion->products as $product)
            
                @php
                    // Determinar el precio final considerando el descuento si existe
                    $precioFinal = $product->pivot ? $product->pivot->precio_final : 0;
                    $descuento = $product->pivot && $product->pivot->precio_descuento !== null ? $product->pivot->precio_descuento : 0;
                    $cantidad = $product->pivot ? $product->pivot->cantidad : 0;

                    // Aplicar descuento si existe
                    $precioConDescuento = $descuento > 0 ? $descuento : $precioFinal;

                    // Calcular el total
                    $totalProductos = $precioConDescuento * $cantidad;
                    $totalGeneralProductos += $totalProductos;

                    if ($product->marcas && $product->marcas->count() > 0) {
                        foreach ($product->marcas as $marca) {
                            // Asegura que la marca tenga un nombre antes de agregarlo al arreglo.
                            if (!isset($nombresDeMarcas[$marca->name])) {
                                $nombresDeMarcas[$marca->name] = $marca->name;
                            }
                        }
                    }

                    if ($product->procedencias && $product->procedencias->count() > 0) {
                        foreach ($product->procedencias as $procedencia) {
                            // Asegura que la marca tenga un nombre antes de agregarlo al arreglo.
                            if (!isset($nombresProcedencias[$procedencia->name])) {
                                $nombresProcedencias[$procedencia->name] = $procedencia->name;
                            }
                        }
                    }

                    if ($product->modelo) {
                        // Agrega el nombre de la marca al arreglo si aún no está presente.
                        $nombresDeModelos[$product->modelo] = $product->modelo;
                    }
                @endphp
                <tr>
                    <td style="width: 60%;">{{ $product->title }}</td>
                    <td style="width: 15%; text-align: center;">{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ number_format($precioConDescuento, 2) }}</td>
                    <td style="width: 10%; text-align: center;">{{ $cantidad }}</td>
                    <td style="width: 15%; text-align: center;">{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ number_format($totalProductos, 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total productos</strong></td>
                <td style="text-align: center; background-color: rgba(255, 0, 0, 0.185);"><strong>{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ number_format($totalGeneralProductos, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
    @endif

    @php
        // Decodificar el JSON. Asegúrate de reemplazar $tuVariableJson con la variable real que contiene el JSON
        $nombresDeMarcasString = implode(', ', $nombresDeMarcas);
        $nombresDeModelosString = implode(', ', $nombresDeModelos);
        $nombresProcedenciasString = implode(', ', $nombresProcedencias);

        $adicionales = json_decode($cotizacion->adicionales, true);
        $totalGeneralAdicionales = 0;
    @endphp

    @if($adicionales && count($adicionales) > 0)
    <table class="tabla-atributos">
        <thead>
            <tr>
                <th colspan="4" style="width: 100%; text-align: center; background-color: #10103a; color: #fff;">ADICIONALES</th>
            </tr>
            <tr>
                <th style="width: 60%;" >Título</th>
                <th style="width: 15%; text-align: center;" >Precio</th>
                <th style="width: 10%; text-align: center;" >Cantidad</th>
                <th style="width: 15%; text-align: center;" >Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($adicionales as $adicional)
            @php
            $totalGeneralAdicionales += $adicional['total'];
            @endphp
                <tr>
                    <td style="width: 60%;">{{ $adicional['titulo'] }}</td>
                    <td style="width: 15%; text-align: center;" >{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ number_format($adicional['precio'], 2) }}</td>
                    <td style="width: 10%; text-align: center;" >{{ $adicional['cantidad'] }}</td>
                    <td style="width: 15%; text-align: center;" >{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ number_format($adicional['total'], 2) }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3"><strong>Total adicionales</strong></td>
                <td style="text-align: center; background-color: rgba(255, 0, 0, 0.185);"><strong>{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ number_format($totalGeneralAdicionales, 2) }}</strong></td>
            </tr> 
        </tbody>
    </table>
    @endif


    @php
        // Asumiendo que $totalGeneralAdicionales y $totalGeneralProductos ya están definidos y son numéricos
        $subTotal = $totalGeneralAdicionales + $totalGeneralProductos;

        // Calcular el IGV como el 18% del subtotal
        $igv = $subTotal * 0.18;

        // Calcula el total sumando el IGV al subtotal
        $total = $subTotal + $igv;

        // Asegurar que ambos, subtotal, IGV, y el total, tengan solo dos decimales
        $subTotal = number_format($subTotal, 2, '.', '');
        $igv = number_format($igv, 2, '.', '');
        $total = number_format($total, 2, '.', '');
    @endphp
<!-- Contenido -->

    <table class="tabla-atributos">
       
        <thead>
            <tr>
                <th colspan="3" style="width: 100%; text-align: center; background-color: #10103a; color: #fff;">TOTALES</th>
            </tr>
            <tr>
                <th colspan="1" style="text-align: center;">SUBTOTAL</th>
                <th colspan="1" style="text-align: center;">IGV (18%)</th>
                <th colspan="1" style="text-align: center;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="1" style="text-align: center;">{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ $subTotal }}</td>
                <td colspan="1" style="text-align: center; background-color: rgba(0, 153, 255, 0.185);">{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ $igv }}</td>
                <td colspan="1" style="text-align: center; background-color: rgba(255, 0, 0, 0.185);"><strong>{{ $cotizacion->moneda->symbol ?? 'N/A' }} {{ $total }}</strong></td>
            </tr>
        </tbody>
    </table>


    <div class="imagen-con-titulo">
        <div class="relleno-cotizacion"></div>
        <div class="final-cotizacion">
            <img class="cotizacion-imagen-sello" src="{{ encodeImageToBase64($cotizacion->misempresa->imagensello->ruta) }}" alt="">
            <p class="parrafo-inferior-cotizacion-nombre"><strong>{{ $cotizacion->user->name ?? 'N/A' }}</strong></p>
            <p class="parrafo-inferior-cotizacion-cargo"><strong>{{ $cotizacion->user->cargo ?? 'N/A' }}</strong></p>
            
            <p class="parrafo-inferior-cotizacion"><strong>Marcas:</strong> {{ $nombresDeMarcasString ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>Modelos:</strong> {{ $nombresDeModelosString ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>Procedencias:</strong> {{ $nombresProcedenciasString }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>Entrega:</strong> {{ $cotizacion->entrega ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>Lugar de entrega:</strong> {{ $cotizacion->lugar_entrega ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>Garantia:</strong> {{ $cotizacion->garantia ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>Forma de pago:</strong> {{ $cotizacion->forma_de_pago ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>Despacho:</strong> A TODO EL PERU Y LATINOAMERICA</p>
            <p class="parrafo-inferior-cotizacion"><strong>N° DE CUENTA SOLES:</strong> {{ $cotizacion->misempresa->cuenta_soles ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>N° DE CUENTA DOLARES:</strong> {{ $cotizacion->misempresa->cuenta_dolares ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>N° DE CUENTA DETRACCIÓN:</strong> {{ $cotizacion->misempresa->cuenta_nacion ?? 'N/A' }}</p>
            <p class="parrafo-inferior-cotizacion"><strong>PROVEEDOR DEL ESTADO PERUANO:</strong> REGISTRO VENTAS Y SERVICIOS EN LA OSCE</p>
        </div>
    </div> 

  </div> 
 </div>
</div>
</x-dynamic-component>