<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'user@test.com'], // Busca por este email
            [
                'name'     => 'Usuario Prueba',
                'email'    => 'user@test.com',
                'password' => bcrypt('12345678'), // Contraseña encriptada
            ]
        );
    }
}