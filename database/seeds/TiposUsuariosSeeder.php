<?php

use Illuminate\Database\Seeder;

class TiposUsuariosSeeder extends Seeder
{
    private $datos = [
        ['nombre' => 'administrador'],
        ['nombre' => 'encargado de cocina'],
        ['nombre' => 'mozo'],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_usuarios')->insert($this->datos);
    }
}
