<?php

use Illuminate\Database\Seeder;

class PlatosSeeder extends Seeder
{
    protected $datosDeCarga = [
//        ['nombre' => , 'precio' => , 'descripcion' => , 'foto' => , 'habilitado' => , 'categoria_plato_id' => ],
        ['nombre'=> "Napolitana", 'precio' => 120, 'descripcion' => "Pizza napolitana con pinta de vegetariana", 'foto' => "platos/pizzas__napolitana.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 1],
        ['nombre' => "Hawaiana", 'precio' => 150, 'descripcion' => "Una pizza con onda y ananá", 'foto' => "platos/pizzas__hawaiana.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 1],
        ['nombre' => "Provenzal", 'precio' => 110, 'descripcion' => "Pizza con ajo y prejil", 'foto' => "platos/pizzas__provenzal.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 1],
        ['nombre' => "Especial", 'precio' => 140, 'descripcion' => "Pizza con de todo un poco", 'foto' => "platos/pizzas__especial.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 1],
        ['nombre' => "Calabresa", 'precio' => 130, 'descripcion' => "Pizza con longanisa o salame arriba", 'foto' => "platos/pizzas__calabresa.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 1],
        ['nombre' => "Hamburguesa simple", 'precio' => 50, 'descripcion' => "Pan, carne, adhereso", 'foto' => "platos/hamburguesas__hamburguesa_simple.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 3],
        ['nombre' => "Hamburguesa lechuga y tomate", 'precio' => 55, 'descripcion' => "Como la simple pero con lechuga y tomate", 'foto' => "platos/hamburguesas__hamburguesa_lechuga_y_tomate.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 3],
        ['nombre' => "Hamburguesa jamón y queso", 'precio' => 55, 'descripcion' => "Como la simple pero con jamón y queso", 'foto' => "platos/hamburguesas__hamburguesa_jamón_y_queso.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 3],
        ['nombre' => "Hamburguesa de queso, tomate y panceta", 'precio' => 70, 'descripcion' => "Con actitud de hamburguesa", 'foto' => "platos/hamburguesas__hamburguesa_de_queso,_tomate_y_panceta.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 3],
        ['nombre' => "Hamburguesa jamón, queso y tomate", 'precio' => 60, 'descripcion' => "Hamburguesa un poco más interesante que la media", 'foto' => "platos/hamburguesas__hamburguesa_jamón,_queso_y_tomate.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 3],
        ['nombre' => "Hamburguesa completa", 'precio' => 85, 'descripcion' => "La llevas puesta", 'foto' => "platos/hamburguesas__hamburguesa_completa.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 3],
        ['nombre' => "Hamburguesa doble", 'precio' => 80, 'descripcion' => "Doble o nada", 'foto' => "platos/hamburguesas__hamburguesa_doble.jpg", 'habilitado' => TRUE, 'categoria_plato_id' => 3]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('platos')->insert($this->datosDeCarga);
    }
}
