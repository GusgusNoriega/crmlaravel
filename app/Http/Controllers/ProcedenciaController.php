<?php

namespace App\Http\Controllers;

use App\Models\Procedencia;
use Illuminate\Http\Request;

class ProcedenciaController extends Controller
{
    public function buscar(Request $request)
    {
        // Capturar los parámetros de la solicitud
        $searchTerm = $request->input('searchTerm');
        $field = $request->input('field');

        // Validar que el campo sea 'ruc' o 'name'
        if (!in_array($field, ['name'])) {
            return response()->json(['message' => 'Campo de búsqueda inválido'], 400);
        }

        // Realizar la búsqueda en la base de datos y devolver hasta 3 procedencias
        $empresas = Procedencia::with(['imagenDestacada'])
                    ->where($field, 'LIKE', "%{$searchTerm}%")
                    ->limit(3)
                    ->get();

        // Devolver las procedencias como JSON
        return response()->json($empresas);
    }

    public function show(Procedencia $procedencia)
    {
        return view('admin.procedencias');
    }

    public function crearProcedencia(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:100',
                    'image_id' => 'nullable|exists:images,id', 
                ]);

                // Intenta crear la nueva area
                $procedencia = Procedencia::create([
                    'name' => $validated['name'],
                    'imagen_destacada' => $validated['image_id'],
                ]);

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Area creada con éxito',
                    'marca' => $procedencia
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
            $procedencia = Procedencia::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
                'image_id' => 'nullable|exists:images,id',
            ]);

            $procedencia->name = $validated['name'];
            $procedencia->imagen_destacada = $validated['image_id'];
            $procedencia->save();
    
            // Devolver respuesta exitosa
            return response()->json(['message' => 'la Marca se ha actualizado con éxito']);
            
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
       
        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Procedencia::with(['imagenDestacada'])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $elementos = $query->paginate(20, ['*'], 'page', $page);
        return response()->json(['elementos' => $elementos]);
    }

    public function obtenerProcedenciaPorId(Request $request, $id) {
        $elementos = Procedencia::with(['imagenDestacada'])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

    public function destroy(Procedencia $procedencia)
    {
            try {
                // Eliminar al usuario
                $procedencia->delete();

                return response()->json(['message' => 'Procedencia eliminadA correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la procedencia: ' . $e->getMessage()], 500);
            }
    }

}
