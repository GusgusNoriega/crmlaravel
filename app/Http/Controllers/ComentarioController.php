<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ComentarioController extends Controller
{
    
    public function destroy(Comentario $comentario)
    {
            try {
                // Eliminar al usuario
                $comentario->delete();

                return response()->json(['message' => 'comentario eliminado correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la comentario: ' . $e->getMessage()], 500);
            }
    }

    public function update($id, Request $request)
    {
        try {
            // Buscar la empresa por ID
            $comentario = Comentario::findOrFail($id);

            // Validar el input
          
                $validated = $request->validate([
                    'contenido' => 'required|max:1000',
                    'user_id' => 'nullable|exists:users,id',
                    'fecha_asignada' => 'nullable|date',
                    'completado' => 'boolean',
                ]);

                // Verificar si 'completado' cambió de 0 a 1
                if ($comentario->complete == 0 && $validated['completado'] == 1) {
                    // Si 'complete' cambia de 0 a 1, asignar la fecha actual a 'fecha_culminacion'
                    $comentario->fecha_culminacion = now();
                }

                // Actualizar solo el nombre y el RUC
                $comentario->contenido = $validated['contenido'];
                $comentario->fecha_asignada = $validated['fecha_asignada'];
                $comentario->user_asig_id = $validated['user_id'];
                $comentario->complete = $validated['completado'];
                $comentario->save();

                // Devolver respuesta exitosa
                return response()->json(['message' => 'Tu comentario se ha actualizado con éxito']);
            
            
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

    public function crearComentario(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'contenido' => 'required|max:1000', // Ajusta el máximo según tus necesidades
                    'comentable_id' => 'required|integer', // Asegúrate de que esto corresponda a tu lógica de negocio
                    'comentable_type' => 'required|in:App\Models\Empresa,App\Models\Cliente', // Asegúrate de que esto corresponda a tus modelos comentables
                    'user_id' => 'nullable|exists:users,id',
                    'fecha_asignada' => 'nullable|date',
                    'id_notificacion' => 'nullable|exists:comentarios,id',
                ]);

                // Intenta crear la nueva empresa
                $comentario = Comentario::create([
                    'user_id' => Auth::id(),
                    'contenido' => $validated['contenido'],
                    'comentable_id' => $validated['comentable_id'],
                    'comentable_type' => $validated['comentable_type'],
                    'user_asig_id' => $validated['user_id'] ?? Auth::id(),
                    'fecha_asignada' => $validated['fecha_asignada'] ?? null,
                ]);

                
                if (!empty($validated['id_notificacion'])) {
                    $comentarioNotificacion = Comentario::find($validated['id_notificacion']);
                    if ($comentarioNotificacion) {
                        $comentarioNotificacion->update([
                            'complete' => 1, // Asegúrate de que 'complete' sea el nombre correcto del campo
                            'fecha_culminacion' => now(), // Esto establecerá la fecha actual
                        ]);
                    }
                }

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Empresa creada con éxito',
                    'empresa' => $comentario
                ], 201);

        } catch (ValidationException $e) {
                // Capturar los errores de validación y devolver una respuesta JSON
                return response()->json([
                    'message' => 'Error en la validación',
                    'errors' => $e->errors(),
                ], 422); // Código de estado HTTP 422 Unprocessable Entity para errores de validación
        } catch (\Exception $e) {
            Log::error('Error al crear comentario: '.$e->getMessage(), ['stack' => $e->getTraceAsString()]);
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
        $comentableId = $request->input('comentable_id');
        $comentableType = $request->input('comentable_type');
        
        $user = $request->input('user');

        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Comentario::with(['user.image', 'userAsignado.image'])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('contenido', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($user)) {
            $query->where('user_id', $user);
        }

        if (!empty($comentableId)) {
            $query->where('comentable_id', $comentableId);
        }

        if (!empty($comentableType)) {
            $query->where('comentable_type', $comentableType);
        }

        if (!empty($fechaDesde)) {
            $query->whereDate('created_at', '>=', $fechaDesde);
        }

        if (!empty($fechaHasta)) {
            $query->whereDate('created_at', '<=', $fechaHasta);
        }

        $elementos = $query->paginate(10, ['*'], 'page', $page);
        return response()->json(['elementos' => $elementos]);
    }

    public function obtenerComentarioPorId(Request $request, $id) {
        $elementos = Comentario::with([ 'user.image', 'userAsignado'])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

    public function getNotificaciones()
    {
        $usuario = Auth::user();

        if ($usuario && $usuario->role) {
            $tienePermiso = $usuario->role->permissions()->where('name', 'update_todos_comentarios')->exists();

            if ($tienePermiso) {
                // Si el usuario tiene permiso, obtiene todas las notificaciones pendientes
                $comentariosPaginados = Comentario::with(['user.image', 'userAsignado.image', 'comentable'])
                                                  ->where('complete', '0')
                                                  ->whereNotNull('fecha_asignada')
                                                  ->orderBy('fecha_asignada', 'asc')
                                                  ->paginate(10);

                $totalComentarios = Comentario::where('complete', '0')
                                               ->whereNotNull('fecha_asignada')
                                               ->count();

            } else {
                // Si el usuario no tiene permiso, obtiene solo las notificaciones asignadas a él
                $comentariosPaginados = Comentario::with(['user.image', 'userAsignado.image', 'comentable'])
                                                  ->where('complete', '0')
                                                  ->where('user_asig_id', $usuario->id)
                                                  ->whereNotNull('fecha_asignada')
                                                  ->orderBy('fecha_asignada', 'asc')
                                                  ->paginate(10);

                $totalComentarios = Comentario::where('complete', '0')
                                                ->where('user_asig_id', $usuario->id)
                                                ->whereNotNull('fecha_asignada')
                                                ->count();

            }

            return response()->json([
                'comentarios' => $comentariosPaginados,
                'totalComentarios' => $totalComentarios,
                'tienePermiso' => $tienePermiso
            ]);
        }

        return response()->json(['mensaje' => 'Usuario no autenticado o sin rol definido']);
    }
}

