<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClienteController extends Controller
{
    /*
    *
    *template ver clientes
    *
    */
    public function show(Cliente $cliente)
    {
        return view('admin.clientes');
    }
    /*
    *
    *actualizar clientes
    *
    */
    public function update($id, Request $request)
    {
        try {
            // Buscar la empresa por ID
            $cliente = Cliente::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
                'ruc' => 'nullable|max:15',
                'email' => 'required|email',
                'telefono' => 'required|max:50',
                'image_id' => 'nullable|exists:images,id',
                'direccion' => 'nullable|max:250',
                'user_id' => 'required|exists:users,id',
                'empresa5' => 'nullable|exists:empresas,id',
                'sucursales' => 'nullable|exists:sucursals,id',
                'cargo' => 'nullable|max:1000',
                'area_id' => 'nullable|exists:areas,id',
            ]);

            $tipo = $request->has('empresa5') && !empty($validated['empresa5']) ? 'empleado' : 'particular';

            $usuarioAnterior = $cliente->user_id;
            // Actualizar solo el nombre y el RUC
            $cliente->name = $validated['name'];
            $cliente->ruc = $validated['ruc'] ?? null;
            $cliente->email = $validated['email'];
            $cliente->telefono = $validated['telefono'];
            $cliente->imagen_destacada = $validated['image_id'];
            $cliente->direccion = $validated['direccion'] ?? null;
            $cliente->user_id = $validated['user_id'];
            $cliente->empresa_id = $validated['empresa5'] ?? null;
            $cliente->sucursal_id = $validated['sucursales'] ?? null;
            $cliente->cargo = $validated['cargo'] ?? null;
            $cliente->area_id = $validated['area_id'] ?? null;
            $cliente->tipo = $tipo;
            $cliente->save();
    
            // Devolver respuesta exitosa
            $usuarioActual = $cliente->user_id;
            $user = $request->user();
            $userName = $user ? $user->name : 'Usuario desconocido';

            // Registrar el error con el nombre del usuario
            Log::info("el usuario: {$userName}. a actualizado al cliente con el nombre {$cliente->name} y el email {$cliente->email} el usuario anterior asignado es {$usuarioAnterior} y e usuario actual asignado es {$usuarioActual}");
             
            return response()->json(['message' => 'Tu cliente se ha actualizado con éxito, recuerda que todos los cambios que realices a clientes y empresas quedaran registrados por la seguridad de los vendedores y de la empresa']);
   
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
    *
    *eliminar clientes
    *
    */
    public function destroy(Request $request, Cliente $cliente)
    {
            try {
                // Devolver respuesta exitosa
                $user = $request->user();
                $userName = $user ? $user->name : 'Usuario desconocido';
    
                // Registrar el error con el nombre del usuario
                Log::info("el usuario: {$userName}. a borrado al cliente con nombre {$cliente->name} y el email {$cliente->email} y el usuario asignado {$cliente->user_id}");
                // Eliminar al usuario
                $cliente->delete();

                return response()->json(['message' => 'Cliente eliminado correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar el cliente: ' . $e->getMessage()], 500);
            }
    }
    /*
    *
    *crear clientes
    *
    */
    public function crearCliente(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:100',
                    'ruc' => 'nullable|max:100|unique:clientes,ruc', // Asegura que el 'ruc' sea único en la tabla 'empresas'
                    'telefono' => 'required|max:50',
                    'email' => 'required|email|unique:clientes,email',
                    'direccion' => 'nullable|max:200',
                    'image_id' => 'nullable|exists:images,id',
                    'user_id' => 'required|exists:users,id',
                    'empresa3' => 'nullable|exists:empresas,id',   
                    'sucursales' => 'nullable|exists:sucursals,id',
                    'agregar-cargo' => 'nullable|max:1000',
                    'area_id' => 'nullable|exists:areas,id',       
                ]);

                $tipo = $request->has('empresa3') && !empty($validated['empresa3']) ? 'empleado' : 'particular';

                // Intenta crear la nueva empresa
                $cliente = Cliente::create([
                    'name' => $validated['name'],
                    'ruc' => $validated['ruc'] ?? null,
                    'telefono' => $validated['telefono'],
                    'email' => $validated['email'],
                    'direccion' => $validated['direccion'] ?? null,
                    'imagen_destacada' => $validated['image_id'],
                    'user_id' => $validated['user_id'],
                    'empresa_id' => $validated['empresa3'] ?? null,
                    'tipo' => $tipo,
                    'sucursal_id' => $validated['sucursales'] ?? null,
                    'cargo' => $validated['agregar-cargo'] ?? null,
                    'area_id' => $validated['area_id'] ?? null,
                ]);

                // Devolver respuesta exitosa
                $user = $request->user();
                $userName = $user ? $user->name : 'Usuario desconocido';
    
                // Registrar el error con el nombre del usuario
                Log::info("el usuario: {$userName}. a creado al cliente con nombre {$cliente->name} y el email {$cliente->email} ");

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Cliente creado con éxito',
                    'empresa' => $cliente
                ], 201);

        } catch (ValidationException $e) {
                // Capturar los errores de validación y devolver una respuesta JSON

                  // Obtener el usuario actual
                  $user = $request->user(); // Esto asume que estás utilizando la autenticación por defecto de Laravel
                  // O si necesitas obtenerlo usando el user_id del cliente
                  // Comprobar si el usuario está disponible y registrar el nombre
                  $userName = $user ? $user->name : 'Usuario desconocido';

                  // Registrar el error con el nombre del usuario
                  Log::error("Error de validación para crear el cliente del usuario: {$userName}. Detalles: ", $e->errors());

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
    *buscar y ver clientes
    *
    */
    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
        $rucSearchTerm = $request->input('rucsearch', '');
        $fechaDesde = $request->input('desde'); // Fecha de inicio
        $fechaHasta = $request->input('hasta'); // Fecha de finalización
        $user = $request->input('user');
        $empresa = $request->input('empresa');
        $email = $request->input('email');

        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Cliente::with(['imagenDestacada', 'user.image', 'empresa.imagenDestacada', 'sucursal', 'area'])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($email)) {
            $query->where('email', 'like', '%' . $email . '%');
        }

        if (!empty($user)) {
            $query->where('user_id', $user);
        }

        if (!empty($empresa)) {
            $query->where('empresa_id', $empresa);
        }

        if (!empty($rucSearchTerm)) {
            $query->where('ruc', 'like', '%' . $rucSearchTerm . '%');
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
    *solicitar cliente por id
    *
    */
    public function obtenerClientePorId(Request $request, $id) {
        $elementos = Cliente::with(['imagenDestacada', 'user.image', 'empresa.imagenDestacada', 'empresa.sucursales', 'sucursal'])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }

   /**
    * 
    *buscar clientes
    *
    */
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
        $clientes = Cliente::with(['imagenDestacada'])
                    ->where($field, 'LIKE', "%{$searchTerm}%")
                    ->limit(5)
                    ->get();

        // Devolver las procedencias como JSON
        return response()->json($clientes);
    }

    public function verCliente($id)
    {
        $cliente = Cliente::with(['imagenDestacada', 'user', 'empresa.imagenDestacada'])->find($id);

        if (!$cliente) {
            // Aquí puedes optar por redirigir a una página de error o mostrar un mensaje.
            return redirect()->route('nombre.ruta.error')->with('error', 'empresa no encontrado');
        }

        return view('admin.single-cliente', compact('cliente'));
    }
}
