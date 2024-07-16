<?php

namespace App\Http\Controllers;

use App\Models\Termino;
use Illuminate\Http\Request;

class TerminoController extends Controller
{
   
    public function buscar(Request $request)
    {
        $taxonomiaId = $request->input('taxonomia_id');
        $nombre = $request->input('name');

        $terminos = Termino::where('taxonomia_id', $taxonomiaId)
                            ->where('name', 'like', '%' . $nombre . '%')
                            ->take(5)
                            ->get();

        return response()->json($terminos);
    }

    public function crearTermino(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:100|unique:taxonomias',
                    'taxonomia_id' => 'required|exists:taxonomias,id', 
                ]);

                // Intenta crear la nueva taxonomia
                $termino = Termino::create([
                    'name' => $validated['name'],
                    'taxonomia_id' => $validated['taxonomia_id'],
                ]);

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Taxonomia creada con éxito',
                    'taxonomia' => $termino
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
            $termino = Termino::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
            ]);

            $termino->name = $validated['name'];
            $termino->save();
    
            // Devolver respuesta exitosa
            return response()->json(['message' => 'el termino se ha actualizado con éxito']);
            
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
        $taxonomia_id = $request->input('taxonomia');
       
        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Termino::with([])->latest();

        if (!empty($taxonomia_id)) {
            $query->where('taxonomia_id',  $taxonomia_id);
        }
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $elementos = $query->paginate(20, ['*'], 'page', $page);
        return response()->json(['elementos' => $elementos]);
    }

    public function obtenerTerminoPorId(Request $request, $id) {
        $elementos = Termino::with([])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

    public function destroy(Termino $termino)
    {
            try {
                // Eliminar al usuario
                $termino->delete();

                return response()->json(['message' => 'Taxonomia eliminadA correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la taxonomia: ' . $e->getMessage()], 500);
            }
    }
}
