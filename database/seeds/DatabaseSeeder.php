<?php

use App\User;
use Illuminate\Database\Seeder;

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
            'email'=>'kartokatya@gmail.com',
            'name'=>'kate',
        ]);
        factory(User::class)->create([
            'email'=>'user1@gmail.com',
            'name'=>'user1',
        ]);
        factory(User::class)->create([
            'email'=>'user2@gmail.com',
            'name'=>'user2',
        ]);
    }
}
