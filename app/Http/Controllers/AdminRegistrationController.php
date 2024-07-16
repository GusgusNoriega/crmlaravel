<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminRegistrationController extends Controller
{
    public function store(Request $request)
    {
        // Validar la entrada
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'], // Validación de role_id
            'image_id' => ['required', 'exists:images,id'], // Asegurarse de que image_id exista en la tabla de imágenes
            'telefono' => ['required', 'string', 'max:255'],
            'cargo' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Crear el nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id, // Asignar el rol al usuario
            'image_id' => $request->image_id, // Asignar el image_id al usuario
            'cargo' => $request->cargo,
            'telefono' => $request->telefono,
        ]);
   

        return response()->json([
            'status' => 'success',
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }

    public function showForm()
    {
        return view('admin.Usuarios');
    }

    public function getUserById($id)
    {

        $datos = User::with(['image', 'role'])->find($id);
        // Verifica si se encontró el usuario
        if (!$datos) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        return response()->json($datos);
    }


    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'image_id' => $request->input('image_id'),
            'cargo' => $request->input('cargo'),
            'telefono' => $request->input('telefono'),
            'role_id' => $request->input('role_id'),
        ]);

        return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente']);
    }

    public function obtenerUsuarios()
    {
        $usuarios = User::with(['image', 'role'])->get();

        // Verifica si se encontraron usuarios
        if ($usuarios->isEmpty()) {
            return response()->json(['error' => 'No se encontraron usuarios'], 404);
        }

        return response()->json($usuarios);
    }

    public function destroy($id)
    {
        try {
            // Buscar al usuario por su ID
            $user = User::findOrFail($id);

            // Eliminar al usuario
            $user->delete();

            // Puedes agregar lógica adicional aquí, como redirección o mensajes de éxito

            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } catch (\Exception $e) {
            // Puedes manejar cualquier excepción que ocurra durante el proceso de eliminación
            return response()->json(['error' => 'Error al eliminar el usuario'], 500);
        }
    }
}
