<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
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
        try {
            $validatedData = $request->validate([
                'name' => 'required|unique:roles,name', // Asegúrate de validar el nombre del rol
            ]);
        
            $role = new Role();
            $role->name = $request->name;
            // No es necesario establecer guard_name, ya que se asignará a 'web' por defecto
            $role->save();
        
            return response()->json([
                'success' => true,
                'message' => 'El Rol ' . $role->name . ' fue creado con éxito',
                'role' => [
                    'name' => $role->name,
                    'id' => $role->id // Retorna el ID del rol recién creado
                ]
            ]);
        } catch (ValidationException $e) {
            // Personaliza la respuesta en caso de error de validación
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            // Lógica para eliminar el rol
            $role->delete();
    
            return response()->json(['success' => true, 'message' => 'Rol eliminado con éxito']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el rol', 'error' => $e->getMessage()], 500);
        }
    }

    public function showRoles()
    {
        $roles = Role::all(); // Obtiene todos los roles
        $modelos = ['usuarios', 'categorias', 'clientes', 'embudos', 'cotizaciones', 'imagenes', 'marcas', 'misempresas', 'monedas', 'roles', 'taxonomia', 'terminos', 'comentarios'];
        return view('admin.rolesYpermisos', compact('roles', 'modelos')); // Pasa los roles a la vista
    }

    public function actualizarPermisos(Request $request, $roleId)
    {
        try {
                $permisos = $request->input('permisos'); // Array de permisos

                // Encuentra el rol por ID o falla
                $rol = Role::findOrFail($roleId);

                foreach ($permisos as $nombrePermiso => $estadoPermiso) {
                    // Encuentra o crea el permiso
                    $permiso = Permission::firstOrCreate(['name' => $nombrePermiso]);
                
                    // Añade o elimina la relación basada en $estadoPermiso
                    if ($estadoPermiso) {
                        // Asegúrate de que la relación exista
                        $rol->permissions()->syncWithoutDetaching([$permiso->id]);
                    } else {
                        // Elimina la relación si existe
                        $rol->permissions()->detach($permiso->id);
                    }
                }

                // Respuesta adecuada (por ejemplo, un mensaje de éxito)
                return response()->json(['success' => true, 'message' => 'Permisos actualizados correctamente']);
           } catch (\Exception $e) {
            // Aquí capturas cualquier excepción que pueda ocurrir y devuelves un mensaje de error
                return response()->json(['success' => false, 'message' => 'Error al actualizar permisos: ' . $e->getMessage()], 500);
           }
    }

    public function obtenerPermisosDelRol($roleId)
    {
        try {
            // Encuentra el rol por ID o falla
            $rol = Role::findOrFail($roleId);

            // Obtiene los nombres de los permisos asociados al rol
            $nombresPermisos = $rol->permissions()->pluck('name');

            // Devuelve una respuesta JSON con los nombres de los permisos
            return response()->json(['success' => true, 'permisos' => $nombresPermisos]);
        } catch (\Exception $e) {
            // Manejo de errores
            return response()->json(['success' => false, 'message' => 'Error al obtener permisos: ' . $e->getMessage()], 500);
        }
    }

}
