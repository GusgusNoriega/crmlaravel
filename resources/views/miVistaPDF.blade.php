@php
    // Asegúrate primero de que ambas fechas no son null
    if ($cotizacion->fecha_cotizacion && $cotizacion->fecha_vencimiento) {
        // Calcula la diferencia en días entre las fechas
        $validez = $cotizacion->fecha_cotizacion->diffInDays($cotizacion->fecha_vencimiento);
        $textoValidez = "Válido hasta por {$validez} días";
    } else {
        $textoValidez = "Fechas no definidas";
    }

    $email = $cotizacion->cliente->email ?? 'N/A';
    foreach (range(1, 10) as $number) {
        $email = str_ireplace("-delta{$number}", '', $email);
    }

 
    
@endphp


<!DOCTYPE html>
<html>
<head>
    <style>
        @page { 
            margin: 25px 25px; 
        }
       
        .page-break {
            page-break-before: always;
            position: relative;
        }
        body{
            border: solid 2px rgb(16, 16, 58);
            border-radius: 8px;
            padding: 20px;
            font-family: 'Helvetica', sans-serif;
        }
        img{
            width: 100%;
            height: auto;
        }
        img.imagen-destacada-productos {
            width: 50%;
            max-height: 900px;
            display: block;
            margin-left: 25%;
        }
        img.cotizacion-imagen-sello {
            width: 30%;
            margin-bottom: 10px;
        }
        .seccion-header-datos {
           border-bottom: solid 1px rgb(16, 16, 58);
           padding-top: 5px; 
        }

        .texto-pdf {
            font-size: 9pt;
        }
        .imagen-con-titulo {
            page-break-before: auto; /* O 'always' para forzar el inicio en una nueva página */
            page-break-inside: avoid; /* Intenta evitar cortes dentro del div */
            page-break-after: auto;  
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Elimina el espacio entre bordes */
            margin-top: 20px; /* Espacio antes de la tabla, ajusta según necesidad */
            font-family: Arial, sans-serif; /* Fuente más similar a Excel */
        }
        table, th, td {
            border: 1px solid black; /* Define el borde de la tabla y celdas */
            font-size: 8pt;
        }
        th, td {
            text-align: left; /* Alineación del texto en las celdas */
            padding: 5px; /* Espaciado interno en las celdas */
        }
        th {
            font-weight: bold; /* Hace que el texto de los encabezados sea negrita */
        }
        /*tabla de atributos de productos*/
        .tabla-atributos {
            width: 100%; /* Ajusta al ancho completo */
            border-collapse: collapse; /* Elimina el espacio entre bordes */
            margin-top: 20px; /* Espacio antes de la tabla, ajusta según necesidad */
            font-family: Arial, sans-serif; /* Fuente más similar a Excel */
        }

        .tabla-atributos, .tabla-atributos th, .tabla-atributos td {
            border: 1px solid black; /* Define el borde de la tabla y celdas */
            font-size: 8pt;
        }

        .tabla-atributos th, .tabla-atributos td {
            text-align: left; /* Alineación del texto en las celdas */
            padding: 5px; /* Espaciado interno en las celdas */
        }

        .tabla-atributos th {
             /* Color de fondo para los encabezados, similar a Excel */
            font-weight: bold; /* Hace que el texto de los encabezados sea negrita */
        }
    
        /*tabla header de datos*/
        .tabla-header {
            border-collapse: collapse; /* Elimina el espacio entre bordes */
            margin-top: 0;
        }
        table.tabla-header, .tabla-header th, .tabla-header td {
            border: none; /* Define el borde de la tabla y celdas */
            font-size: 8pt;
        }
        .tabla-header th, .tabla-header td {
            text-align: left; /* Alineación del texto en las celdas */
            padding: 0px; /* Espaciado interno en las celdas */
        }
        /*final tabla header de datos*/
        h2.titulo-producto {
            text-align: center;
            padding: 5px;
            background-color: rgb(16, 16, 58);
            color: #fff;
            border-radius: 100px;
            font-size: 13pt;
        }
        h2.titulo-totales {
            text-align: center;
            padding: 5px;
            background-color: red;
            color: #fff;
            border-radius: 100px;
            margin: 0;
            font-size: 12pt;
        }
        .productos-dascripciones {
            color: red;
            font-size: 13pt;
            margin-top: 20px; 
            margin-bottom: 10px;
        }
        p {
            margin-bottom: 20px;
            margin-top: 20px; 
        }
        p.parrafo-inferior-cotizacion {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            width: 95%;
        }
        .parrafo-inferior-cotizacion-cargo {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            margin-bottom: 20px; 
        }
        .parrafo-inferior-cotizacion-nombre {
            margin: 0;
            padding: 0;
            font-size: 8pt;
        }
        .final-cotizacion {
            position: absolute;
            width: 100%;
            bottom: 20px;
        }
        .relleno-cotizacion {
            height: 300pt;
            width: 100%;
            background-color: rgba(255, 255, 255, 0);
        }
        .nro-cotizacion-color {
            color: rgb(255, 0, 0);
            margin: 0!important;
            padding: 0!important;
            width: 100%;
        }
        .nro-cotizacion-color strong {
            color: #000;
        }
    </style>
