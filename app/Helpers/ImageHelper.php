
<?php

if (!function_exists('encodeImageToBase64')) {
  
    function encodeImageToBase64($imagePath) {
        // Construir la ruta absoluta a la imagen
        $absolutePath = storage_path('app/public/' . $imagePath);
    
        // Verificar si el archivo existe
        if (!file_exists($absolutePath)) {
            return 'Archivo no encontrado';
        }
    
        // Detectar el tipo de imagen
        $imageType = mime_content_type($absolutePath);
        $base64Type = 'image/jpeg'; // Tipo por defecto
    
        switch ($imageType) {
            case 'image/png':
                $base64Type = 'image/png';
                break;
            case 'image/webp':
                $base64Type = 'image/webp';
                break;
            case 'image/jpeg':
                $base64Type = 'image/jpeg';
                break;
            // Añade más casos según sea necesario
        }
    
        // Codificar el contenido de la imagen a base64
        $imageData = base64_encode(file_get_contents($absolutePath));
    
        // Retornar la cadena completa para incrustar la imagen
        return "data:$base64Type;base64,$imageData";
    }
    
}

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


function eliminarAtributosHTML($html) {
    if (trim($html) === '') {
        return '';
    }

    $dom = new DOMDocument();
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

    foreach ($dom->getElementsByTagName('*') as $element) {
        while ($element->attributes->length) {
            $element->removeAttribute($element->attributes->item(0)->name);
        }
    }

    $paragraphs = $dom->getElementsByTagName('p');
    for ($i = $paragraphs->length - 1; $i >= 0; $i--) {
        $paragraph = $paragraphs->item($i);
        if (!$paragraph->hasChildNodes() && trim($paragraph->textContent) === '') {
            $paragraph->parentNode->removeChild($paragraph);
        }
    }

    $htmlLimpio = $dom->saveHTML();

    $htmlLimpio = html_entity_decode($htmlLimpio);
    $htmlLimpio = preg_replace('/\s+/', ' ', $htmlLimpio);
    $htmlLimpio = preg_replace('/<p>(\s|&nbsp;)*<\/p>/', '', $htmlLimpio);

    Log::info('HTML final limpio:', ['html' => trim($htmlLimpio)]);

    return trim($htmlLimpio);
}

function descargarYGuardarImagen($url) {
    // Asegúrate de que la URL de la imagen sea válida.
     $urlCorregida = corregirUrl($url);

     // Verificar si la URL corregida es válida
     if (filter_var($urlCorregida, FILTER_VALIDATE_URL) === FALSE) {
         Log::error('La URL proporcionada no es válida: ' . $url);
         return FALSE;
     }

    try {
        // Obtener el contenido de la imagen
        $contenidoImagen = file_get_contents($url);

        if ($contenidoImagen === FALSE) {
            Log::error('No se pudo descargar la imagen de la URL: ' . $url);
            return FALSE;
        }

        // Extraer el nombre de la imagen de la URL
        $nombreImagen = basename($url);

        // Definir la ruta donde se guardará la imagen dentro de tu proyecto.
        $rutaGuardado = 'public/images/' . $nombreImagen;

        // Guardar la imagen en el disco.
        Storage::put($rutaGuardado, $contenidoImagen);

        $rutaAccesible = 'images/' . $nombreImagen;

        // Retornar la ruta de acceso a la imagen guardada.
        return $rutaAccesible;

    } catch (Exception $e) {
        // Manejar cualquier error que pueda ocurrir
        Log::error('Error al descargar o guardar la imagen: ' . $e->getMessage());
        return FALSE; // Asegurarse de devolver FALSE si se produce una excepción.
    }
}

function corregirUrl($url) {
    $partes = parse_url($url);
    if (!isset($partes['scheme']) || !isset($partes['host'])) {
        return $url; // Si no se puede parsear correctamente, devolver la URL tal cual
    }

    $rutaCorregida = isset($partes['path']) ? implode("/", array_map("rawurlencode", explode("/", $partes['path']))) : '';
    $urlCorregida = $partes['scheme'] . '://' . $partes['host'] . $rutaCorregida;

    // Agregar la parte de query si existe
    if (isset($partes['query'])) {
        $urlCorregida .= '?' . $partes['query'];
    }

    return $urlCorregida;
}