<?php

namespace App\Http\Controllers;

use App\Models\Taxonomia;
use Illuminate\Http\Request;

class TaxonomiaController extends Controller
{
    public function buscar(Request $request)
    {
        $nombre = $request->input('name');

        $taxonomias = Taxonomia::where('name', 'like', '%' . $nombre . '%')
            ->take(5)
            ->get();

        return response()->json($taxonomias);
    }

    public function show(Taxonomia $taxonomia)
    {
        return view('admin.taxonomias');
    }

    public function crearTaxonomia(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:100|unique:taxonomias',  
                ]);

                // Intenta crear la nueva taxonomia
                $taxonomia = Taxonomia::create([
                    'name' => $validated['name'],
                ]);

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Taxonomia creada con éxito',
                    'taxonomia' => $taxonomia
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
            $taxonomia = Taxonomia::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
            ]);

            $taxonomia->name = $validated['name'];
            $taxonomia->save();
    
            // Devolver respuesta exitosa
            return response()->json(['message' => 'la taxonomia se ha actualizado con éxito']);
            
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
        $query = Taxonomia::with(['terminos'])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $elementos = $query->paginate(20, ['*'], 'page', $page);
        return response()->json(['elementos' => $elementos]);
    }

    public function obtenerTaxonomiaPorId(Request $request, $id) {
        $elementos = Taxonomia::with([])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

    public function destroy(Taxonomia $taxonomia)
    {
            try {
                // Eliminar al usuario
                $taxonomia->delete();

                return response()->json(['message' => 'Taxonomia eliminadA correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la taxonomia: ' . $e->getMessage()], 500);
            }
    }

    public function verTaxonomia($id)
    {
        $taxonomia = Taxonomia::with([])->find($id);

        if (!$taxonomia) {
            // Aquí puedes optar por redirigir a una página de error o mostrar un mensaje.
            return redirect()->route('nombre.ruta.error')->with('error', 'taxonomia no encontrada');
        }

        return view('admin.single-taxonomia', compact('taxonomia'));
    }

} 
