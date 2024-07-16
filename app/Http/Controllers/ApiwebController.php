<?php

namespace App\Http\Controllers;

use App\Models\Apiweb;
use App\Models\Product;
use App\Models\Moneda;
use App\Models\Image;
use App\Models\Galeria;
use App\Models\Taxonomia;
use App\Models\Termino;
use App\Models\Marca;
use App\Models\Procedencia;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiwebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /*
    *
    *
    *template ver clientes
    *
    *
    */
    public function show(Apiweb $cotizacion)
    {
        return view('admin.apisweb');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apiweb $apiweb)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        try {
            // Buscar la empresa por ID
            $apiweb = Apiweb::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
                'web' => 'required|max:100',
                'clave_key' => 'required|max:100',
                'clave_secret' => 'required|max:100',    
            ]);

            $apiweb->name = $validated['name'];
            $apiweb->web = $validated['web'];
            $apiweb->clave_key = $validated['clave_key'];
            $apiweb->clave_secret = $validated['clave_secret'];
            $apiweb->save();
    
            // Devolver respuesta exitosa
            return response()->json(['message' => 'Apiweb se ha actualizado con éxito']);
            
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
                'errors' => $e->getMessage(),
            ], 500); // Código de estado HTTP 500 Internal Server Error para errores generales
        }
    }

    /*
    *
    *
    *obtener api de web por id
    *
    */
    public function obtenerApiPorId(Request $request, $id) {
        $elementos = Apiweb::with([])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

    /*
    *
    *
    * mostrar producto individual
    *
    *
    */
    public function mostrarProducto($id)
    {
        $consumerKey = 'ck_814bedee5e60ee66f6a4674f050164d107f39a24'; // Reemplaza con tu Consumer Key
        $consumerSecret = 'cs_545cc7e0015bb4984766629c348c852505273ddc'; // Reemplaza con tu Consumer Secret
        $url = 'https://megaequipamiento.com/wp-json/wc/v3/products/'.$id; // Asegúrate de reemplazar tudominio.com con tu dominio real

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)->get($url);

        // Devolver directamente el JSON de la respuesta
        return response()->json(json_decode($response->body(), true));
    }
    
    /*
    *
    *
    *
    * actualizar productos por paginas
    *
    *
    */
    public function mostrarProductosPaginados($id, $pagina)
    {
        $apiweb = Apiweb::find($id);

        if (!$apiweb) {
            return response()->json(['error' => 'No se encontró la configuración de API con el ID proporcionado'], 404);
        }

        $consumerKey = $apiweb->clave_key; // Reemplaza con tu Consumer Key
        $consumerSecret = $apiweb->clave_secret; // Reemplaza con tu Consumer Secret
        $url = $apiweb->web . '/wp-json/wc/v3/products'; // Asegúrate de reemplazar tudominio.com con tu dominio real
        // Configurar parámetros de paginación
        $parametros = [
            'per_page' => 20, // Limitar a 2 productos por página
            'page' => $pagina, // Número de página
            'status' => 'publish',
            'orderby' => 'date', // Ordenar por fecha de creación
            'order' => 'asc',
            '_fields' => 'id,name,price,regular_price,status,permalink,description,sku,images,categories,attributes,meta_data',
        ];

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)->get($url, $parametros);
        $productosApi = json_decode($response->body(), true);

        $codigoMoneda = $productosApi[0]['currency'] ?? 'USD';
        //$moneda = Moneda::firstOrCreate(['code' => $codigoMoneda]);
        $moneda = Moneda::where('code', $codigoMoneda)->first();

        foreach ($productosApi as $productoApi) {
            // Crear un nuevo producto en tu base de datos con los datos obtenidos de la API
            $productoExistente = Product::where('id_referencia', $productoApi['id'])
                                        ->where('apiweb_id', $apiweb->id)
                                        ->first();

           if (is_null($productoExistente)) {

                 /*Agregar galeria y relacionar con imagenes*/
                 $galeria = new Galeria();
                 $galeria->name = $productoApi['name'];
                 $galeria->save();

                $nuevoProducto = new Product();
                $nuevoProducto->id_referencia = $productoApi['id'];
                $nuevoProducto->sku = $productoApi['sku'];
                $nuevoProducto->title = $productoApi['name']; // Asume que tu modelo tiene un atributo title
                $nuevoProducto->precio = $productoApi['price']; // Asume que tu modelo tiene un atributo price
                $nuevoProducto->tipo = 1; // Asume que tu modelo tiene un atributo description
                $nuevoProducto->moneda = $moneda->id;
                $nuevoProducto->apiweb_id = $apiweb->id;
                $nuevoProducto->galeria_id = $galeria->id;
                
                $metaData = collect($productoApi['meta_data']);
                $objetoEnvio = $metaData->firstWhere('key', 'contenido_de_envio');
                $objetoDatosTecnicos = $metaData->firstWhere('key', 'datos_tecnicos');

                if (empty($nuevoProducto->description)) {
                    $nuevaDescripcion = eliminarAtributosHTML($productoApi['description']);
                    $nuevoProducto->description = $nuevaDescripcion;
                }
                if ($objetoEnvio) {
                    $contenidoEnvio = eliminarAtributosHTML($objetoEnvio['value']);
                    $nuevoProducto->cont_envio = $contenidoEnvio; // Asignar el valor encontrado a 'cont_envio'
                }
                if ($objetoDatosTecnicos) {
                    $datosTecnicos = eliminarAtributosHTML($objetoDatosTecnicos['value']);
                    $nuevoProducto->datos_tecnicos = $datosTecnicos; // Asignar el valor encontrado a 'cont_envio'
                }

                // Definir la ruta de la imagen anterior
                if (!empty($productoApi['images'])) {
                        $idsImagenes = []; // Array para almacenar los IDs de todas las imágenes
                    
                        foreach ($productoApi['images'] as $index => $imagen) {
                            $rutaImagenAnterior = $imagen['src'];
                    
                            // Buscar en la base de datos por una imagen existente con la misma ruta anterior
                            $imagenExistente = Image::where('ruta_anterior', $rutaImagenAnterior)->first();
                    
                            // Verificar si ya existe una imagen con esa ruta anterior
                            if (!$imagenExistente) {
                                // La imagen no existe, proceder a descargar y crear una nueva
                                $rutaDescargada = descargarYGuardarImagen($rutaImagenAnterior);
                    
                                // Verificar si el resultado de la descarga no es FALSE
                                if ($rutaDescargada !== FALSE) {
                                    // Crear una nueva instancia del modelo Image y asignar los valores a los campos
                                    $imagenNueva = new Image();
                                    $imagenNueva->name = $productoApi['name']; 
                                    $imagenNueva->ruta = $rutaDescargada;
                                    $imagenNueva->alt = $productoApi['name']; // Ajusta según necesites
                                    $imagenNueva->ruta_anterior = $rutaImagenAnterior; // Ajusta según necesites
                    
                                    // Guardar el nuevo registro en la base de datos
                                    $imagenNueva->save();
                    
                                    $imagenExistente = $imagenNueva;
                                }
                            }
                    
                            // Si la imagen es la primera, establecerla como destacada
                            if ($index === 0) {
                                $nuevoProducto->imagen_destacada = $imagenExistente->id;
                            }else {
                                $idsImagenes[] = $imagenExistente->id;
                            }
                       
                        }
                    
                        // Si hay imágenes además de la destacada, sincronizarlas con la galería directamente
                        if (count($idsImagenes) > 0) {
                            // Asegurar que $galeria->images() define una relación que permite la operación sync()
                            $galeria->images()->sync($idsImagenes);
                        }

                }

                $idsTaxonomias = [];
                $idsTerminos = [];
                $marcasProducto = [];
                $procedenciasProducto = [];

                if (!empty($productoApi['attributes'])) {
                    $atributos = $productoApi['attributes'];
                    foreach ($atributos as $atributo) {
                        // Verificar si la taxonomía ya existe
                        if ($atributo['name'] === 'Marca') { // Asegúrate de que el nombre coincida exactamente
                            foreach ($atributo['options'] as $nombreMarca) {
                                // Verificar si la marca ya existe
                                $marca = Marca::firstOrCreate(['name' => $nombreMarca]);
                
                                // Añadir el ID de la marca al array de marcas del producto
                                $marcasProducto[] = $marca->id;
                            }
                        }

                        if ($atributo['name'] === 'Procedencia') { // Asegúrate de que el nombre coincida exactamente
                            foreach ($atributo['options'] as $nombreProcedencia) {
                                // Verificar si la marca ya existe
                                $procedencia = Procedencia::firstOrCreate(['name' => $nombreProcedencia]);
                                // Añadir el ID de la marca al array de marcas del producto
                                $procedenciasProducto[] = $procedencia->id;
                            }
                        }
                        
                        $taxonomia = Taxonomia::firstOrCreate(
                            ['name' => $atributo['name']]
                        );

                        $idsTaxonomias[] = $taxonomia->id;
                    
                        foreach ($atributo['options'] as $opcion) {
                            // Verificar si el término ya existe para la taxonomía dada
                            $termino = Termino::firstOrCreate(
                                [
                                    'name' => $opcion,
                                    'taxonomia_id' => $taxonomia->id
                                ]
                            );

                            $idsTerminos[] = $termino->id;
                        }
                    }
                }

                $idsCategorias = [];

                if (!empty($productoApi['categories'])) {
                    $categorias = $productoApi['categories'];
                    foreach ($categorias as $categoria) {
                        $categoriaid = Categoria::firstOrCreate(
                            ['name' => $categoria['name']]
                        );
                      $idsCategorias[] = $categoriaid->id;
                     }
                }

                Log::info('Estado final del producto antes de guardar', [
                    'description' => $nuevoProducto->description,
                    'cont_envio' => $nuevoProducto->cont_envio,
                    'datos_tecnicos' => $nuevoProducto->datos_tecnicos,
                ]);

                $nuevoProducto->save(); // Guardar el nuevo producto en la base de datos
                $nuevoProducto->taxonomias()->sync($idsTaxonomias);
                $nuevoProducto->terminos()->sync($idsTerminos);
                $nuevoProducto->marcas()->sync($marcasProducto);
                $nuevoProducto->procedencias()->sync($procedenciasProducto);
                $nuevoProducto->categorias()->sync($idsCategorias);
                
            } else {
                // Producto ya existe, entonces actualizamos su imagen principal si es necesario
                // Puedes ajustar la lógica de selección y actualización de la imagen principal según tus necesidades
                
                // Suponiendo que solo se actualiza si hay imágenes nuevas
                if (!empty($productoApi['images'])) {
                    $imagenPrincipalApi = $productoApi['images'][0]['src']; // Tomamos como principal la primera imagen
                    
                    // Buscar en la base de datos por una imagen existente con la misma ruta principal
                    $imagenExistente = Image::where('ruta_anterior', $imagenPrincipalApi)->first();
            
                    // Si no existe la imagen, proceder a descargar y guardar como nueva
                    if (!$imagenExistente) {
                        $rutaDescargada = descargarYGuardarImagen($imagenPrincipalApi);
            
                        if ($rutaDescargada !== FALSE) {
                            // Crear una nueva instancia del modelo Image y asignar los valores
                            $imagenNueva = new Image();
                            $imagenNueva->name = $productoApi['name']; 
                            $imagenNueva->ruta = $rutaDescargada;
                            $imagenNueva->alt = $productoApi['name'];
                            $imagenNueva->ruta_anterior = $imagenPrincipalApi;
            
                            $imagenNueva->save();
            
                            // Actualizar la imagen destacada del producto existente
                            $productoExistente->imagen_destacada = $imagenNueva->id;
                            $productoExistente->save();
                        }
                    } else {
                        // La imagen ya existe, pero podemos decidir actualizar la referencia de la imagen destacada del producto si es necesario
                        // Esto depende de tu lógica de negocio. Si siempre quieres actualizar a la última imagen cargada como destacada, puedes descomentar las siguientes líneas
                         $productoExistente->imagen_destacada = $imagenExistente->id;
                         $productoExistente->save();
                    }
                }
            
                // Aquí puedes agregar cualquier otra lógica de actualización que necesites para el producto existente
            }
        }

        // Obtener el total de productos desde los encabezados de respuesta
        $totalProductos = $response->header('X-WP-Total');
        $totalPaginas = $response->header('X-WP-TotalPages');

        // Devolver los productos y la información de paginación como JSON
        return response()->json([
            'productos' => $productosApi,
            'total_productos' => $totalProductos,
            'total_paginas' => $totalPaginas,
            'pagina_actual' => $pagina,
        ]);
    }

    public function crearApiweb(Request $request) {

        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:100',
                    'web' => 'required|max:100',
                    'clave_key' => 'required|max:100',
                    'clave_secret' => 'required|max:100',
                    'tipo' => 'required|max:50',
                ]);

                // Intenta crear la nueva area
                $apiweb = Apiweb::create([
                    'name' => $validated['name'],
                    'web' => $validated['web'],
                    'clave_key' => $validated['clave_key'],
                    'clave_secret' => $validated['clave_secret'],
                    'tipo' => $validated['tipo'],
                ]);

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Apiweb creada con éxito',
                    'empresa' => $apiweb
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
                    'message' => 'Ha ocurrido un error inesperado intentando crear la apiweb :(',
                    'errors' => $e->errors(),
                ], 500); // Código de estado HTTP 500 Internal Server Error para errores generales
        }

    }

    /*
    *
    *
    *todos apiweb
    *
    *
    */
    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
       
        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Apiweb::with([])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $elementos = $query->paginate(20, ['*'], 'page', $page);
        return response()->json(['elementos' => $elementos]);
    }

    /*
    *
    *
    *eliminar apiweb
    *
    *
    */
    public function destroy(Apiweb $apiweb)
    {
            try {
                // Eliminar la api
                $apiweb->delete();

                return response()->json(['message' => 'Api web eliminadA correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar el api web: ' . $e->getMessage()], 500);
            }
    }

    /*
    *
    *
    *ver api de la web
    *
    *
    */
    public function verApiweb($id)
    {
      try {
          $apiweb = Apiweb::with([])->findOrFail($id);
          return view('admin.single-apiweb', ['apiweb' => $apiweb]);
          //return response()->json($cotizacion);
          //dd($apiweb);
      } catch (ModelNotFoundException $e) {
      
          return redirect()->back()->withErrors('Cotización no encontrada.');
      }
    }
}
