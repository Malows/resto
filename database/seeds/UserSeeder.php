<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datos = [
            [
                'name' => 'administrador',
                'password' => bcrypt("pertennesco"),
                'email' => 'administrador@mail.com',
                'tipo_usuario_id' => 1,
            ], [
                'name' => 'encargado',
                'password' => bcrypt("pertennesco"),
                'email' => 'encargado@mail.com',
                'tipo_usuario_id' => 2,
            ], [
                'name' => 'mozo',
                'password' => bcrypt("pertennesco"),
                'email' => 'mozo@mail.com',
                'tipo_usuario_id' => 3,
            ]
        ];

        DB::table('users')->insert($datos);
    }
}
