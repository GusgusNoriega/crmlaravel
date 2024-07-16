<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
   
    public function crearSucursal(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:1000', // Ajusta el máximo según tus necesidades
                    'direccion' => 'required|max:1000', // Asegúrate de que esto corresponda a tu lógica de negocio
                    'empresa_id' => 'nullable|exists:empresas,id'
                ]);

                // Intenta crear la nueva empresa
                $sucursal = Sucursal::create([
                    'name' => $validated['name'],
                    'direccion' => $validated['direccion'],
                    'empresa_id' => $validated['empresa_id'],
                ]);

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Empresa creada con éxito',
                    'empresa' => $sucursal
                ], 201);

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

    public function update($id, Request $request)
    {
        try {
            // Buscar la empresa por ID
            $sucursal = Sucursal::findOrFail($id);

            // Validar el input
          
                $validated = $request->validate([
                    'name' => 'required|max:1000',
                    'direccion' => 'nullable|max:1000' 
                ]);

                // Actualizar solo el nombre y el RUC
                $sucursal->name = $validated['name'];
                $sucursal->direccion = $validated['direccion'];
                $sucursal->save();
        
                // Devolver respuesta exitosa
                return response()->json(['message' => 'Tu sucursal se ha actualizado con éxito']);
            
            
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

    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
        $fechaDesde = $request->input('desde'); // Fecha de inicio
        $fechaHasta = $request->input('hasta'); // Fecha de finalización
        $empresaId = $request->input('empresaId');
         
        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Sucursal::with(['clientes'])->latest();

        if (!empty($empresaId)) {
            $query->where('empresa_id', $empresaId);
        }
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($fechaDesde)) {
            $query->whereDate('created_at', '>=', $fechaDesde);
        }

        if (!empty($fechaHasta)) {
            $query->whereDate('created_at', '<=', $fechaHasta);
        }

        $elementos = $query->paginate(5, ['*'], 'page', $page);
        return response()->json(['elementos' => $elementos]);
    }

    public function obtenerSucursalPorId(Request $request, $id) {
        $elementos = Sucursal::with(['clientes'])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

    public function destroy(Sucursal $sucursal)
    {
            try {
                // Eliminar la sucursal
                $sucursal->delete();

                return response()->json(['message' => 'sucursal eliminada correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la sucursal: ' . $e->getMessage()], 500);
            }
    }

    public function getSucursalesPorEmpresa($empresa_id)
    {
        $sucursales = Sucursal::where('empresa_id', $empresa_id)->get();
        return response()->json($sucursales);
    }
}
