<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Product;
use App\Models\Taxonomia;
use App\Models\Termino;
use App\Models\Image;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Galeria;
use App\Models\MisEmpresa;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Procedencia;
use App\Models\Moneda;
use App\Models\Document;
use App\Models\Factura;
use App\Models\Cotizacion;
use App\Models\Embudo;
use App\Models\Columna;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::factory()->count(10)->create(); // Crea 10 roles
        Permission::factory()->count(10)->create(); // Crea 10 permisos
        
        // Crear 10 categorías raíz
        Image::factory()->count(10)->create();
        Moneda::factory()->count(5)->create();
        Categoria::factory()->count(5)->create();
        // Crear 20 categorías adicionales con posibles categorías padre
        Categoria::factory()->count(10)->create();
        $products = Product::factory()->count(5)->create();

        Taxonomia::factory()->count(10)->create();
        $terminos = Termino::factory()->count(20)->create();

        $products->each(function ($product) use ($terminos) {
            // Seleccionar un conjunto aleatorio de términos para asociar con el producto
            $product->terminos()->attach(
                $terminos->random(rand(1, 5))->pluck('id')->toArray()
            );
        });
        
       
        User::factory()->count(5)->create();

        $roles = Role::all();
        $permissions = Permission::all();

        foreach ($roles as $role) {
            // Asigna un subconjunto aleatorio de permisos a cada rol
            $role->permissions()->attach(
                $permissions->random(rand(1, 5))->pluck('id')->toArray()
            );
        }
       
        Galeria::factory()->count(4)->create();
        MisEmpresa::factory()->count(10)->create();
        Cliente::factory()->count(10)->create();
        Document::factory()->count(10)->create();
        Embudo::factory()->count(10)->create();
        Columna::factory()->count(10)->create();
        $facturas = Factura::factory()->count(10)->create();
        

        $marcas = Marca::factory()->count(10)->create();
        $procedencias = Procedencia::factory()->count(10)->create();

        $marcas->each(function ($marca) use ($products) {
            // Seleccionar un conjunto aleatorio de productos
            $productosAsignados = $products->random(rand(1, 5))->pluck('id')->toArray();
            $marca->products()->attach($productosAsignados);
        });

        $procedencias->each(function ($procedencia) use ($products) {
            // Seleccionar un conjunto aleatorio de productos
            $productosAsignados = $products->random(rand(1, 5))->pluck('id')->toArray();
            $procedencia->products()->attach($productosAsignados);
        });

        $cotizaciones = Cotizacion::factory()->count(10)->create();

        foreach ($facturas as $factura) {
            $factura->cotizaciones()->attach(
                $cotizaciones->random(rand(1, 3))->pluck('id')->toArray()
            );
        }

        foreach ($cotizaciones as $cotizacion) {
            $cotizacion->products()->attach(
                $products->random(rand(1, 3))->pluck('id')->toArray()
            );
        }

        $embudos = Embudo::all();
        $columnas = Columna::all();

        foreach ($embudos as $embudo) {
            // Seleccionar un conjunto aleatorio de columnas para asociar con el embudo
            $columnasSeleccionadas = $columnas->random(rand(1, $columnas->count()));

            foreach ($columnasSeleccionadas as $columna) {
                DB::table('columna_embudo')->insert([
                    'columna_id' => $columna->id,
                    'embudo_id' => $embudo->id,
                    'posicion' => rand(1, 10) / 10, // Valor aleatorio para 'posicion'
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        
    }
}
