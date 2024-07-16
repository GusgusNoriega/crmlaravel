<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Galeria;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

   
    public function crearProducto(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:200',
                    'image_id' => 'required|exists:images,id',
                    'precio' => 'required|numeric',
                    'taxonomias-terminos-input' => 'required|json',
                    'description' => 'nullable|string',
                    'cont_envio' => 'nullable|string',
                    'tipo' => 'required',
                    'datos_tecnicos' => 'nullable|string',
                    'modelo' => 'nullable|string|max:100',
                    'moneda_id' => 'required|exists:monedas,id',
                    'imagenes_id' => 'nullable|string',
                    'marca1' => 'nullable|string',
                    'procedencia1' => 'nullable|string',
                    'categoria1' => 'nullable|string',
                ]);

                /*Agregar galeria y relacionar con imagenes*/
                $galeria = new Galeria();
                $galeria->name = $validated['name'];
                $galeria->save();

                if (!empty($validated['imagenes_id'])) {
                    $imagenesIds = explode(',', $validated['imagenes_id']);

                    // Asegurarse de que son IDs válidos y eliminar posibles espacios
                    $imagenesIds = array_filter($imagenesIds, function($value) { 
                        return is_numeric($value) && intval($value) > 0; 
                    });

                    $imagenesIds = array_map('intval', $imagenesIds);
                    //sincronizar las relaciones entre imagenes y galeria
                    $galeria->images()->sync($imagenesIds);
                    /*fin de Agregar galeria y relacionar con imagenes*/
                }

                $ultimoProducto = Product::orderBy('sku_ref', 'desc')->first();
                $nuevoSkuRef = $ultimoProducto ? $ultimoProducto->sku_ref + 1 : 1;

                $producto = new Product([
                    'title' => $validated['name'],
                    'imagen_destacada' => $validated['image_id'],
                    'precio' => $validated['precio'],
                    'description' => $validated['description'],
                    'cont_envio' => $validated['cont_envio'],
                    'tipo' => $validated['tipo'],
                    'datos_tecnicos' => $validated['datos_tecnicos'],
                    'modelo' => $validated['modelo'],
                    'moneda' => $validated['moneda_id'],
                    'galeria_id' => $galeria->id,
                    'sku_ref' => $nuevoSkuRef,
                    'sku' => 'PRO-' . $nuevoSkuRef,
                ]);

                $producto->save();

                $taxonomiasInput = json_decode($request->input('taxonomias-terminos-input'), true);
                $taxonomiaIds = collect($taxonomiasInput)->pluck('taxonomiaId')->all();
                $terminosIds = collect($taxonomiasInput)->flatMap(function ($taxonomia) {
                                    return collect($taxonomia['terminos'])->pluck('terminoId');
                                })->unique()->all();

                $producto->taxonomias()->sync($taxonomiaIds);
                $producto->terminos()->sync($terminosIds);

                if (!empty($validated['marca1'])) {
                    // Convertir 'marca1' en un array
                    $marcaIds = explode(',', $validated['marca1']);
                
                    // Asegurarse de que son IDs válidos y eliminar posibles espacios
                    $marcaIds = array_filter($marcaIds, function($value) { 
                        return is_numeric($value) && intval($value) > 0; 
                    });
                    $marcaIds = array_map('intval', $marcaIds);
                
                    // Asociar las marcas con el Producto
                    $producto->marcas()->sync($marcaIds);
                }

                if (!empty($validated['procedencia1'])) {

                    $procedenciasIds = explode(',', $validated['procedencia1']);
                
                    // Asegurarse de que son IDs válidos y eliminar posibles espacios
                    $procedenciasIds = array_filter($procedenciasIds, function($value) { 
                        return is_numeric($value) && intval($value) > 0; 
                    });
                    $procedenciasIds = array_map('intval', $procedenciasIds);
                
                    // Asociar las marcas con el Producto
                    $producto->procedencias()->sync($procedenciasIds);

                }

                if (!empty($validated['categoria1'])) {

                    $categoriasIds = explode(',', $validated['categoria1']);
                
                    // Asegurarse de que son IDs válidos y eliminar posibles espacios
                    $categoriasIds = array_filter($categoriasIds, function($value) { 
                        return is_numeric($value) && intval($value) > 0; 
                    });
                    $categoriasIds = array_map('intval', $categoriasIds);
                
                    // Asociar las marcas con el Producto
                    $producto->categorias()->sync($categoriasIds);

                }
                
                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Producto creado con éxito',
                    'elemento' => $producto
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
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(), // Opcional, si deseas un seguimiento completo del stack
                ]);

                return response()->json([
                    'message' => 'Ha ocurrido un error inesperado',
                    'errors' => $e->errors(),
                ], 500); // Código de estado HTTP 500 Internal Server Error para errores generales
        }          
    }

    public function update($id, Request $request)
    {
        try {
            // Buscar la empresa por ID
            $producto = Product::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:200',
                'image_id' => 'nullable|exists:images,id',
                'precio' => 'required|numeric',
                'taxonomias-terminos-input' => 'required|json',
                'description' => 'nullable|string',
                'cont_envio' => 'nullable|string',
                'datos_tecnicos' => 'nullable|string',
                'modelo' => 'nullable|string|max:100',
                'moneda_id' => 'required|exists:monedas,id',
                'imagenes_id' => 'nullable|string',
                'marca1' => 'nullable|string',
                'procedencia1' => 'nullable|string',
                'categoria1' => 'nullable|string',
            ]);

            $galeria = Galeria::findOrFail($producto->galeria_id);

            if (!empty($validated['imagenes_id'])) {
                $imagenesIds = explode(',', $validated['imagenes_id']);

                // Asegurarse de que son IDs válidos y eliminar posibles espacios
                $imagenesIds = array_filter($imagenesIds, function($value) { 
                    return is_numeric($value) && intval($value) > 0; 
                });

                $imagenesIds = array_map('intval', $imagenesIds);
                //sincronizar las relaciones entre imagenes y galeria
                $galeria->images()->sync($imagenesIds);
                /*fin de Agregar galeria y relacionar con imagenes*/
            }else {
                $galeria->images()->detach();
            }

            // Actualizar solo el nombre y el RUC
            $producto->title = $validated['name'];
            $producto->imagen_destacada = $validated['image_id'];
            $producto->precio = $validated['precio'];
            $producto->descripTion = $validated['description'];
            $producto->cont_envio = $validated['cont_envio'];
            $producto->datos_tecnicos = $validated['datos_tecnicos'];
            $producto->modelo = $validated['modelo'];
            $producto->moneda = $validated['moneda_id'];
            $producto->save();

            $taxonomiasInput = json_decode($request->input('taxonomias-terminos-input'), true);
            $taxonomiaIds = collect($taxonomiasInput)->pluck('taxonomiaId')->all();
            $terminosIds = collect($taxonomiasInput)->flatMap(function ($taxonomia) {
                                return collect($taxonomia['terminos'])->pluck('terminoId');
                            })->unique()->all();

            $producto->taxonomias()->sync($taxonomiaIds);
            $producto->terminos()->sync($terminosIds);

            if (!empty($validated['marca1'])) {
                // Convertir 'marca1' en un array
                $marcaIds = explode(',', $validated['marca1']);
            
                // Asegurarse de que son IDs válidos y eliminar posibles espacios
                $marcaIds = array_filter($marcaIds, function($value) { 
                    return is_numeric($value) && intval($value) > 0; 
                });
                $marcaIds = array_map('intval', $marcaIds);
            
                // Asociar las marcas con el Producto
                $producto->marcas()->sync($marcaIds);
            }else {
                $producto->marcas()->detach();
            }

            
            if (!empty($validated['procedencia1'])) {

                $procedenciasIds = explode(',', $validated['procedencia1']);
        
                // Asegurarse de que son IDs válidos y eliminar posibles espacios
                $procedenciasIds = array_filter($procedenciasIds, function($value) { 
                    return is_numeric($value) && intval($value) > 0; 
                });
                $procedenciasIds = array_map('intval', $procedenciasIds);
                info('Procedencias IDs:', $procedenciasIds);
                // Asociar las marcas con el Producto
                $producto->procedencias()->sync($procedenciasIds);

            }else {
                $producto->procedencias()->detach();
            }

            if (!empty($validated['categoria1'])) {

                $categoriasIds = explode(',', $validated['categoria1']);
            
                // Asegurarse de que son IDs válidos y eliminar posibles espacios
                $categoriasIds = array_filter($categoriasIds, function($value) { 
                    return is_numeric($value) && intval($value) > 0; 
                });
                $categoriasIds = array_map('intval', $categoriasIds);
            
                // Asociar las marcas con el Producto
                $producto->categorias()->sync($categoriasIds);

            }else {
                $producto->categorias()->detach();
            }
    
            // Devolver respuesta exitosa
            return response()->json(['message' => 'Tu producto se ha actualizado con éxito']);
            
        } catch (ValidationException $e) {
            // Capturar los errores de validación y devolver una respuesta JSON
            return response()->json([
                'message' => 'Error en la validación',
                'errors' => $e->errors(),
            ], 422); // Código de estado HTTP 422 Unprocessable Entity para errores de validación
        } catch (\Exception $e) {
            // Capturar cualquier otro tipo de error y devolver una respuesta JSON
            return response()->json([
                'message' => 'Ha ocurrido un error inesperado',
                'error' => $e->getMessage(),
            ], 500); // Código de estado HTTP 500 Internal Server Error para errores generales
        }
    }

    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
        $fechaDesde = $request->input('desde'); // Fecha de inicio
        $fechaHasta = $request->input('hasta'); // Fecha de finalización
        $tipo = $request->input('tipo');

        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Product::with(['imagenDestacada', 'monedaRelacionada'])
                          ->select('id', 'title', 'precio', 'moneda', 'imagen_destacada', 'modelo', 'sku')
                          ->latest();

        if (!empty($tipo)) {                  
            $query->where('tipo', $tipo);
        }

        if (!empty($searchTerm)) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
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
    
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.productos');
    }

     /**
     * Display the specified resource.
     */
    public function show2(Product $product)
    {
        return view('admin.servicios');
    }

    public function verProducto($id)
    {
        $producto = Product::with(['imagenDestacada', 'galeria.images', 'monedaRelacionada', 'categorias', 'terminos.taxonomia', 'marcas', 'procedencias'])->find($id);

        if (!$producto) {
            // Aquí puedes optar por redirigir a una página de error o mostrar un mensaje.
           
        }

        return view('admin.single-product', compact('producto'));
    }

    public function obtenerProductoPorId(Request $request, $id) {
        $elementos = Product::with(['imagenDestacada', 'galeria.images', 'monedaRelacionada', 'categorias', 'terminos.taxonomia', 'marcas', 'procedencias'])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

    public function destroy(Product $producto)
    {
            try {
                // Eliminar al usuario

                if ($producto->galeria) {
                    $producto->galeria->delete(); // Elimina la galería asociada
                }
                
                $producto->delete();

                return response()->json(['message' => 'Producto eliminado correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar el producto: ' . $e->getMessage()], 500);
            }
    }

    /**
    * 
    *buscar productos
    *
    */
    public function buscar(Request $request)
    {
        // Capturar los parámetros de la solicitud
        $searchTerm = $request->input('searchTerm');
        $field = $request->input('field');

        // Validar que el campo sea 'ruc' o 'name'
        if (!in_array($field, ['title'])) {
            return response()->json(['message' => 'Campo de búsqueda inválido'], 400);
        }

        // Realizar la búsqueda en la base de datos y devolver hasta 3 productos
        $productos = Product::with(['imagenDestacada', 'monedaRelacionada'])
                    ->where($field, 'LIKE', "%{$searchTerm}%")
                    ->limit(5)
                    ->get();

        // Devolver las procedencias como JSON
        return response()->json($productos);
    }

}
