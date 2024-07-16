<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
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
        $request->validate([
            'image1' => 'required|image',
        ]);
        
        $path = $request->file('image1')->store('images', 'public');
    
        $image = new Image;
        $image->ruta = $path;
        $image->name = $request->filled('name') ? $request->name : 'Nombre Predeterminado'; // Verificar que el campo name esté presente y no esté vacío
        $image->alt = $request->filled('alt') ? $request->alt : 'Texto Alternativo Predeterminado'; // Verificar que el campo alt esté presente y no esté vacío
        $image->ruta_anterior = 'ruta anterior';
        $image->save();
    
        // En lugar de redireccionar, devolvemos una respuesta JSON
        return response()->json(['success' => 'Imagen subida correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar la entrada
        $request->validate([
            'name' => 'required|max:255', // Asegúrate de que el nombre sea válido
            // Añade más reglas de validación si es necesario
        ]);

        // Buscar la imagen por ID
        $image = Image::findOrFail($id);

        // Actualizar el nombre de la imagen
        $image->name = $request->name;
        $image->save();

        // Devolver una respuesta, por ejemplo, en formato JSON
        return response()->json(['success' => true, 'message' => 'Imagen actualizada con éxito']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
        {
            $image = Image::find($id);

            if (!$image) {
                return response()->json(['message' => 'Imagen no encontrada'], 404);
            }

            // Construir la ruta completa del archivo en el sistema de archivos
            $path = storage_path('app/public/' . $image->ruta);


            if (File::exists($path)) {
                File::delete($path);
            }
            
            // Eliminar el registro de la imagen de la base de datos
            $image->delete();

            return response()->json(['message' => 'Imagen eliminada con éxito']);
        }

    public function loadMore(Request $request) 
    {
        $page = intval($request->input('page', 1)); 
        $searchTerm = $request->input('search', ''); // Recibe el término de búsqueda
        $fechaDesde = $request->input('desde'); // Fecha de inicio
        $fechaHasta = $request->input('hasta'); // Fecha de finalización

        // Modifica la consulta para incluir el filtro de búsqueda si se proporciona un término de búsqueda
        $query = Image::latest();
        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Filtrar por fecha si se proporcionan fechas de inicio y finalización
        if (!empty($fechaDesde)) {
            $query->whereDate('created_at', '>=', $fechaDesde);
        }
        if (!empty($fechaHasta)) {
            $query->whereDate('created_at', '<=', $fechaHasta);
        }

        $images = $query->paginate(20, ['*'], 'page', $page);
        return response()->json(['images' => $images]);
    }

    public function imagenPorId($ids)
    {
        $idArray = explode(',', $ids);

        if (count($idArray) == 1) {
            // Solo un ID, buscar una sola imagen
            $image = Image::find($idArray[0]);

            if ($image) {
                return response()->json([
                    'success' => true,
                    'data' => $image
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Imagen no encontrada'
                ], 404);
            }
        } else {
            // Múltiples IDs, buscar una colección de imágenes
            $images = Image::whereIn('id', $idArray)->get();

            if ($images->isNotEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => $images
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Imagenes no encontradas'
                ], 404);
            }
        }
    }
}