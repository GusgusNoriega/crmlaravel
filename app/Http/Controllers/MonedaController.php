<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;

class MonedaController extends Controller
{
    /*
     * ver monedas
     */
    public function show(Moneda $moneda)
    {
        return view('admin.monedas');
    }
    /*
    *crear moneda
    */
    public function crearMoneda(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:100',
                    'code' => 'required|max:100',
                    'tipo_cambio' => 'required|numeric',
                    'symbol' => 'required|max:4',
                ]);

                // Intenta crear la nueva area
                $moneda = Moneda::create([
                    'name' => $validated['name'],
                    'code' => $validated['code'],
                    'tipo_cambio' => $validated['tipo_cambio'],
                    'symbol' => $validated['symbol'],
                ]);

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Moneda creada con éxito',
                    'marca' => $moneda
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
    *actualizar monedas
    */
    public function update($id, Request $request)
    {
        try {
            // Buscar la empresa por ID
            $moneda = Moneda::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
                'code' => 'required|max:100',
                'tipo_cambio' => 'required|numeric',
                'symbol' => 'required|max:4',
            ]);

            $moneda->name = $validated['name'];
            $moneda->code = $validated['code'];
            $moneda->tipo_cambio = $validated['tipo_cambio'];
            $moneda->symbol = $validated['symbol'];
            $moneda->save();
    
            // Devolver respuesta exitosa
            return response()->json(['message' => 'la Moneda se ha actualizado con éxito']);
            
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
                'errors' => $e->errors(),
            ], 500); // Código de estado HTTP 500 Internal Server Error para errores generales
        }
    }
    /*
    *filtrar y ver monedas
    */
    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
       
        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Moneda::with([])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $elementos = $query->paginate(20, ['*'], 'page', $page);
        return response()->json(['elementos' => $elementos]);
    }
    /*
    *obtener moneda por id
    */
    public function obtenerMonedaPorId(Request $request, $id) {
        $elementos = Moneda::with([])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }
    /*
    *obtener moneda por id
    */
    public function destroy(Moneda $moneda)
    {
            try {
                // Eliminar al usuario
                $moneda->delete();

                return response()->json(['message' => 'Moneda eliminada correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la Moneda: ' . $e->getMessage()], 500);
            }
    }
}
