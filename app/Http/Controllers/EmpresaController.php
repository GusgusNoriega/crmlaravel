<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Sucursal;
use Illuminate\Http\Request;
use \Illuminate\Validation\ValidationException;

class EmpresaController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Capturar los parámetros de la solicitud
        $searchTerm = $request->input('searchTerm');
        $field = $request->input('field');

        // Validar que el campo sea 'ruc' o 'name'
        if (!in_array($field, ['ruc', 'name'])) {
            return response()->json(['message' => 'Campo de búsqueda inválido'], 400);
        }

        // Realizar la búsqueda en la base de datos y devolver hasta 3 clientes
        $empresas = Empresa::with(['imagenDestacada'])
                    ->where($field, 'LIKE', "%{$searchTerm}%")
                    ->limit(3)
                    ->get();

        // Devolver los clientes como JSON
        return response()->json($empresas);
    }

    /*
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /*
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        return view('admin.empresas');
    }


    /*
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        //
    }

    /*
     *
     * Update the specified resource in storage.
     * 
     */
    public function update($id, Request $request)
    {
        try {
            // Buscar la empresa por ID
            $empresa = Empresa::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
                'ruc' => 'required|max:15',
                'email' => 'required|email',
                'telefono' => 'required|max:50',
                'image_id' => 'nullable|exists:images,id',
                'user_id' => 'required|exists:users,id',
            ]);
    
            // Actualizar solo el nombre y el RUC
            $empresa->name = $validated['name'];
            $empresa->ruc = $validated['ruc'];
            $empresa->email = $validated['email'];
            $empresa->telefono = $validated['telefono'];
            $empresa->imagen_destacada = $validated['image_id'];
            $empresa->user_id = $validated['user_id'];
            $empresa->save();
    
            // Devolver respuesta exitosa
            return response()->json(['message' => 'Tu empresa se ha actualizado con éxito']);
            
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
     * 
     * Remove the specified resource from storage.
     * 
     * 
     */
    public function destroy(Empresa $empresa)
    {
            try {
                // Eliminar al usuario
                $empresa->delete();

                return response()->json(['message' => 'Empresa eliminada correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la empresa: ' . $e->getMessage()], 500);
            }
    }
     /*
     *
     * 
     * crear empresa.
     * 
     * 
     */
    public function crearEmpresa(Request $request)
    {
          
        try {
                // Validar el input
                $validated = $request->validate([
                    'name' => 'required|max:100',
                    'ruc' => 'required|max:100|unique:empresas,ruc', // Asegura que el 'ruc' sea único en la tabla 'empresas'
                    'telefono' => 'required|max:50',
                    'email' => 'required|email|unique:empresas,email',
                    'direccion' => 'required|max:200',
                    'image_id' => 'nullable|exists:images,id',
                    'user_id' => 'required|exists:users,id',
                ]);

                // Intenta crear la nueva empresa
                $empresa = Empresa::create([
                    'name' => $validated['name'],
                    'ruc' => $validated['ruc'],
                    'telefono' => $validated['telefono'],
                    'email' => $validated['email'],
                    'imagen_destacada' => $validated['image_id'],
                    'user_id' => $validated['user_id'],
                ]);

                $sucursal = new Sucursal([
                    'name' => 'Sede principal ' . $empresa->name,
                    'empresa_id' => $empresa->id,
                    'direccion' => $validated['direccion'],
                ]);

                $sucursal->save();

                // Devolver una respuesta de éxito con la empresa creada
                return response()->json([
                    'status' => 'success',
                    'message' => 'Empresa creada con éxito',
                    'empresa' => $empresa
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
    /*
    *
    *
    * ver todas las empresas.
    *
    *
    */
    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
        $rucSearchTerm = $request->input('rucsearch', '');
        $fechaDesde = $request->input('desde'); // Fecha de inicio
        $fechaHasta = $request->input('hasta'); // Fecha de finalización
        $emailEmpresa = $request->input('email');
        $user = $request->input('user');

        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Empresa::with(['imagenDestacada', 'user.image'])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($user)) {
            $query->where('user_id', $user);
        }

        if (!empty($rucSearchTerm)) {
            $query->where('ruc', 'like', '%' . $rucSearchTerm . '%');
        }

        if (!empty($emailEmpresa)) {
            $query->where('email', 'like', '%' . $emailEmpresa . '%');
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
    *
    *Obtener empresa por id.
    *
    *
    */
    public function obtenerEmpresaPorId(Request $request, $id) {
        $elementos = Empresa::with(['imagenDestacada', 'user.image'])->find($id);
        if (!$elementos) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($elementos);
    }
    /*
    *
    *
    *Ver empresa por id
    *
    *
    */
    public function verEmpresa($id)
    {
        $empresa = Empresa::with(['imagenDestacada', 'user', 'empleados'])->find($id);

        if (!$empresa) {
            // Aquí puedes optar por redirigir a una página de error o mostrar un mensaje.
            return redirect()->route('nombre.ruta.error')->with('error', 'empresa no encontrado');
        }

        return view('admin.single-empresa', compact('empresa'));
    }
} 
