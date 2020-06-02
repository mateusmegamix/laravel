<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create();

        // User::create([
        //     'name' => 'Mateus Pereira',
        //      'email' => 'mateusp.1996@gmail.com',
        //      'password' => bcrypt('123456')
        // ]);
    }
}
