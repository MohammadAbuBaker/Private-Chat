<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        factory(User::class)->create([
            'email'=>'bakeriiuc@gmail.com',
            'name'=>'Baker'
        ]);
        factory(User::class)->create([
            'email'=>'bakercse36@gmail.com',
            'name'=>'Abu Baker'
        ]);
        factory(User::class)->create([
            'email'=>'samouniiuc@gmail.com',
            'name'=>'Samoun'
        ]);

    }
}
