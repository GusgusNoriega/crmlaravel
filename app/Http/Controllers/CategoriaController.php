<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    
    /*
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        return view('admin.categorias');
    }

    /*
    * crear categoria
    */
    public function crearCategoria(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:100|unique:categorias',
                    'image_id' => 'nullable|exists:images,id',
                    'categoria1' => 'nullable|exists:categorias,id', 
                ]);

                // Intenta crear la nueva categoria
                $categoria = Categoria::create([
                    'name' => $validated['name'],
                    'imagen_destacada' => $validated['image_id'],
                    'categoria_padre_id' => $validated['categoria1'],
                ]);

                
                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Categoria creada con éxito',
                    'categoria' => $categoria
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
    /*
    *
    */
    public function update($id, Request $request)
    {
        try {
            // Buscar la categoria por ID
            $categoria = Categoria::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
                'image_id' => 'nullable|exists:images,id',
                'categoria2' => 'nullable|exists:categorias,id', 
            ]);

            $categoria->name = $validated['name'];
            $categoria->imagen_destacada = $validated['image_id'];
            $categoria->categoria_padre_id = $validated['categoria2'];
            $categoria->save();
    
            // Devolver respuesta exitosa
            return response()->json(['message' => 'la Categoria se ha actualizado con éxito']);
            
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

    /*
    *ver las categorias
    */
    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
       
        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Categoria::with(['imagenDestacada', 'subcategorias.imagenDestacada'])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $query->where('categoria_padre_id', null);

        $elementos = $query->paginate(20, ['*'], 'page', $page);
        return response()->json(['elementos' => $elementos]);
    }

    /*
    * buscar categorias.
    */
    public function buscar(Request $request)
    {
        // Capturar los parámetros de la solicitud
        $searchTerm = $request->input('searchTerm');
        $field = $request->input('field');
        $subcategorias = $request->input('subCategorias', 'false') === 'true';

        // Validar que el campo sea 'ruc' o 'name'
        if (!in_array($field, ['name'])) {
            return response()->json(['message' => 'Campo de búsqueda inválido'], 400);
        }

        // Iniciar la consulta
        $query = Categoria::with(['imagenDestacada'])
        ->where($field, 'LIKE', "%{$searchTerm}%");

        // Si subcategorias es false, agregar el filtro para que categoria_padre_id sea nulo
        if ($subcategorias) {
        $query->whereNull('categoria_padre_id');
        }

        // Obtener los resultados limitados a 3
        $categorias = $query->limit(3)->get();


        // Devolver las procedencias como JSON
        return response()->json($categorias);
    }

    /*
    *
    */
    public function obtenerCategoriaPorId(Request $request, $id) {
        $elementos = Categoria::with(['imagenDestacada', 'categoriaPadre.imagenDestacada'])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

    public function destroy(Categoria $categoria)
    {
            try {
                // Eliminar al usuario
                $categoria->delete();

                return response()->json(['message' => 'Categoria eliminadA correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la Categoria: ' . $e->getMessage()], 500);
            }
    }
}