</head>
<body>
    
   
    <img src="{{ encodeImageToBase64($cotizacion->misempresa->imagenLogo->ruta) }}" alt="">

    <div class="seccion-header-datos">
        <table class="tabla-header" style="width: 100%;">
            <tr>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>RUC: </strong>{{ $cotizacion->misempresa->ruc ?? 'N/A' }}</td>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><p class="nro-cotizacion-color"><strong>NUMERO DE COTIZACIÓN: </strong>{{ $cotizacion->misempresa->alias ?? 'N/A' }}-000{{ $cotizacion->nro_cotizacion ?? 'N/A' }}-{{ date('Y', strtotime($cotizacion->fecha_cotizacion)) }}</p></td>
            </tr>
        </table>
    </div>
    <div class="seccion-header-datos">
        <table class="tabla-header" style="width: 100%;">

            <tr>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>ASESOR COMERCIAL: </strong>{{ $cotizacion->user->name ?? 'N/A' }}</td>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>CLIENTE: </strong>{{ $cotizacion->cliente->empresa->name ?? $cotizacion->cliente->name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>TELEFONO: </strong>{{ $cotizacion->user->telefono ?? 'N/A' }}</td>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>CONTACTO: </strong>{{ $cotizacion->cliente->name ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>CORREO: </strong>{{ $cotizacion->user->email ?? 'N/A' }}</td>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>CORREO: </strong>{{ $email }}</td>
            </tr>

            <tr>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>FECHA: </strong>{{ $cotizacion->fecha_cotizacion ? $cotizacion->fecha_cotizacion->format('d/m/Y') : 'N/A' }}</td>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>TELEFONO: </strong>{{ $cotizacion->cliente->telefono ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td class="texto-pdf" style="width: 50%; text-align: left;"><strong>VALIDEZ: </strong>{{ $textoValidez ?? 'N/A' }}</td>
                <td class="texto-pdf" style="width: 50%; text-align: left;">
                    <strong>
                        @if($cotizacion->cliente->tipo == 'empleado')
                            RUC:
                        @elseif($cotizacion->cliente->tipo == 'particular')
                            RUC/DNI:
                        @else
                            RUC:
                        @endif 
                    </strong>
                    {{ $cotizacion->cliente->empresa->ruc ?? $cotizacion->cliente->ruc ?? 'N/A' }}
                </td>
            </tr>
            
        </table>
    </div>

    @if($cotizacion->products && $cotizacion->products->count() > 0)
        @foreach($cotizacion->products as $product)

            @php
                   if($product->description) {
                        // Paso 1: Eliminar espacios blancos redundantes entre etiquetas
                        $htmlContent = html_entity_decode($product->description);
                        $htmlContent = preg_replace('/\s+/', ' ', $htmlContent);
                        $htmlContent = preg_replace('/<p>(\s|&nbsp;)*<\/p>/', '', $htmlContent);
                    }
                    if($product->datos_tecnicos) {
                        $htmlContent2 = html_entity_decode($product->datos_tecnicos);
                        $htmlContent2 = preg_replace('/\s+/', ' ', $htmlContent2);
                        $htmlContent2 = preg_replace('/<p>(\s|&nbsp;)*<\/p>/', '', $htmlContent2);
                    }
                    if($product->cont_envio) {
                        $htmlContent3 = html_entity_decode($product->cont_envio);
                        $htmlContent3 = preg_replace('/\s+/', ' ', $htmlContent3);
                        $htmlContent3 = preg_replace('/<p>(\s|&nbsp;)*<\/p>/', '', $htmlContent3);
                    }
            @endphp

              <div class="imagen-con-titulo">
                <h2 class="titulo-producto">{{ $product->title }}</h2>
                <img class="imagen-destacada-productos" src="{{ encodeImageToBase64($product->imagendestacada->ruta) }}" alt="">
              </div>
              @php
                if($product->description) {
                    echo '<h3 class="productos-dascripciones">Descripcion: </h3>'; 
                    echo $htmlContent;
                }
                if($product->datos_tecnicos) {
                    echo '<h3 class="productos-dascripciones">Datos tecnicos: </h3>';
                    echo $htmlContent2;
                }
                if($product->cont_envio) {
                    echo '<div class="imagen-con-titulo"><h3 class="productos-dascripciones">Contenido de envio: </h3>';
                    echo $htmlContent3;
                    echo  '</div>';
                }

                @endphp
        @endforeach
    @else
        <p>No hay productos asociados a esta cotización.</p>
    @endif
   
   
    <!-- Segundo div, forzará el inicio en una nueva página -->
    <div class="page-break">
        <h2 class="titulo-totales">RESUMEN Y TOTALES</h2>

        @if($cotizacion->products && $cotizacion->products->count() > 0)
        <table class="tabla-atributos">
            <tr>
                <th colspan="4" style="width: 100%; text-align: center; background-color: #10103a; color: #fff;">PRODUCTOS</th>
            </tr>
            <thead>
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
            <tr>
                <th colspan="4" style="width: 100%; text-align: center; background-color: #10103a; color: #fff;">ADICIONALES</th>
            </tr>
            <thead>
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
            <tr>
                <th colspan="3" style="width: 100%; text-align: center; background-color: #10103a; color: #fff;">TOTALES</th>
            </tr>
            <thead>
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
 
    </div>
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
</body>
</html>

