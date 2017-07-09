<?php

use Illuminate\Database\Seeder;

class CategoriasPlatosSeeder extends Seeder
{
    protected $datosDeCarga = [
        ['nombre' => 'pizzas'],
        ['nombre' => 'minutas'],
        ['nombre' => 'hamburguesas'],
        ['nombre' => 'lomitos'],
        ['nombre' => 'pastas'],
        ['nombre' => 'postres'],
        ['nombre' => 'bebidas']
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categorias_platos')->insert($this->datosDeCarga);
    }
}
