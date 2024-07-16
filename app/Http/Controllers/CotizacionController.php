<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Barryvdh\DomPDF\PDF as DomPDF;


class CotizacionController extends Controller
{

    /*
    *
    *
    *template ver clientes
    *
    *
    */
    public function show(Cotizacion $cotizacion)
    {
        return view('admin.cotizaciones');
    }

    /*
    *
    *
    *crear cotizaacion
    *
    *
    */
    public function crearCotizacion(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'fecha_cotizacion' => 'required|date',
                    'fecha_vencimiento' => 'required|date',
                    'entrega' => 'nullable|string',  
                    'lugar_entrega' => 'nullable|string',
                    'garantia' => 'nullable|string',
                    'forma_de_pago' => 'nullable|string',
                    'tipo_de_cambio' => 'nullable|numeric',
                    'adicionales' => 'nullable|string',
                    'total_productos' => 'nullable|string',
                    'total' => 'nullable|numeric',
                    'user_id' => 'required|exists:users,id',
                    'moneda_id' => 'required|exists:monedas,id',
                    'misempresa_id' => 'required|exists:misempresas,id',
                    'cliente1' => 'required|exists:clientes,id',  
                ]);

                 // Decodificar el JSON de total_productos para validar su contenido
                $productos = json_decode($request->total_productos, true);

                // Verificar si json_decode falló
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \Exception('Invalid JSON in total_productos');
                }

                // Segunda validación para el contenido de total_productos
                $productosValidados = Validator::make($productos, [
                    '*.id' => 'required|exists:products,id',
                    '*.tipoCambioActual' => 'required|numeric',
                    '*.tipoCambioFinal' => 'required|numeric',
                    '*.precioActual' => 'required|numeric',
                    '*.precioFinal' => 'required|numeric',
                    '*.monedaActual' => 'required|string|max:3',
                    '*.monedaFinal' => 'required|string|max:3',
                    '*.cantidad' => 'required|integer|min:1',
                    '*.precioDescuento' => 'nullable|numeric',
                    '*.total' => 'nullable|numeric',
                ]);

                if ($productosValidados->fails()) {
                        // Manejar errores de validación de los productos
                        return response()->json(['message' => 'Validation Error in total_productos', 'errors' => $productosValidados->errors()], 422);
                }

                // Paso 1: Obtener el año de la fecha de cotización
                $year = Carbon::parse($validated['fecha_cotizacion'])->year;

                 // Paso 2: Buscar la última cotización para el año y misempresa_id
                $lastCotizacion = Cotizacion::whereYear('fecha_cotizacion', $year)
                                                ->where('misempresa_id', $validated['misempresa_id'])
                                                ->orderBy('nro_cotizacion', 'desc')
                                                ->first();

                $nroCotizacion = $lastCotizacion ? $lastCotizacion->nro_cotizacion + 1 : 1;

                // Intenta crear la nueva cotizacion
                $cotizacion = Cotizacion::create([
                    'fecha_cotizacion' => $validated['fecha_cotizacion'],
                    'fecha_vencimiento' => $validated['fecha_vencimiento'],
                    'entrega' => $validated['entrega'],
                    'lugar_entrega' => $validated['lugar_entrega'],
                    'garantia' => $validated['garantia'],
                    'forma_de_pago' => $validated['forma_de_pago'],
                    'tipo_de_cambio' => $validated['tipo_de_cambio'],
                    'adicionales' => $validated['adicionales'],
                    'user_id' => $validated['user_id'],
                    'moneda_id' => $validated['moneda_id'],
                    'misempresa_id' => $validated['misempresa_id'],
                    'cliente_id' => $validated['cliente1'],
                    'total' => $validated['total'],
                    'nro_cotizacion' => $nroCotizacion,
                ]);

                $cotizacion->products()->detach();

                foreach ($productos as $producto) {
                    $cotizacion->products()->attach($producto['id'], [
                        'tipo_cambio_actual' => $producto['tipoCambioActual'] ?? 0,
                        'tipo_cambio_final' => $producto['tipoCambioFinal'] ?? 0,
                        'precio_actual' => $producto['precioActual'] ?? 0,
                        'precio_final' => $producto['precioFinal'] ?? 0,
                        'moneda_actual' => $producto['monedaActual'] ?? 0,
                        'moneda_final' => $producto['monedaFinal'] ?? 0,
                        'cantidad' => $producto['cantidad'] ?? 0,
                        'precio_descuento' => $producto['precioDescuento'] !== '' ? $producto['precioDescuento'] : null,
                        'total' => $producto['total'] ?? 0,
                    ]);
                }

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Area creada con éxito',
                    'marca' => $cotizacion
                ], 201);

        } catch (ValidationException $e) {
                // Capturar los errores de validación y devolver una respuesta JSON
                return response()->json([
                    'message' => 'Error en la validación',
                    'errors' => $e->errors(),
                ], 422); // Código de estado HTTP 422 Unprocessable Entity para errores de validación
        } catch (\Exception $e) {
                // Capturar cualquier otro tipo de error y devolver una respuesta JSON
                \Log::error('Error al procesar la solicitud: ', [
                    'message' => $e->getMessage(),
                    'errors' => $e->getTraceAsString(), // Opcional, si deseas un seguimiento completo del stack
                ]);

                return response()->json([
                    'message' => 'Ha ocurrido un error inesperado',
                    'errors' => $e->errors(),
                ], 500); // Código de estado HTTP 500 Internal Server Error para errores generales
        }
         
   }

   /*
   *
   * 
   * todas las cotizaciones
   * 
   * 
   */ 
  public function loadMore(Request $request) 
  {
      $page = intval($request->input('page', 1)); 
      $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
      $fechaDesde = $request->input('desde'); // Fecha de inicio
      $fechaHasta = $request->input('hasta'); // Fecha de finalización
      $idUsuario = $request->input('usuario');

      // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
      $query = Cotizacion::with(['moneda', 'cliente.imagenDestacada', 'cliente.empresa', 'user.image', 'misempresa'])
                        ->select('id', 'nro_cotizacion', 'fecha_cotizacion', 'fecha_vencimiento', 'total', 'moneda_id', 'user_id', 'cliente_id', 'misempresa_id')/*especifica los campos que se visualizaran*/
                        ->latest();
      
      if (!empty($searchTerm)) {
          $query->where('title', 'like', '%' . $searchTerm . '%');
      }

      if (!empty($idUsuario)) {
          $query->where('user_id', $idUsuario);
      }

      if (!empty($fechaDesde)) {
          $query->whereDate('created_at', '>=', $fechaDesde);
      }

      if (!empty($fechaHasta)) {
          $query->whereDate('created_at', '<=', $fechaHasta);
      }

      $elementos = $query->paginate(20, ['*'], 'page', $page);
      return response()->json(['elementos' => $elementos]);
  }

  /*
  *
  *
  *cotizacion individual
  *
  *
  */
  public function verCotizacion($id)
  {
    try {
        $cotizacion = Cotizacion::with(['moneda', 'cliente.imagenDestacada', 'cliente.empresa', 'user.image', 'misempresa.imagenLogo', 'misempresa.imagenSello', 'products.marcas', 'products.procedencias', 'products.imagenDestacada', 'products.terminos.taxonomia'])->findOrFail($id);

        return view('admin.single-cotizacion', ['cotizacion' => $cotizacion]);
        //return response()->json($cotizacion);
        //dd($cotizacion->misempresa->imagenLogo);
    } catch (ModelNotFoundException $e) {
    
        return redirect()->back()->withErrors('Cotización no encontrada.');
    }
  }

 /*
 *
 *
 *generar pdf de cotizacion
 *
 *
 */
  public function generatePDF($id)
  {
      // Iniciar opciones de DomPDF
      $options = new \Dompdf\Options();
      $options->set('isRemoteEnabled', TRUE);
      
      // Intentar generar el PDF
      try {
          $cotizacion = Cotizacion::with([
              'moneda', 
              'cliente.imagenDestacada', 
              'user.image', 
              'misempresa.imagenLogo', 
              'misempresa.imagenSello', 
              'products.marcas',
              'products.procedencias',
              'products.imagenDestacada',
              'products.terminos.taxonomia'
          ])->findOrFail($id);
      
          // Crear una instancia de DomPDF con las opciones
          $pdf = app('dompdf.wrapper');
          $pdf->getDomPDF()->setOptions($options);
      
          // Cargar la vista con los datos de la cotización
          $pdf->loadView('miVistaPDF', ['cotizacion' => $cotizacion]);
      
          // Configurar opciones del papel y márgenes del PDF
          $pdf->setPaper('a4', 'portrait')->setOptions([
              'margin_top' => '10mm', 
              'margin_bottom' => '10mm', 
              'margin_left' => '15mm', 
              'margin_right' => '15mm'
          ]);
      
          // Devolver el PDF generado para su descarga
          return $pdf->download('miDocumentoPDF.pdf');
      } catch (\Exception $e) {
          // Capturar cualquier excepción y mostrar el mensaje de error
          return response()->json(['error' => $e->getMessage()], 500);
      }
  }

  public function obtenerCotizacionPorId(Request $request, $id) {
        $elementos = Cotizacion::with(['moneda', 'cliente.imagenDestacada', 'cliente.empresa', 'user.image', 'misempresa.imagenLogo', 'misempresa.imagenSello', 'products.marcas', 'products.procedencias', 'products.imagenDestacada', 'products.terminos.taxonomia'])->findOrFail($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
  }

  public function update($id, Request $request)
  {
      try {
          // Buscar la cotizacion por ID
          $cotizacion = Cotizacion::findOrFail($id);
  
          // Validar el input
          $validated = $request->validate([
            'fecha_cotizacion' => 'required|date',
            'fecha_vencimiento' => 'required|date',
            'entrega' => 'nullable|string',  
            'lugar_entrega' => 'nullable|string',
            'garantia' => 'nullable|string',
            'forma_de_pago' => 'nullable|string',
            'tipo_de_cambio' => 'nullable|numeric',
            'adicionales' => 'nullable|string',
            'total_productos' => 'nullable|string',
            'total' => 'nullable|numeric',
            'user_id' => 'required|exists:users,id',
            'moneda_id' => 'required|exists:monedas,id',
            'misempresa_id' => 'required|exists:misempresas,id',
            'cliente1' => 'required|exists:clientes,id',  
        ]);

        if ($cotizacion->misempresa_id != $validated['misempresa_id']) {
            // Paso 1: Obtener el año de la fecha de cotización
            $year = Carbon::parse($validated['fecha_cotizacion'])->year;
            // Paso 2: Buscar la última cotización para el año y misempresa_id
            $lastCotizacion = Cotizacion::whereYear('fecha_cotizacion', $year)
                                        ->where('misempresa_id', $validated['misempresa_id'])
                                        ->orderBy('nro_cotizacion', 'desc')
                                        ->first();
            // Determinar el nuevo número de cotización
            $nroCotizacion = $lastCotizacion ? $lastCotizacion->nro_cotizacion + 1 : 1;
            // Actualizar el número de cotización
            $cotizacion->nro_cotizacion = $nroCotizacion;
        }

        $cotizacion->fecha_cotizacion = $validated['fecha_cotizacion'];
        $cotizacion->fecha_vencimiento = $validated['fecha_vencimiento'];
        $cotizacion->entrega = $validated['entrega'];
        $cotizacion->lugar_entrega = $validated['lugar_entrega'];
        $cotizacion->garantia = $validated['garantia'];
        $cotizacion->forma_de_pago = $validated['forma_de_pago'];
        $cotizacion->tipo_de_cambio = $validated['tipo_de_cambio'];
        $cotizacion->adicionales = $validated['adicionales'];
        $cotizacion->user_id = $validated['user_id'];
        $cotizacion->moneda_id = $validated['moneda_id'];
        $cotizacion->misempresa_id = $validated['misempresa_id'];
        $cotizacion->cliente_id = $validated['cliente1'];
        $cotizacion->total = $validated['total'];
        $cotizacion->save();

         // Decodificar el JSON de total_productos para validar su contenido
         $productos = json_decode($request->total_productos, true);

         // Verificar si json_decode falló
         if (json_last_error() !== JSON_ERROR_NONE) {
             throw new \Exception('Invalid JSON in total_productos');
         }

         // Segunda validación para el contenido de total_productos
         $productosValidados = Validator::make($productos, [
             '*.id' => 'required|exists:products,id',
             '*.tipoCambioActual' => 'required|numeric',
             '*.tipoCambioFinal' => 'required|numeric',
             '*.precioActual' => 'required|numeric',
             '*.precioFinal' => 'required|numeric',
             '*.monedaActual' => 'required|string|max:10',
             '*.monedaFinal' => 'required|string|max:10',
             '*.cantidad' => 'required|integer|min:1',
             '*.precioDescuento' => 'nullable|numeric',
             '*.total' => 'nullable|numeric',
         ]);

         if ($productosValidados->fails()) {
            // Manejar errores de validación de los productos
            return response()->json(['message' => 'Validation Error in total_productos', 'errors' => $productosValidados->errors()], 422);
         }

      
         $productosData = [];
         foreach ($productos as $producto) {
             $productosData[$producto['id']] = [
                 'tipo_cambio_actual' => $producto['tipoCambioActual'] ?? 0,
                 'tipo_cambio_final' => $producto['tipoCambioFinal'] ?? 0,
                 'precio_actual' => $producto['precioActual'] ?? 0,
                 'precio_final' => $producto['precioFinal'] ?? 0,
                 'moneda_actual' => $producto['monedaActual'] ?? 0,
                 'moneda_final' => $producto['monedaFinal'] ?? 0,
                 'cantidad' => $producto['cantidad'] ?? 0,
                 'precio_descuento' => $producto['precioDescuento'] !== '' ? $producto['precioDescuento'] : null,
                 'total' => $producto['total'] ?? 0,
             ];
         }
 
         // Actualizar las relaciones con el método sync
         $cotizacion->products()->sync($productosData);
        
        // Devolver respuesta exitosa
        return response()->json(['message' => 'Tu cotizacion se a actualizado con exito']);


          
      } catch (ValidationException $e) {
          
          return response()->json([
              'message' => 'Error en la validación',
              'errors' => $e->errors(),
          ], 422); 

      } catch (\Exception $e) {
         
          return response()->json([
              'message' => 'Ha ocurrido un error inesperado',
              'errors' => $e->getMessage(),
          ], 500); 
      }
  }
}

