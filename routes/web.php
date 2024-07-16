<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\MisempresaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\TaxonomiaController;
use App\Http\Controllers\TerminoController;
use App\Http\Controllers\ProcedenciaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\MonedaController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ApiwebController;


// Aplica el middleware 'auth' a todas las rutas excepto las rutas de autenticación
Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'show']);

    Route::post('/images', [ImageController::class, 'store'])->name('images.store');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*rutas para usuarios*/
    Route::get('admin/usuarios', [AdminRegistrationController::class, 'showForm'])->name('usuarios');
    Route::get('admin/usuarios/get', [AdminRegistrationController::class, 'obtenerUsuarios'])->name('obtenerUsuarios');
    Route::get('admin/usuarios/get/{id}', [AdminRegistrationController::class, 'getUserById']);
    Route::delete('admin/usuarios/delete/{id}', [AdminRegistrationController::class, 'destroy'])->name('deleteUsuarios');
    Route::post('admin/usuarios/update/{id}', [AdminRegistrationController::class, 'update']);

    /*rutas para nuestras empresas*/
    Route::get('admin/nuestrasempresas', [MisempresaController::class, 'show'])->name('nuestrasEmpresas');
    Route::post('admin/nuestrasempresas/create', [MisempresaController::class, 'crearEmpresa'])->name('crearNuestrasEmpresa');
    Route::post('admin/nuestrasempresas/loadMore', [MisempresaController::class, 'loadMore'])->name('misempresas.loadMore');
    Route::get('admin/nuestrasempresas/get/{id}', [MisempresaController::class, 'obtenerEmpresaPorId'])->name('misempresas.obtenerEmpresaPorId');
    Route::post('admin/nuestrasempresas/update/{id}', [MisempresaController::class, 'update'])->name('updateMisestrasEmpresas');
    Route::delete('admin/nuestrasempresas/delete/{misempresa}', [MisempresaController::class, 'destroy'])->name('deleteMisempresas');

    /*rutas para empresas*/
    Route::get('admin/empresas', [EmpresaController::class, 'show'])->name('verEmpresas');
    Route::post('admin/empresas/create', [EmpresaController::class, 'crearEmpresa'])->name('empresa.crearEmpresa');
    Route::post('/admin/empresas/get', [EmpresaController::class, 'loadMore'])->name('empresa.loadMore');
    Route::get('admin/empresas/get/{id}', [EmpresaController::class, 'obtenerEmpresaPorId'])->name('obtenerEmpresaPorId');
    Route::post('admin/empresas/update/{id}', [EmpresaController::class, 'update'])->name('EmpresaUpdate');
    Route::delete('admin/empresas/delete/{empresa}', [EmpresaController::class, 'destroy'])->name('deleteEmpresas');
    Route::get('/admin/empresas/buscar', [EmpresaController::class, 'index'])->name('buscarEmpresas');
    Route::get('/admin/empresas/{id}', [EmpresaController::class, 'verEmpresa'])->name('empresas.verEmpresas');

    /*rutas para clientes*/
    Route::get('/admin/clientes', [ClienteController::class, 'show'])->name('verClientes');
    Route::post('/admin/clientes/create', [ClienteController::class, 'crearCliente'])->name('clientes.crearCliente');
    Route::post('/admin/clientes/get', [ClienteController::class, 'loadMore'])->name('clientes.loadMore');
    Route::get('/admin/clientes/get/{id}', [ClienteController::class, 'obtenerClientePorId'])->name('clientes.obtenerClientePorId');
    Route::post('/admin/clientes/update/{id}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('/admin/clientes/delete/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.deleteCliente');
    Route::get('/admin/clientes/buscar', [ClienteController::class, 'buscar'])->name('buscarClientes');
    Route::get('/admin/clientes/{id}', [ClienteController::class, 'verCliente'])->name('empresas.verCliente');
 
    /*rutas para imagenes*/
    Route::post('admin/register', [AdminRegistrationController::class, 'store']);
    Route::get('/load-more-images', [ImageController::class, 'loadMore'])->name('images.loadMore');
    Route::get('/imagen/{ids}', [ImageController::class, 'imagenPorId']);
    Route::post('admin/imagen/update/{id}', [ImageController::class, 'update']);
    Route::delete('/admin/imagen/destroy/{id}', [ImageController::class, 'destroy']);

    /*Rutas para roles*/
    Route::post('/admin/rol/create', [RoleController::class, 'store']);
    Route::get('/admin/roles', [RoleController::class, 'showRoles'])->name('roles');
    Route::delete('/admin/roles/delete/{role}', [RoleController::class, 'destroy']);
    Route::post('/admin/roles/permisos/update/{role}', [RoleController::class, 'actualizarPermisos']);
    Route::get('/admin/roles/{role}/permisos', [RoleController::class, 'obtenerPermisosDelRol']);

    /*rutas para productos*/
    Route::controller(ProductController::class)->group(function () {
        Route::get('/admin/productos/buscar', 'buscar')->name('buscarProductos');
        Route::get('/admin/productos', 'show')->name('products.productos');
        Route::post('/admin/productos/create', 'crearProducto')->name('products.crearProducto');
        Route::post('/admin/productos/get', 'loadMore')->name('products.loadMore');
        Route::get('/admin/productos/{id}', 'verProducto')->name('products.verProducto');
        Route::get('/admin/productos/get/{id}', 'obtenerProductoPorId')->name('productos.obtenerProductoPorId');
        Route::post('/admin/productos/update/{producto}', 'update')->name('productos.updateProducto');
        Route::delete('/admin/productos/delete/{producto}', 'destroy')->name('productos.deleteProducto');
        Route::get('/admin/servicios', 'show2')->name('servicios.deleteServicio');
          
    });

    /*rutas para comentarios*/
    Route::post('/admin/comentarios/create', [ComentarioController::class, 'crearComentario'])->name('comentarios.crearComentario');
    Route::post('/admin/comentarios/get', [ComentarioController::class, 'loadMore'])->name('comentarios.loadMore');
    Route::get('/admin/comentarios/get/{id}', [ComentarioController::class, 'obtenerComentarioPorId'])->name('comentarios.obtenerComentarioPorId');
    Route::post('/admin/comentarios/update/{id}', [ComentarioController::class, 'update'])->name('comentarios.update');
    Route::delete('/admin/comentarios/delete/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.deleteComentario');
    Route::get('/admin/comentarios/notificaciones', [ComentarioController::class, 'getNotificaciones'])->name('comentarios.notificaciones');

    /*rutas para sucursales*/
    Route::post('/admin/sucursales/create', [SucursalController::class, 'crearSucursal'])->name('sucursales.crearSucursal');
    Route::post('/admin/sucursales/get', [SucursalController::class, 'loadMore'])->name('sucursales.loadMore');
    Route::get('/admin/sucursales/get/{id}', [SucursalController::class, 'obtenerSucursalPorId'])->name('sucursales.obtenerSucursalPorId');
    Route::post('/admin/sucursales/update/{id}', [SucursalController::class, 'update'])->name('sucursales.update');
    Route::delete('/admin/sucursales/delete/{sucursal}', [SucursalController::class, 'destroy'])->name('sucursales.deleteSucursales');
    Route::get('/admin/sucursales/empresa/{id}', [SucursalController::class, 'getSucursalesPorEmpresa'])->name('sucursales.obtenerSucursalPorEmpresa');

    /*rutas para areas*/
    Route::get('/admin/areas', [AreaController::class, 'show'])->name('verAreas');
    Route::post('/admin/areas/create', [AreaController::class, 'crearArea'])->name('areas.crearArea');
    Route::post('/admin/areas/get', [AreaController::class, 'loadMore'])->name('areas.loadMore');
    Route::get('/admin/areas/get/{id}', [AreaController::class, 'obtenerAreaPorId'])->name('areas.obtenerAreaPorId');
    Route::post('/admin/areas/update/{id}', [AreaController::class, 'update'])->name('areas.update');
    Route::delete('/admin/areas/delete/{area}', [AreaController::class, 'destroy'])->name('areas.deleteAreas');
    
    /*rutas para procedencias*/
    Route::get('/admin/procedencias/buscar', [ProcedenciaController::class, 'buscar'])->name('buscarProcedencias');
    Route::get('/admin/procedencias', [ProcedenciaController::class, 'show'])->name('verProcedencias');
    Route::post('/admin/procedencias/create', [ProcedenciaController::class, 'crearProcedencia'])->name('procedencias.crearProcedencias');
    Route::post('/admin/procedencias/get', [ProcedenciaController::class, 'loadMore'])->name('procedencias.loadMore');
    Route::get('/admin/procedencias/get/{id}', [ProcedenciaController::class, 'obtenerProcedenciaPorId'])->name('procedencias.obtenerProcedenciaPorId');
    Route::post('/admin/procedencias/update/{id}', [ProcedenciaController::class, 'update'])->name('procedencias.update');
    Route::delete('/admin/procedencias/delete/{procedencia}', [ProcedenciaController::class, 'destroy'])->name('procedencias.deleteProcedencia');

    /*rutas para marcas*/
    Route::get('/admin/marcas/buscar', [MarcaController::class, 'buscar'])->name('buscarMarcas');
    Route::get('/admin/marcas', [MarcaController::class, 'show'])->name('verMarcas');
    Route::post('/admin/marcas/create', [MarcaController::class, 'crearMarca'])->name('marcas.crearMarca');
    Route::post('/admin/marcas/get', [MarcaController::class, 'loadMore'])->name('marcas.loadMore');
    Route::get('/admin/marcas/get/{id}', [MarcaController::class, 'obtenerMarcaPorId'])->name('marcas.obtenerMarcaPorId');
    Route::post('/admin/marcas/update/{id}', [MarcaController::class, 'update'])->name('marcas.update');
    Route::delete('/admin/marcas/delete/{marca}', [MarcaController::class, 'destroy'])->name('marcas.deleteMarcas');

    /*rutas para categorias*/
    Route::get('/admin/categorias/buscar', [CategoriaController::class, 'buscar'])->name('buscarCategorias');
    Route::get('/admin/categorias', [CategoriaController::class, 'show'])->name('verCategorias');
    Route::post('/admin/categorias/create', [CategoriaController::class, 'crearCategoria'])->name('categorias.crearCategoria');
    Route::post('/admin/categorias/get', [CategoriaController::class, 'loadMore'])->name('categorias.loadMore');
    Route::get('/admin/categorias/get/{id}', [CategoriaController::class, 'obtenerCategoriaPorId'])->name('categorias.obtenerCategoriaPorId');
    Route::delete('/admin/categorias/delete/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.deleteCategorias');
    Route::post('/admin/categorias/update/{id}', [CategoriaController::class, 'update'])->name('categorias.update');

    /*rutas para buscar taxonomias*/
    Route::get('/admin/taxonomias/buscar', [TaxonomiaController::class, 'buscar']);
    Route::get('/admin/taxonomias', [TaxonomiaController::class, 'show'])->name('verTaxonomias');
    Route::post('/admin/taxonomias/create', [TaxonomiaController::class, 'crearTaxonomia'])->name('taxonomias.crearTaxonomia');
    Route::post('/admin/taxonomias/get', [TaxonomiaController::class, 'loadMore'])->name('taxonomias.loadMore');
    Route::get('/admin/taxonomias/get/{id}', [TaxonomiaController::class, 'obtenerTaxonomiaPorId'])->name('taxonomias.obtenerTaxonomiaPorId');
    Route::post('/admin/taxonomias/update/{id}', [TaxonomiaController::class, 'update'])->name('taxonomias.update');
    Route::delete('/admin/taxonomias/delete/{taxonomia}', [TaxonomiaController::class, 'destroy'])->name('taxonomias.deleteTaxonomias');
    Route::get('/admin/taxonomias/{id}', [TaxonomiaController::class, 'verTaxonomia'])->name('taxonomias.verTaxonomia');

    /*rutas para buscar terminos*/
    Route::get('/admin/terminos/buscar', [TerminoController::class, 'buscar']);
    Route::post('/admin/terminos/create', [TerminoController::class, 'crearTermino'])->name('terminos.crearTermino');
    Route::post('/admin/terminos/get', [TerminoController::class, 'loadMore'])->name('terminos.loadMore');
    Route::get('/admin/terminos/get/{id}', [TerminoController::class, 'obtenerTerminoPorId'])->name('terminos.obtenerTerminoPorId');
    Route::post('/admin/terminos/update/{id}', [TerminoController::class, 'update'])->name('terminos.update');
    Route::delete('/admin/terminos/delete/{termino}', [TerminoController::class, 'destroy'])->name('terminos.deleteTerminos');

    /*rutas para las monedas*/
    Route::get('/admin/monedas', [MonedaController::class, 'show'])->name('verMonedas');
    Route::post('/admin/monedas/create', [MonedaController::class, 'crearMoneda'])->name('monedas.crearMoneda');
    Route::post('/admin/monedas/get', [MonedaController::class, 'loadMore'])->name('monedas.loadMore');
    Route::get('/admin/monedas/get/{id}', [MonedaController::class, 'obtenerMonedaPorId'])->name('monedas.obtenerMonedaPorId');
    Route::post('/admin/monedas/update/{id}', [MonedaController::class, 'update'])->name('monedas.update');
    Route::delete('/admin/monedas/delete/{moneda}', [MonedaController::class, 'destroy'])->name('monedas.deleteMonedas');
    
    /*rutas para las monedas*/
    Route::get('/admin/cotizaciones', [CotizacionController::class, 'show'])->name('verCotizaciones');
    Route::post('/admin/cotizaciones/create', [CotizacionController::class, 'crearCotizacion'])->name('cotizaciones.crearCotizacion');
    Route::post('/admin/cotizaciones/get', [CotizacionController::class, 'loadMore'])->name('cotizaciones.loadMore');
    Route::get('/admin/cotizaciones/pdf/{id}', [CotizacionController::class, 'generatePDF'])->name('cotizaciones.pdf');
    Route::get('/admin/cotizaciones/{id}', [CotizacionController::class, 'verCotizacion'])->name('cotizaciones.verCotizacion');
    Route::get('/admin/cotizaciones/get/{cotizacion}', [CotizacionController::class, 'obtenerCotizacionPorId'])->name('cotizaciones.obtenerCotizacionPorId');
    Route::post('/admin/cotizaciones/update/{id}', [CotizacionController::class, 'update'])->name('cotizaciones.update');

    /*rutas para las apis de la web*/
    Route::get('/admin/apis', [ApiwebController::class, 'show'])->name('verApis');
    Route::get('/admin/apis/producto/{id}', [ApiwebController::class, 'mostrarProducto'])->name('api.mostrarProducto');
    Route::get('/admin/apis/producto/pagina/{pagina}/{id}', [ApiwebController::class, 'mostrarProductosPaginados'])->name('api.mostrarProductosPaginados');
    Route::post('/admin/apis/create', [ApiwebController::class, 'crearApiweb'])->name('apiweb.crearApiweb');
    Route::post('/admin/apis/get', [ApiwebController::class, 'loadMore'])->name('apiweb.loadMore');
    Route::get('/admin/apis/get/{id}', [ApiwebController::class, 'obtenerApiPorId'])->name('apis.obtenerApiPorId');
    Route::post('/admin/apis/update/{id}', [ApiwebController::class, 'update'])->name('apis.update');
    Route::delete('/admin/apis/delete/{apiweb}', [ApiwebController::class, 'destroy'])->name('apis.deleteApi');
    Route::get('/admin/apis/{id}', [ApiwebController::class, 'verApiweb'])->name('apis.verApiweb');
     
});



require __DIR__.'/auth.php';
