<?php

namespace App\Http\Controllers;

use App\Models\Misempresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use \Illuminate\Validation\ValidationException;

class MisempresaController extends Controller
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

    /**
     * Display the specified resource.
     */
    public function show(Misempresa $misempresa)
    {
        return view('admin.nuestrasEmpresas');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Misempresa $misempresa)
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
            $empresa = Misempresa::findOrFail($id);
    
            // Validar el input
            $validated = $request->validate([
                'name' => 'required|max:100',
                'ruc' => 'required|max:15',
                'alias' => 'required|max:5',
                'telefono' => 'required|max:10',
                'cuenta_dolares' => 'required|max:100',
                'cuenta_soles' => 'required|max:100',
                'cuenta_nacion' => 'required|max:100',
                'image_id' => 'required|exists:images,id',
                'imagen_sello_id' => 'required|exists:images,id',
            ]);
    
            // Actualizar solo el nombre y el RUC
            $empresa->name = $validated['name'];
            $empresa->ruc = $validated['ruc'];
            $empresa->alias = $validated['alias'];
            $empresa->telefono = $validated['telefono'];
            $empresa->cuenta_dolares = $validated['cuenta_dolares'];
            $empresa->cuenta_soles = $validated['cuenta_soles'];
            $empresa->cuenta_nacion = $validated['cuenta_nacion'];
            $empresa->imagen_logo = $validated['image_id'];
            $empresa->imagen_sello = $validated['imagen_sello_id'];
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

    /**
     * Remove the specified resource from storage.
     */
    
     public function destroy(Misempresa $misempresa)
    {
            try {
                // Eliminar al usuario
                $misempresa->delete();

                return response()->json(['message' => 'Empresa eliminada correctamente']);
            } catch (\Exception $e) {
                // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
                return response()->json(['error' => 'Error al eliminar la empresa: ' . $e->getMessage()], 500);
            }
    }

    public function obtenerEmpresaPorId(Request $request, $id) {
        $misEmpresa = Misempresa::with(['imagenLogo', 'imagenSello'])->find($id);
        if (!$misEmpresa) {
            return response()->json(['mensaje' => 'No encontrado'], 404);
        }
        return response()->json($misEmpresa);
    }

    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
        $rucSearchTerm = $request->input('rucsearch', '');
        $fechaDesde = $request->input('desde'); // Fecha de inicio
        $fechaHasta = $request->input('hasta'); // Fecha de finalización

        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Misempresa::with(['imagenLogo', 'imagenSello'])->latest();
        
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        if (!empty($rucSearchTerm)) {
            $query->where('ruc', 'like', '%' . $rucSearchTerm . '%');
        }

        // Filtrar por fecha si se proporcionan fechas de inicio y finalización
        if (!empty($fechaDesde)) {
            $query->whereDate('created_at', '>=', $fechaDesde);
        }
        if (!empty($fechaHasta)) {
            $query->whereDate('created_at', '<=', $fechaHasta);
        }

        $misempresas = $query->paginate(6, ['*'], 'page', $page);
        return response()->json(['misempresas' => $misempresas]);
    }

    public function crearEmpresa(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'ruc' => ['required', 'string', 'max:255'],
                'image_id' => ['required', 'exists:images,id'],
                'alias' => ['required', 'string', 'max:255'],
                'telefono' => ['required', 'string', 'max:255'],
                'cuenta_soles' => ['required', 'string', 'max:255'],
                'cuenta_dolares' => ['required', 'string', 'max:255'],
                'cuenta_nacion' => ['required', 'string', 'max:255'],
                'imagen_sello_id' => ['required', 'exists:images,id'],
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $baseSlug = Str::slug($request->name); // Generar el slug base.
            $slug = $baseSlug; // Comenzar con el slug base.
            $counter = 1; // Contador para el slug.

            // Mientras el slug exista en la base de datos, genera un nuevo slug con el contador.
            while (Misempresa::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $counter;
                $counter++;
            }
            // Crear el nuevo usuario
            $Misempresa = Misempresa::create([
                'name' => $request->name,
                'ruc' => $request->ruc,
                'slug' => $slug,
                'alias' => $request->alias,
                'telefono' => $request->telefono,
                'imagen_logo' => $request->image_id, // Asignar el rol al usuario
                'imagen_sello' => $request->imagen_sello_id,
                'cuenta_soles' => $request->cuenta_soles,
                'cuenta_dolares' => $request->cuenta_dolares,
                'cuenta_nacion' => $request->cuenta_nacion,
            ]);
       
    
            return response()->json([
                'status' => 'success',
                'message' => 'Empresa creada con exito',
                'misempresa' => $Misempresa
            ], 201);
       
    }

}
