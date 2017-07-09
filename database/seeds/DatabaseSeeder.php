<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TiposUsuariosSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategoriasPlatosSeeder::class);
        $this->call(PlatosSeeder::class);
    }
}
